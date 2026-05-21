<template>
  <div class="container mt-4">
    <h2>Thêm người bán</h2>

    <div v-if="errors" class="alert alert-danger">
      <div v-for="(messages, field) in errors" :key="field">
        <strong>{{ field }}:</strong> {{ Array.isArray(messages) ? messages.join(', ') : messages }}
      </div>
    </div>

    <form @submit.prevent="save">
      <div class="mb-3">
        <label>Tên người bán *</label>
        <input v-model="form.seller_name" class="form-control" placeholder="Tên người bán" required />
      </div>

      <div class="mb-3">
        <label>Số điện thoại *</label>
        <input v-model="form.seller_phone_number" class="form-control" placeholder="Số điện thoại" required />
      </div>

      <button type="submit" class="btn btn-success" :disabled="isLoading">
        {{ isLoading ? 'Đang lưu...' : 'Lưu' }}
      </button>
      <router-link to="/admin/sellers" class="btn btn-secondary ms-2">Quay lại</router-link>
    </form>
  </div>
</template>

<script setup>
import { reactive, ref } from "vue"
import { useRouter } from "vue-router"
import { createSeller } from "../../services/sellerService"

const router = useRouter()
const errors = ref(null)
const isLoading = ref(false)

const form = reactive({
  seller_name: "",
  seller_phone_number: ""
})

const save = async () => {
  errors.value = null
  isLoading.value = true

  try {
    await createSeller(form)
    router.push("/admin/sellers")
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