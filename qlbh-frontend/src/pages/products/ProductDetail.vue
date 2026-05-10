<template>
  <div class="container mt-4">
    <h2 class="fw-bold mb-4">Chi tiết sản phẩm</h2>

    <div class="card p-4 shadow-sm rounded">
      <div class="row">
        <div class="col-md-8">
          <div class="mb-3">
            <label class="fw-bold text-secondary">ID:</label>
            <p class="ms-2">#{{ product.id }}</p>
          </div>
          
          <div class="mb-3">
            <label class="fw-bold text-secondary">Tên:</label>
            <p class="ms-2">{{ product.product_name }}</p>
          </div>
          
          <div class="mb-3">
            <label class="fw-bold text-secondary">Giá:</label>
            <p class="ms-2 text-danger fw-semibold">{{ formatPrice(product.price) }}</p>
          </div>
          
          <div class="mb-3">
            <label class="fw-bold text-secondary">Danh mục:</label>
            <p class="ms-2">{{ product.category?.name || 'Chưa phân loại' }}</p>
          </div>
          
          <div class="mb-3">
            <label class="fw-bold text-secondary">Số lượng:</label>
            <p class="ms-2">{{ product.quantity || 0 }} sản phẩm</p>
          </div>
          
          <div class="mb-3">
            <label class="fw-bold text-secondary">Trạng thái:</label>
            <p class="ms-2">
              <span :class="product.state === 'active' ? 'text-success' : 'text-warning'">
                ● {{ product.state || 'unknown' }}
              </span>
            </p>
          </div>
          
          <div class="mb-3">
            <label class="fw-bold text-secondary">Mô tả:</label>
            <p class="ms-2">{{ product.details || 'Chưa có mô tả' }}</p>
          </div>
        </div>
      </div>
    </div>

    <router-link to="/admin/products" class="btn btn-secondary mt-4 shadow-sm">
      Quay lại
    </router-link>
  </div>
</template>

<script setup>
import { ref, onMounted } from "vue"
import { useRoute } from "vue-router"
import { getProduct } from "../../services/productService"

const route = useRoute()
const product = ref({})

const formatPrice = (price) => {
  return new Intl.NumberFormat('vi-VN', { 
    style: 'currency', 
    currency: 'VND' 
  }).format(price || 0)
}

onMounted(async () => {
  try {
    const res = await getProduct(route.params.id)
    product.value = res.data.data || res.data
  } catch (error) {
    console.error('Error loading product:', error)
  }
})
</script>

<style scoped>
.card {
  border: none;
  background-color: #f8f9fa;
}

label {
  color: #6c757d;
  font-size: 0.95rem;
}

p {
  margin-bottom: 0;
  font-size: 1rem;
}
</style>