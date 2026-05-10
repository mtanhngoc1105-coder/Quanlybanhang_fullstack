<template>
<div class="container mt-4">
  <h2>Chi tiết Order Item</h2>

  <p><b>Order ID:</b> {{ item.order_id }}</p>
  <p><b>Product:</b> {{ item.product?.name }}</p>
  <p><b>Quantity:</b> {{ item.quantity }}</p>
  <p><b>Price:</b> {{ item.price }}</p>
</div>
</template>

<script>
import { ref, onMounted } from "vue"
import { useRoute } from "vue-router"
import { getOrderItem } from "../../services/orderItemService"

export default {
setup(){
  const route = useRoute()
  const item = ref({})

  onMounted(async ()=>{
    const res = await getOrderItem(route.params.id)
    item.value = res.data
  })

  return { item }
}
}
</script>