<?php
require_once __DIR__ . '/includes/header.php';

$transactions = $_SESSION['transactions'] ?? [];
?>

<main class="main-wrapper">
    <div class="welcome-bar">
        <div class="welcome-text">
            <h1>Lịch Sử Giao Dịch & Sổ Nhật Ký</h1>
            <p>Kiểm tra chi tiết tất cả dòng tiền vào/ra và tải về chứng từ biên lai chính thức.</p>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <span class="card-title">Danh Sách Lệnh Chuyển Khoản & Thanh Toán</span>
            <div style="font-size:0.85rem; color:var(--text-muted);">
                Tài khoản: <strong><?php echo htmlspecialchars($user['checking_acc']); ?></strong>
            </div>
        </div>

        <div class="table-responsive">
            <table class="bank-table">
                <thead>
                    <tr>
                        <th>Mã Tham Chiếu</th>
                        <th>Ngày Giờ</th>
                        <th>Nội Dung Giao Dịch</th>
                        <th>Trạng Thái</th>
                        <th>Biến Động Số Dư</th>
                        <th>Chứng Từ (Biên Lai)</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($transactions as $t): ?>
                        <tr>
                            <td><code><?php echo htmlspecialchars($t['ref']); ?></code></td>
                            <td style="color:var(--text-muted); font-size:0.8rem;"><?php echo htmlspecialchars($t['date']); ?></td>
                            <td><strong><?php echo htmlspecialchars($t['desc']); ?></strong></td>
                            <td>
                                <span class="status-chip" style="font-size:0.75rem; padding:0.2rem 0.6rem;">
                                    <?php echo htmlspecialchars($t['status']); ?>
                                </span>
                            </td>
                            <td class="<?php echo $t['amount'] > 0 ? 'amount-positive' : 'amount-negative'; ?>">
                                <?php echo ($t['amount'] > 0 ? '+ ' : '') . '$ ' . number_format($t['amount'], 2); ?>
                            </td>
                            <td>
                                <?php if ($t['receipt']): ?>
                                    <a href="api/download.php?type=receipt&file=<?php echo urlencode($t['receipt']); ?>" target="_blank" class="btn btn-secondary btn-sm">
                                        Tải Biên Lai (.txt)
                                    </a>
                                <?php else: ?>
                                    <span style="font-size:0.75rem; color:var(--text-sub);">Hóa đơn điện tử</span>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</main>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
