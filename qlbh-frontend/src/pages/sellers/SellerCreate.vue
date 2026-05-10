<template>
  <div class="container mt-4">
    <h2>Thêm người bán</h2>

    <form @submit.prevent="save">
      <input v-model="form.seller_name" class="form-control mb-3" placeholder="Tên người bán"/>
      <input v-model="form.seller_phone_number" class="form-control mb-3" placeholder="Số điện thoại"/>

      <button class="btn btn-success">Lưu</button>
      <router-link to="/admin/sellers" class="btn btn-secondary ms-2">Quay lại</router-link>
    </form>
  </div>
</template>

<script setup>
import { reactive } from "vue"
import { useRouter } from "vue-router"
import { createSeller } from "../../services/sellerService"

const router = useRouter()

const form = reactive({
  seller_name:"",
  seller_phone_number:""
})

const save = async () => {
  await createSeller(form)
  router.push("/admin/sellers")
}
</script>