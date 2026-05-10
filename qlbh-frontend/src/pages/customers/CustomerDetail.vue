<template>
  <div v-if="customer">
    <h2>Chi tiết khách hàng</h2>
    <p><b>Tên:</b> {{ customer.name }}</p>
    <p><b>Email:</b> {{ customer.email }}</p>
    <p><b>Phone:</b> {{ customer.phone }}</p>
    <p><b>Address:</b> {{ customer.address }}</p>
  </div>
</template>

<script setup>
import { ref, onMounted } from "vue"
import { useRoute } from "vue-router"
import { getCustomer } from "../../api/customerApi"

const route = useRoute()
const customer = ref(null)

onMounted(async () => {
  const res = await getCustomer(route.params.id)
  customer.value = res.data.data
})
</script>