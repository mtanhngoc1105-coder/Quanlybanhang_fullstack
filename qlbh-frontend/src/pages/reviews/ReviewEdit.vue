<template>
  <div class="container mt-4">
    <h2>Sửa đánh giá</h2>

    <form @submit.prevent="update">
      <input v-model="form.order_id" class="form-control mb-3"/>
      <input v-model="form.customer_id" class="form-control mb-3"/>

      <select v-model="form.rating" class="form-control mb-3">
        <option v-for="i in 5" :key="i" :value="i">{{ i }} ⭐</option>
      </select>

      <textarea v-model="form.comment" class="form-control mb-3"></textarea>

      <button class="btn btn-warning">Cập nhật</button>
      <router-link to="/admin/reviews" class="btn btn-secondary ms-2">Quay lại</router-link>
    </form>
  </div>
</template>

<script setup>
import { reactive, onMounted } from "vue"
import { useRoute, useRouter } from "vue-router"
import { getReview, updateReview } from "../../services/reviewService"

const route = useRoute()
const router = useRouter()

const form = reactive({})

onMounted(async () => {
  const res = await getReview(route.params.id)
  Object.assign(form, res.data.data)
})

const update = async () => {
  await updateReview(route.params.id, form)
  router.push("/admin/reviews")
}
</script>