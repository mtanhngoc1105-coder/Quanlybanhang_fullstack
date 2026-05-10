<template>
<div class="container mt-4">
  <h2>Chi tiết bưu cục</h2>

  <p><b>Seller:</b> {{ post.seller?.seller_name }}</p>
  <p><b>Branch:</b> {{ post.branch_office }}</p>
  <p><b>Address:</b> {{ post.post_add }}</p>
  <p><b>Hotline:</b> {{ post.hotline }}</p>
  <p><b>Giờ làm việc:</b> {{ post.operating_hour }}</p>
</div>
</template>

<script>
import { ref, onMounted } from "vue"
import { useRoute } from "vue-router"
import { getPostOffice } from "../../services/postOfficeService"

export default {
setup(){
  const route = useRoute()
  const post = ref({})

  onMounted(async ()=>{
    const res = await getPostOffice(route.params.id)
    post.value = res.data.data
  })

  return { post }
}
}
</script>