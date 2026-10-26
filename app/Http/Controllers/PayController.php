<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use Inertia\Response;
use MercadoPago\Client\Preference\PreferenceClient;
use MercadoPago\MercadoPagoConfig;

class PayController extends Controller
{
    public function index(): Response
    {
        $preferenceId = $this->generatePreferenceId();

        return Inertia::render('Pay', [
            'preference' => $preferenceId,
            'publicKey' => config('services.mercadopago.public_key'),
        ]);
    }

    private function generatePreferenceId(): string
    {
        MercadoPagoConfig::setAccessToken(config('services.mercadopago.access_token'));

        $client = new PreferenceClient;

        $preference = $client->create([
            'items' => [
                [
                    'id' => '1234',
                    'title' => 'Mi producto',
                    'quantity' => 1,
                    'unit_price' => 100,
                    'currency_id' => 'ARS',
                ],
            ],
        ]);

        return $preference->id;
    }
}
