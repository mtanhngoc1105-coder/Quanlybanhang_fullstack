<template>
  <div class="container mt-4">
    <h2>Sửa người bán</h2>

    <form @submit.prevent="update">
      <input v-model="form.seller_name" class="form-control mb-3"/>
      <input v-model="form.seller_phone_number" class="form-control mb-3"/>

      <button class="btn btn-warning">Cập nhật</button>
      <router-link to="/admin/sellers" class="btn btn-secondary ms-2">Quay lại</router-link>
    </form>
  </div>
</template>

<script setup>
import { reactive, onMounted } from "vue"
import { useRoute, useRouter } from "vue-router"
import { getSeller, updateSeller } from "../../services/sellerService"

const route = useRoute()
const router = useRouter()

const form = reactive({})

onMounted(async () => {
  const res = await getSeller(route.params.id)
  Object.assign(form, res.data)
})

const update = async () => {
  await updateSeller(route.params.id, form)
  router.push("/admin/sellers")
}
</script>