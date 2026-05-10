<template>
<div class="container mt-4">
  <h2>Update Order Item</h2>

  <form @submit.prevent="update">
    <input v-model="form.quantity" class="form-control mb-2">
    <input v-model="form.price" class="form-control mb-2">

    <button class="btn btn-warning">Update</button>
  </form>
</div>
</template>

<script>
import { reactive, onMounted } from "vue"
import { useRoute, useRouter } from "vue-router"
import { getOrderItem, updateOrderItem } from "../../services/orderItemService"

export default {
  setup(){
    const route = useRoute()
    const router = useRouter()

    const form = reactive({ quantity:"", price:"" })

    onMounted(async ()=>{
      const res = await getOrderItem(route.params.id)
      form.quantity = res.data.quantity
      form.price = res.data.price
    })

    const update = async ()=>{
      await updateOrderItem(route.params.id, form)
      router.push("/admin/order-items")
    }

    return { form, update }
  }
}
</script>