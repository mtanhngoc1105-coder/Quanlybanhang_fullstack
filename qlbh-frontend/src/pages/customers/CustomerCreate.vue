<template>
  <div>
    <h2>Thêm khách hàng</h2>

    <form @submit.prevent="save">
      <input v-model="form.name" class="form-control mb-2" placeholder="Tên" />
      <input v-model="form.email" class="form-control mb-2" placeholder="Email" />
      <input v-model="form.phone" class="form-control mb-2" placeholder="Phone" />
      <input v-model="form.address" class="form-control mb-2" placeholder="Address" />

      <button class="btn btn-success">Lưu</button>
    </form>
  </div>
</template>

<script setup>
import { reactive } from "vue"
import { createCustomer } from "../../api/customerApi"
import { useRouter } from "vue-router"

const router = useRouter()

const form = reactive({
  name: "",
  email: "",
  phone: "",
  address: ""
})

const save = async () => {
  await createCustomer(form)
  alert("Tạo thành công")
  router.push("/admin/customers")
}
</script>