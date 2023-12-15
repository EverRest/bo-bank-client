<?php

return [
    'name' => env('ADMIN_NAME', 'Admin'),
    'email' => env('ADMIN_EMAIL', 'admin@admin.com'),
    'password' => env('ADMIN_PASSWORD', 'admin'),
    'wallet_currency' => env('STORAGE_WALLET_CURRENCY', 'USD'),
    'exchange_rates_api' => env('EXCHANGE_API_KEY'),
    'exchange_commission' => env('EXCHANGE_COMMISSION', 1),
    'transfer_commission' => env('TRANSFER_COMMISSION', 2),
];
