<?php
require_once __DIR__ . '/includes/header.php';

$msg = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'transfer') {
    $recipient = htmlspecialchars($_POST['recipient'] ?? '', ENT_QUOTES, 'UTF-8');
    $amount = floatval($_POST['amount'] ?? 0);
    if ($amount > 0 && $amount <= $_SESSION['user']['balance']) {
        $_SESSION['user']['balance'] -= $amount;
        $user = $_SESSION['user'];
        
        $newTx = [
            'date' => date('d/m/Y H:i'),
            'ref' => 'TXN-' . rand(10000, 99999),
            'desc' => 'Chuyển khoản tới ' . $recipient,
            'type' => 'outward',
            'amount' => -$amount,
            'status' => 'Hoàn tất',
            'receipt' => null
        ];
        array_unshift($_SESSION['transactions'], $newTx);

        $msg = "Chuyển khoản thành công $" . number_format($amount, 2) . " tới tài khoản " . $recipient . ". Mã tham chiếu: " . $newTx['ref'];
    } elseif ($amount > $_SESSION['user']['balance']) {
        $msg = "Lỗi: Số dư không đủ.";
    }
}
?>

<main class="main-wrapper">
    <!-- Welcome Bar -->
    <div class="welcome-bar">
        <div class="welcome-text">
            <h1>Xin chào, <?php echo htmlspecialchars($user['name']); ?></h1>
            <p>Tài khoản Doanh Nghiệp & Cá Nhân &bull; CIF: <code><?php echo htmlspecialchars($user['id']); ?></code></p>
        </div>
        <div class="status-chip">
            <span class="status-dot"></span>
            Hệ Thống Trực Tuyến &bull; Bảo Mật Cấp 3
        </div>
    </div>

    <?php if ($msg): ?>
        <div style="background:var(--emerald-glow); border:1px solid rgba(16,185,129,0.4); color:var(--emerald); padding:1rem 1.25rem; border-radius:var(--radius-sm); margin-bottom:1.5rem; font-weight:500;">
            &#10003; <?php echo $msg; ?>
        </div>
    <?php endif; ?>

    <!-- Balances Grid -->
    <div class="balance-grid">
        <div class="balance-card">
            <div class="card-label">
                <span>TÀI KHOẢN THANH TOÁN (CHECKING)</span>
                <span style="font-size:0.75rem; color:var(--emerald);">&#9679; HOẠT ĐỘNG</span>
            </div>
            <div class="card-amount">$ <?php echo number_format($user['balance'], 2); ?></div>
            <div class="card-subtext">STK: <?php echo htmlspecialchars($user['checking_acc']); ?></div>
        </div>

        <div class="balance-card savings">
            <div class="card-label">
                <span>TIẾT KIỆM TÍCH LŨY (HIGH-YIELD)</span>
                <span style="font-size:0.75rem; color:var(--cyan);">LÃI SUẤT 5.2%</span>
            </div>
            <div class="card-amount">$ <?php echo number_format($user['savings'], 2); ?></div>
            <div class="card-subtext">STK: <?php echo htmlspecialchars($user['savings_acc']); ?></div>
        </div>

        <div class="balance-card credit">
            <div class="card-label">
                <span>HẠN MỨC TÍN DỤNG DOANH NGHIỆP</span>
                <span style="font-size:0.75rem; color:#c084fc;">PLATINUM</span>
            </div>
            <div class="card-amount">$ <?php echo number_format($user['credit_limit'], 2); ?></div>
            <div class="card-subtext">Dư nợ hiện tại: $ 0.00</div>
        </div>
    </div>

    <!-- Content 2 Columns -->
    <div class="content-grid">
        <!-- Left Column: Recent Transactions -->
        <div>
            <div class="card">
                <div class="card-header">
                    <span class="card-title">Giao Dịch Gần Đây</span>
                    <a href="transactions.php" class="btn btn-secondary btn-sm">Xem tất cả &rarr;</a>
                </div>

                <div class="table-responsive">
                    <table class="bank-table">
                        <thead>
                            <tr>
                                <th>Thời Gian</th>
                                <th>Mô Tả Giao Dịch</th>
                                <th>Số Tiền (USD)</th>
                                <th>Biên Lai</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                            $recent_tx = array_slice($_SESSION['transactions'] ?? [], 0, 3);
                            foreach ($recent_tx as $tx): 
                            ?>
                            <tr>
                                <td style="color:var(--text-muted); font-size:0.8rem;"><?php echo htmlspecialchars($tx['date']); ?></td>
                                <td>
                                    <strong><?php echo htmlspecialchars($tx['desc']); ?></strong><br>
                                    <span style="font-size:0.75rem; color:var(--text-sub);">Ref: <?php echo htmlspecialchars($tx['ref']); ?></span>
                                </td>
                                <td class="<?php echo $tx['amount'] > 0 ? 'amount-positive' : 'amount-negative'; ?>">
                                    <?php echo $tx['amount'] > 0 ? '+' : ''; ?> $ <?php echo number_format(abs($tx['amount']), 2); ?>
                                </td>
                                <td>
                                    <?php if ($tx['receipt']): ?>
                                        <a href="api/download.php?type=receipt&file=<?php echo urlencode($tx['receipt']); ?>" target="_blank" class="btn btn-secondary btn-sm">
                                            Xem Biên Lai
                                        </a>
                                    <?php else: ?>
                                        <span style="font-size:0.75rem; color:var(--text-sub);">Tự động</span>
                                    <?php endif; ?>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Right Column: Quick Transfer & e-Statement Widget -->
        <div>
            <!-- Quick Transfer Card -->
            <div class="card">
                <div class="card-header">
                    <span class="card-title">Chuyển Tiền Nhanh (24/7)</span>
                </div>
                <form action="dashboard.php" method="POST">
                    <input type="hidden" name="action" value="transfer">
                    <div class="form-group">
                        <label class="form-label">Tài Khoản Thụ Hưởng</label>
                        <input type="text" name="recipient" class="form-control" placeholder="Nhập số tài khoản hoặc IBAN" required>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Số Tiền (USD)</label>
                        <input type="number" step="0.01" name="amount" class="form-control" placeholder="0.00" required>
                    </div>
                    <button type="submit" class="btn btn-primary" style="width:100%;">
                        Xác Nhận Chuyển Tiền
                    </button>
                </form>
            </div>

            <!-- e-Statement Widget -->
            <div class="card">
                <div class="card-header">
                    <span class="card-title">Sao Kê Tháng Gần Nhất</span>
                </div>
                <p style="font-size:0.85rem; color:var(--text-muted); margin-bottom:1rem;">
                    Bản sao kê tài khoản tháng 02/2026 đã sẵn sàng để kiểm tra và tải về.
                </p>
                <div style="display:flex; gap:0.5rem;">
                    <a href="api/download.php?type=statement&file=statement_2026_02.txt" target="_blank" class="btn btn-secondary btn-sm" style="flex:1;">
                        Xem Bản Gốc
                    </a>
                    <a href="statements.php" class="btn btn-primary btn-sm" style="flex:1;">
                        Kho Sao Kê &rarr;
                    </a>
                </div>
            </div>
        </div>
    </div>
</main>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
