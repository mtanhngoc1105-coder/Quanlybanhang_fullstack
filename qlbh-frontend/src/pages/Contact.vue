<template>
  <div class="contact-page">
    <div class="contact-hero">
      <div class="hero-card">
        <div class="hero-label">CỬA HÀNG CHÍNH</div>
        <h1>Ngõ 32 Đỗ Đức Dục, Mễ Trì, Hà Nội</h1>
        <p class="hero-text">Địa chỉ showroom chính, mở cửa mỗi ngày từ 09:00 đến 21:00.</p>
        <div class="hero-info-row">
          <div>
            <span>Hotline</span>
            <a href="tel:0363961832">0363 961 832</a>
          </div>
          <div>
            <span>Email</span>
            <a href="mailto:ngocmt363@gmail.com">ngocmt363@gmail.com</a>
          </div>
        </div>
      </div>
      <div class="hero-map">
        <iframe
          title="Map Ngõ 32 Đỗ Đức Dục"
          src="https://maps.google.com/maps?q=Ngõ%2032%20Đỗ%20Đức%20Dục%2C%20Mễ%20Trì%2C%20Hà%20Nội&t=&z=16&ie=UTF8&iwloc=&output=embed"
          frameborder="0"
          allowfullscreen
          loading="lazy"
        ></iframe>
      </div>
    </div>

    <div class="contact-details">
      <div class="detail-card">
        <h2>Thông tin cửa hàng</h2>
        <ul>
          <li><strong>Địa chỉ:</strong> Ngõ 32 Đỗ Đức Dục, Mễ Trì, Hà Nội</li>
          <li><strong>Giờ mở cửa:</strong> 09:00 - 21:00</li>
          <li><strong>Hotline:</strong> <a href="tel:0363961832">0363 961 832</a></li>
          <li><strong>Email:</strong> <a href="mailto:ngocmt363@gmail.com">ngocmt363@gmail.com</a></li>
        </ul>
      </div>
      <div class="detail-card detail-card--note">
        <h2>Về cửa hàng</h2>
        <p>Đây là showroom chính của Shop Của Ngọc, trưng bày mô hình, figure và phụ kiện anime chất lượng cao. Ghé thăm ngay để xem sản phẩm và nhận tư vấn trực tiếp.</p>
      </div>
    </div>
  </div>
</template>

<script setup>
</script>

<style scoped>
.contact-page {
  max-width: 1400px;
  margin: 0 auto;
  padding: 30px 20px;
}

.contact-hero {
  display: grid;
  grid-template-columns: 1.1fr 1.4fr;
  gap: 24px;
  align-items: stretch;
}

.hero-card {
  background: #ffffff;
  border-radius: 24px;
  padding: 36px;
  box-shadow: 0 20px 60px rgba(24, 60, 118, 0.12);
  display: flex;
  flex-direction: column;
  justify-content: center;
}

.hero-label {
  display: inline-block;
  margin-bottom: 18px;
  padding: 10px 18px;
  background: rgba(30, 112, 175, 0.12);
  color: #0f3c70;
  font-weight: 700;
  border-radius: 999px;
  letter-spacing: 0.05em;
  font-size: 12px;
}

.hero-card h1 {
  margin: 0;
  font-size: 40px;
  line-height: 1.05;
  color: #10244c;
}

.hero-text {
  margin: 20px 0 28px;
  color: #475569;
  font-size: 16px;
  max-width: 540px;
}

.hero-info-row {
  display: grid;
  grid-template-columns: repeat(2, minmax(0, 1fr));
  gap: 18px;
}

.hero-info-row div {
  background: #f6faff;
  border-radius: 18px;
  padding: 18px 20px;
}

.hero-info-row span {
  display: block;
  font-size: 12px;
  color: #667085;
  margin-bottom: 8px;
  text-transform: uppercase;
  letter-spacing: 0.08em;
}

.hero-info-row a {
  color: #10244c;
  font-size: 18px;
  font-weight: 700;
  text-decoration: none;
}

.hero-map {
  min-height: 460px;
  border-radius: 24px;
  overflow: hidden;
  box-shadow: 0 20px 60px rgba(24, 60, 118, 0.16);
}

.hero-map iframe {
  width: 100%;
  height: 100%;
  border: 0;
}

.contact-details {
  display: grid;
  grid-template-columns: repeat(2, minmax(0, 1fr));
  gap: 20px;
  margin-top: 32px;
}

.detail-card {
  background: #ffffff;
  border-radius: 24px;
  padding: 28px;
  box-shadow: 0 16px 40px rgba(23, 56, 108, 0.08);
}

.detail-card h2 {
  margin-top: 0;
  color: #10244c;
  font-size: 24px;
}

.detail-card ul {
  list-style: none;
  padding: 0;
  margin: 18px 0 0;
}

.detail-card li {
  margin-bottom: 14px;
  color: #475569;
  font-size: 15px;
}

.detail-card li strong {
  color: #10244c;
}

.detail-card a {
  color: #0f3c70;
  text-decoration: none;
  font-weight: 600;
}

.detail-card--note p {
  margin: 0;
  color: #475569;
  line-height: 1.75;
}

@media (max-width: 1040px) {
  .contact-hero,
  .contact-details {
    grid-template-columns: 1fr;
  }
}

@media (max-width: 720px) {
  .contact-page {
    padding: 24px 16px;
  }

  .hero-card h1 {
    font-size: 32px;
  }
}
</style>
