<template>
<div class="container mt-4">
  <h2>Tạo Order</h2>

  <form @submit.prevent="createOrder">
    <input v-model="form.customer_id" class="form-control mb-2" placeholder="Customer ID">
    <input v-model="form.post_office_id" class="form-control mb-2" placeholder="Post Office ID">
    <input v-model="form.promo_code" class="form-control mb-2" placeholder="Promo Code">

    <input v-model="form.shipping_fee" type="number" class="form-control mb-2" placeholder="Shipping fee">
    <input v-model="form.total_amount" type="number" class="form-control mb-2" placeholder="Total">

    <input v-model="form.dest_address" class="form-control mb-2" placeholder="Address">
    <input v-model="form.order_date" type="datetime-local" class="form-control mb-2">

    <input v-model="form.payment_status" class="form-control mb-2" placeholder="Payment status">
    <input v-model="form.shipping_status" class="form-control mb-2" placeholder="Shipping status">
    <input v-model="form.note" class="form-control mb-3" placeholder="Note">

    <button class="btn btn-success">Create</button>
  </form>
</div>
</template>

<script>
import orderService from "../../services/orderService";

export default {
  data() {
    return {
      form: {
        customer_id:"",
        post_office_id:"",
        promo_code:"",
        shipping_fee:"",
        total_amount:"",
        dest_address:"",
        order_date:"",
        payment_status:"",
        shipping_status:"",
        note:""
      }
    };
  },
  methods: {
    async createOrder() {
      await orderService.create(this.form);
      this.$router.push("/admin/orders");
    }
  }
};
</script>