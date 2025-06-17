<?php

return [
    /*
    |--------------------------------------------------------------------------
    | AbacatePay Configuration
    |--------------------------------------------------------------------------
    |
    | Aqui você pode configurar as credenciais e opções do AbacatePay.
    |
    */

    'token' => env('ABACATEPAY_TOKEN'),
    'environment' => env('ABACATEPAY_ENVIRONMENT', 'sandbox'),
    'webhook_secret' => env('ABACATEPAY_WEBHOOK_SECRET'),

    /*
    |--------------------------------------------------------------------------
    | URLs da API
    |--------------------------------------------------------------------------
    |
    | URLs base da API do AbacatePay para cada ambiente.
    |
    */
    'urls' => [
        'sandbox' => 'https://sandbox.abacatepay.com/v1',
        'production' => 'https://api.abacatepay.com/v1',
    ],

    /*
    |--------------------------------------------------------------------------
    | Configurações de Webhook
    |--------------------------------------------------------------------------
    |
    | Configurações relacionadas ao webhook do AbacatePay.
    |
    */
    'webhook' => [
        'url' => env('APP_URL') . '/webhooks/abacatepay',
        'events' => [
            'charge.created',
            'charge.paid',
            'charge.cancelled',
            'charge.expired',
            'charge.failed',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Configurações de Cobrança
    |--------------------------------------------------------------------------
    |
    | Configurações padrão para criação de cobranças.
    |
    */
    'billing' => [
        'due_date_days' => 7,
        'payment_methods' => [
            'pix',
            'boleto',
            'credit_card',
            'debit_card',
        ],
    ],
]; 