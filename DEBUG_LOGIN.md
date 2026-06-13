# 🔴 LỖI LOGIN - NGUYÊN NHÂN & CÁCH FIX

## 🚨 Vấn Đề Chính
**MySQL không chạy!** Backend không thể kết nối cơ sở dữ liệu → Tất cả API request fail

---

## ✅ CÁCH FIX (Bước theo bước)

### 1️⃣ **Khởi Động XAMPP (CẦN TRƯỚC MỌI THỨ)**

```bash
# Mở XAMPP Control Panel: C:\xampp\xampp-control.exe
# Hoặc từ Terminal:
C:\xampp\xampp_start.exe

# Click "Start" Apache ✓
# Click "Start" MySQL ✓
# Chờ cả 2 thành "Running"
```

### 2️⃣ **Kiểm Tra MySQL Kết Nối**

```bash
cd C:\xampp\htdocs\QLBH

# Thử kết nối database
php artisan tinker
> DB::connection()->getPDO();
> exit()
```

✅ Nếu không có lỗi → Database OK

### 3️⃣ **Chạy Migrations (Tạo bảng)**

```bash
cd C:\xampp\htdocs\QLBH

# Chạy tất cả migrations
php artisan migrate --force

# Kết quả:
# Migrating: ...
# Migrated:  ...
```

### 4️⃣ **Clear Cache & Config**

```bash
php artisan cache:clear
php artisan config:clear
php artisan config:cache
```

### 5️⃣ **Restart Frontend Dev Server**

```bash
cd C:\xampp\htdocs\QLBH\qlbh-frontend

# Đóng dev server cũ (Ctrl+C)
# Chạy lại
npm run dev
```

---

## 🔧 CÁC LỖI CỤ THỂ & GIẢI PHÁP

### ❌ Lỗi: "Could not find driver"
```
SQLSTATE[HY000] [2002] Connection refused
```
**→ FIX:** Mở XAMPP → Start MySQL

### ❌ Lỗi: "No such file or directory"
```
SQLSTATE[HY000] [2002]
```
**→ FIX:** Kiểm tra `.env` port: `DB_PORT=3306`

### ❌ Lỗi: "Table 'users' doesn't exist"
```
SQLSTATE[42S02]: Table not found
```
**→ FIX:** Chạy `php artisan migrate --force`

### ❌ Lỗi: "Unknown database 'sales_management'"
```
SQLSTATE[HY000]: Unknown database
```
**→ FIX:**
```bash
# Mở phpMyAdmin: http://localhost/phpmyadmin
# Tạo database: sales_management
# Charset: utf8mb4_unicode_ci
```

---

## 📋 CHECKLIST TRƯỚC KHI ĐĂNG NHẬP

- [ ] XAMPP Apache chạy ✓
- [ ] XAMPP MySQL chạy ✓
- [ ] Database `sales_management` tồn tại
- [ ] Migrations đã chạy (`php artisan migrate --force`)
- [ ] `.env` có `DB_PORT=3306`
- [ ] `.env` có `APP_URL=http://localhost/QLBH`
- [ ] Frontend dev server chạy (`npm run dev`)
- [ ] Truy cập: http://localhost:5173/login

---

## 🧪 TEST API TRỰC TIẾP

```bash
# Terminal mới:
curl http://localhost/QLBH/api/login \
  -X POST \
  -H "Content-Type: application/json" \
  -d '{"email":"test@example.com","password":"password123"}'

# Nếu trả về JSON → Backend hoạt động ✅
```

---

## 📊 FLOW CHỈ TIÊU

```
Frontend: http://localhost:5173/login
    ↓
Form submit → axiosInstance.post('login', {...})
    ↓
Axios baseURL: /api → URL = /api/login
    ↓
Vite Proxy: /api → http://localhost/QLBH/api
    ↓
http://localhost/QLBH/api/login
    ↓
AuthController@login
    ↓
Query Users table
    ↓
Response JSON + JWT Token
    ↓
Frontend lưu localStorage + redirect
```

---

## 🆘 NẾU VẪN LỖI

1. **Check Laravel logs:**
   ```bash
   tail -f storage/logs/laravel.log
   ```

2. **Check browser DevTools (F12):**
   - Network tab → look for `/api/login` request
   - Response tab → check error message from backend

3. **Check backend response:**
   ```bash
   curl -v http://localhost/QLBH/api/login \
     -X POST \
     -H "Content-Type: application/json" \
     -d '{"email":"test@example.com","password":"123456"}'
   ```

4. **Reset toàn bộ:**
   ```bash
   php artisan migrate:fresh --seed
   php artisan cache:clear
   php artisan config:clear
   ```

---

## ✨ ĐƠNYÊN NỐI

**Lệnh magic để start mọi thứ:**

**PowerShell/CMD:**
```batch
REM Start XAMPP
start C:\xampp\xampp-control.exe

REM Wait a bit, then open another terminal
REM Terminal 2:
cd C:\xampp\htdocs\QLBH\qlbh-frontend
npm run dev

REM Browser:
start http://localhost:5173/login
```

**Git Bash:**
```bash
# Terminal 1
cd /c/xampp
bash xampp_start.sh

# Terminal 2
cd /c/xampp/htdocs/QLBH/qlbh-frontend
npm run dev

# Browser
open http://localhost:5173/login
```
