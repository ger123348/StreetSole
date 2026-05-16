<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

Midtrans\Config::$serverKey = config('midtrans.server_key');
Midtrans\Config::$isProduction = config('midtrans.is_production');
Midtrans\Config::$isSanitized = config('midtrans.is_sanitized');
Midtrans\Config::$is3ds = config('midtrans.is_3ds');
Midtrans\Config::$curlOptions = [
    CURLOPT_IPRESOLVE => CURL_IPRESOLVE_V4,
    CURLOPT_TIMEOUT => 30,
    CURLOPT_CONNECTTIMEOUT => 15,
    CURLOPT_SSL_VERIFYPEER => false,
    CURLOPT_HTTPHEADER => [],
];

echo "Server Key: " . config('midtrans.server_key') . "\n";
echo "Is Production: " . (config('midtrans.is_production') ? 'true' : 'false') . "\n";

try {
    $params = [
        'transaction_details' => [
            'order_id' => 'TEST' . time(),
            'gross_amount' => 100000,
        ],
        'customer_details' => [
            'first_name' => 'Test',
            'email' => 'test@example.com',
            'phone' => '081234567890',
        ],
    ];
    $token = Midtrans\Snap::getSnapToken($params);
    echo "SUCCESS! Token: " . $token . "\n";
} catch (Exception $e) {
    echo "ERROR: " . $e->getMessage() . "\n";
    echo "Trace: " . $e->getTraceAsString() . "\n";
}
