<?php
require_once __DIR__ . '/auth.php';
$user = currentUser();
$currentPage = basename($_SERVER['PHP_SELF']);
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Novus Capital Bank &bull; Online Banking</title>
    <link rel="stylesheet" href="assets/css/app.css">
</head>
<body>
    <header class="bank-header">
        <div class="nav-container">
            <a href="dashboard.php" class="bank-logo">
                <div class="logo-icon">&#9670;</div>
                <span>NOVUS <strong>CAPITAL</strong></span>
            </a>

            <ul class="nav-menu">
                <li><a href="dashboard.php" class="nav-link <?php echo $currentPage==='dashboard.php'?'active':''; ?>">Dashboard</a></li>
                <li><a href="transactions.php" class="nav-link <?php echo $currentPage==='transactions.php'?'active':''; ?>">Giao Dịch</a></li>
                <li><a href="statements.php" class="nav-link <?php echo $currentPage==='statements.php'?'active':''; ?>">Sao Kê Điện Tử</a></li>
                <li><a href="kyc.php" class="nav-link <?php echo $currentPage==='kyc.php'?'active':''; ?>">Hồ Sơ KYC</a></li>
                <li><a href="support.php" class="nav-link <?php echo $currentPage==='support.php'?'active':''; ?>">Hỗ Trợ</a></li>
            </ul>

            <div class="user-badge">
                <div class="avatar">AV</div>
                <div style="font-size:0.85rem; line-height:1.2;">
                    <div style="font-weight:600;"><?php echo htmlspecialchars($user['name']); ?></div>
                    <div style="font-size:0.75rem; color:var(--text-muted);"><?php echo htmlspecialchars($user['tier']); ?></div>
                </div>
            </div>
        </div>
    </header>
