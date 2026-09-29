<?php
require_once __DIR__ . '/includes/header.php';

$statements = [
    [
        'month' => 'Tháng 02 / 2026',
        'file' => 'statement_2026_02.txt',
        'closing' => 189209.50,
        'gen_date' => '01/03/2026'
    ],
    [
        'month' => 'Tháng 01 / 2026',
        'file' => 'statement_2026_01.txt',
        'closing' => 151359.50,
        'gen_date' => '01/02/2026'
    ]
];
?>

<main class="main-wrapper">
    <div class="welcome-bar">
        <div class="welcome-text">
            <h1>Sao Kê Điện Tử Định Kỳ (e-Statements)</h1>
            <p>Trích xuất báo cáo tài chính và lịch sử biến động số dư hàng tháng có chữ ký số của Novus Bank.</p>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <span class="card-title">Bản Sao Kê Hàng Tháng Có Sẵn</span>
        </div>

        <div class="table-responsive">
            <table class="bank-table">
                <thead>
                    <tr>
                        <th>Kỳ Sao Kê</th>
                        <th>Ngày Phát Hành</th>
                        <th>Số Dư Cuối Kỳ (USD)</th>
                        <th>Tên Tệp Lưu Trữ</th>
                        <th>Thao Tác</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($statements as $s): ?>
                        <tr>
                            <td><strong><?php echo htmlspecialchars($s['month']); ?></strong></td>
                            <td style="color:var(--text-muted);"><?php echo htmlspecialchars($s['gen_date']); ?></td>
                            <td style="font-weight:600; color:#fff;">$ <?php echo number_format($s['closing'], 2); ?></td>
                            <td><code><?php echo htmlspecialchars($s['file']); ?></code></td>
                            <td style="display:flex; gap:0.5rem;">
                                <a href="api/download.php?type=statement&file=<?php echo urlencode($s['file']); ?>" target="_blank" class="btn btn-secondary btn-sm">
                                    Xem Trực Tuyến
                                </a>
                                <a href="api/download.php?type=statement&file=<?php echo urlencode($s['file']); ?>&download=1" class="btn btn-primary btn-sm">
                                    Tải Về (.txt)
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
