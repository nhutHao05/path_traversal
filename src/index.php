<?php
require_once __DIR__ . '/includes/auth.php';

if (isset($_GET['action']) && $_GET['action'] === 'demo_login') {
    header('Location: dashboard.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng Nhập &bull; Novus Capital International Bank</title>
    <link rel="stylesheet" href="assets/css/app.css">
</head>
<body class="login-body">
    <div class="login-card">
        <div class="login-header">
            <div class="logo-icon">&#9670;</div>
            <h2 style="font-size:1.5rem; font-weight:700; color:#fff;">NOVUS CAPITAL</h2>
            <p style="color:var(--text-muted); font-size:0.875rem;">Hệ Thống Ngân Hàng Trực Tuyến Doanh Nghiệp & Cá Nhân</p>
        </div>

        <form action="dashboard.php" method="POST">
            <div class="form-group">
                <label class="form-label">Tên Đăng Nhập / Mã Định Danh (CIF)</label>
                <input type="text" class="form-control" name="username" value="alex.vance" placeholder="Nhập username">
            </div>

            <div class="form-group">
                <label class="form-label">Mật Khẩu Đăng Nhập</label>
                <input type="password" class="form-control" name="password" value="Password@123" placeholder="Nhập mật khẩu">
            </div>

            <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:1.5rem; font-size:0.8rem;">
                <label style="color:var(--text-muted); display:flex; align-items:center; gap:0.4rem; cursor:pointer;">
                    <input type="checkbox" checked> Ghi nhớ thiết bị
                </label>
                <a href="#" style="color:var(--primary); text-decoration:none;">Quên mật khẩu?</a>
            </div>

            <button type="submit" class="btn btn-primary" style="width:100%; padding:0.75rem;">
                Đăng Nhập Hệ Thống
            </button>
        </form>

        <div style="margin-top:1.5rem; padding-top:1.5rem; border-top:1px solid var(--border); text-align:center;">
            <a href="index.php?action=demo_login" class="btn btn-secondary" style="width:100%; font-size:0.825rem;">
                &rarr; Vào Ngay Bằng Tài Khoản Demo (Alex Vance)
            </a>
        </div>
    </div>
</body>
</html>
