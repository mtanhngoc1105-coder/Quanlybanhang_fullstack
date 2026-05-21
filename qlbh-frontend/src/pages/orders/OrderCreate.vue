<template>
<div class="container mt-4">
  <h2>Tạo Đơn Hàng</h2>

  <div v-if="errors" class="alert alert-danger">
    <div v-for="(messages, field) in errors" :key="field">
      <strong>{{ field }}:</strong> {{ Array.isArray(messages) ? messages.join(', ') : messages }}
    </div>
  </div>

  <form @submit.prevent="createOrder">
    <div class="mb-3">
      <label>Khách hàng *</label>
      <select v-model.number="form.customer_id" class="form-control" required>
        <option value="">-- Chọn khách hàng --</option>
        <option v-for="cus in customers" :key="cus.id" :value="cus.id">
          {{ cus.name || cus.customer_name }} ({{ cus.email }})
        </option>
      </select>
    </div>

    <div class="mb-3">
      <label>Bưu cục *</label>
      <select v-model.number="form.post_office_id" class="form-control" required>
        <option value="">-- Chọn bưu cục --</option>
        <option v-for="po in postOffices" :key="po.id" :value="po.id">
          {{ po.name || po.post_office_name }}
        </option>
      </select>
    </div>

    <div class="mb-3">
      <label>Mã khuyến mãi</label>
      <input v-model="form.promo_code" class="form-control" placeholder="Mã khuyến mãi (tùy chọn)">
    </div>

    <div class="mb-3">
      <label>Phí vận chuyển *</label>
      <input v-model.number="form.shipping_fee" type="number" class="form-control" placeholder="Phí vận chuyển" min="0" step="0.01" required>
    </div>

    <div class="mb-3">
      <label>Tổng tiền *</label>
      <input v-model.number="form.total_amount" type="number" class="form-control" placeholder="Tổng tiền" min="0" step="0.01" required>
    </div>

    <div class="mb-3">
      <label>Địa chỉ giao hàng *</label>
      <textarea v-model="form.dest_address" class="form-control" placeholder="Địa chỉ giao hàng" required></textarea>
    </div>

    <div class="mb-3">
      <label>Ngày đặt *</label>
      <input v-model="form.order_date" type="datetime-local" class="form-control" required>
    </div>

    <div class="mb-3">
      <label>Trạng thái thanh toán *</label>
      <input v-model="form.payment_status" class="form-control" placeholder="VD: pending, completed" required>
    </div>

    <div class="mb-3">
      <label>Trạng thái giao hàng *</label>
      <input v-model="form.shipping_status" class="form-control" placeholder="VD: pending, shipped, delivered" required>
    </div>

    <div class="mb-3">
      <label>Ghi chú</label>
      <textarea v-model="form.note" class="form-control" placeholder="Ghi chú (tùy chọn)" rows="3"></textarea>
    </div>

    <button type="submit" class="btn btn-success" :disabled="isLoading">
      {{ isLoading ? 'Đang tạo...' : 'Tạo' }}
    </button>
    <router-link to="/admin/orders" class="btn btn-secondary ms-2">Quay lại</router-link>
  </form>
</div>
</template>

<script>
import orderService from "../../services/orderService";
import { getCustomers } from "../../services/customerService";
import { getPostOffices } from "../../services/postOfficeService";

export default {
  data() {
    return {
      form: {
        customer_id: "",
        post_office_id: "",
        promo_code: "",
        shipping_fee: "",
        total_amount: "",
        dest_address: "",
        order_date: "",
        payment_status: "pending",
        shipping_status: "pending",
        note: ""
      },
      customers: [],
      postOffices: [],
      errors: null,
      isLoading: false
    };
  },
  async mounted() {
    try {
      const [cusRes, poRes] = await Promise.all([
        getCustomers(),
        getPostOffices()
      ]);
      this.customers = cusRes.data.data || cusRes.data;
      this.postOffices = poRes.data.data || poRes.data;
    } catch (err) {
      console.error('Lỗi tải dữ liệu:', err);
    }
  },
  methods: {
    async createOrder() {
      this.errors = null;
      this.isLoading = true;

      try {
        await orderService.create(this.form);
        this.$router.push("/admin/orders");
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