<template>
  <header class="topbar">
    <div class="topbar-left">
      <button class="breadcrumb-toggle" @click="showBreadcrumb = !showBreadcrumb">
        ☰
      </button>
      <div class="breadcrumbs" v-if="showBreadcrumb">
        <router-link to="/admin" class="breadcrumb-item">Admin</router-link>
        <span class="breadcrumb-sep">/</span>
        <span class="breadcrumb-current">{{ currentPageTitle }}</span>
      </div>
    </div>

    <div class="topbar-right">
      <div class="dropdown-wrapper" ref="notificationRef">
        <button
          @click.stop="toggleDropdown('notifications')"
          :class="['icon-btn', { active: showNotifications }]"
          title="Thông báo"
        >
          <span class="bell-icon">🔔</span>
          <span class="badge">{{ unreadCount }}</span>
        </button>

        <div v-if="showNotifications" class="dropdown-panel notification-dropdown" @click.stop>
          <div class="panel-header">
            <span>Thông báo</span>
            <button class="close-btn" @click="showNotifications = false">×</button>
          </div>
          <div class="panel-tabs">
            <button class="tab-btn active">Tất cả</button>
            <button class="tab-btn">Chưa đọc</button>
          </div>
          <div class="panel-list">
            <div
              v-for="notification in notifications"
              :key="notification.id"
              class="panel-item"
              :class="{ unread: !notification.read }"
            >
              <div class="item-icon">{{ notification.icon }}</div>
              <div class="item-text">
                <div class="item-title">{{ notification.title }}</div>
                <div class="item-message">{{ notification.message }}</div>
                <div class="item-time">{{ notification.time }}</div>
              </div>
              <button class="mark-read" @click="markAsRead(notification.id)">✓</button>
            </div>
          </div>
          <button class="view-all-btn">Xem tất cả</button>
        </div>
      </div>

      <div class="dropdown-wrapper" ref="settingsRef">
        <button
          @click.stop="toggleDropdown('settings')"
          :class="['icon-btn', { active: showSettings }]"
          title="Cài đặt"
        >
          ⚙️
        </button>
        <div v-if="showSettings" class="dropdown-panel settings-dropdown" @click.stop>
          <div class="panel-header">
            <span>Cài đặt nhanh</span>
            <button class="close-btn" @click="showSettings = false">×</button>
          </div>
          <ul class="settings-options">
            <li class="settings-option"><span class="settings-icon">🎛</span> <span>Cài đặt tài khoản</span></li>
            <li class="settings-option"><span class="settings-icon">🔒</span> <span>Quyền riêng tư</span></li>
            <li class="settings-option"><span class="settings-icon">🔔</span> <span>Thông báo</span></li>
            <li class="settings-option"><span class="settings-icon">🌙</span> <span>Giao diện</span></li>
          </ul>
        </div>
      </div>

      <div class="user-menu" ref="userRef">
        <button :class="['user-btn', { active: showUserDropdown }]" @click.stop="toggleDropdown('user')">
          <span class="avatar">👤</span>
          <span class="user-info">
            <span class="user-name">{{ user?.email || 'Người dùng' }}</span>
            <span class="user-role">{{ user?.role === 'manager' ? 'Quản lý' : 'Người mua' }}</span>
          </span>
        </button>
        <div class="user-dropdown" v-if="showUserDropdown" @click.stop>
          <button @click="showUserDropdown = false" class="dropdown-item"> Hồ sơ</button>
          <button @click="showSettings = true; showUserDropdown = false" class="dropdown-item"> Cài đặt</button>
          <div class="dropdown-divider"></div>
          <button @click="logout" class="dropdown-item logout"> Đăng xuất</button>
        </div>
      </div>
    </div>

  </header>
</template>

<script setup>
import { ref, computed, onMounted, onBeforeUnmount } from "vue"
import { useRoute } from "vue-router"

const route = useRoute()
const showBreadcrumb = ref(true)
const showUserDropdown = ref(false)
const showNotifications = ref(false)
const showSettings = ref(false)
const notificationRef = ref(null)
const settingsRef = ref(null)
const userRef = ref(null)
const user = ref(JSON.parse(localStorage.getItem("auth") || "null"))

const settings = ref({
  darkMode: false,
  compactView: false,
  emailNotifications: true,
  pushNotifications: true,
  language: 'vi'
})

const notifications = ref([
  {
    id: 1,
    icon: '📦',
    title: 'Đơn hàng mới',
    message: 'Bạn có 5 đơn hàng mới cần xử lý',
    time: '5 phút trước',
    read: false
  },
  {
    id: 2,
    icon: '👤',
    title: 'Khách hàng mới',
    message: 'Khách hàng Nguyễn Văn A đã đăng ký',
    time: '10 phút trước',
    read: false
  },
  {
    id: 3,
    icon: '⭐',
    title: 'Đánh giá mới',
    message: 'Sản phẩm X nhận được đánh giá 5 sao',
    time: '1 giờ trước',
    read: false
  }
])

const unreadCount = computed(() => notifications.value.filter(n => !n.read).length)

const toggleDropdown = (type) => {
  showNotifications.value = type === 'notifications' ? !showNotifications.value : false
  showSettings.value = type === 'settings' ? !showSettings.value : false
  showUserDropdown.value = type === 'user' ? !showUserDropdown.value : false
}

const closeDropdowns = () => {
  showNotifications.value = false
  showSettings.value = false
  showUserDropdown.value = false
}

const handleOutsideClick = (event) => {
  const clickedNotification = notificationRef.value?.contains(event.target)
  const clickedSettings = settingsRef.value?.contains(event.target)
  const clickedUser = userRef.value?.contains(event.target)

  if (!clickedNotification && !clickedSettings && !clickedUser) {
    closeDropdowns()
  }
}

const logout = () => {
  localStorage.removeItem("auth")
  localStorage.removeItem("auth_token")
  user.value = null
  closeDropdowns()
  window.location.href = "/login"
}

const markAsRead = (id) => {
  const notification = notifications.value.find(n => n.id === id)
  if (notification) {
    notification.read = true
  }
}

const saveSettings = () => {
  localStorage.setItem('adminSettings', JSON.stringify(settings.value))
  showSettings.value = false
  alert('Cài đặt đã được lưu!')
}

const currentPageTitle = computed(() => {
  const path = route.path
  if (path.includes('customers')) return 'Khách hàng'
  if (path.includes('drivers')) return 'Tài xế'
  if (path.includes('products')) return 'Sản phẩm'
  if (path.includes('orders')) return 'Đơn hàng'
  if (path.includes('reviews')) return 'Đánh giá'
  if (path.includes('sellers')) return 'Người bán'
  if (path.includes('vouchers')) return 'Voucher'
  return 'Dashboard'
})

onMounted(() => {
  const savedSettings = localStorage.getItem('adminSettings')
  if (savedSettings) {
    settings.value = { ...settings.value, ...JSON.parse(savedSettings) }
  }
  document.addEventListener('click', handleOutsideClick)
})

onBeforeUnmount(() => {
  document.removeEventListener('click', handleOutsideClick)
})
</script>

<style scoped>
.topbar {
  background: white;
  padding: 15px 30px;
  display: flex;
  justify-content: space-between;
  align-items: center;
  box-shadow: 0 2px 12px rgba(0, 0, 0, 0.08);
  border-bottom: 1px solid #e9ecef;
  position: sticky;
  top: 0;
  z-index: 40;
}

.topbar-left {
  display: flex;
  align-items: center;
  gap: 20px;
  flex: 1;
}

.breadcrumb-toggle {
  display: none;
  background: none;
  border: none;
  font-size: 18px;
  cursor: pointer;
  color: #667eea;
}

.breadcrumbs {
  display: flex;
  align-items: center;
  gap: 8px;
  font-size: 14px;
}

.breadcrumb-item {
  color: #667eea;
  text-decoration: none;
  transition: color 0.3s ease;
}

.breadcrumb-item:hover {
  color: #764ba2;
  text-decoration: underline;
}

.breadcrumb-sep {
  color: #bdc3c7;
}

.breadcrumb-current {
  color: #24468b;
  font-weight: 700;
  font-size: 15px;
}

.topbar-right {
  display: flex;
  align-items: center;
  gap: 20px;
}

.search-box {
  display: flex;
  align-items: center;
  background: #f5f7fb;
  border: 1px solid #e0e0e0;
  border-radius: 6px;
  overflow: hidden;
  transition: all 0.3s ease;
}

.search-box:focus-within {
  border-color: #667eea;
  box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
}

.search-input {
  flex: 1;
  border: none;
  background: none;
  padding: 8px 12px;
  font-size: 13px;
  outline: none;
}

.search-input::placeholder {
  color: #bdc3c7;
}

.search-btn {
  background: none;
  border: none;
  padding: 8px 12px;
  cursor: pointer;
  color: #667eea;
  font-size: 14px;
  transition: color 0.3s ease;
}

.search-btn:hover {
  color: #764ba2;
}

.icon-btn {
  background: #edf2f7;
  border: 1px solid #d1d5db;
  font-size: 18px;
  cursor: pointer;
  color: #1f2937;
  width: 44px;
  height: 44px;
  border-radius: 50%;
  position: relative;
  transition: all 0.2s ease;
  display: inline-flex;
  align-items: center;
  justify-content: center;
}

.icon-btn:hover {
  background: #e2e8f0;
}

.bell-icon {
  display: inline-flex;
  filter: grayscale(1) brightness(0.65);
}

.icon-btn.active {
  background: #1877f2;
  color: white;
  border-color: #1877f2;
}

.dropdown-wrapper {
  position: relative;
}

.dropdown-panel {
  position: absolute;
  top: calc(100% + 10px);
  left: 0;
  right: auto;
  background: #ffffff;
  border: 1px solid #e5e7eb;
  border-radius: 18px;
  box-shadow: 0 24px 80px rgba(15, 23, 42, 0.14);
  overflow: hidden;
  z-index: 1000;
  transform-origin: top left;
  width: 360px;
}

.settings-dropdown {
  width: 280px;
}

.panel-header {
  display: flex;
  align-items: center;
  justify-content: space-between;
  gap: 12px;
  padding: 16px 18px;
  border-bottom: 1px solid #f1f5f9;
  font-weight: 700;
  color: #111827;
}

.close-btn {
  width: 32px;
  height: 32px;
  border: none;
  border-radius: 50%;
  background: #f3f4f6;
  color: #475569;
  font-size: 18px;
  cursor: pointer;
  transition: background 0.2s ease;
}

.close-btn:hover {
  background: #e2e8f0;
}

.panel-tabs {
  display: flex;
  gap: 10px;
  padding: 12px 16px 0;
}

.tab-btn {
  border: none;
  background: #f3f4f6;
  color: #475569;
  padding: 8px 12px;
  border-radius: 999px;
  cursor: pointer;
  font-size: 13px;
}

.tab-btn.active {
  background: #e7f3ff;
  color: #1d4ed8;
}

.panel-list {
  max-height: 320px;
  overflow-y: auto;
  padding: 12px 0 0;
}

.panel-item {
  display: flex;
  align-items: flex-start;
  gap: 12px;
  padding: 12px 16px;
  transition: background 0.2s ease;
}

.panel-item:hover {
  background: #f8fafc;
}

.panel-item.unread {
  background: #f5f7fb;
}

.item-icon {
  width: 44px;
  height: 44px;
  display: flex;
  align-items: center;
  justify-content: center;
  border-radius: 14px;
  background: #eef2ff;
  color: #1d4ed8;
  font-size: 18px;
}

.item-text {
  flex: 1;
  min-width: 0;
}

.item-title {
  font-weight: 700;
  color: #111827;
  font-size: 14px;
  margin-bottom: 4px;
}

.item-message {
  color: #64748b;
  font-size: 13px;
  line-height: 1.5;
}

.item-time {
  color: #2563eb;
  font-size: 12px;
  margin-top: 6px;
}

.mark-read {
  min-width: 34px;
  min-height: 34px;
  border-radius: 50%;
  border: none;
  background: #e7f3ff;
  color: #1d4ed8;
  font-weight: 700;
  cursor: pointer;
}

.view-all-btn {
  width: calc(100% - 32px);
  margin: 12px 16px 16px;
  border: none;
  background: #eef2ff;
  color: #1d4ed8;
  border-radius: 12px;
  padding: 12px;
  cursor: pointer;
  font-weight: 700;
}

.settings-options {
  list-style: none;
  margin: 0;
  padding: 0;
}

.settings-option {
  display: flex;
  align-items: center;
  gap: 12px;
  padding: 14px 16px;
  border-radius: 14px;
  color: #111827;
  transition: background 0.2s ease;
  cursor: pointer;
  font-weight: 600;
}

.settings-option:hover {
  background: #f8fafc;
  color: #1664d9;
}

.settings-icon {
  width: 36px;
  height: 36px;
  display: inline-flex;
  align-items: center;
  justify-content: center;
  border-radius: 12px;
  background: #f3f4f6;
  color: #6b7280;
  font-size: 16px;
  filter: grayscale(1);
}

.settings-option span:last-child {
  color: #475569;
  font-weight: 500;
}

.badge {
  position: absolute;
  top: 0;
  right: 0;
  background: #e74c3c;
  color: white;
  border-radius: 50%;
  width: 18px;
  height: 18px;
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 10px;
  font-weight: bold;
}

.user-menu {
  position: relative;
}

.user-dropdown {
  position: absolute;
  top: calc(100% + 10px);
  left: 0;
  right: auto;
  min-width: 260px;
  background: #ffffff;
  border: 1px solid #e5e7eb;
  border-radius: 18px;
  box-shadow: 0 24px 80px rgba(15, 23, 42, 0.14);
  margin-top: 8px;
  z-index: 1000;
  overflow: hidden;
}

.dropdown-item {
  display: block;
  padding: 14px 18px;
  color: #2c3e50;
  text-decoration: none;
  font-size: 14px;
  transition: background 0.2s ease;
  border: none;
  background: none;
  width: 100%;
  text-align: left;
  cursor: pointer;
}

.dropdown-item:hover {
  background: #f5f7fb;
  color: #1877f2;
}

.dropdown-divider {
  height: 1px;
  background: #edf2f7;
  margin: 8px 0;
}

.dropdown-item.logout {
  color: #e74c3c;
}

.dropdown-item.logout:hover {
  background: #ffe5e5;
  color: #c92a2a;
}

.user-btn {
  display: flex;
  align-items: center;
  gap: 10px;
  background: #f0f2f5;
  border: 1px solid #d1d5db;
  padding: 8px 14px;
  border-radius: 999px;
  transition: all 0.2s ease;
}

.user-btn:hover {
  background: #e2e8f0;
}

.user-btn.active {
  background: #1877f2;
  color: white;
  border-color: #1877f2;
}

.user-btn.active .avatar,
.user-btn.active .user-name,
.user-btn.active .user-role {
  color: white;
}

.avatar {
  width: 32px;
  height: 32px;
  display: inline-flex;
  align-items: center;
  justify-content: center;
  background: #d9dee4;
  border-radius: 50%;
  font-size: 16px;
}

.user-role {
  font-size: 11px;
  color: #7f8c8d;
}

/* RESPONSIVE */
@media (max-width: 768px) {
  .topbar {
    flex-direction: column;
    gap: 15px;
    padding: 12px 20px;
  }

  .topbar-left {
    width: 100%;
  }

  .breadcrumb-toggle {
    display: block;
  }

  .breadcrumbs {
    display: none;
  }

  .topbar-left.show-breadcrumbs .breadcrumbs {
    display: flex;
  }

  .topbar-right {
    width: 100%;
    gap: 10px;
  }

  .search-box {
    flex: 1;
  }

  .user-info {
    display: none;
  }

  .search-input {
    padding: 6px 10px;
    font-size: 12px;
  }
}
</style>