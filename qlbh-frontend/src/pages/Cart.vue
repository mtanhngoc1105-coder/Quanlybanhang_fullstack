<template>
  <div class="cart-page">
    <div class="cart-header">
      <h1>Giỏ hàng</h1>
      <p>Quản lý sản phẩm, số lượng và tổng tiền trước khi thanh toán.</p>
    </div>

    <div v-if="cart.length > 0" class="cart-content">
      <div class="cart-table">
        <div class="cart-row cart-row-head">
          <div>Sản phẩm</div>
          <div>Giá</div>
          <div>Số lượng</div>
          <div>Thành tiền</div>
          <div></div>
        </div>

        <div class="cart-row" v-for="item in cart" :key="item.id">
          <div class="product-cell">
            <img :src="item.image || '/images/product/default.jpg'" alt="item.name" class="product-image" />
            <div>
              <div class="product-name">{{ item.name }}</div>
            </div>
          </div>
          <div>{{ formatPrice(item.price) }} đ</div>
          <div class="quantity-cell">
            <button class="qty-btn" @click="decrement(item)">-</button>
            <input
              type="number"
              min="1"
              class="quantity-input"
              :value="item.quantity"
              @change="event => changeQuantity(item, event)"
            />
            <button class="qty-btn" @click="increment(item)">+</button>
          </div>
          <div>{{ formatPrice(item.price * item.quantity) }} đ</div>
          <div>
            <button class="remove-btn" @click="removeItem(item.id)">Xóa</button>
          </div>
        </div>
      </div>

      <div class="cart-summary">
        <div class="summary-row">
          <span>Tổng số sản phẩm:</span>
          <strong>{{ cart.reduce((sum, item) => sum + item.quantity, 0) }}</strong>
        </div>
        <div class="summary-row">
          <span>Tổng tiền:</span>
          <strong>{{ formatPrice(total) }} đ</strong>
        </div>
        <button class="checkout-btn" @click="goCheckout">Thanh toán</button>
      </div>
    </div>

    <div v-else class="empty-cart">
      <div class="empty-icon">🛒</div>
      <h2>Giỏ hàng của bạn đang trống</h2>
      <p>Thêm sản phẩm vào giỏ và quay lại trang này để hoàn tất đơn hàng.</p>
      <button class="shop-btn" @click="goShop">Tiếp tục mua sắm</button>
    </div>
  </div>
</template>

<script setup>
import { ref, computed, onMounted, onUnmounted } from "vue"
import { useRouter } from "vue-router"
import {
  getCart,
  removeFromCartService,
  updateQuantityService,
} from "../services/cartService.js"

const router = useRouter()
const cart = ref([])

const loadCart = () => {
  cart.value = getCart()
}

const total = computed(() => {
  return cart.value.reduce((sum, item) => {
    return sum + Number(item.price || 0) * Number(item.quantity || 0)
  }, 0)
})

const formatPrice = (value) => {
  return new Intl.NumberFormat("vi-VN").format(value)
}

const increment = (item) => {
  updateQuantityService(item.id, Number(item.quantity || 0) + 1)
  loadCart()
}

const decrement = (item) => {
  if (item.quantity > 1) {
    updateQuantityService(item.id, item.quantity - 1)
  } else {
    removeFromCartService(item.id)
  }
  loadCart()
}

const changeQuantity = (item, event) => {
  const quantity = Math.max(1, Number(event.target.value) || 1)
  updateQuantityService(item.id, quantity)
  loadCart()
}

const removeItem = (id) => {
  removeFromCartService(id)
  loadCart()
}

const goShop = () => {
  router.push("/shop")
}

const goCheckout = () => {
  if (cart.value.length === 0) {
    router.push("/shop")
    return
  }
  router.push("/checkout")
}

const handleCartUpdate = () => loadCart()
const handleStorage = (event) => {
  if (event.key === "cart") {
    loadCart()
  }
}

onMounted(() => {
  loadCart()
  window.addEventListener("cart-updated", handleCartUpdate)
  window.addEventListener("storage", handleStorage)
})

onUnmounted(() => {
  window.removeEventListener("cart-updated", handleCartUpdate)
  window.removeEventListener("storage", handleStorage)
})
</script>

<style scoped>
.cart-page {
  max-width: 1100px;
  margin: 0 auto;
  padding: 30px 20px;
}

.cart-header h1 {
  font-size: 32px;
  margin-bottom: 8px;
}

.cart-header p {
  color: #555;
  margin-bottom: 24px;
}

.cart-table {
  width: 100%;
  border-collapse: collapse;
  margin-bottom: 24px;
}

.cart-row {
  display: grid;
  grid-template-columns: 3fr 1fr 2fr 1fr 1fr;
  gap: 12px;
  align-items: center;
  padding: 16px 0;
  border-bottom: 1px solid #e4e7ed;
}

.cart-row-head {
  font-weight: 700;
  color: #222;
}

.product-cell {
  display: flex;
  align-items: center;
  gap: 12px;
}

.product-image {
  width: 72px;
  height: 72px;
  object-fit: cover;
  border-radius: 10px;
}

.product-name {
  font-weight: 600;
}

.quantity-cell {
  display: flex;
  align-items: center;
  gap: 8px;
}

.qty-btn,
.remove-btn,
.checkout-btn,
.shop-btn {
  border: none;
  cursor: pointer;
  border-radius: 8px;
  padding: 10px 16px;
}

.qty-btn {
  width: 34px;
  height: 34px;
  background: #f3f4f6;
}

.quantity-input {
  width: 64px;
  padding: 8px;
  text-align: center;
  border: 1px solid #d1d5db;
  border-radius: 8px;
}

.remove-btn {
  background: #ffe3e3;
  color: #b91c1c;
}

.cart-summary {
  display: flex;
  justify-content: flex-end;
  flex-direction: column;
  gap: 12px;
  padding: 24px;
  border: 1px solid #e4e7ed;
  border-radius: 16px;
  background: #fff;
}

.summary-row {
  display: flex;
  justify-content: space-between;
  font-size: 18px;
}

.checkout-btn {
  background: #1f2937;
  color: #fff;
  font-weight: 600;
}

.empty-cart {
  text-align: center;
  padding: 80px 20px;
}

.empty-icon {
  font-size: 60px;
  margin-bottom: 16px;
}

.shop-btn {
  background: #2563eb;
  color: white;
  margin-top: 16px;
}
</style>
