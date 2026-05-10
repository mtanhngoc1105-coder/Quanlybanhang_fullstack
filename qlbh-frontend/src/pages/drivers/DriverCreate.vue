<template>
  <div class="container mt-3">
    <h3> Thêm tài xế</h3>

    <form @submit.prevent="save">
      <input v-model="form.driver_name" class="form-control mb-2" placeholder="Tên tài xế">
      <input v-model="form.driver_phone" class="form-control mb-2" placeholder="SĐT">
      <input v-model="form.status" class="form-control mb-2" placeholder="Trạng thái">
      <input v-model="form.plate_number" class="form-control mb-2" placeholder="Biển số">

      <button class="btn btn-success">Lưu</button>
    </form>
  </div>
</template>

<script setup>
import { reactive } from "vue"
import { useRouter } from "vue-router"
import { createDriver } from "../../services/driverService"

const router = useRouter()

const form = reactive({
  driver_name: "",
  driver_phone: "",
  status: "",
  plate_number: ""
})

const save = async () => {
  await createDriver(form)
  router.push("/drivers")
}
</script>