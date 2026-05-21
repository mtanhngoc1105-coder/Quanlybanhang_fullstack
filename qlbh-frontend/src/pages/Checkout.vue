<template>
  <div class="checkout-page">
    <div class="checkout-header">
      <h1>Thanh toán</h1>
      <p>Hoàn tất thông tin giao hàng và kiểm tra lại đơn trước khi đặt.</p>
    </div>

    <div class="checkout-grid">
      <section class="checkout-form-card">
        <div class="section-title">Thông tin giao hàng</div>

        <div class="field-group">
          <label>Họ và tên <span class="required">*</span></label>
          <input v-model="form.name" type="text" placeholder="Nhập họ và tên" />
        </div>

        <div class="field-group">
          <label>Số điện thoại <span class="required">*</span></label>
          <input v-model="form.phone" type="tel" placeholder="Nhập số điện thoại" />
        </div>

        <div class="field-group">
          <label>Email (tuỳ chọn)</label>
          <input v-model="form.email" type="email" placeholder="Nhập email" />
        </div>

        <div class="field-group">
          <label>Địa chỉ giao hàng <span class="required">*</span></label>
          <textarea v-model="form.address" rows="3" placeholder="Nhập địa chỉ giao hàng"></textarea>
        </div>

        <div class="field-group">
          <label>Ghi chú đơn hàng</label>
          <textarea v-model="form.note" rows="3" placeholder="Ghi chú cho người bán hoặc giao hàng"></textarea>
        </div>

        <div class="section-title">Chọn phương thức thanh toán</div>
        <div class="radio-group">
          <label>
            <input type="radio" value="COD" v-model="form.paymentMethod" />
            Thanh toán khi nhận hàng (COD)
          </label>
          <label>
            <input type="radio" value="bank" v-model="form.paymentMethod" />
            Chuyển khoản ngân hàng
          </label>
          <label>
            <input type="radio" value="momo" v-model="form.paymentMethod" />
            Ví Momo / ZaloPay
          </label>
        </div>

        <div class="section-title">Chọn đơn vị vận chuyển</div>
        <div class="radio-group">
          <label>
            <input type="radio" value="standard" v-model="form.shippingMethod" />
            Giao hàng tiêu chuẩn (2–4 ngày)
          </label>
          <label>
            <input type="radio" value="fast" v-model="form.shippingMethod" />
            Giao nhanh (1–2 ngày)
          </label>
        </div>

        <div class="checkout-actions">
          <button class="submit-btn" @click="placeOrder">ĐẶT HÀNG NGAY</button>
          <router-link class="cancel-link" to="/cart">Quay lại giỏ hàng</router-link>
        </div>
      </section>

      <section class="order-summary-card">
        <div class="section-title">Xác nhận đơn hàng</div>

        <div class="order-products">
          <div class="order-row order-row-head">
            <span>Ảnh</span>
            <span>Tên SP</span>
            <span>Giá</span>
            <span>Số lượng</span>
            <span>Thành tiền</span>
          </div>
          <div class="order-row" v-for="item in cart" :key="item.id">
            <span><img :src="item.image || '/images/product/default.jpg'" alt="item.name" /></span>
            <span class="product-name">{{ item.name }}</span>
            <span>{{ formatPrice(item.price) }} đ</span>
            <span>{{ item.quantity }}</span>
            <span>{{ formatPrice(item.price * item.quantity) }} đ</span>
          </div>
        </div>

        <div class="summary-block">
          <div class="summary-item">
            <span>Tạm tính</span>
            <span>{{ formatPrice(subtotal) }} đ</span>
          </div>
          <div class="summary-item">
            <span>Phí ship</span>
            <span>{{ formatPrice(shippingFee) }} đ</span>
          </div>
          <div class="summary-item discount-row">
            <span>Mã giảm giá</span>
            <div class="discount-input-wrap">
              <input v-model="couponCode" placeholder="Nhập mã giảm giá" />
              <button @click="applyCoupon">Áp dụng</button>
            </div>
          </div>
          <div v-if="discount > 0" class="summary-item discount-value">
            <span>Giảm giá</span>
            <span>-{{ formatPrice(discount) }} đ</span>
          </div>

          <div class="summary-item total-row">
            <span>Tổng tiền cần thanh toán</span>
            <strong>{{ formatPrice(grandTotal) }} đ</strong>
          </div>
        </div>

        <div v-if="errorMessage" class="error-message">
          {{ errorMessage }}
        </div>
        <div v-if="successMessage" class="success-message">
          {{ successMessage }}
        </div>
      </section>
    </div>
  </div>
</template>

<script setup>
import { ref, computed, onMounted } from "vue"
import { useRouter } from "vue-router"
import {
  getCart,
  getCartTotal,
  clearCartService,
} from "../services/cartService.js"

const router = useRouter()
const cart = ref([])
const subtotal = ref(0)
const couponCode = ref("")
const discount = ref(0)
const errorMessage = ref("")
const successMessage = ref("")

const form = ref({
  name: "",
  phone: "",
  email: "",
  address: "",
  note: "",
  paymentMethod: "COD",
  shippingMethod: "standard",
})

const loadCart = () => {
  cart.value = getCart()
  subtotal.value = getCartTotal()
  if (cart.value.length === 0) {
    router.push("/cart")
  }
}

const loadUserInfo = () => {
  const auth = JSON.parse(localStorage.getItem("auth") || "null")
  if (auth) {
    form.value.name = auth.name || form.value.name
    form.value.phone = auth.phone || form.value.phone
    form.value.email = auth.email || form.value.email
    form.value.address = auth.address || form.value.address
  }
}

const formatPrice = (value) => {
  return new Intl.NumberFormat("vi-VN").format(value)
}

const shippingFee = computed(() => {
  return form.value.shippingMethod === "fast" ? 30000 : 15000
})

const grandTotal = computed(() => {
  return subtotal.value + shippingFee.value - discount.value
})

const validateForm = () => {
  if (!form.value.name.trim()) {
    errorMessage.value = "Vui lòng nhập họ và tên."
    return false
  }
  if (!form.value.phone.trim()) {
    errorMessage.value = "Vui lòng nhập số điện thoại."
    return false
  }
  if (!form.value.address.trim()) {
    errorMessage.value = "Vui lòng nhập địa chỉ giao hàng."
    return false
  }
  if (!form.value.paymentMethod) {
    errorMessage.value = "Vui lòng chọn phương thức thanh toán."
    return false
  }
  if (!form.value.shippingMethod) {
    errorMessage.value = "Vui lòng chọn đơn vị vận chuyển."
    return false
  }
  errorMessage.value = ""
  return true
}

const applyCoupon = () => {
  const code = couponCode.value.trim().toUpperCase()
  if (code === "GIAM50" && subtotal.value >= 500000) {
    discount.value = 50000
    successMessage.value = "Mã giảm giá đã được áp dụng."
    errorMessage.value = ""
  } else if (code === "SHIPFREE") {
    discount.value = shippingFee.value
    successMessage.value = "Mã giảm giá miễn phí ship đã được áp dụng."
    errorMessage.value = ""
  } else if (!code) {
    errorMessage.value = "Vui lòng nhập mã giảm giá."
    successMessage.value = ""
  } else {
    errorMessage.value = "Mã giảm giá không hợp lệ hoặc điều kiện chưa đủ."
    successMessage.value = ""
    discount.value = 0
  }
}

const placeOrder = () => {
  if (!validateForm()) {
    return
  }

  const orderId = `DH${Math.floor(10000 + Math.random() * 90000)}`
  const order = {
    id: orderId,
    createdAt: new Date().toISOString(),
    customer: { ...form.value },
    items: cart.value,
    subtotal: subtotal.value,
    shippingFee: shippingFee.value,
    discount: discount.value,
    total: grandTotal.value,
    paymentMethod: form.value.paymentMethod,
    shippingMethod: form.value.shippingMethod,
  }

  const orders = JSON.parse(localStorage.getItem("orders") || "[]")
  orders.push(order)
  localStorage.setItem("orders", JSON.stringify(orders))
  sessionStorage.setItem("latest_order", JSON.stringify(order))

  clearCartService()
  router.push(`/order-success/${orderId}`)
}

onMounted(() => {
  loadCart()
  loadUserInfo()
})
</script>

<style scoped>
.checkout-page {
  max-width: 1180px;
  margin: 0 auto;
  padding: 30px 20px;
}

.checkout-header h1 {
  font-size: 32px;
  margin-bottom: 8px;
}

.checkout-header p {
  color: #515151;
  margin-bottom: 24px;
}

.checkout-grid {
  display: grid;
  grid-template-columns: 1.5fr 1fr;
  gap: 28px;
}

.checkout-form-card,
.order-summary-card {
  background: #fff;
  padding: 24px;
  border-radius: 20px;
  box-shadow: 0 8px 24px rgba(0, 0, 0, 0.05);
}

.section-title {
  font-size: 20px;
  font-weight: 700;
  margin-bottom: 16px;
}

.field-group {
  display: flex;
  flex-direction: column;
  margin-bottom: 16px;
}

.field-group label {
  margin-bottom: 8px;
  font-weight: 600;
}

.field-group input,
.field-group textarea,
.discount-input-wrap input {
  border: 1px solid #d2d6dc;
  border-radius: 12px;
  padding: 12px 14px;
  font-size: 14px;
  width: 100%;
}

.field-group textarea {
  resize: vertical;
  min-height: 84px;
}

.required {
  color: #d32f2f;
}

.radio-group {
  display: flex;
  flex-direction: column;
  gap: 10px;
  margin-bottom: 20px;
}

.radio-group label {
  display: flex;
  align-items: center;
  gap: 10px;
  font-weight: 500;
}

.checkout-actions {
  display: flex;
  justify-content: space-between;
  align-items: center;
  gap: 16px;
  margin-top: 24px;
}

.submit-btn {
  background: #2563eb;
  color: white;
  border: none;
  padding: 14px 24px;
  border-radius: 14px;
  font-size: 16px;
  font-weight: 700;
  cursor: pointer;
}

.cancel-link {
  color: #2563eb;
  font-weight: 600;
}

.order-products {
  border-top: 1px solid #e5e7eb;
  margin-top: 16px;
}

.order-row {
  display: grid;
  grid-template-columns: 65px 1fr 90px 70px 110px;
  align-items: center;
  gap: 12px;
  padding: 12px 0;
  border-bottom: 1px solid #f1f5f9;
}

.order-row-head {
  font-weight: 700;
  color: #1f2937;
}

.order-row img {
  width: 56px;
  height: 56px;
  object-fit: cover;
  border-radius: 12px;
}

.product-name {
  font-weight: 600;
}

.summary-block {
  margin-top: 18px;
  display: grid;
  gap: 14px;
}

.summary-item {
  display: flex;
  justify-content: space-between;
  font-size: 15px;
}

.discount-row {
  flex-direction: column;
  align-items: flex-start;
  gap: 10px;
}

.discount-input-wrap {
  display: flex;
  gap: 10px;
  width: 100%;
}

.discount-input-wrap button {
  background: #111827;
  color: #fff;
  border: none;
  padding: 12px 16px;
  border-radius: 12px;
  cursor: pointer;
}

.discount-value {
  color: #047857;
}

.total-row {
  font-size: 18px;
  font-weight: 700;
}

.error-message,
.success-message {
  margin-top: 16px;
  padding: 14px 16px;
  border-radius: 14px;
}

.error-message {
  background: #fee2e2;
  color: #b91c1c;
}

.success-message {
  background: #dcfce7;
  color: #166534;
}

@media (max-width: 980px) {
  .checkout-grid {
    grid-template-columns: 1fr;
  }
}
</style>
