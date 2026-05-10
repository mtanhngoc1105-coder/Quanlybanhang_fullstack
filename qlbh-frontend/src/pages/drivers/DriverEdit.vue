<template>
  <div class="container mt-3">
    <h3>✏️ Sửa tài xế</h3>

    <form @submit.prevent="update">
      <input v-model="form.driver_name" class="form-control mb-2">
      <input v-model="form.driver_phone" class="form-control mb-2">
      <input v-model="form.status" class="form-control mb-2">
      <input v-model="form.plate_number" class="form-control mb-2">

      <button class="btn btn-success">Cập nhật</button>
    </form>
  </div>
</template>

<script setup>
import { reactive, onMounted } from "vue"
import { useRoute, useRouter } from "vue-router"
import { getDriver, updateDriver } from "../../services/driverService"

const route = useRoute()
const router = useRouter()

const form = reactive({
  driver_name: "",
  driver_phone: "",
  status: "",
  plate_number: ""
})

onMounted(async () => {
  const res = await getDriver(route.params.id)
  Object.assign(form, res.data.data)
})

const update = async () => {
  await updateDriver(route.params.id, form)
  router.push("/admin/drivers")
}
</script>