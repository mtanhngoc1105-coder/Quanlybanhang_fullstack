<template>
  <header class="header">
    <nav class="navbar">
      <div class="navbar-container">

        <router-link to="/" class="logo">
          💎 Shop Anime
        </router-link>

        <!-- MENU CATEGORY -->
        <ul class="nav-menu">
          <li class="nav-item">
            <router-link to="/" class="nav-link">Trang chủ</router-link>
          </li>

          <li class="nav-item" ref="menuRef">
            <button class="nav-link" @click.stop="toggleMenu">
              Danh mục ▾
            </button>

            <div v-if="showMenu" class="submenu">
              <router-link
                v-for="c in categories"
                :key="c.id"
                :to="`/category/${c.slug}`"
                class="submenu-link"
                @click="showMenu=false"
              >
                {{ c.name }}
              </router-link>
            </div>
          </li>
        </ul>

        <router-link to="/login" class="btn-login">
          Đăng nhập
        </router-link>

      </div>
    </nav>
  </header>
</template>
<script setup>
import { ref, onMounted, onBeforeUnmount } from "vue"
import axios from "axios"

const categories = ref([])
const showMenu = ref(false)
const menuRef = ref(null)

const toggleMenu = () => showMenu.value = !showMenu.value

const loadCategories = async () => {
  try {
    const res = await axios.get("https://anhngoc.gamer.gd/api/categories")
    categories.value = res.data
  } catch (err) {
    console.error("Load categories lỗi:", err)
  }
}

const handleClickOutside = (e) => {
  if (!menuRef.value?.contains(e.target)) showMenu.value = false
}

onMounted(() => {
  loadCategories()
  document.addEventListener("click", handleClickOutside)
})

onBeforeUnmount(() => {
  document.removeEventListener("click", handleClickOutside)
})
</script>
<style scoped>
.header {
  border-bottom: 1px solid #eee;
  background: white;
}

.navbar-container {
  display: flex;
  justify-content: space-between;
  padding: 14px 40px;
  align-items: center;
}

.logo {
  font-weight: 800;
  font-size: 20px;
  text-decoration: none;
  color: #111;
}

.nav-menu {
  display: flex;
  gap: 20px;
  list-style: none;
}

.nav-link {
  background: none;
  border: none;
  font-weight: 700;
  cursor: pointer;
  text-decoration: none;
  color: #333;
}

.submenu {
  position: absolute;
  background: white;
  border: 1px solid #ddd;
  border-radius: 10px;
  margin-top: 10px;
  min-width: 200px;
}

.submenu-link {
  display: block;
  padding: 10px;
  text-decoration: none;
  color: #333;
}

.submenu-link:hover {
  background: #f1f5f9;
}

.btn-login {
  background: #2563eb;
  color: white;
  padding: 8px 18px;
  border-radius: 8px;
  text-decoration: none;
}
</style>