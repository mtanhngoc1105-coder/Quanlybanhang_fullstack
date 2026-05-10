<template>
<div class="container mt-4">
  <h2>Tạo bưu cục</h2>

  <form @submit.prevent="save">
    <input v-model="form.seller_id" class="form-control mb-2" placeholder="Seller ID">
    <input v-model="form.branch_office" class="form-control mb-2" placeholder="Tên chi nhánh">
    <input v-model="form.post_add" class="form-control mb-2" placeholder="Địa chỉ">
    <input v-model="form.hotline" class="form-control mb-2" placeholder="Hotline">
    <input v-model="form.operating_hour" class="form-control mb-2" placeholder="Giờ làm việc">

    <button class="btn btn-success">Save</button>
  </form>
</div>
</template>

<script>
import { reactive } from "vue"
import { useRouter } from "vue-router"
import { createPostOffice } from "../../services/postOfficeService"

export default {
setup(){
  const router = useRouter()

  const form = reactive({
    seller_id:"",
    branch_office:"",
    post_add:"",
    hotline:"",
    operating_hour:""
  })

  const save = async ()=>{
    await createPostOffice(form)
    router.push("/postoffices")
  }

  return { form, save }
}
}
</script>