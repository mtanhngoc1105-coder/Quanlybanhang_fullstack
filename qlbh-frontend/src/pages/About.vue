<template>
  <div class="about-page">

    <!-- HERO -->
    <div class="hero">
      <div class="hero-overlay">
        <h1>Anime Figure Store</h1>
        <p>Thiên đường mô hình anime chính hãng dành cho fan tại Việt Nam</p>
      </div>
    </div>

    <div class="container">

      <!-- STORY -->
      <section class="section">
        <h2>Câu chuyện của chúng tôi</h2>
        <p>
          Shop Của Ngọc ra đời từ niềm đam mê anime và mong muốn mang những mô hình
          chất lượng cao từ Nhật Bản đến cộng đồng fan Việt Nam.
        </p>
        <p>
          Ban đầu chỉ là một cửa hàng nhỏ bán figure cho bạn bè và người quen,
          nhưng nhờ sự tin tưởng của khách hàng, shop đã phát triển thành một
          hệ thống bán hàng online phục vụ trên toàn quốc.
        </p>
      </section>

      <!-- MISSION + VISION -->
      <div class="grid-2">
        <section class="card">
          <h3>Sứ mệnh</h3>
          <p>
            Mang đến mô hình anime chính hãng với giá hợp lý,
            giúp fan anime dễ dàng tiếp cận và sở hữu sản phẩm yêu thích.
          </p>
        </section>

        <section class="card">
          <h3>Tầm nhìn</h3>
          <p>
            Trở thành cửa hàng mô hình anime uy tín hàng đầu tại Việt Nam
            về chất lượng sản phẩm và dịch vụ khách hàng.
          </p>
        </section>
      </div>

      <!-- WHY CHOOSE US -->
      <section class="section">
        <h2>Tại sao nên chọn chúng tôi?</h2>

        <div class="grid-3">
          <div class="feature">
            <h4>100% Chính Hãng</h4>
            <p>Sản phẩm nhập trực tiếp từ Nhật Bản, có hộp và tem đầy đủ.</p>
          </div>

          <div class="feature">
            <h4>Đóng gói cẩn thận</h4>
            <p>Chống sốc nhiều lớp đảm bảo sản phẩm nguyên vẹn khi nhận.</p>
          </div>

          <div class="feature">
            <h4>Giao hàng toàn quốc</h4>
            <p>Ship nhanh từ 1–3 ngày trên toàn Việt Nam.</p>
          </div>

          <div class="feature">
            <h4>Đổi trả dễ dàng</h4>
            <p>1 đổi 1 nếu lỗi từ nhà sản xuất trong 7 ngày.</p>
          </div>

          <div class="feature">
            <h4>Tư vấn tận tâm</h4>
            <p>Đội ngũ hiểu anime, hỗ trợ chọn figure phù hợp.</p>
          </div>

          <div class="feature">
            <h4>Cập nhật liên tục</h4>
            <p>Luôn có các mẫu figure mới hot nhất.</p>
          </div>
        </div>
      </section>

      <!-- PROCESS -->
      <section class="section">
        <h2>Quy trình mua hàng</h2>
        <div class="timeline">
          <div class="step">1️⃣ Chọn sản phẩm yêu thích</div>
          <div class="step">2️⃣ Đặt hàng trên website</div>
          <div class="step">3️⃣ Shop xác nhận đơn</div>
          <div class="step">4️⃣ Đóng gói & giao hàng</div>
          <div class="step">5️⃣ Nhận hàng & tận hưởng</div>
        </div>
      </section>

      <!-- CONTACT -->
      <section class="contact">
        <h2>Liên hệ với chúng tôi</h2>
        <p>Hotline: <strong>0363 961 832</strong></p>
        <p>Email: <strong>ngocmt363@gmail.com</strong></p>
        <p>Thời gian hỗ trợ: 8:00 – 22:00 mỗi ngày</p>
      </section>

    </div>
  </div>
</template>

<script setup>
</script>

<style scoped>
.hero{
  height:300px;
  background:url("https://images.unsplash.com/photo-1608889175123-8ee362201f81") center/cover;
  border-radius:0 0 30px 30px;
  margin-bottom:40px;
}
.hero-overlay{
  background:rgba(0,0,0,0.55);
  height:100%;
  display:flex;
  flex-direction:column;
  justify-content:center;
  align-items:center;
  color:#fff;
  text-align:center;
}

.container{max-width:1100px;margin:auto;padding:0 20px}
.section{margin-bottom:40px}

.grid-2{display:grid;grid-template-columns:1fr 1fr;gap:20px;margin-bottom:40px}
.grid-3{display:grid;grid-template-columns:repeat(3,1fr);gap:20px}

.card{background:#fff;padding:24px;border-radius:18px;box-shadow:0 10px 30px rgba(0,0,0,0.08)}
.feature{background:#fff;padding:18px;border-radius:16px;box-shadow:0 6px 18px rgba(0,0,0,0.06)}

.timeline{display:flex;flex-direction:column;gap:12px}
.step{background:#eef2ff;padding:14px;border-radius:12px}

.contact{
  background:#1e3a8a;
  color:#fff;
  padding:30px;
  border-radius:20px;
  text-align:center;
}
</style>