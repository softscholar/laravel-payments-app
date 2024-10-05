<?php

namespace App\Http\Controllers\Gateways;

use App\Constants\AppConstant;
use App\Http\Controllers\Controller;
use App\Models\Product;
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

    public function process(Product $product)
    {
        dd(request()->all());
    }
}
