<?php
// includes/auth.php - Session & Authentication Controller

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Giả lập trạng thái đăng nhập mặc định cho môi trường diễn tập
if (!isset($_SESSION['user'])) {
    $_SESSION['user'] = [
        'id'           => 'CUST-88192',
        'username'     => 'alex.vance',
        'name'         => 'Alexander Vance',
        'tier'         => 'Private Wealth (Tier 2)',
        'checking_acc' => '4920-8812-7491-0021',
        'savings_acc'  => '8104-2201-9943-8812',
        'balance'      => 189209.50,
        'savings'      => 450000.00,
        'credit_limit' => 50000.00
    ];
}

// Khởi tạo danh sách giao dịch mẫu nếu chưa có
if (!isset($_SESSION['transactions'])) {
    $_SESSION['transactions'] = [
        [
            'date' => '20/03/2026 16:48',
            'ref' => 'TXN-99215',
            'desc' => 'SWIFT Inward - Global Hedge Fund Partners',
            'type' => 'inward',
            'amount' => 50000.00,
            'status' => 'Hoàn tất',
            'receipt' => 'rec_99215.txt'
        ],
        [
            'date' => '14/03/2026 10:24',
            'ref' => 'TXN-99214',
            'desc' => 'Fedwire Outward - Acme Security Solutions LLC',
            'type' => 'outward',
            'amount' => -25400.00,
            'status' => 'Hoàn tất',
            'receipt' => 'rec_99214.txt'
        ],
        [
            'date' => '26/02/2026 09:12',
            'ref' => 'TXN-99102',
            'desc' => 'Corporate Credit Settlement Auto-Debit',
            'type' => 'outward',
            'amount' => -7150.00,
            'status' => 'Hoàn tất',
            'receipt' => null
        ],
        [
            'date' => '19/02/2026 14:00',
            'ref' => 'TXN-99081',
            'desc' => 'Tech Advisory Fee Retainer',
            'type' => 'inward',
            'amount' => 20000.00,
            'status' => 'Hoàn tất',
            'receipt' => null
        ]
    ];
}

function currentUser() {
    return $_SESSION['user'] ?? null;
}
