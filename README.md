# Novus Capital Bank - Môi Trường Huấn Luyện Pentest Thực Tế

Chào bạn! Đây là bài tập thực hành dành riêng cho **Intern Pentester** với mục tiêu giả lập một ứng dụng thực tế (Production-like Web Application). Hệ thống được thiết kế dưới dạng nền tảng ngân hàng trực tuyến cao cấp (**Novus Capital Online Banking**) chứa các lỗ hổng **Directory Path Traversal** được ẩn giấu tự nhiên trong các luồng nghiệp vụ thường gặp.

---

## 1. Hướng Dẫn Vận Hành Môi Trường Docker

Ứng dụng được đóng gói hoàn toàn trong Docker Compose:

```bash
# Khởi động hệ thống ngân hàng (chạy nền)
docker compose up -d

# Xem log hoạt động của web server Apache / PHP
docker compose logs -f

# Dừng container khi hoàn thành phiên thực hành
docker compose down
```

- **Địa chỉ truy cập:** [http://localhost:8080](http://localhost:8080)
- **Tài khoản kiểm thử (Demo Account):**
  - **Tên đăng nhập (CIF):** `alex.vance`
  - **Mật khẩu:** `Password@123`
  - *(Hoặc bấm trực tiếp nút "Vào Ngay Bằng Tài Khoản Demo" trên giao diện)*

---

## 2. Cấu Trúc Mã Nguồn Ứng Dụng (Architecture)

```text
d:\HaoNN_Working\Train_Pentest\
├── docker-compose.yml              # Cấu hình container novus_banking_app (Port 8080)
├── Dockerfile                      # PHP 8.2 Apache + tạo file bí mật hệ thống
├── README.md                       # Tài liệu hướng dẫn & phạm vi kiểm thử
└── src/                            # Mã nguồn ứng dụng ngân hàng (/var/www/html)
    ├── index.php                   # Màn hình đăng nhập bảo mật
    ├── dashboard.php               # Bảng điều khiển tài chính (Số dư, Chuyển tiền, Lịch sử)
    ├── transactions.php            # Nhật ký giao dịch & tải biên lai (.txt)
    ├── statements.php              # Kho sao kê điện tử định kỳ (e-Statements)
    ├── kyc.php                     # Trung tâm quản lý hồ sơ định danh khách hàng
    ├── support.php                 # Hệ thống ticket & xem nhật ký chẩn đoán kỹ thuật
    ├── api/
    │   └── download.php            # Trình xử lý backend tải và hiển thị chứng từ
    ├── config/
    │   ├── database.php            # File cấu hình kết nối DB (Chứa mật khẩu & user)
    │   └── app.php                 # File cấu hình khóa mã hóa, JWT secret & SWIFT key
    ├── storage/
    │   ├── statements/             # Thư mục lưu bản sao kê tháng 01, tháng 02/2026
    │   ├── receipts/               # Thư mục lưu biên lai chuyển tiền
    │   ├── kyc/                    # Thư mục lưu bản scan giấy tờ tùy thân
    │   └── logs/
    │       ├── bank_audit.log      # Nhật ký kiểm toán bảo mật nội bộ
    │       └── ticket_8812.log     # File log chẩn đoán ticket #8812
    └── assets/
        └── css/app.css             # Giao diện Fintech Dark Mode chuyên nghiệp
```

---

## 3. Mục Tiêu Kiểm Thử (Engagement Objectives)

Hãy đóng vai trò một Chuyên viên Kiểm thử Xâm nhập (Pentester) được ủy quyền đánh giá hệ thống ngân hàng theo mô hình Black-box / Grey-box:

1. **Reconnaissance & Parameter Mapping:**
   - Dạo quanh các tính năng trong hệ thống (Dashboard, Lịch sử giao dịch, Sao kê, Hồ sơ KYC, Phiếu hỗ trợ).
   - Xác định những nơi ứng dụng gửi tham số lên máy chủ để yêu cầu đọc hoặc tải file (như `file=...`, `type=...`, `view_log=...`).
2. **Khai thác Directory Path Traversal:**
   - Tìm ra các endpoint mà lập trình viên xử lý nối chuỗi đường dẫn lỏng lẻo mà không có cơ chế chuẩn hóa (Canonicalization) hoặc kiểm soát danh sách trắng (Whitelist).
3. **Thu thập các mục tiêu nhạy cảm (Flags / Crown Jewels):**
   - **Cấp độ 1 (Source Code & Config Disclosure):** Tìm cách đọc file cấu hình DB `config/database.php` hoặc cấu hình khóa bảo mật `config/app.php`.
   - **Cấp độ 2 (Internal Audit Logs):** Tìm cách đọc nhật ký kiểm toán mật `storage/logs/bank_audit.log`.
   - **Cấp độ 3 (Container & System Escape):** Đọc danh sách tài khoản hệ điều hành `/etc/passwd` và khóa Vault của ngân hàng tại `/var/secret/vault_master_key.txt`.

---

## 4. Quy Trình Phối Hợp & Giải Đáp Thắc Mắc

- Bạn hãy tự do kiểm thử bằng trình duyệt hoặc các công cụ pentest quen thuộc (Burp Suite, curl, python script,...).
- Khi bạn gặp trở ngại (ví dụ: bối rối về cấu trúc đường dẫn, cách fuzzing, hoặc không chắc chắn lỗi nằm ở đâu) hoặc khi bạn đã tìm thấy dữ liệu và muốn mổ xẻ xem tại sao đoạn code đó lại bị hổng, hãy nhắn lại cho mình để chúng ta cùng phân tích sâu nhé!
