<template>
  <div class="container mt-4">
    <h2 class="fw-bold mb-4">Chi tiết danh mục</h2>

    <div class="card p-4 shadow-sm rounded">
      <div class="row">
        <div class="col-md-4">
          <div class="mb-3">
            <label class="fw-bold text-secondary">Ảnh danh mục:</label>
            <div class="mt-2">
              <img
                v-if="category.image"
                :src="category.image"
                alt="Category Image"
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
            <label class="fw-bold text-secondary">ID:</label>
            <p class="ms-2">#{{ category.id }}</p>
          </div>

          <div class="mb-3">
            <label class="fw-bold text-secondary">Tên danh mục:</label>
            <p class="ms-2">{{ category.name }}</p>
          </div>

          <div class="mb-3">
            <label class="fw-bold text-secondary">Slug:</label>
            <p class="ms-2">
              <span class="badge bg-light text-dark border">{{ category.slug }}</span>
            </p>
          </div>

          <div class="mb-3">
            <label class="fw-bold text-secondary">Danh mục cha:</label>
            <p class="ms-2">{{ category.parent_id ? `Danh mục #${category.parent_id}` : 'Danh mục gốc' }}</p>
          </div>
        </div>
      </div>
    </div>

    <router-link to="/admin/categories" class="btn btn-secondary mt-4 shadow-sm">
      Quay lại
    </router-link>
  </div>
</template>

<script setup>
import { ref, onMounted } from "vue"
import { useRoute } from "vue-router"
import categoryService from "../../services/categoryService"

const route = useRoute()
const category = ref({})

onMounted(async () => {
  try {
    const res = await categoryService.get(route.params.id)
    category.value = res.data.data
  } catch (error) {
    console.error('Error loading category:', error)
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

.img-fluid {
  max-height: 300px;
  object-fit: cover;
}
</style>