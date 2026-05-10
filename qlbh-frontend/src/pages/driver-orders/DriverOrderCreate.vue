<template>
  <div class="container mt-4">
    <h2>Gán tài xế cho đơn</h2>

    <form @submit.prevent="save">
      <input v-model="form.order_id" class="form-control mb-2" placeholder="Order ID">
      <input v-model="form.driver_id" class="form-control mb-2" placeholder="Driver ID">
      <input v-model="form.assign_date" type="date" class="form-control mb-2">

      <button class="btn btn-success">Save</button>
    </form>
  </div>
</template>

<script>
import { reactive } from "vue"
import { useRouter } from "vue-router"
import { createDriverOrder } from "../../services/driverOrderService"

export default {
  setup(){
    const router = useRouter()
    const form = reactive({
      order_id:"",
      driver_id:"",
      assign_date:""
    })

    const save = async () => {
      await createDriverOrder(form)
      router.push("/admin/driver-orders")
    }

    return { form, save }
  }
}
</script>