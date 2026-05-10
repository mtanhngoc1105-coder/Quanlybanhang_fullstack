<template>
<div class="container mt-4">
  <h2>Update bưu cục</h2>

  <form @submit.prevent="update">
    <input v-model="form.branch_office" class="form-control mb-2">
    <input v-model="form.post_add" class="form-control mb-2">
    <input v-model="form.hotline" class="form-control mb-2">
    <input v-model="form.operating_hour" class="form-control mb-2">

    <button class="btn btn-warning">Update</button>
  </form>
</div>
</template>

<script>
import { reactive, onMounted } from "vue"
import { useRoute, useRouter } from "vue-router"
import { getPostOffice, updatePostOffice } from "../../services/postOfficeService"

export default {
setup(){
  const route = useRoute()
  const router = useRouter()

  const form = reactive({})

  onMounted(async ()=>{
    const res = await getPostOffice(route.params.id)
    Object.assign(form, res.data.data)
  })

  const update = async ()=>{
    await updatePostOffice(route.params.id, form)
    router.push("/postoffices")
  }

  return { form, update }
}
}
</script>