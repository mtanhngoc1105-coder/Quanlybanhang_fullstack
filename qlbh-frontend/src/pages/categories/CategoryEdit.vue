<template>
  <div class="container mt-4">
    <h2 class="fw-bold mb-4">Chỉnh sửa danh mục</h2>

    <div class="card p-4 shadow-sm rounded">
      <form @submit.prevent="update">
        <div class="row">
          <div class="col-md-4">
            <div class="mb-3">
              <label class="form-label fw-bold">Ảnh hiện tại:</label>
              <div class="mt-2">
                <img
                  v-if="form.image"
                  :src="form.image"
                  alt="Current Image"
                  class="img-fluid rounded shadow-sm"
                  style="max-width: 100%; height: auto;"
                >
                <div v-else class="text-muted">
                  <i class="fas fa-image"></i> Chưa có ảnh
                </div>
              </div>
            </div>
          </div>

          <div class="col-md-8">
            <div class="mb-3">
              <label class="form-label fw-bold">Tên danh mục:</label>
              <input
                v-model="form.name"
                class="form-control shadow-sm"
                placeholder="Nhập tên danh mục"
                required
              >
            </div>

            <div class="mb-3">
              <label class="form-label fw-bold">Link ảnh:</label>
              <input
                v-model="form.image"
                class="form-control shadow-sm"
                placeholder="Nhập link ảnh (tùy chọn)"
              >
            </div>

            <div class="mb-3">
              <label class="form-label fw-bold">Danh mục cha (ID):</label>
              <input
                v-model="form.parent_id"
                type="number"
                class="form-control shadow-sm"
                placeholder="Nhập ID danh mục cha (tùy chọn)"
              >
            </div>

            <div class="mb-3">
              <label class="form-label fw-bold">Slug (tự động tạo):</label>
              <input
                :value="generateSlug(form.name)"
                class="form-control shadow-sm"
                readonly
                placeholder="Slug sẽ được tạo tự động"
              >
            </div>
          </div>
        </div>

        <div class="d-flex gap-2 mt-4">
          <button type="submit" class="btn btn-warning shadow-sm">
            Cập nhật danh mục
          </button>
          <router-link to="/admin/categories" class="btn btn-secondary shadow-sm">
            Hủy
          </router-link>
        </div>
      </form>
    </div>
  </div>
</template>

<script setup>
import { reactive, onMounted, computed } from "vue"
import { useRoute, useRouter } from "vue-router"
import categoryService from "../../services/categoryService"

const route = useRoute()
const router = useRouter()

const form = reactive({
  name: "",
  image: "",
  parent_id: ""
})

const generateSlug = (name) => {
  if (!name) return ""
  return name
    .toLowerCase()
    .normalize('NFD')
    .replace(/[\u0300-\u036f]/g, '')
    .replace(/[^a-z0-9\s-]/g, '')
    .trim()
    .replace(/\s+/g, '-')
    .replace(/-+/g, '-')
}

onMounted(async () => {
  try {
    const res = await categoryService.get(route.params.id)
    Object.assign(form, res.data.data)
  } catch (error) {
    console.error('Error loading category:', error)
  }
})

const update = async () => {
  try {
    await categoryService.update(route.params.id, form)
    router.push("/admin/categories")
  } catch (error) {
    console.error('Error updating category:', error)
    alert('Có lỗi xảy ra khi cập nhật danh mục!')
  }
}
</script>

<style scoped>
.card {
  border: none;
  background-color: #f8f9fa;
}

.form-label {
  color: #495057;
  font-size: 0.95rem;
}

.img-fluid {
  max-height: 250px;
  object-fit: cover;
}
</style>