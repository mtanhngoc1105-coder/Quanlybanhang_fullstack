<template>
  <div class="container mt-3" v-if="driver">
    <h3>👨‍✈️ Chi tiết tài xế</h3>

    <div class="card p-3">
      <p><b>ID:</b> {{ driver.id }}</p>
      <p><b>Tên:</b> {{ driver.driver_name }}</p>
      <p><b>SĐT:</b> {{ driver.driver_phone }}</p>
      <p><b>Trạng thái:</b> {{ driver.status }}</p>
      <p><b>Biển số:</b> {{ driver.plate_number }}</p>
    </div>

    <router-link to="/admin/drivers" class="btn btn-secondary mt-3">← Quay lại</router-link>
  </div>
</template>

<script setup>
import { ref, onMounted } from "vue"
import { useRoute } from "vue-router"
import { getDriver } from "../../services/driverService"

const route = useRoute()
const driver = ref(null)

onMounted(async () => {
  const res = await getDriver(route.params.id)
  driver.value = res.data.data
})
</script>