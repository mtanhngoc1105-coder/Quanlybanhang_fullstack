<template>
  <div class="main-layout">
    <header class="primary-header">
      <div class="primary-header-inner">
        <div class="header-section logo-section">
          <router-link to="/" class="brand">
            <img src="/images/logo/logo.jpg" alt="Shop Của Ngọc" class="brand-logo" />
            <div class="brand-text">
              <strong>ANIME NEI</strong>
              <span>Shop Của Ngọc</span>
            </div>
          </router-link>
        </div>

       
        <div class="header-section search-section">
          <div class="search-container">
            <div class="search-box">
              <input
                v-model="searchKeyword"
                type="text"
                placeholder="Từ khóa..."
                class="search-input"
                @keyup.enter="onSearch"
              />
              <button class="search-submit" @click="onSearch">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                  <circle cx="11" cy="11" r="8"></circle>
                  <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                </svg>
              </button>
            </div>
          </div>
        </div>

        
        <div class="header-section info-section">
          <div class="header-info-group">
            <div class="info-item hotline-item">
              <div class="icon-wrapper shake-icon">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                  <path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"></path>
                </svg>
              </div>
              <div class="text-group">
                <span class="label">Hotline:</span>
                <a href="tel:0363961832" class="value">0363.961.832</a>
              </div>
            </div>

            
            <div class="info-item store-item">
              <div class="icon-wrapper">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                  <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path>
                  <circle cx="12" cy="10" r="3"></circle>
                </svg>
              </div>
              <div class="text-group">
                <span class="label">Hệ thống</span>
                <router-link to="/contact" class="value">Cửa hàng</router-link>
              </div>
            </div>
          </div>
        </div>

        
        <div class="header-section actions-section">
          <div class="action-buttons">
            <button class="icon-btn" @click="goCart" title="Giỏ hàng">
              🛒<span class="cart-count">{{ cartCount }}</span>
            </button>
            <router-link to="/login" class="login-btn">Đăng nhập</router-link>
          </div>
        </div>
      </div>
    </header>

    <nav class="menu-bar">
      <div class="menu-bar-inner">
        <router-link to="/" class="menu-item" :class="{ active: route.path === '/' }">Trang chủ</router-link>
        
       <!-- Dynamic categories menu -->
<template v-for="category in categories" :key="category.id">

  <!-- CATEGORY CÓ CON → DROPDOWN -->
  <div 
    v-if="category.children && category.children.length"
    class="menu-item dropdown"
  >
    <span @click="goCategory(category)">{{ category.name }}</span>
    <button class="dropdown-btn" @click.stop="toggleDropdown(category.id)">▼</button>

    <div class="submenu" v-show="openDropdown === category.id">
      <router-link 
        v-for="child in category.children" 
        :key="child.id"
        :to="getCategoryLink(child)"
        @click="closeDropdown"
      >
        {{ child.name }}
      </router-link>
    </div>
  </div>

  <!-- CATEGORY KHÔNG CÓ CON → LINK THƯỜNG -->
  <router-link
    v-else
    :to="getCategoryLink(category)"
    class="menu-item"
  >
    {{ category.name }}
  </router-link>

</template>
    
        <!-- Liên hệ static link -->
        <router-link to="/contact" class="menu-item" :class="{ active: route.path === '/contact' }">Liên hệ</router-link>
      </div>
    </nav>

    
    <main class="main-content">
      <router-view />
    </main>

    <!-- Footer -->
    <footer class="footer">
      <div class="footer-content">
        <div class="footer-section">
          <h4>Về Shop của Ngọc</h4>
          <p>Chúng tôi cung cấp các sản phẩm chất lượng cao với giá tốt nhất trên thị trường.</p>
        </div>
        <div class="footer-section">
          <h4>Liên kết nhanh</h4>
          <ul>
            <li><router-link to="/">Trang chủ</router-link></li>
            <li><router-link to="/shop">Cửa hàng</router-link></li>
            <li><a href="#about">Về chúng tôi</a></li>
            <li><a href="#contact">Liên hệ</a></li>
          </ul>
        </div>
        <div class="footer-section">
          <h4>Hỗ trợ khách hàng</h4>
          <ul>
            <li><a href="#help">Trung tâm trợ giúp</a></li>
            <li><a href="#track">Theo dõi đơn hàng</a></li>
            <li><a href="#return">Chính sách đổi trả</a></li>
            <li><a href="#faq">Câu hỏi thường gặp</a></li>
          </ul>
        </div>
        <div class="footer-section">
          <h4>Liên hệ</h4>
          <p>Email: ngocmt363@gmail.com</p>
          <p>Điện thoại: 0363 961 832</p>
          <p>Địa chỉ: Mễ Trì, Hà Nội</p>
        </div>
      </div>
      <div class="footer-bottom">
        <p>&copy; 2026 Shop của Ngọc. Tất cả quyền được bảo lưu.</p>
      </div>
    </footer>
  </div>
</template>

// src/layouts/MainLayout.vue
<script setup>
import { ref, onMounted, onUnmounted } from 'vue'
import { useRoute, useRouter } from 'vue-router'
import categoryService from '../services/categoryService'

// Helper function for category navigation
const getCategoryLink = (category) => {
  const keyName = category.name?.trim().toUpperCase() || ''
  const keySlug = category.slug?.trim().toLowerCase() || ''

  const pageRoutes = {
    // root pages
    'TRANG CHỦ': '/',
    'HOME': '/',
    'HƯỚNG DẪN': '/guide',
    'KHUYẾN MÃI': '/promotions',
    'TIN TỨC': '/news',
    'KHÁC': '/recruitment',
    'GIỚI THIỆU': '/about',

    // guide child pages
    'CÁCH MUA': '/guide?section=how-to-buy',
    'THANH TOÁN': '/guide?section=payment',
    'GIAO HÀNG': '/guide?section=shipping',

    // news child pages
    'LIÊN HỆ': '/news?section=contact',
    'TIN MỚI': '/news?section=latest',
    'REVIEW': '/news?section=reviews',
    'SỰ KIỆN': '/news?section=events',

    // recruitment child pages
    'TUYỂN DỤNG': '/recruitment?section=jobs',
    'CỘNG TÁC VIÊN': '/recruitment?section=affiliates',
    'LIÊN HỆ QUẢNG CÁO': '/recruitment?section=advertising'
  }

  const slugRoutes = {
    'hinh-danh-chu': '/',
    'huong-dan': '/guide',
    'khuyen-mai': '/promotions',
    'tin-tuc': '/news',
    'khac': '/recruitment',
    'gioi-thieu': '/about',
    'cach-mua': '/guide?section=how-to-buy',
    'thanh-toan': '/guide?section=payment',
    'giao-hang': '/guide?section=shipping',
    'lien-he': '/news?section=contact',
    'tin-moi': '/news?section=latest',
    'review': '/news?section=reviews',
    'su-kien': '/news?section=events',
    'tuyen-dung': '/recruitment?section=jobs',
    'cong-tac-vien': '/recruitment?section=affiliates',
    'lien-he-quang-cao': '/recruitment?section=advertising'
  }

  return pageRoutes[keyName] || slugRoutes[keySlug] || `/shop/category/${category.id}`
}

const goCategory = (category) => {
  router.push(getCategoryLink(category))
}
// Các biến và hàm liên quan đến tìm kiếm, giỏ hàng, và dropdown menu
const route = useRoute()
const router = useRouter()
const searchKeyword = ref('')
const cartCount = ref(0)
const openDropdown = ref(null)
const categories = ref([])

// Fetch categories on mount
onMounted(async () => {
  document.addEventListener('click', handleClickOutside)
  try {
   const response = await categoryService.getAll()
categories.value = Array.isArray(response.data.data) ? response.data.data : []
  } catch (error) {
    console.error('Failed to fetch categories:', error)
  }
})

onUnmounted(() => {
  document.removeEventListener('click', handleClickOutside)
})

// Hàm để thực hiện tìm kiếm
const onSearch = () => {
  if (!searchKeyword.value.trim()) return
  const query = encodeURIComponent(searchKeyword.value.trim())
  router.push(`/shop?search=${query}`)
}

// Hàm để chuyển hướng đến trang giỏ hàng
const goCart = () => {
  router.push('/cart')
}

// Dropdown functions
const toggleDropdown = (categoryId) => {
  openDropdown.value = openDropdown.value === categoryId ? null : categoryId
}

const closeDropdown = () => {
  openDropdown.value = null
}

const handleClickOutside = (event) => {
  const menuBar = document.querySelector('.menu-bar')
  if (menuBar && !menuBar.contains(event.target)) {
    closeDropdown()
  }
}

</script>


<style scoped>
/* Main layout container */
.main-layout {
  display: flex;
  flex-direction: column;
  min-height: 100vh;
  background: #f2f7fc;
}
/* Top header with hotline and store info */
.top-header {
  background: #ffd500;
  color: #1a1a1a;
  font-size: 13px;
  font-weight: 600;
}

.top-header-inner {
  max-width: 1400px;
  margin: 0 auto;
  display: flex;
  justify-content: space-between;
  align-items: center;
  padding: 8px 20px;
  gap: 12px;
}

.top-left,
.top-right {
  display: flex;
  align-items: center;
  gap: 12px;
}
/* Icon styles */
.primary-header {
  background: #1e70af;
  box-shadow: 0 2px 12px rgba(0, 0, 0, 0.2);
  position: sticky;
  top: 0;
  z-index: 150;
}
/* Primary header with logo, search, and actions */
.primary-header-inner {
  max-width: 1400px;
  margin: 0 auto;
  display: flex;
  align-items: center;
  padding: 14px 22px;
  gap: 18px;
}

.header-section {
  display: flex;
  align-items: center;
  justify-content: center;
}

.logo-section {
  flex: 0 0 auto;
  justify-content: flex-start;
}

.search-section {
  flex: 2 1 0;
  justify-content: center;
  min-width: 320px;
}

.info-section {
  flex: 1 1 0;
  justify-content: center;
}

/* Container cho nhóm thông tin liên hệ */
.actions-section {
  flex: 0 0 auto;
  justify-content: flex-end;
}

/* Main content area */
.brand {
  display: flex;
  align-items: center;
  gap: 10px;
  text-decoration: none;
}

.brand-logo {
  width: 80px;
  height: 80px;
  object-fit: contain;
  border-radius: 50%;
  background: #fff;
  padding: 6px;
}

.brand-text {
  display: flex;
  flex-direction: column;
  line-height: 1.05;
  color: #ffffff;
}

.brand-text strong {
  font-size: 34px;
  letter-spacing: 0.8px;
}

.brand-text span {
  font-size: 16px;
  color: #d8e8ff;
}


/* Main layout container */
.search-container {
  width: 100%;
  max-width: 720px;
}
/* Main content area */
.search-box {
  display: flex;
  align-items: center;
  background-color: #ffffff;
  border-radius: 12px;
  padding: 8px 16px;
  height: 48px;
  box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
  transition: all 0.3s ease;
  width: 100%;
}

/* Hiệu ứng khi nhấn vào ô tìm kiếm */
.search-box:focus-within {
  box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
  transform: translateY(-1px);
}

.search-input {
  flex: 1;
  border: none;
  outline: none;
  background: transparent;
  font-size: 17px;
  color: #333;
  font-family: inherit;
}

/* Màu chữ của chữ "Từ khóa..." */
.search-input::placeholder {
  color: #888;
  font-weight: 400;
}
/* Nút submit tìm kiếm (icon kính lúp) */
.search-submit {
  background: none;
  border: none;
  padding: 0;
  margin-left: 10px;
  cursor: pointer;
  display: flex;
  align-items: center;
  color: #444; /* Màu icon kính lúp */
  transition: color 0.2s;
}
/* Hiệu ứng khi hover vào icon kính lúp */
.search-submit:hover {
  color: #000; /* Đậm lên khi di chuột vào icon */
}

.search-submit svg {
  width: 26px;
  height: 26px;
}

/* Container chính chứa Hotline và Cửa hàng */
.header-info-group {
  display: flex;
  align-items: center;
  gap: 25px; /* Khoảng cách giữa 2 mục */
}

/* Style chung cho mỗi mục info */
.info-item {
  display: flex;
  align-items: center;
  gap: 10px;
  color: #ffffff; /* Tất cả chữ màu trắng */
}

/* Container cho Icon, đảm bảo icon màu trắng */
.info-item .icon-wrapper {
  display: flex;
  align-items: center;
  justify-content: center;
  color: #ffffff; /* Màu icon trắng */
}

/* Kích thước icon SVG */
.info-item .icon-wrapper svg {
  width: 24px;
  height: 24px;
}

/* Container cho phần chữ */
.info-item .text-group {
  display: flex;
  flex-direction: column;
  line-height: 1.2;
}

/* Style cho dòng chữ trên (label) */
.info-item .label {
  font-size: 11px;
  font-weight: 600;
  color: #d8e8ff; /* Màu xanh nhạt để phân biệt nhẹ, hoặc dùng #fff nếu muốn trắng hoàn toàn */
  text-transform: uppercase;
  letter-spacing: 0.5px;
}

/* Style cho dòng chữ dưới (value) */
.info-item .value {
  font-size: 15px;
  font-weight: 800;
  color: #ffffff; /* Màu chữ trắng */
  text-decoration: none;
  white-space: nowrap;
}

/* Hiệu ứng khi hover vào link */
.info-item .value:hover {
  color: #ffd500; /* Đổi màu vàng khi hover cho đồng bộ với theme */
}

/* =========================================
   HIỆU ỨNG LẮC CHO ICON ĐIỆN THOẠI
   ========================================= */

/* Đăng ký animation cho class shake-icon */
.shake-icon {
  animation: shake 2s ease-in-out infinite;
  transform-origin: center center; /* Lắc quanh tâm */
}

/* Định nghĩa keyframes cho hiệu ứng lắc */
@keyframes shake {
  0% { transform: rotate(0deg); }
  5% { transform: rotate(-10deg); }
  10% { transform: rotate(10deg); }
  15% { transform: rotate(-10deg); }
  20% { transform: rotate(10deg); }
  25% { transform: rotate(0deg); } /* Lắc nhanh trong 25% đầu */
  100% { transform: rotate(0deg); } /* Dừng 75% còn lại */
}

/* Responsive: Điều chỉnh cho màn hình nhỏ hơn */
@media (max-width: 1200px) {
  /* Có thể thu nhỏ khoảng cách hoặc ẩn đi nếu quá chật */
  .header-info-group {
    gap: 15px;
    margin: 0 10px;
  }
  .info-item .label {
    display: none; /* Ẩn label trên, chỉ hiện số/chữ chính */
  }
}

/* Menu điều hướng chính */
.action-buttons {
  display: flex;
  align-items: center;
  gap: 10px;
}
/* Nút giỏ hàng */
.icon-btn {
  background: rgba(255, 255, 255, 0.92);
  border: 1px solid #cfdbe9;
  border-radius: 10px;
  padding: 10px 12px;
  cursor: pointer;
  position: relative;
  font-size: 18px;
}
/* Hiệu ứng khi hover vào nút giỏ hàng */
.icon-btn:hover {
  background: #fff;
}
/* Số lượng sản phẩm trong giỏ hàng */
.cart-count {
  position: absolute;
  top: -5px;
  right: -5px;
  width: 18px;
  height: 18px;
  border-radius: 50%;
  background: #d82627;
  color: #fff;
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 11px;
  font-weight: 700;
}
/* Nút đăng nhập */
.login-btn {
  background: #0a305f;
  color: #fff;
  border-radius: 10px;
  padding: 10px 14px;
  font-weight: 700;
  text-decoration: none;
}

.menu-bar {
  --menu-bg: #1e70af;
  background: var(--menu-bg);
  border-bottom: none;
}
/* Menu điều hướng chính */
.menu-bar-inner {
  max-width: 1400px;
  margin: 0 auto;
  padding: 8px 20px;
  display: flex;
  flex-wrap: wrap;
  gap: 8px;
  align-items: center;
  justify-content: center;
}
/* Menu item chung */
.menu-item {
  padding: 8px 14px;
  border-radius: 0;
  background: transparent;
  color: #eff8ff;
  text-decoration: none;
  font-weight: 700;
  height: 44px;
  display: inline-flex;
  align-items: center;
  gap: 6px;
  cursor: pointer;
  position: relative;
  text-transform: uppercase;
  letter-spacing: 0.2px;
}

.menu-item:hover {
  color: #ffffff;
  background: rgba(255,255,255,0.15);
}

.menu-item.active {
  color: #ffffff;
  border-bottom: 3px solid #ffffff;
}
/* Dropdown menu styles */
.menu-item.dropdown {
  position: relative;
  display: inline-flex;
  align-items: center;
  gap: 4px;
}
/* Đảm bảo phần text và icon trong dropdown luôn nằm trên cùng một dòng */
.menu-item.dropdown span {
  display: inline-block;
  line-height: 1;
}
/* Nút dropdown */
.menu-item.dropdown .dropdown-btn {
  background: transparent;
  border: none;
  color: inherit;
  font-size: 14px;
  cursor: pointer;
  padding: 4px 6px;
  margin: 0;
  display: inline-flex;
  align-items: center;
  transition: transform 0.2s;
  flex-shrink: 0;
}
/* Hiệu ứng khi nhấn vào nút dropdown */
.menu-item.dropdown .dropdown-btn:active {
  transform: scale(0.95);
}
/* Submenu styles */
.menu-item.dropdown .submenu {
  position: absolute;
  top: 100%;
  left: 0;
  min-width: 220px;
  background: white;
  box-shadow: 0 6px 20px rgba(0,0,0,0.12);
  border-radius: 6px;
  padding: 8px 0;
  z-index: 250;
  margin-top: 4px;
  animation: slideDown 0.2s ease-out;
}

@keyframes slideDown {
  from {
    opacity: 0;
    transform: translateY(-8px);
  }
  to {
    opacity: 1;
    transform: translateY(0);
  }
}
/* Submenu item styles */
.menu-item.dropdown .submenu a {
  display: block;
  padding: 12px 16px;
  color: #1f3a6b;
  text-decoration: none;
  font-weight: 600;
  white-space: nowrap;
  transition: all 0.2s;
  font-size: 14px;
}

.menu-item.dropdown .submenu a:first-child {
  border-radius: 6px 6px 0 0;
}

.menu-item.dropdown .submenu a:last-child {
  border-radius: 0 0 6px 6px;
}
/* Hiệu ứng khi hover vào submenu item */
.menu-item.dropdown .submenu a:hover {
  background: rgba(30, 112, 175, 0.14);
  color: #1b4a8a;
  padding-left: 20px;
}
/* Loại bỏ outline và box-shadow mặc định khi focus vào menu item, input, và button */
.menu-item,
.search-input,
.search-btn,
.icon-btn,
.login-btn,
.dropdown-btn {
  box-shadow: none;
  outline: none;
}
/* Đảm bảo không có outline hoặc box-shadow khi focus vào các phần tử này */
.menu-item:focus-visible,
.search-input:focus-visible,
.search-btn:focus-visible,
.icon-btn:focus-visible,
.login-btn:focus-visible,
.dropdown-btn:focus-visible {
  outline: none;
  box-shadow: none;
}
/* Main content area */
.main-content {
  flex: 1;
  max-width: 1400px;
  width: 100%;
  margin: 0 auto;
  padding: 30px 20px;
}

.footer {
  background: #1c3c71;
  color: #f2f5fb;
}

.footer-content {
  max-width: 1400px;
  margin: 0 auto;
  padding: 40px 20px;
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
  gap: 22px;
}

.footer-section h4 {
  margin-bottom: 12px;
}

.footer-section a {
  color: #dbe9ff;
  display: block;
  margin-bottom: 8px;
  text-decoration: none;
}

.footer-section a:hover {
  color: #fff;
}

.footer-bottom {
  border-top: 1px solid rgba(255, 255, 255, 0.2);
  padding: 14px 20px;
  text-align: center;
  color: #cfd8ec;
}

@media (max-width: 1024px) {
  .top-header-inner,
  .primary-header-inner,
  .menu-bar-inner {
    flex-direction: column;
    align-items: stretch;
    text-align: center;
  }

  .search-wrapper {
    width: 100%;
    max-width: none;
  }

  .action-buttons {
    justify-content: center;
  }
}
</style>
