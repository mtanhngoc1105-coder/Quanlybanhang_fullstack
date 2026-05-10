<template>
  <div class="container mt-4">
    <h2>Chi tiết người bán</h2>

    <div class="card p-3">
      <p><b>ID:</b> {{ seller.id }}</p>
      <p><b>Tên:</b> {{ seller.seller_name }}</p>
      <p><b>SĐT:</b> {{ seller.seller_phone_number }}</p>
    </div>

    <router-link to="/admin/sellers" class="btn btn-secondary mt-3">Quay lại</router-link>
  </div>
</template>

<script setup>
import { ref, onMounted } from "vue"
import { useRoute } from "vue-router"
import { getSeller } from "../../services/sellerService"

const route = useRoute()
const seller = ref({})

onMounted(async () => {
  const res = await getSeller(route.params.id)
  seller.value = res.data
})
</script>