<template>
  <div class="container mt-4">
    <h2>Thêm tài xế</h2>

    <div v-if="errors" class="alert alert-danger">
      <div v-for="(messages, field) in errors" :key="field">
        <strong>{{ field }}:</strong> {{ Array.isArray(messages) ? messages.join(', ') : messages }}
      </div>
    </div>

    <form @submit.prevent="save">
      <div class="mb-3">
        <label>Tên tài xế *</label>
        <input v-model="form.driver_name" class="form-control" placeholder="Tên tài xế" required />
      </div>

      <div class="mb-3">
        <label>Số điện thoại *</label>
        <input v-model="form.driver_phone" class="form-control" placeholder="SĐT" required />
      </div>

      <div class="mb-3">
        <label>Biển số xe *</label>
        <input v-model="form.plate_number" class="form-control" placeholder="Biển số" required />
      </div>

      <div class="mb-3">
        <label>Trạng thái *</label>
        <select v-model="form.status" class="form-control" required>
          <option value="">-- Chọn trạng thái --</option>
          <option value="active">Hoạt động</option>
          <option value="inactive">Không hoạt động</option>
        </select>
      </div>

      <button type="submit" class="btn btn-success" :disabled="isLoading">
        {{ isLoading ? 'Đang lưu...' : 'Lưu' }}
      </button>
      <router-link to="/admin/drivers" class="btn btn-secondary ms-2">Quay lại</router-link>
    </form>
  </div>
</template>

<script setup>
import { reactive, ref } from "vue"
import { useRouter } from "vue-router"
import { createDriver } from "../../services/driverService"

const router = useRouter()
const errors = ref(null)
const isLoading = ref(false)

const form = reactive({
  driver_name: "",
  driver_phone: "",
  status: "active",
  plate_number: ""
})

const save = async () => {
  errors.value = null
  isLoading.value = true

  try {
    await createDriver(form)
    router.push("/admin/drivers")
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
</script>