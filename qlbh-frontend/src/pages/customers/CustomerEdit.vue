<template>
  <div v-if="form">
    <h2>Sửa khách hàng</h2>

    <form @submit.prevent="update">
      <input v-model="form.name" class="form-control mb-2" />
      <input v-model="form.email" class="form-control mb-2" />
      <input v-model="form.phone" class="form-control mb-2" />
      <input v-model="form.address" class="form-control mb-2" />

      <button class="btn btn-warning">Cập nhật</button>
    </form>
  </div>
</template>

<script setup>
import { ref, onMounted } from "vue"
import { useRoute, useRouter } from "vue-router"
import { getCustomer, updateCustomer } from "../../api/customerApi"

const route = useRoute()
const router = useRouter()
const form = ref(null)

onMounted(async () => {
  const res = await getCustomer(route.params.id)
  form.value = res.data.data
})

const update = async () => {
  await updateCustomer(route.params.id, form.value)
  alert("Cập nhật thành công")
  router.push("/admin/customers")
}
</script>