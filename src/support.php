<?php
require_once __DIR__ . '/includes/header.php';

$viewLog = $_GET['view_log'] ?? null;
$logContent = null;
$logError = null;

if ($viewLog) {
    // Đoạn code backend xử lý đọc file chẩn đoán của ticket
    $logPath = __DIR__ . '/storage/logs/' . $viewLog;
    if (file_exists($logPath)) {
        $logContent = @file_get_contents($logPath);
        if ($logContent === false) {
            $logError = "Không thể đọc nội dung file log do quyền hạn hệ thống.";
        }
    } else {
        $logError = "Không tìm thấy tệp chẩn đoán: " . htmlspecialchars($viewLog, ENT_QUOTES, 'UTF-8');
    }
}
?>

<main class="main-wrapper">
    <div class="welcome-bar">
        <div class="welcome-text">
            <h1>Trung Tâm Hỗ Trợ & Yêu Cầu Kỹ Thuật (Tickets)</h1>
            <p>Liên hệ đội ngũ Private Wealth Support 24/7 và theo dõi tiến độ xử lý yêu cầu.</p>
        </div>
    </div>

    <div class="content-grid">
        <!-- Cột trái: Danh sách Ticket -->
        <div>
            <div class="card">
                <div class="card-header">
                    <span class="card-title">Phiếu Hỗ Trợ Gần Đây</span>
                    <button class="btn btn-primary btn-sm">+ Tạo Yêu Cầu Mới</button>
                </div>

                <div class="table-responsive">
                    <table class="bank-table">
                        <thead>
                            <tr>
                                <th>Mã Phiếu</th>
                                <th>Tiêu Đề Yêu Cầu</th>
                                <th>Chuyên Viên Phụ Trách</th>
                                <th>Trạng Thái</th>
                                <th>Nhật Ký Chẩn Đoán</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><code>#8812</code></td>
                                <td>
                                    <strong>Tiến độ lệnh chuyển tiền Fedwire Quốc Tế</strong><br>
                                    <span style="font-size:0.75rem; color:var(--text-sub);">Tạo lúc: 26/03/2026 12:44 UTC</span>
                                </td>
                                <td>Sarah Jenkins</td>
                                <td>
                                    <span class="status-chip" style="font-size:0.75rem; background:rgba(59,130,246,0.15); color:#60a5fa; border-color:rgba(59,130,246,0.3);">
                                        Đang xử lý
                                    </span>
                                </td>
                                <td>
                                    <a href="support.php?view_log=ticket_8812.log" class="btn btn-secondary btn-sm">
                                        Xem Log Kỹ Thuật
                                    </a>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Khung hiển thị Log kỹ thuật khi người dùng bấm xem -->
            <?php if ($viewLog): ?>
                <div class="card" style="border-top:3px solid var(--primary);">
                    <div class="card-header">
                        <span class="card-title">Chi Tiết Nhật Ký Kỹ Thuật: <code><?php echo htmlspecialchars($viewLog); ?></code></span>
                        <a href="support.php" class="btn btn-secondary btn-sm">&times; Đóng</a>
                    </div>

                    <?php if ($logError): ?>
                        <div style="background:rgba(239,68,68,0.15); border:1px solid rgba(239,68,68,0.4); color:#fca5a5; padding:1rem; border-radius:var(--radius-sm); font-size:0.875rem;">
                            <strong>Thông báo:</strong> <?php echo $logError; ?>
                        </div>
                    <?php else: ?>
                        <div class="preview-box"><?php echo htmlspecialchars($logContent, ENT_QUOTES, 'UTF-8'); ?></div>
                    <?php endif; ?>
                </div>
            <?php endif; ?>
        </div>

        <!-- Cột phải: Thông tin liên hệ chuyên viên -->
        <div>
            <div class="card">
                <div class="card-header">
                    <span class="card-title">Chuyên Viên Khách Hàng Ưu Tiên</span>
                </div>
                <div style="text-align:center; padding:1rem 0;">
                    <div class="avatar" style="width:54px; height:54px; font-size:1.25rem; margin:0 auto 0.75rem; background:linear-gradient(135deg,#3b82f6,#8b5cf6);">SJ</div>
                    <div style="font-weight:700; font-size:1.05rem;">Sarah Jenkins</div>
                    <div style="font-size:0.8rem; color:var(--text-muted);">Senior Private Banker &bull; VP Wealth Management</div>
                </div>
                <div style="font-size:0.85rem; border-top:1px solid var(--border); padding-top:1rem; color:var(--text-muted); line-height:1.8;">
                    <div><strong>Hotline VIP:</strong> +1 (800) 555-NOVUS</div>
                    <div><strong>Email:</strong> s.jenkins@novusbank.internal</div>
                    <div><strong>Giờ làm việc:</strong> 24/7 Toàn Cầu</div>
                </div>
            </div>
        </div>
    </div>
</main>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
