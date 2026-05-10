<template>
  <div class="container mt-4">
    <h2>Thêm sản phẩm</h2>

    <form @submit.prevent="save">
      <input v-model="form.product_name" class="form-control mb-3" placeholder="Tên sản phẩm"/>
      <input v-model="form.price" type="number" class="form-control mb-3" placeholder="Giá"/>
      <input v-model="form.state" class="form-control mb-3" placeholder="Trạng thái"/>
      <input v-model="form.quantity" class="form-control mb-3" placeholder="Số lượng"/>
      <input v-model="form.details" class="form-control mb-3" placeholder="Mô tả"/>


      <button class="btn btn-success">Lưu</button>
      <router-link to="/admin/products" class="btn btn-secondary ms-2">Quay lại</router-link>
    </form>
  </div>
</template>

<script setup>
import { reactive } from "vue"
import { useRouter } from "vue-router"
import { createProduct } from "../../services/productService"

const router = useRouter()

const form = reactive({
  product_name:"",
  price:""
})

const save = async () => {
  await createProduct(form)
  router.push("/admin/products")
}
</script>