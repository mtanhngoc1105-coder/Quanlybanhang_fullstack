<template>
<div class="container mt-4">
  <h2>Thêm sản phẩm vào đơn</h2>

  <div v-if="error" class="alert alert-danger">{{ error }}</div>

  <form @submit.prevent="save">
    <input v-model="form.order_id" type="number" class="form-control mb-2" placeholder="Order ID">
    <input v-model="form.product_id" type="number" class="form-control mb-2" placeholder="Product ID">
    <input v-model="form.quantity" type="number" class="form-control mb-2" placeholder="Quantity">
    <input v-model="form.price" type="number" step="0.01" class="form-control mb-2" placeholder="Price">

    <button class="btn btn-success">Save</button>
  </form>
</div>
</template>

<script>
import { reactive, ref } from "vue"
import { useRouter } from "vue-router"
import { createOrderItem } from "../../services/orderItemService"

export default {
setup(){
  const router = useRouter()
  const error = ref("")

  const form = reactive({
    order_id:"",
    product_id:"",
    quantity:"",
    price:""
  })

  const save = async ()=>{
    if (!form.order_id || !form.product_id || !form.quantity || !form.price) {
      error.value = "Vui lòng điền đầy đủ thông tin"
      return
    }

    const submitData = {
      order_id: parseInt(form.order_id, 10),
      product_id: parseInt(form.product_id, 10),
      quantity: parseInt(form.quantity, 10),
      price: parseFloat(form.price)
    }

    if (Number.isNaN(submitData.order_id) || Number.isNaN(submitData.product_id) || Number.isNaN(submitData.quantity) || Number.isNaN(submitData.price)) {
      error.value = "Order ID, Product ID, Quantity và Price phải là số hợp lệ"
      return
    }

    try {
      await createOrderItem(submitData)
      router.push("/admin/order-items")
    } catch (err) {
      const response = err.response?.data
      if (response?.errors) {
        error.value = Object.values(response.errors).flat().join(" ")
      } else {
        error.value = response?.message || "Lỗi khi tạo chi tiết đơn"
      }
      console.error(err)
    }
  }

  return { form, save, error }
}
}
</script>