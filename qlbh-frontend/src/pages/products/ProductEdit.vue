<template>
  <div class="container mt-4">
    <h2>Sửa sản phẩm</h2>

    <form @submit.prevent="update">
      <input v-model="form.product_name" class="form-control mb-3"/>
      <input v-model="form.price" type="number" class="form-control mb-3"/>

      <button class="btn btn-warning">Cập nhật</button>
      <router-link to="/admin/products" class="btn btn-secondary ms-2">Quay lại</router-link>
    </form>
  </div>
</template>

<script setup>
import { reactive, onMounted } from "vue"
import { useRoute, useRouter } from "vue-router"
import { getProduct, updateProduct } from "../../services/productService"

const route = useRoute()
const router = useRouter()

const form = reactive({
  product_name:"",
  price:"",
  state:"",
  quantity:"",
  details:""
})

onMounted(async () => {
  const res = await getProduct(route.params.id)
  Object.assign(form, res.data)
})

const update = async () => {
  await updateProduct(route.params.id, form)
  router.push("/admin/products")
}
</script>