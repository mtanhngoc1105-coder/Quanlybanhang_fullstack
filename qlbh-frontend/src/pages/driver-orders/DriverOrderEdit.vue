<template>
  <div class="container mt-4">
    <h2>Cập nhật ngày giao</h2>

    <form @submit.prevent="update">
      <input v-model="form.driver_id" class="form-control mb-2" placeholder="Driver ID">
      <input v-model="form.assign_date" type="date" class="form-control mb-2">
      <button class="btn btn-warning">Update</button>
    </form>
  </div>
</template>

<script>
import { reactive, onMounted } from "vue"
import { useRoute, useRouter } from "vue-router"
import { updateDriverOrder, getDriverOrder } from "../../services/driverOrderService"

export default {
  setup(){
    const route = useRoute()
    const router = useRouter()

    const form = reactive({
      driver_id:"",
      assign_date:""
    })

    onMounted(async ()=>{
      const res = await getDriverOrder(route.params.id)
      const data = res.data.data[0]
      form.driver_id = data.driver_id
      form.assign_date = data.assign_date
    })

    const update = async ()=>{
      await updateDriverOrder(route.params.id, form)
      router.push("/admin/driver-orders")
    }

    return { form, update }
  }
}
</script>