<template>
<div class="container mt-4">
  <h2>Order Detail</h2>

  <ul class="list-group">
    <li class="list-group-item"><b>Customer:</b> {{ o.customer?.name }}</li>
    <li class="list-group-item"><b>Post Office:</b> {{ o.post_office?.name }}</li>
    <li class="list-group-item"><b>Voucher:</b> {{ o.voucher?.code }}</li>
    <li class="list-group-item"><b>Total:</b> {{ o.total_amount }}</li>
    <li class="list-group-item"><b>Shipping fee:</b> {{ o.shipping_fee }}</li>
    <li class="list-group-item"><b>Payment:</b> {{ o.payment_status }}</li>
    <li class="list-group-item"><b>Shipping:</b> {{ o.shipping_status }}</li>
    <li class="list-group-item"><b>Address:</b> {{ o.dest_address }}</li>
    <li class="list-group-item"><b>Note:</b> {{ o.note }}</li>
  </ul>
</div>
</template>

<script>
import orderService from "../../services/orderService";

export default {
  data(){ return { o:{} }; },
  async mounted(){
    const res = await orderService.getOne(this.$route.params.id);
    this.o = res.data.data;
  }
};
</script>