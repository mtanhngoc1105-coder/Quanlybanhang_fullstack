<template>
  <div class="not-found">
    <div class="not-found-content">
      <h1>404</h1>
      <h2>Trang không tồn tại</h2>
      <p>Xin lỗi, trang bạn tìm kiếm không được tìm thấy.</p>
      <router-link to="/" class="btn btn-primary">Quay lại trang chủ</router-link>
    </div>
  </div>
</template>

<script setup>
</script>

<style scoped>
.not-found {
  min-height: 80vh;
  display: flex;
  align-items: center;
  justify-content: center;
  background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
}

.not-found-content {
  text-align: center;
  color: white;
}

.not-found-content h1 {
  font-size: 120px;
  margin: 0;
  font-weight: 800;
}

.not-found-content h2 {
  font-size: 32px;
  margin: 10px 0;
}

.not-found-content p {
  font-size: 18px;
  margin-bottom: 30px;
  opacity: 0.9;
}

.btn {
  display: inline-block;
  padding: 12px 28px;
  background: white;
  color: #667eea;
  text-decoration: none;
  border-radius: 8px;
  font-weight: 600;
  transition: transform 0.2s ease;
}

.btn:hover {
  transform: scale(1.05);
}
</style>
