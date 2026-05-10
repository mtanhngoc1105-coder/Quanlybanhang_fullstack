<template>
<div class="container mt-4">
  <h2>Tạo Voucher</h2>

  <form @submit.prevent="createVoucher">
    <input v-model="form.code" class="form-control mb-2" placeholder="Code">

    <select v-model="form.type" class="form-control mb-2">
      <option value="percent">Percent</option>
      <option value="fixed">Fixed</option>
    </select>

    <input v-model="form.value" type="number" class="form-control mb-2" placeholder="Value">
    <input v-model="form.min_order" type="number" class="form-control mb-2" placeholder="Min Order">

    <input v-model="form.start_date" type="date" class="form-control mb-2">
    <input v-model="form.end_date" type="date" class="form-control mb-2">

    <input v-model="form.quantity" type="number" class="form-control mb-2" placeholder="Quantity">

    <select v-model="form.status" class="form-control mb-3">
      <option value="active">Active</option>
      <option value="inactive">Inactive</option>
    </select>

    <button class="btn btn-success">Create</button>
  </form>
</div>
</template>

<script>
import voucherService from "../../services/voucherService";

export default {
  data() {
    return {
      form: {
        code: "",
        type: "percent",
        value: "",
        min_order: "",
        start_date: "",
        end_date: "",
        quantity: "",
        status: "active"
      }
    };
  },
  methods: {
    async createVoucher() {
      await voucherService.create(this.form);
      this.$router.push("/admin/vouchers");
    }
  }
};
</script>