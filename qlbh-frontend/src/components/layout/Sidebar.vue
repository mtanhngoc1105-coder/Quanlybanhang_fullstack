<template>
  <aside class="sidebar">
    <div class="sidebar-header">
      <router-link to="/admin" class="sidebar-logo">
        <span class="logo-icon">🛒</span>
        <span class="logo-text">Ngọc Admin</span>
      </router-link>
      <button class="sidebar-toggle" @click="expanded = !expanded" v-if="isMobile">
        ☰
      </button>
    </div>

    <nav class="sidebar-nav" :class="{ expanded }">
      <div class="nav-group">
        <h3 class="nav-group-title">Quản lý bán hàng</h3>
        <router-link to="/admin/categories" class="nav-item" :class="{ active: isActive('categories') }">
          <span class="nav-icon"></span>
          <span class="nav-label">Danh mục sản phẩm</span>
        </router-link>
        <router-link to="/admin/products" class="nav-item" :class="{ active: isActive('products') }">
          <span class="nav-icon"></span>
          <span class="nav-label">Sản phẩm</span>
        </router-link>
        <router-link to="/admin/orders" class="nav-item" :class="{ active: isActive('orders') }">
          <span class="nav-icon"></span>
          <span class="nav-label">Đơn hàng</span>
        </router-link>
        <router-link to="/admin/sellers" class="nav-item" :class="{ active: isActive('sellers') }">
          <span class="nav-icon"></span>
          <span class="nav-label">Người bán</span>
        </router-link>
        <router-link to="/admin/reviews" class="nav-item" :class="{ active: isActive('reviews') }">
          <span class="nav-icon"></span>
          <span class="nav-label">Đánh giá</span>
        </router-link>
      </div>

      <div class="nav-group">
        <h3 class="nav-group-title">Quản lý vận chuyển</h3>
        <router-link to="/admin/drivers" class="nav-item" :class="{ active: isActive('drivers') }">
          <span class="nav-icon"></span>
          <span class="nav-label">Tài xế</span>
        </router-link>
        <router-link to="/admin/driver-orders" class="nav-item" :class="{ active: isActive('driver-orders') }">
          <span class="nav-icon"></span>
          <span class="nav-label">Đơn vận chuyển</span>
        </router-link>
        <router-link to="/admin/postoffices" class="nav-item" :class="{ active: isActive('postoffices') }">
          <span class="nav-icon"></span>
          <span class="nav-label">Bưu cục</span>
        </router-link>
      </div>

      <div class="nav-group">
        <h3 class="nav-group-title">Quản lý khách hàng</h3>
        <router-link to="/admin/customers" class="nav-item" :class="{ active: isActive('customers') }">
          <span class="nav-icon"></span>
          <span class="nav-label">Khách hàng</span>
        </router-link>
      </div>

      <div class="nav-group">
        <h3 class="nav-group-title">Khác</h3>
        <router-link to="/admin/vouchers" class="nav-item" :class="{ active: isActive('vouchers') }">
          <span class="nav-icon"></span>
          <span class="nav-label">Voucher</span>
        </router-link>
        <router-link to="/admin/order-items" class="nav-item" :class="{ active: isActive('order-items') }">
          <span class="nav-icon"></span>
          <span class="nav-label">Chi tiết đơn</span>
        </router-link>
      </div>

      <div class="sidebar-footer">
        <router-link to="/" class="nav-item nav-exit">
          <span class="nav-icon"></span>
          <span class="nav-label">Trang chủ</span>
        </router-link>
      </div>
    </nav>
  </aside>
</template>

<script setup>
import { ref, onMounted, onUnmounted } from "vue"
import { useRoute } from "vue-router"

const route = useRoute()
const expanded = ref(false)
const isMobile = ref(false)

const isActive = (path) => route.path.includes(path)

const handleResize = () => {
  isMobile.value = window.innerWidth < 768
}

onMounted(() => {
  handleResize()
  window.addEventListener("resize", handleResize)
})

onUnmounted(() => {
  window.removeEventListener("resize", handleResize)
})
</script>

<style scoped>
.sidebar {
  width: 260px;
  background: linear-gradient(180deg, #2c3e50 0%, #34495e 100%);
  color: white;
  padding: 0;
  display: flex;
  flex-direction: column;
  height: 100vh;
  position: sticky;
  top: 0;
  z-index: 50;
  overflow-y: auto;
  box-shadow: 2px 0 12px rgba(0, 0, 0, 0.1);
}

.sidebar-header {
  padding: 20px;
  display: flex;
  align-items: center;
  justify-content: space-between;
  border-bottom: 1px solid rgba(255, 255, 255, 0.1);
  background: rgba(0, 0, 0, 0.2);
}

.sidebar-logo {
  display: flex;
  align-items: center;
  gap: 10px;
  text-decoration: none;
  color: white;
  font-weight: bold;
  font-size: 16px;
}

.logo-icon {
  font-size: 24px;
}

.sidebar-toggle {
  display: none;
  background: none;
  border: none;
  color: white;
  font-size: 20px;
  cursor: pointer;
}

.sidebar-nav {
  flex: 1;
  padding: 10px 0;
  overflow-y: auto;
}

.nav-group {
  margin-bottom: 20px;
}

.nav-group-title {
  font-size: 11px;
  font-weight: 600;
  text-transform: uppercase;
  letter-spacing: 1px;
  padding: 10px 20px;
  color: rgba(255, 255, 255, 0.5);
  margin: 0;
}

.nav-item {
  display: flex;
  align-items: center;
  gap: 12px;
  padding: 12px 20px;
  color: rgba(255, 255, 255, 0.75);
  text-decoration: none;
  transition: all 0.3s ease;
  border-left: 3px solid transparent;
  margin: 0 10px;
  margin-left: 0;
  border-radius: 0 6px 6px 0;
}

.nav-item:hover {
  background: rgba(255, 255, 255, 0.1);
  color: white;
  border-left-color: #667eea;
}

.nav-item.active {
  background: linear-gradient(90deg, #667eea 0%, rgba(102, 126, 234, 0.3) 100%);
  color: white;
  font-weight: 600;
  border-left-color: #667eea;
  box-shadow: inset 0 2px 8px rgba(102, 126, 234, 0.2);
}

.nav-icon {
  font-size: 18px;
  flex-shrink: 0;
}

.nav-label {
  flex: 1;
}

.sidebar-footer {
  padding: 10px 0;
  border-top: 1px solid rgba(255, 255, 255, 0.1);
  margin-top: auto;
}

.nav-exit {
  color: rgba(255, 255, 255, 0.75) !important;
  padding: 12px 20px;
  margin: 0 10px;
}

.nav-exit:hover {
  background: rgba(229, 57, 53, 0.2);
  color: #ff6b6b !important;
  border-left-color: #ff6b6b;
}

/* SCROLLBAR */
.sidebar-nav::-webkit-scrollbar {
  width: 6px;
}

.sidebar-nav::-webkit-scrollbar-track {
  background: transparent;
}

.sidebar-nav::-webkit-scrollbar-thumb {
  background: rgba(255, 255, 255, 0.2);
  border-radius: 3px;
}

.sidebar-nav::-webkit-scrollbar-thumb:hover {
  background: rgba(255, 255, 255, 0.3);
}

/* RESPONSIVE */
@media (max-width: 768px) {
  .sidebar {
    position: fixed;
    height: auto;
    left: 0;
    top: 70px;
    width: 100%;
    max-height: 0;
    overflow: hidden;
    transition: max-height 0.3s ease;
  }

  .sidebar.expanded .sidebar-nav {
    display: block !important;
  }

  .sidebar-nav.expanded {
    max-height: 500px;
  }

  .sidebar-toggle {
    display: block;
  }
}
</style>