# Hướng dẫn Setup Project Trên Local (XAMPP)

## Yêu cầu
- XAMPP đã cài đặt (có Apache, MySQL, PHP)
- Node.js và npm đã cài đặt
- Composer đã cài đặt (hoặc chạy qua PHP)

---

## Bước 1: Cấu hình XAMPP

### 1.1 Đặt Project vào thư mục htdocs
```
C:\xampp\htdocs\QLBH\
```

Sao chép toàn bộ folder `QLBH` vào `C:\xampp\htdocs\`

### 1.2 Khởi động XAMPP Control Panel
- Mở **XAMPP Control Panel**
- Click **Start** Apache
- Click **Start** MySQL

### 1.3 Kiểm tra MySQL Port
- Nếu MySQL chạy trên port khác 3306, cập nhật trong `.env.local`
- Mặc định XAMPP sử dụng port **3306**

---

## Bước 2: Setup Backend (Laravel - QLBH)

### 2.1 Cài đặt Dependencies
```bash
cd C:\xampp\htdocs\QLBH
composer install
```

Nếu không có Composer, dùng PHP:
```bash
php -r "copy('https://getcomposer.org/installer', 'composer-setup.php'); php composer-setup.php; unlink('composer-setup.php');"
```

### 2.2 Tạo Database
1. Mở **phpMyAdmin**: http://localhost/phpmyadmin
2. Tạo database mới tên `sales_management`
3. Chọn charset: `utf8mb4_unicode_ci`

### 2.3 Setup Environment
File `.env.local` đã được tạo sẵn với cấu hình cho local XAMPP:
- `APP_URL=http://localhost/QLBH`
- `DB_HOST=127.0.0.1`
- `DB_PORT=3306`
- `DB_DATABASE=sales_management`

### 2.4 Tạo Application Key
```bash
php artisan key:generate
```

### 2.5 Chạy Migration
```bash
php artisan migrate
```

### 2.6 Chạy Seeder (nếu cần)
```bash
php artisan db:seed
```

---

## Bước 3: Setup Frontend (Vue.js - qlbh-frontend)

### 3.1 Cài đặt Dependencies
```bash
cd C:\xampp\htdocs\...\qlbh-frontend
npm install
```

### 3.2 Cấu hình API URL
File `.env.local` đã được tạo với:
```
VITE_API_URL=http://localhost/QLBH/api
```

### 3.3 Chạy Dev Server
```bash
npm run dev
```

Server sẽ chạy trên: **http://localhost:5173**

---

## Bước 4: Truy cập Ứng dụng

### Frontend (Vue.js)
- URL: **http://localhost:5173**
- Đây là nơi chính để sử dụng ứng dụng

### Backend API (Laravel)
- URL: **http://localhost/QLBH/api**
- Dùng cho test API (Postman, Thunder Client, v.v.)

### PHP MyAdmin (Quản lý Database)
- URL: **http://localhost/phpmyadmin**

---

## Cấu hình Apache (httpd-vhosts.conf) - Tùy chọn

Nếu muốn có Virtual Host riêng:

1. Mở file: `C:\xampp\apache\conf\extra\httpd-vhosts.conf`
2. Thêm vào cuối file:

```apache
<VirtualHost *:80>
    ServerAdmin admin@qlbh.local
    DocumentRoot "C:/xampp/htdocs/QLBH/public"
    ServerName qlbh.local
    
    <Directory "C:/xampp/htdocs/QLBH/public">
        Options Indexes FollowSymLinks
        AllowOverride All
        Require all granted
    </Directory>
</VirtualHost>
```

3. Mở file: `C:\Windows\System32\drivers\etc\hosts` (với quyền Admin)
4. Thêm:
```
127.0.0.1       qlbh.local
```

5. Khởi động lại Apache

Lúc này bạn có thể truy cập: **http://qlbh.local/api**

---

## Các Lệnh Hữu Ích

### Backend Commands
```bash
# Chạy Migration
php artisan migrate

# Rollback Migration
php artisan migrate:rollback

# Refresh Database
php artisan migrate:refresh

# Seed Database
php artisan db:seed

# Tạo Model + Migration + Controller
php artisan make:model ModelName -mcr

# Xóa Cache
php artisan cache:clear
php artisan config:clear
```

### Frontend Commands
```bash
# Dev Server
npm run dev

# Build Production
npm run build

# Preview Build
npm run preview
```

---

## Troubleshooting

### 1. Lỗi "CORS error"
- Kiểm tra `config/cors.php` đã cho phép frontend origin
- Hiện tại đã cấu hình cho phép tất cả origins

### 2. Lỗi "Connection Refused"
- Kiểm tra MySQL đã start trong XAMPP
- Kiểm tra port MySQL (mặc định 3306)
- Kiểm tra DB_HOST, DB_PORT trong `.env.local`

### 3. Lỗi "File not found" (404)
- Kiểm tra `.htaccess` trong `public/` folder
- Kiểm tra `mod_rewrite` đã enable trong Apache

### 4. Lỗi "npm not found"
- Cài đặt Node.js từ https://nodejs.org/

### 5. Lỗi "Composer not found"
- Cài đặt Composer từ https://getcomposer.org/

### 6. API không kết nối được
- Kiểm tra `VITE_API_URL` trong `.env.local` (Frontend)
- Kiểm tra `APP_URL` trong `.env.local` (Backend)
- Kiểm tra CORS configuration
- Mở DevTools > Console để xem chi tiết lỗi

---

## Cấu trúc thư mục khi chạy trên XAMPP

```
C:\xampp\htdocs\
├── QLBH/                 (Backend Laravel)
│   ├── public/
│   │   ├── .htaccess
│   │   └── index.php
│   ├── app/
│   ├── config/
│   ├── routes/
│   ├── .env.local        (Đã tạo sẵn)
│   └── ...
└── qlbh-frontend/        (Frontend Vue)
    ├── src/
    ├── .env.local        (Đã tạo sẵn)
    ├── .env.development  (Đã tạo sẵn)
    ├── package.json
    └── vite.config.js
```

---

## Note
- **Không commit** `.env.local` vào Git
- Sử dụng `.env.example` làm template
- Nếu thay đổi Database, chỉnh sửa `DB_*` trong `.env.local`
