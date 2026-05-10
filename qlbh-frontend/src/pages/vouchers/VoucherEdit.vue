<template>
<div class="container mt-4">
  <h2>Edit Voucher</h2>

  <form @submit.prevent="updateVoucher">
    <input v-model="form.code" class="form-control mb-2">

    <select v-model="form.type" class="form-control mb-2">
      <option value="percent">Percent</option>
      <option value="fixed">Fixed</option>
    </select>

    <input v-model="form.value" type="number" class="form-control mb-2">
    <input v-model="form.min_order" type="number" class="form-control mb-2">

    <input v-model="form.start_date" type="date" class="form-control mb-2">
    <input v-model="form.end_date" type="date" class="form-control mb-2">

    <input v-model="form.quantity" type="number" class="form-control mb-2">

    <select v-model="form.status" class="form-control mb-3">
      <option value="active">Active</option>
      <option value="inactive">Inactive</option>
    </select>

    <button class="btn btn-primary">Update</button>
  </form>
</div>
</template>

<script>
import voucherService from "../../services/voucherService";

export default {
  data() {
    return { form: {} };
  },
  async mounted() {
    const res = await voucherService.getOne(this.$route.params.id);
    this.form = res.data.data;
  },
  methods: {
    async updateVoucher() {
      await voucherService.update(this.$route.params.id, this.form);
      this.$router.push("/admin/vouchers");
    }
  }
};
</script>