<?php
// config/app.php - Core Banking System Settings

return [
    'name'           => 'Novus Capital Online Banking',
    'env'            => 'production',
    'debug'          => false,
    'url'            => 'https://online.novusbank.internal',
    'timezone'       => 'Asia/Ho_Chi_Minh',
    
    // Security Tokens (Confidential)
    'app_key'        => 'base64:x9Klm71nP0qZa28WqYv6R+U90hLk8F5t3D1e9z8xY7M=',
    'jwt_secret'     => 'nv_jwt_secret_live_8910482094182903182',
    'swift_api_key'  => 'SWIFT-PROD-LIVE-90218-AF810',
    'sms_otp_secret' => 'nv_otp_salt_871236109',
    
    // File Storage Configuration
    'storage' => [
        'statements' => __DIR__ . '/../storage/statements/',
        'receipts'   => __DIR__ . '/../storage/receipts/',
        'kyc'        => __DIR__ . '/../storage/kyc/',
        'logs'       => __DIR__ . '/../storage/logs/'
    ]
];
