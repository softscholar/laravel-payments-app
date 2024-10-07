<?php

namespace App\Http\Controllers\Gateways;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use App\Models\PaymentAccount;
use App\Models\Product;
use Exception;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Softscholar\Payment\Services\Gateways\Nagad\Nagad;

class NagadPaymentGatewayController extends Controller
{
    public string $merchantId = '';
    public string $merchantPgKey = '';
    public ?string $merchantPrivateKey = null;
    public string $merchantNumber = '';
    public string $merchantHex = '';
    public string $merchantIv = '';
    public function __construct()
    {
        $this->merchantId = config('spayment.gateways.nagad.merchant_id');
        $this->merchantPgKey = config('spayment.gateways.nagad.merchant_public_key');
        $this->merchantPrivateKey = config('spayment.gateways.nagad.merchant_private_key');
        $this->merchantHex = config('spayment.gateways.nagad.merchant_hex');
        $this->merchantIv = config('spayment.gateways.nagad.merchant_iv');
        $this->merchantNumber = config('spayment.gateways.nagad.merchant_number');
    }

    /**
     * @throws Exception
     */
    public function proceed(Product $product)
    {
        $checkoutData = $this->prepareCheckoutData($product);

        $paymentAccount = null;
        if(request()->payment_account) {
            $paymentAccount = auth()->user()->paymentAccounts()->find(request()->payment_account);
        }

        $nagad = new Nagad(
            $this->merchantId,
            $this->merchantPgKey,
            $this->merchantPrivateKey,
            $this->merchantHex,
            $this->merchantIv,
            $this->merchantNumber
        );

        if (request()->save == 'true') {
            $checkoutData['amount'] = 0;
            $redirectUrl = $nagad->checkout($checkoutData, 'authorize');
        } elseif (request()->payment_account && $paymentAccount) {
            $checkoutData['token'] = $paymentAccount->token;
            $redirectUrl = $nagad->checkout($checkoutData, 'tokenized');
        } else {
            $redirectUrl = $nagad->checkout($checkoutData);
        }

        return Inertia::location($redirectUrl);
    }

    private function prepareCheckoutData(Product $product): array
    {
        $merchantCallbackURL = route('gateways.nagad.callback');

        return [
            'callback_url' => $merchantCallbackURL,
            'order_id' => $product->id . 'Ord' . time(),
            'customer_id' => '0000' . auth()->id(),
            'additional_info' => [
                'additionalFieldNameBN' => 'পণ্যের নাম',
                'additionalFieldNameEN' => 'Product Name',
                'additionalFieldValue' => $product->name,
            ],
//            'amount' => $product->price,
            'amount' => 5,
        ];
    }

    public function callback(): RedirectResponse
    {
        if (!request()->order_id) {
            return $this->redirectWithError();
        }

        $productId = explode('Ord', request()->order_id)[0];

        $status = request()->status;

        if (!$productId) {
            return $this->redirectWithError();
        }

        $product = Product::find($productId);

        if (!$product) {
            return $this->redirectWithError();
        }

        if ($status === 'Success') {
            $this->processPayment($product);
        }

        $type = request()->has('token') ? 'token' : 'regular';

        return $this->redirectWithStatus($product, $status, $type);
    }

    private function processPayment(Product $product): void
    {
        if (request()->has('token')) {
            $this->storeOrUpdatePaymentAccount();
        } else {
            $product->payment()->create([
                'user_id' => auth()->user()->id,
                'gateway' => 'nagad',
                'ref_id' => request()->payment_ref_id,
                'amount' => $product->price,
                'status' => 'success',
                'status_code' => request()->status_code,
                'response' => request()->all(),
            ]);
        }
    }

    private function storeOrUpdatePaymentAccount(): void
    {
        $data = [
            'account_no' => request()->account_no,
            'customer_id' => request()->customer_id,
            'order_id' => request()->order_id,
            'gateway' => 'nagad',
            'payment_ref_id' => request()->payment_ref_id,
            'token' => request()->token,
            'token_type' => request()->token_type,
            'token_expire_at' => request()->token_expiry_dt,
            'status' => 'active',
            'extra' => json_encode(request()->all()),
        ];

        $existingAccount = auth()->user()->paymentAccounts()->firstOrCreate(
            ['customer_id' => request()->customer_id],
            $data
        );

        if ($existingAccount->wasRecentlyCreated === false) {
            $existingAccount->update($data);
        }
    }

    private function redirectWithStatus(Product $product, $status, string $type): RedirectResponse
    {
        if ($type == 'token') {
            flashMessage('Authorized Successfully', 'Payment Account has been saved successfully!Pay Now!');
            return redirect()->route('gateways.payment-accounts', [
                'product' => $product,
                'product_id' => $product->id,
                'gateway' => 'nagad',
                'payment' => $status,
            ]);
        } else {
            if ($status === 'Success') {
                $message = 'Payment Successful';
                $with = 'Successful';
                $type = 'success';
            } else {
                $message = 'Payment Failed. Try Again!';
                $with = 'Error';
                $type = 'error';
            }
        }

        flashMessage($with, $message, $type);

        return redirect()->route('products.index', [
            'product_id' => $product->id,
            'payment' => $status,
        ]);
    }

    private function redirectWithError(): RedirectResponse
    {
        flashMessage('error', 'No order ID provided!');

        return back();
    }

    /**
     * @throws ConnectionException
     */
    public function cancelAuthorization(): bool
    {
        $paymentAccountId = request()->payment_account;

        $paymentAccount = auth()->user()->paymentAccounts()->find($paymentAccountId);

        if ($paymentAccount) {
            $nagad = new Nagad(
                $this->merchantId,
                $this->merchantPgKey,
                $this->merchantPrivateKey,
                $this->merchantHex,
                $this->merchantIv,
                $this->merchantNumber
            );

            $payload = [
                'masked_ac_no' => $paymentAccount['account_no'],
                'customer_id' => $paymentAccount['customer_id'],
                'token_type' => $paymentAccount['token_type'],
            ];

            $response = $nagad->cancelAuthorization($paymentAccount->token, $payload);

            if (isset($response['status']) && $response['status'] === 'Success') {
                $paymentAccount->delete();

                return true;
            }

            return false;
        }

        return false;
    }

    /**
     * @throws ConnectionException
     */
    public function verify(Product $product, Payment $payment): bool
    {
        $nagad = new Nagad(
            $this->merchantId,
            $this->merchantPgKey,
            $this->merchantPrivateKey,
            $this->merchantHex,
            $this->merchantIv,
            $this->merchantNumber
        );

        $response = $nagad->verify($payment->ref_id);

        if ($response['status'] == 'Success') {
            return true;
        }
        else {
            return false;
        }
    }

    public function eligibilityForPayment(PaymentAccount $paymentAccount): bool
    {
        $accountData = json_decode($paymentAccount->extra, true);

        $nagad = new Nagad(
            $this->merchantId,
            $this->merchantPgKey,
            $this->merchantPrivateKey,
            $this->merchantHex,
            $this->merchantIv,
            $this->merchantNumber
        );

        $payload = [
            'masked_ac_no' => $accountData['account_no'],
            'customer_id' => $accountData['customer_id'],
            'token_type' => $accountData['token_type'],
            'amount' => 5,
        ];
        return $nagad->isEligibleForTokenizedCheckout($paymentAccount->token,$payload );
    }
}
