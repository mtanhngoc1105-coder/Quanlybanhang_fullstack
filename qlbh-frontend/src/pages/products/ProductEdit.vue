<template>
  <div class="container mt-4">
    <h2>Sửa sản phẩm</h2>

    <form @submit.prevent="update">
      <div class="mb-3">
        <label>Mã sản phẩm *</label>
        <input v-model="form.product_code" class="form-control" required />
      </div>

      <div class="mb-3">
        <label>Tên sản phẩm *</label>
        <input v-model="form.product_name" class="form-control" required />
      </div>

      <div class="mb-3">
        <label>Giá *</label>
        <input v-model.number="form.price" type="number" class="form-control" min="0" step="0.01" required />
      </div>

      <div class="mb-3">
        <label>Số lượng *</label>
        <input v-model.number="form.quantity" type="number" class="form-control" min="0" required />
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
        <textarea v-model="form.details" class="form-control" rows="3"></textarea>
      </div>

      <button class="btn btn-warning">Cập nhật</button>
      <router-link to="/admin/products" class="btn btn-secondary ms-2">Quay lại</router-link>
    </form>
  </div>
</template>

<script setup>
import { reactive, ref, onMounted } from "vue"
import { useRoute, useRouter } from "vue-router"
import { getProduct, updateProduct } from "../../services/productService"
import categoryService from "../../services/categoryService"

const route = useRoute()
const router = useRouter()
const categories = ref([])

const form = reactive({
  product_code: "",
  product_name: "",
  price: 0,
  quantity: 0,
  state: "active",
  category_id: null,
  details: ""
})

const loadCategories = async () => {
  try {
    const res = await categoryService.getAll()
    categories.value = res.data.data || res.data || []
  } catch (err) {
    console.error('Lỗi tải danh mục:', err)
  }
}

onMounted(async () => {
  await loadCategories()

  const res = await getProduct(route.params.id)
  const product = res.data?.data || res.data || {}
  Object.assign(form, {
    product_code: product.product_code || "",
    product_name: product.product_name || "",
    price: product.price || 0,
    quantity: product.quantity || 0,
    state: product.state || "active",
    category_id: product.category_id || null,
    details: product.details || ""
  })
})

const update = async () => {
  await updateProduct(route.params.id, form)
  router.push("/admin/products")
}
</script>