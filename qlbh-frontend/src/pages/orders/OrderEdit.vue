<template>
<div class="container mt-4">
  <h2>Edit Order</h2>

  <form @submit.prevent="updateOrder">
    <input v-model="form.customer_id" class="form-control mb-2">
    <input v-model="form.post_office_id" class="form-control mb-2">
    <input v-model="form.promo_code" class="form-control mb-2">

    <input v-model="form.shipping_fee" type="number" class="form-control mb-2">
    <input v-model="form.total_amount" type="number" class="form-control mb-2">

    <input v-model="form.dest_address" class="form-control mb-2">
    <input v-model="form.order_date" type="datetime-local" class="form-control mb-2">

    <input v-model="form.payment_status" class="form-control mb-2">
    <input v-model="form.shipping_status" class="form-control mb-2">
    <input v-model="form.note" class="form-control mb-3">

    <button class="btn btn-primary">Update</button>
  </form>
</div>
</template>

<script>
import orderService from "../../services/orderService";

export default {
  data(){ return { form:{} }; },
  async mounted(){
    const res = await orderService.getOne(this.$route.params.id);
    this.form = res.data.data;
  },
  methods:{
    async updateOrder(){
      await orderService.update(this.$route.params.id, this.form);
      this.$router.push("/admin/orders");
    }
  }
};
</script>