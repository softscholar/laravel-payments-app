<?php

namespace App\Http\Controllers\Gateways;

use App\Constants\AppConstant;
use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;
use Inertia\Response;

class GatewayController extends Controller
{
    public function index(Product $product): Response
    {
        return Inertia::render('Gateways/Index', [
            'gateways' => AppConstant::getGateways(),
            'product' => $product,
        ]);
    }

    public function paymentAccounts(Product $product): Response
    {
        $gateway = request()->gateway;

        if (!array_key_exists($gateway, AppConstant::getGateways())) {
            abort(404);
        }

        return Inertia::render('Gateways/PaymentAccounts', [
            'gateway' => AppConstant::getGateways()[$gateway],
            'paymentAccounts' => auth()->user()->paymentAccounts()->where('gateway', $gateway)->get(),
            'product' => $product,
        ]);
    }

    /**
     * @throws \Exception
     */
    public function process(Product $product)
    {
        $gateway = request()->gateway;

        if (! array_key_exists($gateway, AppConstant::getGateways())) {
            return back()->with('error', 'Invalid gateway selected!');
        }
        if ($gateway == 'nagad') {
            $nagad = new NagadPaymentGatewayController();
            return $nagad->proceed($product);
        }
    }

    /**
     * @throws ConnectionException
     */
    public function cancelAuthorization(): RedirectResponse
    {
        $paymentAccountId = request()->payment_account;

        if (! $paymentAccountId) {
            flashMessage('Failed', 'Invalid payment account selected!', 'error');
            return back();
        }
        $nagad = new NagadPaymentGatewayController();
        if ($nagad->cancelAuthorization()) {
            flashMessage('Cancel Authorization', 'Payment account has been deleted successfully!', 'success');
        } else {
            flashMessage('Failed', 'Failed to delete payment account!', 'error');
        }

        return back();
    }

    /**
     * @throws ConnectionException
     */
    public function verify(Product $product)
    {
        $payment = $product->payment;

        if ($payment) {
            if ($payment->gateway == 'nagad') {
                $nagad = new NagadPaymentGatewayController();
                if ($nagad->verify($product, $payment)) {
                    flashMessage('Success', 'Payment verified successfully!', 'success');
                } else {
                    flashMessage('Failed', 'Payment verification failed, please try again!', 'error');
                }
            }
        } else {
            flashMessage('Failed', 'Payment information not found!', 'error');
        }

        return back();
    }
}
