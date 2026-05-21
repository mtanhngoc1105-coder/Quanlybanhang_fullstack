<template>
<div class="container mt-4">
  <h2>Tạo Voucher</h2>

  <div v-if="errors" class="alert alert-danger">
    <div v-for="(messages, field) in errors" :key="field">
      <strong>{{ field }}:</strong> {{ Array.isArray(messages) ? messages.join(', ') : messages }}
    </div>
  </div>

  <form @submit.prevent="createVoucher">
    <div class="mb-3">
      <label>Mã code *</label>
      <input v-model="form.code" class="form-control" placeholder="VD: CODE123" required>
    </div>

    <div class="mb-3">
      <label>Loại *</label>
      <select v-model="form.type" class="form-control" required>
        <option value="">-- Chọn loại --</option>
        <option value="percent">Phần trăm (%)</option>
        <option value="fixed">Cố định (VNĐ)</option>
      </select>
    </div>

    <div class="mb-3">
      <label>Giá trị *</label>
      <input v-model.number="form.value" type="number" class="form-control" placeholder="Giá trị" min="1" required>
    </div>

    <div class="mb-3">
      <label>Đơn tối thiểu</label>
      <input v-model.number="form.min_order" type="number" class="form-control" placeholder="Đơn tối thiểu" min="0">
    </div>

    <div class="mb-3">
      <label>Ngày bắt đầu *</label>
      <input v-model="form.start_date" type="date" class="form-control" required>
    </div>

    <div class="mb-3">
      <label>Ngày kết thúc *</label>
      <input v-model="form.end_date" type="date" class="form-control" required>
    </div>

    <div class="mb-3">
      <label>Số lượng *</label>
      <input v-model.number="form.quantity" type="number" class="form-control" placeholder="Số lượng" min="0" required>
    </div>

    <div class="mb-3">
      <label>Trạng thái *</label>
      <select v-model="form.status" class="form-control" required>
        <option value="">-- Chọn trạng thái --</option>
        <option value="active">Hoạt động</option>
        <option value="inactive">Không hoạt động</option>
      </select>
    </div>

    <button type="submit" class="btn btn-success" :disabled="isLoading">
      {{ isLoading ? 'Đang lưu...' : 'Tạo' }}
    </button>
    <router-link to="/admin/vouchers" class="btn btn-secondary ms-2">Quay lại</router-link>
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
      },
      errors: null,
      isLoading: false
    };
  },
  methods: {
    async createVoucher() {
      this.errors = null;
      this.isLoading = true;

      try {
        await voucherService.create(this.form);
        this.$router.push("/admin/vouchers");
      } catch (err) {
        if (err.response?.status === 422) {
          this.errors = err.response.data.errors;
        } else {
          this.errors = { error: [err.response?.data?.message || 'Có lỗi xảy ra'] };
        }
      } finally {
        this.isLoading = false;
      }
    }
  }
};
</script>