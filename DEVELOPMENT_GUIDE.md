# 🚀 Cấu Hình Local Setup Đã Cập Nhật

Tôi đã tối ưu hóa project để chạy local **một cách đơn giản nhất**. Không cần nhiều server hay cấu hình phức tạp.

---

## 📋 Tóm Tắt Thay Đổi

### **Frontend (Vue.js - qlbh-frontend)**
✅ Cấu hình Vite Proxy tới Laravel API  
✅ Đổi Router từ Hash Mode (`/#/`) sang Web History Mode (`/`)  
✅ Đơn giản hóa Axios configuration  
✅ Thêm script `serve` (alias cho `dev`)  
✅ Cấu hình Build output tới Laravel public folder  

### **Backend (Laravel - QLBH)**
✅ Cấu hình SPA route để serve Vue app  
✅ Tạo `spa.blade.php` view  
✅ Setup CORS cho API access  

---

## 🎯 Cách Chạy Local (Development)

### **1. Setup Ban Đầu (Lần Đầu)**

#### **A. Backend Setup**
```bash
cd C:\xampp\htdocs\QLBH

# Cài dependencies
composer install

# Tạo app key
php artisan key:generate

# Database migrations
php artisan migrate

# (Optional) Seed data
php artisan db:seed
```

#### **B. Frontend Setup**
```bash
cd qlbh-frontend

# Cài dependencies
npm install
```

### **2. Chạy Development Server (Mỗi Lần Làm Việc)**

#### **CÁCH 1: Chạy Vite Dev Server (Khuyến Nghị)**

Chỉ cần chạy **1 lệnh duy nhất**:

```bash
cd qlbh-frontend
npm run dev
```

**Hoặc sử dụng alias:**
```bash
npm run serve
```

Vite dev server sẽ chạy trên **http://localhost:5173** với:
- 🔄 Hot Module Replacement (HMR) - reload tự động khi bạn sửa code
- 🔗 Proxy tới Laravel API tại `/api`
- 🎨 Vue 3 Single File Component support
- ⚡ Nhanh chóng, hiệu quả

**Không cần làm gì khác!** Laravel API sẽ tự động chạy trên `http://localhost/QLBH/api`

---

#### **CÁCH 2: Chạy Laravel Dev Server (Tùy chọn)**

Nếu muốn test API trực tiếp:

```bash
cd QLBH
php artisan serve --port=8000
```

Lúc này:
- Frontend: http://localhost:5173
- Backend: http://localhost:8000/api

**Cần update `vite.config.js`:**
```javascript
// Nếu dùng cách này, thay đổi:
proxy: {
  '/api': {
    target: 'http://localhost:8000',  // Thay từ /QLBH
    changeOrigin: true,
    rewrite: (path) => path
  }
}
```

---

## 🏗️ Build cho Production (Sau Khi Hoàn Thành)

### **Bước 1: Build Vue App**
```bash
cd qlbh-frontend
npm run build
```

**Kết quả:** Vue app được build tới `QLBH/public/dist/`

### **Bước 2: Truy Cập**
Mở browser: **http://localhost/QLBH/**

Laravel sẽ tự động serve Vue app từ `public/dist/` cho tất cả routes.

### **Bước 3: Đóng Vite Dev Server**
- Nhấn `Ctrl + C` trong terminal chạy `npm run dev`
- Giờ chỉ cần Apache + MySQL chạy

---

## 📁 Cấu Trúc Thư Mục Build

```
QLBH/
├── public/
│   ├── dist/                    ← Vue build output (sau npm run build)
│   │   ├── index.html
│   │   ├── assets/
│   │   │   ├── main.xxxx.js
│   │   │   ├── style.xxxx.css
│   │   │   └── ...
│   │   └── manifest.json
│   ├── .htaccess
│   └── index.php
├── resources/
│   ├── views/
│   │   └── spa.blade.php        ← Entry point để serve Vue
│   └── js/
│       └── main.js
├── routes/
│   ├── api.php                  ← API routes
│   └── web.php                  ← SPA route
└── .env.local                   ← Environment config
```

---

## 🔧 File Đã Thay Đổi

| File | Thay Đổi |
|------|---------|
| [qlbh-frontend/vite.config.js](qlbh-frontend/vite.config.js) | Thêm server proxy và build config |
| [qlbh-frontend/src/router/index.js](qlbh-frontend/src/router/index.js) | Đổi sang Web History Mode |
| [qlbh-frontend/src/api/axiosInstance.js](qlbh-frontend/src/api/axiosInstance.js) | Đơn giản hóa API URL |
| [qlbh-frontend/package.json](qlbh-frontend/package.json) | Thêm script `serve` |
| [QLBH/routes/web.php](QLBH/routes/web.php) | Thêm SPA catch-all route |
| [QLBH/resources/views/spa.blade.php](QLBH/resources/views/spa.blade.php) | View mới để serve Vue |

---

## ✨ Lợi Ích Cấu Hình Mới

| Trước | Sau |
|-------|-----|
| ❌ Chạy 2 dev server (Vite + Laravel) | ✅ Chỉ 1 Vite dev server |
| ❌ URL có `#` (Hash mode) | ✅ URL sạch (Web history) |
| ❌ Phức tạp cấu hình API | ✅ Tự động proxy `/api` |
| ❌ Cần quản lý 2 port khác nhau | ✅ Vite tự động xử lý |
| ❌ Build cầu kỳ | ✅ Build đơn giản vào `public/dist` |

---

## 🐛 Troubleshooting

### **Lỗi: "Cannot GET /path"**
- ✅ **Dev Mode:** Vite sẽ tự handle, không cần lo
- ✅ **Production:** Chắc chắn đã chạy `npm run build`

### **Lỗi: "API not found" (Cannot POST /api/...)**
1. Kiểm tra Apache đang chạy
2. Kiểm tra MySQL đang chạy
3. Kiểm tra vite.config.js proxy target đúng: `http://localhost/QLBH`

### **Vue app không load (Production)**
1. Chạy: `npm run build`
2. Kiểm tra file tồn tại: `QLBH/public/dist/index.html`
3. Truy cập: `http://localhost/QLBH/`

### **HMR không hoạt động**
- Vite dev server mặc định sử dụng localhost
- Nếu dùng IP khác, edit `vite.config.js`:
```javascript
server: {
  hmr: {
    host: '192.168.x.x',  // Thay bằng IP máy của bạn
    port: 5173
  }
}
```

---

## 📝 Environment Files

### **`.env.local` (Backend)**
```
APP_URL=http://localhost/QLBH
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=sales_management
```

### **`.env.development` (Frontend)**
```
VITE_API_URL=http://localhost/QLBH/api
```

**Note:** Không commit `.env.local` hoặc `.env.development` lên Git!

---

## 🎬 Quick Start Commands

### **Lần đầu:**
```bash
# Terminal 1: Backend setup
cd QLBH
composer install
php artisan key:generate
php artisan migrate

# Terminal 2: Frontend setup
cd qlbh-frontend
npm install
```

### **Mỗi lần làm việc:**
```bash
# Chỉ cần 1 lệnh này!
cd qlbh-frontend
npm run dev

# Rồi truy cập: http://localhost:5173
```

### **Khi hoàn thành:**
```bash
# Terminal: Frontend build
cd qlbh-frontend
npm run build

# Truy cập: http://localhost/QLBH/
```

---

## ✅ Checklist

- [ ] XAMPP đã start (Apache + MySQL)
- [ ] Database `sales_management` đã tạo
- [ ] Migration đã chạy
- [ ] Frontend dependencies installed (`npm install`)
- [ ] Vite dev server chạy (`npm run dev`)
- [ ] Mở http://localhost:5173 ✨

**Xong! 🎉 Thưởng thức phát triển!**
