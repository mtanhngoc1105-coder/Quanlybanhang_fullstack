<template>
  <div class="admin-layout">
    <Sidebar />
    <div class="admin-main">
      <Topbar />
      <div class="admin-content">
        <router-view />
      </div>
    </div>
  </div>
</template>
<!-- src/layouts/AdminLayout.vue -->
<script setup>
import Sidebar from "../components/layout/Sidebar.vue"
import Topbar from "../components/layout/Topbar.vue"
</script>

<style scoped>
.admin-layout {
  display: flex;
  background: #f5f7fb;
  min-height: 100vh;
}
/* Main content area */
.admin-main {
  flex: 1;
  display: flex;
  flex-direction: column;
  min-width: 0;   /*  QUAN TRỌNG */
  background: #f3f7fd;
}
/* Content area with padding and scroll */
.admin-content {
  flex: 1;
  padding: 32px;
  overflow-y: auto;
}
/* Card styles */
.admin-content > * {
  border-radius: 24px;
  background: white;
  padding: 28px;
  box-shadow: 0 18px 40px rgba(28, 55, 93, 0.06);
}
/* Custom scrollbar styles */
.admin-content::-webkit-scrollbar {
  width: 8px;
}
/* Track */
.admin-content::-webkit-scrollbar {
  width: 8px;
}
/* Track */
.admin-content::-webkit-scrollbar-track {
  background: #f5f7fb;
}
/* Handle */
.admin-content::-webkit-scrollbar-thumb {
  background: #bdc3c7;
  border-radius: 4px;
}

.admin-content::-webkit-scrollbar-thumb:hover {
  background: #95a5a6;
}

/* RESPONSIVE */
@media (max-width: 768px) {
  .admin-layout {
    flex-direction: column;
  }

  .admin-content {
    padding: 20px;
  }
}
</style>