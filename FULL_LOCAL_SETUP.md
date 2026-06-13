# 🚀 LOCAL DEVELOPMENT - HƯỚNG DẪN ĐẦY ĐỦ

## 📋 Yêu Cầu Hệ Thống

- ✅ XAMPP (Apache, MySQL, PHP 8.0+)
- ✅ Node.js + npm
- ✅ Composer (hoặc PHP CLI)
- ✅ Git (tùy chọn)

---

## 🎯 SETUP LẦN ĐẦU

### **1️⃣ Chuẩn Bị Thư Mục**

```bash
# Copy project vào XAMPP htdocs
# C:\xampp\htdocs\QLBH\
# Cấu trúc thư mục:
# C:\xampp\htdocs\
#   ├── QLBH\                  (Backend)
#   └── qlbh-frontend\         (Frontend)
```

### **2️⃣ Khởi Động XAMPP**

- Mở **XAMPP Control Panel** (C:\xampp\xampp-control.exe)
- Click **Start** Apache
- Click **Start** MySQL
- Đợi cho đến khi cả hai chuyển thành **Running** ✓

### **3️⃣ Setup Database**

#### **A. Tạo Database**
```bash
# Mở phpMyAdmin: http://localhost/phpmyadmin
# 
# 1. Bấm "New" ở sidebar trái
# 2. Database name: sales_management
# 3. Collation: utf8mb4_unicode_ci
# 4. Bấm Create
```

#### **B. Kiểm Tra `.env.local` (Backend)**
```bash
cd C:\xampp\htdocs\QLBH
# File: .env.local
# Nội dung:
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=sales_management
DB_USERNAME=root
DB_PASSWORD=
```

**Nếu MySQL port khác 3306**, cập nhật `DB_PORT`  
**Nếu MySQL có password**, thêm vào `DB_PASSWORD`

### **4️⃣ Setup Backend (Laravel)**

```bash
cd C:\xampp\htdocs\QLBH

# Cài Composer dependencies
composer install

# Tạo app key (nếu chưa có)
php artisan key:generate

# Chạy database migrations (tạo bảng)
php artisan migrate

# (OPTIONAL) Seed data test
php artisan db:seed
```

**Output kỳ vọng:**
```
Migration table created successfully.
Migrating: ...
Migrated:  ... (success)
```

### **5️⃣ Setup Frontend (Vue.js)**

```bash
cd C:\xampp\htdocs\QLBH\qlbh-frontend
# Hoặc: cd qlbh-frontend

# Cài npm dependencies
npm install

# Kiểm tra cài đặt xong
npm list
```

---

## 🎬 CHẠY DEVELOPMENT (Hàng Ngày)

### **Bước 1: Start XAMPP**
- Mở XAMPP Control Panel
- Start Apache + MySQL

### **Bước 2: Chạy Frontend Dev Server**

**Mở Terminal/PowerShell và chạy:**

```bash
cd C:\xampp\htdocs\QLBH\qlbh-frontend

npm run dev
```

**Hoặc:**

```bash
npm run serve
```

**Output kỳ vọng:**
```
  VITE v7.2.4  ready in XXX ms

  ➜  Local:   http://localhost:5173/
  ➜  press h to show help
```

### **Bước 3: Truy Cập Ứng Dụng**

- Mở browser: **http://localhost:5173/**
- Bạn sẽ thấy trang chủ ANIME NEI với:
  - Header + Navigation menu
  - Slider/Banner
  - Danh sách sản phẩm
  - Chat support
  - Footer

✨ **XONG! Giờ bạn có thể phát triển**

---

## 🔧 Các Lệnh Hữu Ích (Backend)

```bash
cd C:\xampp\htdocs\QLBH

# Chạy migration
php artisan migrate

# Rollback (undo) migrations
php artisan migrate:rollback

# Fresh (xóa + tạo lại tất cả bảng)
php artisan migrate:refresh

# Seed database
php artisan db:seed

# Clear cache
php artisan cache:clear
php artisan config:clear

# Tạo Model + Migration + Controller
php artisan make:model ModelName -mcr

# Test API (chỉ dev mode)
php artisan tinker
```

## 🔧 Các Lệnh Hữu Ích (Frontend)

```bash
cd C:\xampp\htdocs\QLBH\qlbh-frontend

# Dev server
npm run dev

# Build production
npm run build

# Preview build (test production locally)
npm run preview

# Cài package mới
npm install package-name

# Cập nhật dependencies
npm update
```

---

## 🏗️ PRODUCTION BUILD

Khi bạn hoàn thành phát triển, build project:

### **Bước 1: Build Vue App**
```bash
cd qlbh-frontend
npm run build
```

**Kết quả:** Files được build tới `QLBH/public/dist/`

### **Bước 2: Kiểm Tra**
```
QLBH/public/dist/
├── index.html
├── manifest.json
└── assets/
    ├── main.xxxx.js
    ├── style.xxxx.css
    └── ...
```

### **Bước 3: Truy Cập Production**

Mở browser: **http://localhost/QLBH**

Laravel sẽ tự động serve Vue app từ `public/dist/`

---

## 📡 API Endpoints

### **Base URL**
```
Development:  http://localhost/QLBH/api
Production:   http://localhost/QLBH/api
```

### **Các Endpoint Chính**

| Phương Thức | Endpoint | Mô Tả |
|------------|----------|-------|
| GET | `/api/products` | Danh sách sản phẩm |
| GET | `/api/products/{id}` | Chi tiết sản phẩm |
| GET | `/api/categories` | Danh mục |
| GET | `/api/vouchers` | Vouchers |
| POST | `/api/login` | Đăng nhập |
| POST | `/api/orders` | Tạo đơn hàng |

**Note:** API hiện tại được cấu hình cho public access (GET requests).

---

## 📁 Cấu Trúc Project

```
C:\xampp\htdocs\
├── QLBH/                           (Backend - Laravel)
│   ├── app/
│   │   ├── Http/Controllers/API/   (API Controllers)
│   │   ├── Models/                 (Database Models)
│   │   └── Providers/
│   ├── config/
│   │   ├── cors.php                (CORS config)
│   │   └── database.php            (DB config)
│   ├── database/
│   │   ├── migrations/             (Schema)
│   │   └── seeders/                (Test data)
│   ├── public/
│   │   ├── dist/                   (Vue build output - production)
│   │   ├── index.php               (Entry point)
│   │   └── .htaccess               (URL routing)
│   ├── resources/
│   │   ├── views/
│   │   │   └── spa.blade.php       (SPA template)
│   │   └── js/
│   ├── routes/
│   │   ├── api.php                 (API routes)
│   │   └── web.php                 (SPA route)
│   ├── .env.local                  (Local config)
│   └── composer.json               (PHP dependencies)
│
└── qlbh-frontend/                  (Frontend - Vue.js)
    ├── src/
    │   ├── App.vue                 (Root component)
    │   ├── api/                    (API clients)
    │   │   └── axiosInstance.js
    │   │   └── productApi.js
    │   ├── components/             (Reusable components)
    │   ├── layouts/                (Layout components)
    │   │   └── MainLayout.vue
    │   ├── pages/                  (Page components)
    │   │   ├── Home.vue
    │   │   ├── Cart.vue
    │   │   ├── Checkout.vue
    │   │   └── ...
    │   ├── router/
    │   │   └── index.js            (Vue Router config)
    │   ├── services/               (Business logic)
    │   └── main.js                 (Entry point)
    ├── public/                     (Static assets)
    │   └── images/
    ├── .env.development            (Dev config)
    ├── vite.config.js              (Vite config)
    ├── package.json                (Dependencies)
    └── index.html                  (HTML template)
```

---

## 🐛 TROUBLESHOOTING

### ❌ **Lỗi: "Cannot connect to database"**

**Giải pháp:**
1. Kiểm tra MySQL đã start: XAMPP Control Panel > MySQL > **Running** ✓
2. Kiểm tra `.env.local`:
   ```
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=sales_management
   ```
3. Kiểm tra database tồn tại: http://localhost/phpmyadmin

### ❌ **Lỗi: "npm ERR!"**

**Giải pháp:**
```bash
# Xóa node_modules
rmdir /s node_modules

# Xóa lock file
del package-lock.json

# Cài lại
npm install
```

### ❌ **Lỗi: "CORS error"**

**Giải pháp:**
1. Kiểm tra `QLBH/config/cors.php`
2. Đảm bảo `allowed_origins` bao gồm:
   ```php
   'allowed_origins' => ['*'],  // or http://localhost:5173
   ```

### ❌ **Lỗi: "Cannot GET /" (Frontend trắng)**

**Giải pháp:**
1. **Dev mode:** Đảm bảo Vite server chạy: `npm run dev`
2. **Production:** Đảm bảo `npm run build` đã chạy
3. Kiểm tra `QLBH/public/dist/index.html` tồn tại

### ❌ **Lỗi: "API 404 Not Found"**

**Giải pháp:**
1. Kiểm tra Apache chạy
2. Kiểm tra URL đúng: `/api/products` (không phải `/QLBH/api/products`)
3. Kiểm tra routes định nghĩa trong `routes/api.php`

### ❌ **Lỗi: "Port 5173 already in use"**

**Giải pháp:**
```bash
# Thay đổi port trong vite.config.js
server: {
  port: 5174,  // hoặc port khác
  ...
}

# Hoặc kill process sử dụng port:
# Windows
netstat -ano | findstr :5173
taskkill /PID <PID> /F
```

### ❌ **Database migrations không chạy**

**Giải pháp:**
```bash
cd QLBH

# Kiểm tra status
php artisan migrate:status

# Nếu cần reset
php artisan migrate:refresh

# Nếu vẫn lỗi, check APP_KEY
php artisan key:generate
```

---

## 📝 File Quan Trọng để Edit

| File | Mục Đích | Ví Dụ |
|------|---------|-------|
| `QLBH/.env.local` | Config database + app | DB_HOST, APP_URL |
| `qlbh-frontend/vite.config.js` | Vite server config | port, proxy, build |
| `QLBH/routes/api.php` | API routes | Route::get('products', ...) |
| `qlbh-frontend/src/router/index.js` | Frontend routes | { path: '/', component: Home } |
| `qlbh-frontend/src/api/axiosInstance.js` | HTTP client config | baseURL, interceptors |

---

## ✅ CHECKLIST TRƯỚC KHI CHẠY

- [ ] XAMPP Control Panel mở
- [ ] Apache: **Running** ✓
- [ ] MySQL: **Running** ✓
- [ ] Database `sales_management` tồn tại
- [ ] `.env.local` cấu hình đúng (DB info)
- [ ] `composer install` đã chạy
- [ ] `php artisan migrate` đã chạy
- [ ] `npm install` đã chạy (trong qlbh-frontend)
- [ ] Không có error trong console

---

## 🚀 QUICK START (TÓM TẮT)

### **Lần Đầu:**
```bash
# 1. Backend
cd C:\xampp\htdocs\QLBH
composer install
php artisan key:generate
php artisan migrate

# 2. Frontend
cd qlbh-frontend
npm install
```

### **Mỗi Lần:**
```bash
# 1. Start XAMPP (Apache + MySQL)
# 2. Terminal: cd qlbh-frontend && npm run dev
# 3. Browser: http://localhost:5173
```

### **Production:**
```bash
cd qlbh-frontend
npm run build
# Browser: http://localhost/QLBH
```

---

## 📞 LIÊN HỆ HỖ TRỢ

**Nếu gặp lỗi:**
1. Kiểm tra file này: Troubleshooting section
2. Kiểm tra console (F12) xem error message
3. Kiểm tra terminal xem warning/error

---

**Happy Coding! 🎉**
