<template>
  <div class="order-success-page">
    <div class="success-card">
      <div class="success-icon">✔️</div>
      <h1>Đặt hàng thành công</h1>
      <p>Đơn hàng của bạn đã được tiếp nhận và đang được xử lý.</p>

      <div class="order-info">
        <div>
          <span>Mã đơn hàng:</span>
          <strong>#{{ order.id }}</strong>
        </div>
        <div>
          <span>Thời gian giao dự kiến:</span>
          <strong>{{ deliveryDate }}</strong>
        </div>
        <div>
          <span>Hỗ trợ:</span>
          <strong>0363.961.832</strong>
        </div>
      </div>

      <div class="button-group">
        <router-link class="primary-btn" :to="`/order-success/${order.id}`">Xem đơn hàng</router-link>
        <router-link class="secondary-btn" to="/shop">Tiếp tục mua sắm</router-link>
      </div>
    </div>
  </div>
</template>

<script setup>
import { computed } from "vue"
import { useRoute, useRouter } from "vue-router"

const route = useRoute()
const router = useRouter()

const orderId = route.params.id
const stored = sessionStorage.getItem("latest_order")
const order = stored ? JSON.parse(stored) : null

if (!order || order.id !== orderId) {
  router.replace("/shop")
}

const deliveryDate = computed(() => {
  const now = new Date()
  now.setDate(now.getDate() + 3)
  return now.toLocaleDateString("vi-VN", {
    weekday: "long",
    day: "2-digit",
    month: "2-digit",
    year: "numeric",
  })
})
</script>

<style scoped>
.order-success-page {
  max-width: 820px;
  margin: 0 auto;
  padding: 60px 20px;
}

.success-card {
  background: #fff;
  padding: 36px 34px;
  border-radius: 26px;
  text-align: center;
  box-shadow: 0 18px 60px rgba(15, 23, 42, 0.08);
}

.success-icon {
  font-size: 52px;
  margin-bottom: 22px;
}

.success-card h1 {
  font-size: 32px;
  margin-bottom: 12px;
}

.success-card p {
  color: #4b5563;
  margin-bottom: 28px;
}

.order-info {
  display: grid;
  gap: 16px;
  margin-bottom: 28px;
}

.order-info div {
  display: flex;
  justify-content: space-between;
  padding: 16px 18px;
  border-radius: 16px;
  background: #f8fafc;
  font-weight: 600;
}

.button-group {
  display: flex;
  justify-content: center;
  gap: 16px;
  flex-wrap: wrap;
}

.primary-btn,
.secondary-btn {
  padding: 14px 24px;
  border-radius: 14px;
  font-weight: 700;
  text-decoration: none;
}

.primary-btn {
  background: #2563eb;
  color: #fff;
}

.secondary-btn {
  background: #f8fafc;
  color: #111827;
  border: 1px solid #d1d5db;
}
</style>
