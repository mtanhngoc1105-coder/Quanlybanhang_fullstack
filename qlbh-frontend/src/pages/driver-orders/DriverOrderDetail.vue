<template>
  <div class="container mt-4">
    <h2>Chi tiết giao đơn</h2>

    <p><b>Order:</b> {{ data.order_id }}</p>
    <p><b>Driver:</b> {{ data.driver_id }}</p>
    <p><b>Date:</b> {{ data.assign_date }}</p>
  </div>
</template>

<script>
import { ref, onMounted } from "vue"
import { useRoute } from "vue-router"
import { getDriverOrder } from "../../services/driverOrderService"

export default {
  setup(){
    const route = useRoute()
    const data = ref({})

    onMounted(async ()=>{
      const res = await getDriverOrder(route.params.id)
      data.value = res.data.data[0]
    })

    return { data }
  }
}
</script>