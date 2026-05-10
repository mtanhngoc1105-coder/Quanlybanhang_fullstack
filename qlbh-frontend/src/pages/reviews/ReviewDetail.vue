<template>
  <div class="container mt-4">
    <h2>Chi tiết đánh giá</h2>

    <div class="card p-3">
      <p><b>ID:</b> {{ review.id }}</p>
      <p><b>Order:</b> {{ review.order_id }}</p>
      <p><b>Customer:</b> {{ review.customer_id }}</p>
      <p><b>Rating:</b> ⭐ {{ review.rating }}</p>
      <p><b>Comment:</b> {{ review.comment }}</p>
    </div>

    <router-link to="/admin/reviews" class="btn btn-secondary mt-3">Quay lại</router-link>
  </div>
</template>

<script setup>
import { ref, onMounted } from "vue"
import { useRoute } from "vue-router"
import { getReview } from "../../services/reviewService"

const route = useRoute()
const review = ref({})

onMounted(async () => {
  const res = await getReview(route.params.id)
  review.value = res.data.data
})
</script>