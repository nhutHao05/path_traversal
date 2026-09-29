<?php
require_once __DIR__ . '/includes/header.php';

$kycDocs = [
    [
        'title' => 'Giấy Tờ Tùy Thân / Hộ Chiếu Quốc Gia',
        'type' => 'Identity Proof',
        'file' => 'id_card_front.txt',
        'verified_at' => '10/01/2026',
        'status' => 'Đã xác thực (Tier 2)'
    ],
    [
        'title' => 'Chứng Từ Xác Minh Địa Chỉ Cư Trú',
        'type' => 'Proof of Address',
        'file' => 'proof_of_address.txt',
        'verified_at' => '10/01/2026',
        'status' => 'Đã xác thực (Tier 2)'
    ]
];
?>

<main class="main-wrapper">
    <div class="welcome-bar">
        <div class="welcome-text">
            <h1>Hồ Sơ Xác Minh Danh Tính (KYC & Compliance)</h1>
            <p>Quản lý các tài liệu pháp lý định danh khách hàng theo chuẩn phòng chống rửa tiền quốc tế (AML).</p>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <span class="card-title">Tài Liệu KYC Đang Lưu Trữ Trong Hệ Thống</span>
        </div>

        <div class="table-responsive">
            <table class="bank-table">
                <thead>
                    <tr>
                        <th>Loại Giấy Tờ</th>
                        <th>Phân Loại</th>
                        <th>Ngày Phê Duyệt</th>
                        <th>Trạng Thái</th>
                        <th>Xem Hồ Sơ</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($kycDocs as $k): ?>
                        <tr>
                            <td><strong><?php echo htmlspecialchars($k['title']); ?></strong></td>
                            <td style="color:var(--text-muted);"><?php echo htmlspecialchars($k['type']); ?></td>
                            <td><?php echo htmlspecialchars($k['verified_at']); ?></td>
                            <td>
                                <span class="status-chip" style="font-size:0.75rem;">
                                    <?php echo htmlspecialchars($k['status']); ?>
                                </span>
                            </td>
                            <td>
                                <a href="api/download.php?type=kyc&file=<?php echo urlencode($k['file']); ?>" target="_blank" class="btn btn-secondary btn-sm">
                                    Mở Tài Liệu Lưu Trữ
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</main>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
