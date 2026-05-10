<template>
  <div class="container mt-4">
    <h2>🎟️ Chi tiết Voucher</h2>

    <div class="card">
      <div class="card-content">
        <p><b>ID:</b> {{ voucher.id }}</p>
        <p><b>Code:</b> {{ voucher.code }}</p>
        <p><b>Type:</b> {{ voucher.type }}</p>
        <p><b>Value:</b> {{ voucher.value }}</p>
        <p><b>Min Order:</b> {{ voucher.min_order }}</p>
        <p><b>Start Date:</b> {{ voucher.start_date }}</p>
        <p><b>End Date:</b> {{ voucher.end_date }}</p>
        <p><b>Quantity:</b> {{ voucher.quantity }}</p>
        <p><b>Status:</b> {{ voucher.status }}</p>
      </div>
    </div>

    <router-link to="/admin/vouchers" class="btn btn-secondary mt-3">Quay lại</router-link>
  </div>
</template>

<script setup>
import { ref, onMounted } from "vue"
import { useRoute } from "vue-router"
import voucherService from "../../services/voucherService"

const route = useRoute()
const voucher = ref({})

onMounted(async () => {
  try {
    const res = await voucherService.getOne(route.params.id)
    voucher.value = res.data.data
  } catch (err) {
    console.error("Error loading voucher:", err)
  }
})
</script>

<style>
.card-content {
  line-height: 2;
}

.card-content p {
  margin: 10px 0;
}
</style>
