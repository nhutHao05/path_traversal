<?php
// api/download.php - Trình xử lý tải và xem trước chứng từ ngân hàng
require_once __DIR__ . '/../includes/auth.php';

$type = $_GET['type'] ?? 'statement';
$file = $_GET['file'] ?? '';
$isDownload = isset($_GET['download']) && $_GET['download'] === '1';

if (empty($file)) {
    http_response_code(400);
    die("Lỗi 400: Thiếu tham số tên tệp tin cần truy xuất.");
}

// Bảng ánh xạ thư mục lưu trữ theo phân loại chứng từ
$storageBase = [
    'statement' => __DIR__ . '/../storage/statements/',
    'receipt'   => __DIR__ . '/../storage/receipts/',
    'kyc'       => __DIR__ . '/../storage/kyc/',
];

$baseDir = $storageBase[$type] ?? $storageBase['statement'];

// Nối chuỗi đường dẫn lưu trữ
$targetPath = $baseDir . $file;

if (!file_exists($targetPath)) {
    http_response_code(404);
    die("Lỗi 404: Không tìm thấy tệp chứng từ trong kho lưu trữ dữ liệu.");
}

// Kiểm tra và gán MIME type phù hợp
$mimeType = 'text/plain';
if (function_exists('finfo_open')) {
    $finfo = finfo_open(FILEINFO_MIME_TYPE);
    $mimeType = finfo_file($finfo, $targetPath) ?: 'text/plain';
    finfo_close($finfo);
}

header('Content-Type: ' . $mimeType . '; charset=utf-8');

if ($isDownload) {
    header('Content-Disposition: attachment; filename="' . basename($file) . '"');
} else {
    header('Content-Disposition: inline; filename="' . basename($file) . '"');
}

header('Content-Length: ' . filesize($targetPath));
header('Cache-Control: private, no-cache, no-store, must-revalidate');

readfile($targetPath);
exit;
