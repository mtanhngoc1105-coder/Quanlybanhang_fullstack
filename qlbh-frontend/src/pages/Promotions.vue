<template>
  <div class="promotions-page">
    <div class="page-header">
      <h1>Khuyến Mãi Đặc Biệt</h1>
      <p>Những ưu đãi tốt nhất hiện có dành cho fan anime và mô hình figure.</p>
    </div>

    <div class="promotions-content">
      <div class="promo-card">
        <h2>FLASH SALE</h2>
        <p>Giảm giá lên đến 50% cho nhiều sản phẩm mô hình anime trong thời gian có hạn.</p>
      </div>
      <div class="promo-card">
        <h2>ƯU ĐÃI MỚI</h2>
        <p>Nhận thêm quà tặng khi mua đơn hàng từ 499.000đ trở lên. Áp dụng kèm mã giảm giá.</p>
      </div>
      <div class="promo-card">
        <h2>MUA 2 TẶNG 1</h2>
        <p>Chương trình khuyến mãi dành cho các bộ figure và phụ kiện, chỉ áp dụng trực tuyến.</p>
      </div>
    </div>

    <div class="promo-notes">
      <h3>Lưu ý khi sử dụng khuyến mãi</h3>
      <ul>
        <li>Mỗi khách hàng chỉ được áp dụng 1 mã giảm giá cho mỗi đơn hàng.</li>
        <li>Khuyến mãi không áp dụng đồng thời với các chương trình khác trừ khi có thông báo đặc biệt.</li>
        <li>Hàng khuyến mãi có thể bị hết, vui lòng kiểm tra lại trước khi đặt hàng.</li>
      </ul>
    </div>
  </div>
</template>

<script setup>
</script>

<style scoped>
.promotions-page {
  max-width: 1100px;
  margin: 0 auto;
  padding: 24px 20px;
}

.page-header {
  text-align: center;
  margin-bottom: 36px;
}

.page-header h1 {
  font-size: 36px;
  color: #10244c;
  margin-bottom: 12px;
}

.page-header p {
  color: #4a5568;
  font-size: 16px;
}

.promotions-content {
  display: grid;
  gap: 18px;
  margin-bottom: 28px;
}

.promo-card {
  background: #ffffff;
  border-radius: 20px;
  padding: 24px;
  box-shadow: 0 16px 40px rgba(15, 42, 81, 0.08);
}

.promo-card h2 {
  margin-top: 0;
  font-size: 24px;
  color: #0d3c75;
}

.promo-card p {
  color: #475569;
  line-height: 1.75;
}

.promo-notes {
  background: #f8fafc;
  border-radius: 20px;
  padding: 22px;
}

.promo-notes h3 {
  margin-top: 0;
  color: #0d3c75;
}

.promo-notes ul {
  margin: 0;
  padding-left: 20px;
}

.promo-notes li {
  margin-bottom: 10px;
  color: #475569;
}
</style>
