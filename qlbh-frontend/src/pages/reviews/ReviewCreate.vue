<template>
  <div class="container mt-4">
    <h2>Thêm đánh giá</h2>

    <div v-if="error" class="alert alert-danger">{{ error }}</div>

    <form @submit.prevent="save">
      <input v-model="form.order_id" type="number" class="form-control mb-3" placeholder="Order ID"/>
      <input v-model="form.customer_id" type="number" class="form-control mb-3" placeholder="Customer ID"/>

      <select v-model="form.rating" class="form-control mb-3">
        <option value="">Chọn rating</option>
        <option v-for="i in 5" :key="i" :value="i">{{ i }} ⭐</option>
      </select>

      <textarea v-model="form.comment" class="form-control mb-3" placeholder="Nhận xét"></textarea>

      <button class="btn btn-success">Lưu</button>
      <router-link to="/admin/reviews" class="btn btn-secondary ms-2">Quay lại</router-link>
    </form>
  </div>
</template>

<script setup>
import { reactive, ref } from "vue"
import { useRouter } from "vue-router"
import { createReview } from "../../services/reviewService"

const router = useRouter()
const error = ref("")

const form = reactive({
  order_id:"",
  customer_id:"",
  rating:"",
  comment:""
})

const save = async () => {
  // Validate required fields
  if (!form.order_id || !form.customer_id || !form.rating || !form.comment) {
    error.value = "Vui lòng điền đầy đủ thông tin"
    return
  }

  const submitData = {
    order_id: parseInt(form.order_id, 10),
    customer_id: parseInt(form.customer_id, 10),
    rating: parseInt(form.rating, 10),
    comment: form.comment
  }

  if (Number.isNaN(submitData.order_id) || Number.isNaN(submitData.customer_id) || Number.isNaN(submitData.rating)) {
    error.value = "Order ID, Customer ID và Rating phải là số hợp lệ"
    return
  }

  try {
    await createReview(submitData)
    router.push("/admin/reviews")
  } catch (err) {
    const response = err.response?.data
    if (response?.errors) {
      error.value = Object.values(response.errors).flat().join(" ")
    } else {
      error.value = response?.message || "Lỗi khi tạo đánh giá"
    }
    console.error(err)
  }
}
</script>