# 🚀 HƯỚNG DẪN CHẠY LOCAL - BACKEND & FRONTEND LIÊN KẾT ĐẦY ĐỦ

## ✅ Kiểm Tra Cấu Hình (ĐỌC TRƯỚC)

### 1️⃣ Cấu Trúc Thư Mục
```
C:\xampp\htdocs\
├── QLBH\                (Backend - Laravel)
│   ├── .env             ✓ Đã fix DB_PORT=3306 & APP_URL
│   ├── app/
│   ├── routes/api.php   ✓ API endpoints
│   └── public/
│
└── qlbh-frontend\       (Frontend - Vue.js)
    ├── .env.development ✓ Đã fix - proxy tới backend
    ├── vite.config.js   ✓ Proxy /api → http://localhost/QLBH/api
    └── src/
```

### 2️⃣ Cấu Hình Đã Sửa ✅
- **Backend `.env`**: 
  - `DB_PORT=3306` (XAMPP default, fix từ 3307)
  - `APP_URL=http://localhost/QLBH` (fix từ http://127.0.0.1:8000)
- **Frontend `.env.development`**: 
  - Proxy được cấu hình qua Vite (vite.config.js)
  - `/api` requests → `http://localhost/QLBH/api`

---

## 🎯 CHẠY CÁC LẦN SAU (Hàng Ngày)

### Bước 1️⃣: Khởi Động XAMPP
```bash
# Mở XAMPP Control Panel (C:\xampp\xampp-control.exe)
# Click "Start" → Apache
# Click "Start" → MySQL
# Chờ cả hai show "Running" ✓
```

### Bước 2️⃣: Khởi Động Backend (Laravel)
```bash
cd C:\xampp\htdocs\QLBH

# Kiểm tra kết nối database
php artisan tinker
# Gõ: DB::connection()->getPDO();
# Nếu không lỗi thì OK, gõ: exit()

# Hoặc chạy migration để test
php artisan migrate --force
```

✅ Backend sẵn sàng tại: **http://localhost/QLBH/api**

### Bước 3️⃣: Khởi Động Frontend (Vue.js)
```bash
cd C:\xampp\htdocs\QLBH\qlbh-frontend

# Hoặc từ terminal đã mở:
# cd qlbh-frontend

npm run dev
```

✅ Sẽ hiển thị:
```
  VITE v7.x.x  ready in XXX ms
  ➜  Local:   http://localhost:5173/
```

### Bước 4️⃣: Truy Cập & Kiểm Tra
- Mở browser → **http://localhost:5173/**
- Kiểm tra Console (F12) có lỗi CORS hay không
- Nếu có API calls → chúng sẽ tới `http://localhost/QLBH/api`

---

## 🔍 KIỂM TRA KẾT NỐI

### ✓ Test Backend API
```bash
# Terminal mới:
curl http://localhost/QLBH/api/categories
```
Nếu trả về JSON → Backend OK ✅

### ✓ Test Frontend Proxy
1. Mở **DevTools (F12)** → **Network tab**
2. Click vào page (reload)
3. Tìm request tới `/api/...`
4. Nếu status 200 → Proxy OK ✅

### ✓ Test Database Connection
```bash
cd C:\xampp\htdocs\QLBH
php artisan tinker
DB::connection()->getPDO();
# Nếu không lỗi → Database OK ✅
exit()
```

---

## ⚠️ LỖI THƯỜNG GẶP & CÁCH FIX

### ❌ "Could not find driver" / Database Connection Error
**Nguyên nhân:** MySQL port sai hoặc MySQL chưa chạy
```bash
# Fix:
# 1. Kiểm tra XAMPP MySQL đã "Running" chưa
# 2. Nếu port khác 3306, cập nhật .env:
DB_PORT=3307  # (nếu port là 3307)
```

### ❌ Frontend không call được API / CORS error
**Nguyên nhân:** Backend URL sai hoặc CORS chưa được allow
```bash
# Fix:
# 1. Kiểm tra .env: APP_URL=http://localhost/QLBH
# 2. CORS đã enable trong config/cors.php
# 3. Restart Laravel
```

### ❌ "Port 5173 already in use"
```bash
# Fix:
# Terminate process trên port 5173 hoặc dùng port khác
npm run dev -- --port 5174
```

---

## 🎬 TÓM TẮT FLOW

```
User Browser (http://localhost:5173/)
    ↓
Vue.js Frontend (Vite Dev Server)
    ↓
Request to /api/categories
    ↓
Vite Proxy (vite.config.js)
    ↓
http://localhost/QLBH/api/categories
    ↓
Laravel Routes (QLBH/routes/api.php)
    ↓
Controller → Database → Response
    ↓
JSON response back to Frontend
```

---

## 📝 CÔNG THỨC MỌI LẦN CHẠY

**Terminal 1:**
```bash
# XAMPP Control Panel → Start Apache + MySQL
```

**Terminal 2:**
```bash
cd qlbh-frontend
npm run dev
```

**Truy cập:** http://localhost:5173/

**XONG!** ✨

---

## 🆘 Nếu Vẫn Có Lỗi

1. **Check logs:**
   ```bash
   # Backend logs
   cat storage/logs/laravel.log
   ```

2. **Clear cache:**
   ```bash
   php artisan cache:clear
   php artisan config:clear
   ```

3. **Reinstall dependencies:**
   ```bash
   # Backend
   cd QLBH
   composer install
   
   # Frontend
   cd qlbh-frontend
   npm install
   ```

4. **Reset database:**
   ```bash
   php artisan migrate:fresh --seed
   ```
