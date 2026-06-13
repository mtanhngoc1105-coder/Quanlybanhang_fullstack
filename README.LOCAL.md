# 🚀 LOCAL DEVELOPMENT - QUICK START

## ⚡ Bắt Đầu Nhanh (5 Phút)

### **1️⃣ Chuẩn Bị (Lần Đầu)**

```bash
# Terminal 1: Setup Backend
cd C:\xampp\htdocs\QLBH
composer install
php artisan key:generate
php artisan migrate

# Terminal 2: Setup Frontend
cd qlbh-frontend
npm install
```

### **2️⃣ Start XAMPP**
- Mở **XAMPP Control Panel**
- Click **Start** Apache ✓
- Click **Start** MySQL ✓

### **3️⃣ Chạy Frontend**
```bash
cd qlbh-frontend
npm run dev
```

### **4️⃣ Truy Cập**
- Mở browser: **http://localhost:5173** ✨

---

## 📝 Hàng Ngày (Sau Lần Đầu)

### **Start:**
```bash
# Terminal 1: XAMPP trên background (hoặc mở XAMPP Control Panel)
# Terminal 2: Frontend
cd qlbh-frontend
npm run dev
```

### **Truy cập:** http://localhost:5173

---

## 🏗️ Production Build

```bash
cd qlbh-frontend
npm run build
```

Truy cập: **http://localhost/QLBH**

---

## 📊 URL Reference

| Dịch Vụ | Development | Production |
|---------|-------------|-----------|
| **Frontend** | http://localhost:5173 | http://localhost/QLBH |
| **API** | http://localhost:5173/api | http://localhost/QLBH/api |
| **Database** | http://localhost/phpmyadmin | http://localhost/phpmyadmin |

---

## ❓ Gặp Vấn Đề?

**Xem:** [FULL_LOCAL_SETUP.md](FULL_LOCAL_SETUP.md) - Hướng dẫn chi tiết + Troubleshooting

---

## 🎯 Cấu Trúc Project

```
Project/
├── QLBH/                      ← Backend (Laravel API)
│   ├── app/Models/
│   ├── app/Http/Controllers/
│   ├── database/migrations/
│   ├── routes/api.php
│   ├── .env.local
│   └── public/
│       ├── index.php
│       └── dist/             ← Vue build output
│
└── qlbh-frontend/             ← Frontend (Vue.js)
    ├── src/
    │   ├── pages/            ← Page components
    │   ├── components/       ← Reusable components
    │   ├── api/              ← API clients
    │   ├── router/           ← Routes
    │   └── main.js
    ├── vite.config.js        ← Vite configuration
    ├── package.json
    └── .env.development
```

---

## 🔗 Kết Nối

- ✅ **Vite Proxy**: Tự động forward `/api` → Backend
- ✅ **CORS**: Enabled cho API access
- ✅ **Router**: Web History Mode (URL sạch)
- ✅ **Build**: Vue app → `QLBH/public/dist`

---

## ✨ Features

- 🏪 Trang chủ với slider + sản phẩm
- 🔍 Tìm kiếm sản phẩm
- 🛒 Giỏ hàng
- 📦 Quản lý đơn hàng
- 👤 Đăng nhập/Đăng ký
- 💬 Chat support

---

## 🎬 Video Hướng Dẫn (Optional)

1. **Setup XAMPP** → Start Apache + MySQL
2. **Setup Database** → Tạo `sales_management`
3. **Backend** → `composer install` + `php artisan migrate`
4. **Frontend** → `npm install` + `npm run dev`
5. **Browser** → http://localhost:5173 🎉

---

**Thắc mắc?** Xem [FULL_LOCAL_SETUP.md](FULL_LOCAL_SETUP.md)

