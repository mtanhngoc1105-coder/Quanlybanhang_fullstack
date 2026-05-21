<template>
  <div class="container mt-4">
    <h2>Thêm sản phẩm</h2>

    <div v-if="errors" class="alert alert-danger">
      <div v-for="(messages, field) in errors" :key="field">
        <strong>{{ field }}:</strong> {{ Array.isArray(messages) ? messages.join(', ') : messages }}
      </div>
    </div>

    <form @submit.prevent="save">
      <div class="mb-3">
        <label>Mã sản phẩm *</label>
        <input v-model="form.product_code" class="form-control" placeholder="VD: PROD001" required />
      </div>

      <div class="mb-3">
        <label>Tên sản phẩm *</label>
        <input v-model="form.product_name" class="form-control" placeholder="Tên sản phẩm" required />
      </div>

      <div class="mb-3">
        <label>Giá *</label>
        <input v-model.number="form.price" type="number" class="form-control" placeholder="Giá" min="0" step="0.01" required />
      </div>

      <div class="mb-3">
        <label>Số lượng *</label>
        <input v-model.number="form.quantity" type="number" class="form-control" placeholder="Số lượng" min="0" required />
      </div>

      <div class="mb-3">
        <label>Trạng thái *</label>
        <select v-model="form.state" class="form-control" required>
          <option value="">-- Chọn trạng thái --</option>
          <option value="active">Hoạt động</option>
          <option value="inactive">Không hoạt động</option>
          <option value="out_of_stock">Hết hàng</option>
        </select>
      </div>

      <div class="mb-3">
        <label>Danh mục</label>
        <select v-model.number="form.category_id" class="form-control">
          <option value="">-- Chọn danh mục --</option>
          <option v-for="cat in categories" :key="cat.id" :value="cat.id">
            {{ cat.name }}
          </option>
        </select>
      </div>

      <div class="mb-3">
        <label>Mô tả</label>
        <textarea v-model="form.details" class="form-control" placeholder="Mô tả sản phẩm" rows="3"></textarea>
      </div>

      <button type="submit" class="btn btn-success" :disabled="isLoading">
        {{ isLoading ? 'Đang lưu...' : 'Lưu' }}
      </button>
      <router-link to="/admin/products" class="btn btn-secondary ms-2">Quay lại</router-link>
    </form>
  </div>
</template>

<script setup>
import { reactive, ref, onMounted } from "vue"
import { useRouter } from "vue-router"
import { createProduct } from "../../services/productService"
import categoryService from "../../services/categoryService"

const router = useRouter()
const errors = ref(null)
const isLoading = ref(false)
const categories = ref([])

const form = reactive({
  product_code: "",
  product_name: "",
  price: "",
  quantity: "",
  state: "active",
  category_id: null,
  details: ""
})

const save = async () => {
  errors.value = null
  isLoading.value = true

  try {
    await createProduct(form)
    router.push("/admin/products")
  } catch (err) {
    if (err.response?.status === 422) {
      errors.value = err.response.data.errors
    } else {
      errors.value = { error: [err.response?.data?.message || 'Có lỗi xảy ra'] }
    }
  } finally {
    isLoading.value = false
  }
}

onMounted(async () => {
  try {
    const res = await categoryService.getAll()
    categories.value = res.data.data || res.data
  } catch (err) {
    console.error('Lỗi tải danh mục:', err)
  }
})
</script>