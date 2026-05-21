<template>
  <div class="guide-page">
    <header class="page-header-banner">
      <div class="banner-content">
        <h1 class="banner-title">{{ getSectionTitle() }}</h1>
        <p class="banner-subtitle">{{ getSectionDescription() }}</p>
      </div>
    </header>

    <nav class="guide-tabs-container" role="tablist">
      <div class="tabs-pill-wrapper">
        <button 
          v-for="tab in guideTabs" 
          :key="tab.id"
          :class="['tab-pill-btn', { active: activeSection === tab.id }]"
          @click="activeSection = tab.id"
          role="tab"
          :aria-selected="activeSection === tab.id"
        >
          <span class="tab-label">{{ tab.label }}</span>
        </button>
      </div>
    </nav>

    <main class="guide-content">
      
      <div v-if="activeSection === 'how-to-buy'" class="section-pane">
        <div class="guide-section text-article-card">
          <div class="guide-steps">
            <div class="step-card">
              <div class="step-number-badge">1</div>
              <div class="step-content">
                <h3>🔍 Chọn sản phẩm</h3>
                <p>Duyệt qua các danh mục sản phẩm của AnimeNei, sử dụng bộ lọc tìm kiếm để lựa chọn mẫu mô hình Anime/Manga chính hãng mà bạn yêu thích.</p>
              </div>
            </div>
            
            <div class="step-card">
              <div class="step-number-badge">2</div>
              <div class="step-content">
                <h3>🛒 Thêm vào giỏ hàng</h3>
                <p>Kiểm tra kỹ thông tin phiên bản (bản thường/bản giới hạn), click vào nút <strong>"Thêm vào giỏ"</strong> hoặc <strong>"Mua ngay"</strong> để chuyển tới trang hoàn tất đơn hàng.</p>
              </div>
            </div>
            
            <div class="step-card">
              <div class="step-number-badge">3</div>
              <div class="step-content">
                <h3>📝 Điền thông tin giao hàng</h3>
                <p>Cung cấp chính xác họ tên, số điện thoại chính chủ và địa chỉ nhận hàng chi tiết để hệ thống tính toán chính xác lộ trình và thời gian vận chuyển.</p>
              </div>
            </div>
            
            <div class="step-card">
              <div class="step-number-badge">4</div>
              <div class="step-content">
                <h3>💳 Thanh toán & Hoàn tất</h3>
                <p>Lựa chọn phương thức thanh toán phù hợp nhất. Hệ thống gửi mã vận đơn qua Email/SMS ngay sau khi điều phối viên xác nhận đóng gói thành công.</p>
              </div>
            </div>
          </div>
        </div>
      </div>

      <div v-if="activeSection === 'payment'" class="section-pane">
        <div class="guide-section text-article-card">
          <h2 class="section-inner-title">🛡️ Phương Thức Thanh Toán An Toàn</h2>
          <div class="payment-methods-grid">
            <div class="payment-method-item">
              <div class="payment-icon-wrapper">💳</div>
              <h3>Thẻ Tín Dụng / Debit</h3>
              <p>Hỗ trợ Visa, Mastercard, JCB hoặc thẻ nội địa ATM thông qua cổng kết nối an toàn bảo mật cao.</p>
              <span class="info-badge font-italic">Bảo mật mã hóa đầu cuối</span>
            </div>
            
            <div class="payment-method-item">
              <div class="payment-icon-wrapper">🏦</div>
              <h3>Chuyển Khoản Ngân Hàng</h3>
              <p>Chuyển khoản qua mã QR hiển thị tại trang hoàn tất đơn hàng. Xác thực giao dịch tự động trong 30 giây.</p>
              <span class="info-badge font-italic">Xử lý tự động 24/7</span>
            </div>
            
            <div class="payment-method-item">
              <div class="payment-icon-wrapper">💵</div>
              <h3>Tiền Mặt Khi Nhận Hàng (COD)</h3>
              <p>Nhận kiện hàng mô hình tại nhà, kiểm tra tình trạng hộp bên ngoài và thanh toán trực tiếp cho shipper.</p>
              <span class="info-badge font-italic">An tâm 100% khi mua sắm</span>
            </div>
            
            <div class="payment-method-item">
              <div class="payment-icon-wrapper">📱</div>
              <h3>Ví Điện Tử Liên Kết</h3>
              <p>Thanh toán siêu tốc, nhận thêm nhiều voucher giảm giá độc quyền thông qua ví điện tử MoMo, ZaloPay, ShopeePay.</p>
              <span class="info-badge font-italic">Tiện lợi, nhiều ưu đãi</span>
            </div>
          </div>
        </div>
      </div>

      <div v-if="activeSection === 'shipping'" class="section-pane">
        <div class="guide-section text-article-card">
          <h2 class="section-inner-title">📦 Lộ Trình & Quy Chuẩn Đóng Gói</h2>
          <div class="shipping-info-grid">
            <div class="shipping-info-item">
              <h3>📍 Nội thành Hà Nội</h3>
              <p class="shipping-meta"><strong>Phí giao hàng:</strong> Miễn phí cho mọi đơn hàng từ 299.000đ</p>
              <p class="shipping-meta"><strong>Thời gian:</strong> 1-2 ngày làm việc (Hỗ trợ ship hỏa tốc)</p>
              <p class="info-desc text-muted">Nhân viên trực tiếp giao tận tay, đảm bảo hộp mô hình nguyên vẹn không móp méo.</p>
            </div>
            
            <div class="shipping-info-item">
              <h3>✈️ Các Tỉnh Thành Khác</h3>
              <p class="shipping-meta"><strong>Phí giao hàng:</strong> 30.000đ - 60.000đ tùy khoảng cách</p>
              <p class="shipping-meta"><strong>Thời gian:</strong> 2-5 ngày làm việc</p>
              <p class="info-desc text-muted">Đồng hành cùng các đối tác vận chuyển chuyên nghiệp: GHTK, Viettel Post, VNPost.</p>
            </div>
            
            <div class="shipping-info-item full-width-item">
              <h3>📦 Quy chuẩn chống sốc & Bảo hiểm mô hình</h3>
              <p class="shipping-meta"><strong>Đóng gói:</strong> 100% bọc màng khí chống sốc xốp bong bóng dày 3 lớp, cố định trong thùng carton cứng.</p>
              <p class="shipping-meta"><strong>Bảo hiểm:</strong> Đơn hàng được đóng bảo hiểm hàng hóa có giá trị. Đổi mới lập tức nếu xước xát, lỗi do vận chuyển.</p>
            </div>
          </div>

          <div class="important-notice-block">
            <h3>⚠️ Lưu ý quan trọng khi nhận sản phẩm</h3>
            <ul class="notice-list">
              <li>Vui lòng quay lại Video Unboxing mở hộp khi nhận hàng để làm căn cứ xử lý khiếu nại nhanh chóng nhất nếu xảy ra sự cố.</li>
              <li>Mọi yêu cầu đổi trả/hoàn tiền do lỗi bên ngoài cần được phản hồi lại tổng đài CSKH trong vòng 24 giờ kể từ khi ký nhận hàng thành công.</li>
              <li>Thời gian nhận hàng thực tế có thể dao động nhẹ tùy thuộc vào tình hình thời tiết đỉnh điểm hoặc các dịp lễ lớn của đơn vị vận chuyển.</li>
            </ul>
          </div>
        </div>
      </div>

    </main>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import { useRoute } from 'vue-router'

const route = useRoute()
const activeSection = ref('how-to-buy')

const guideTabs = [
  { id: 'how-to-buy', label: 'CÁCH MUA' },
  { id: 'payment', label: 'THANH TOÁN' },
  { id: 'shipping', label: 'GIAO HÀNG' }
]

onMounted(() => {
  const section = route?.query?.section || 'how-to-buy'
  activeSection.value = section
})

const getSectionTitle = () => {
  const titles = {
    'how-to-buy': 'Hướng Dẫn Mua Hàng',
    'payment': 'Hệ Thống Thanh Toán',
    'shipping': 'Quy Trình Giao Nhận Hàng'
  }
  return titles[activeSection.value] || 'Trung Tâm Hướng Dẫn'
}

const getSectionDescription = () => {
  const descriptions = {
    'how-to-buy': 'Chi tiết quy trình đặt hàng mô hình Anime/Manga chính hãng an tâm tại cửa hàng.',
    'payment': 'Hỗ trợ đa dạng giải pháp giao dịch thông minh tích hợp công nghệ bảo mật dữ liệu an toàn.',
    'shipping': 'Thông tin chi tiết về chính sách vận chuyển toàn quốc và tiêu chuẩn bảo vệ hộp sản phẩm.'
  }
  return descriptions[activeSection.value] || ''
}
</script>

<style scoped>
.guide-page {
  max-width: 1240px;
  margin: 0 auto;
  padding: 40px 24px;
  font-family: 'Inter', system-ui, -apple-system, sans-serif;
  color: #334155;
  line-height: 1.6;
}

/* ==========================================================================
   HEADER BANNER (Màu gradient tím - xanh theo ảnh thiết kế)
   ========================================================================== */
.page-header-banner {
  background: linear-gradient(135deg, #4f46e5 0%, #7c3aed 50%, #9333ea 100%);
  border-radius: 24px; /* Bo góc lớn mềm mại */
  padding: 64px 40px;
  text-align: center;
  margin-bottom: 40px;
  box-shadow: 0 10px 30px -5px rgba(124, 58, 237, 0.2);
}

.banner-content {
  max-width: 850px;
  margin: 0 auto;
}

.banner-title {
  color: #ffffff;
  font-size: 40px;
  font-weight: 800;
  margin: 0 0 16px 0;
  letter-spacing: -0.5px;
  text-shadow: 0 2px 4px rgba(0, 0, 0, 0.15);
}

.banner-subtitle {
  color: rgba(255, 255, 255, 0.9);
  font-size: 16px;
  font-weight: 400;
  margin: 0;
  line-height: 1.6;
}

/* ==========================================================================
   NAVIGATION TABS (Hệ thanh điều hướng dạng viên thuốc giống ảnh)
   ========================================================================== */
.guide-tabs-container {
  display: flex;
  justify-content: center;
  margin-bottom: 40px;
}

.tabs-pill-wrapper {
  display: flex;
  background: #ffffff;
  padding: 6px;
  border-radius: 16px;
  box-shadow: 0 4px 20px rgba(15, 23, 42, 0.04);
  border: 1px solid #f1f5f9;
}

.tab-pill-btn {
  padding: 12px 32px;
  background: transparent;
  border: none;
  color: #475569;
  font-weight: 600;
  font-size: 14px;
  text-transform: uppercase; /* Chữ in hoa dạng nhãn điều hướng */
  letter-spacing: 0.5px;
  cursor: pointer;
  border-radius: 12px;
  transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
}

.tab-pill-btn:hover {
  color: #7c3aed;
}

/* Trạng thái Tab Active: Nền gradient tím xanh nổi bật */
.tab-pill-btn.active {
  background: linear-gradient(135deg, #6366f1 0%, #7c3aed 100%);
  color: #ffffff;
  font-weight: 700;
  box-shadow: 0 4px 14px rgba(99, 102, 241, 0.3);
}

/* ==========================================================================
   MAIN CONTENT COMPONENT UPGRADES
   ========================================================================== */
.section-pane {
  animation: fadeIn 0.4s cubic-bezier(0.16, 1, 0.3, 1);
}
@keyframes fadeIn {
  from { opacity: 0; transform: translateY(10px); }
  to { opacity: 1; transform: translateY(0); }
}

/* Container bọc bài viết cao cấp */
.text-article-card {
  background: #ffffff;
  border: 1px solid #e2e8f0;
  border-radius: 16px;
  padding: 40px;
  box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.03), 0 10px 15px -3px rgba(0, 0, 0, 0.05);
}

.section-inner-title {
  font-size: 24px;
  color: #0f172a;
  font-weight: 700;
  margin-top: 0;
  margin-bottom: 28px;
}

/* --- 1. CÁCH MUA: Nâng cấp danh sách bước tiến trình (Step list) --- */
.guide-steps {
  display: flex;
  flex-direction: column;
  gap: 24px;
}

.step-card {
  display: flex;
  align-items: flex-start;
  gap: 20px;
  padding: 24px;
  background: #f8fafc;
  border: 1px solid #f1f5f9;
  border-radius: 12px;
  transition: all 0.25s ease;
}
.step-card:hover {
  border-color: #cbd5e1;
  background: #ffffff;
  transform: translateX(4px);
  box-shadow: 0 4px 12px rgba(15, 23, 42, 0.03);
}

.step-number-badge {
  width: 36px;
  height: 36px;
  background: linear-gradient(135deg, #6366f1 0%, #7c3aed 100%);
  color: #ffffff;
  border-radius: 50%;
  display: flex;
  align-items: center;
  justify-content: center;
  font-weight: 700;
  font-size: 15px;
  flex-shrink: 0;
  box-shadow: 0 4px 10px rgba(124, 58, 237, 0.2);
}

.step-content h3 {
  margin: 0 0 8px 0;
  font-size: 18px;
  color: #0f172a;
  font-weight: 700;
}

.step-content p {
  margin: 0;
  font-size: 14.5px;
  color: #475569;
  line-height: 1.6;
}

/* --- 2. THANH TOÁN: Nâng cấp lưới hiển thị (Grid list) --- */
.payment-methods-grid {
  display: grid;
  grid-template-columns: repeat(auto-fill, minmax(260px, 1fr));
  gap: 24px;
}

.payment-method-item {
  text-align: center;
  padding: 32px 24px;
  background: #f8fafc;
  border: 1px solid #e2e8f0;
  border-radius: 14px;
  transition: all 0.3s ease;
  display: flex;
  flex-direction: column;
  align-items: center;
}
.payment-method-item:hover {
  background: #ffffff;
  border-color: #7c3aed;
  box-shadow: 0 10px 20px -5px rgba(124, 58, 237, 0.08);
  transform: translateY(-4px);
}

.payment-icon-wrapper {
  font-size: 36px;
  background: #ffffff;
  width: 72px;
  height: 72px;
  border-radius: 50%;
  display: flex;
  align-items: center;
  justify-content: center;
  margin-bottom: 16px;
  box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
  border: 1px solid #f1f5f9;
}

.payment-method-item h3 {
  font-size: 16px;
  font-weight: 700;
  color: #0f172a;
  margin: 0 0 10px 0;
}

.payment-method-item p {
  font-size: 13.5px;
  color: #64748b;
  margin: 0 0 16px 0;
  line-height: 1.5;
  flex-grow: 1;
}

.info-badge {
  font-size: 12px;
  color: #7c3aed;
  background: #f5f3ff;
  padding: 4px 12px;
  border-radius: 100px;
  font-weight: 500;
}

/* --- 3. GIAO HÀNG: Khối vận chuyển & Note cảnh báo --- */
.shipping-info-grid {
  display: grid;
  grid-template-columns: repeat(2, 1fr);
  gap: 24px;
  margin-bottom: 32px;
}

.shipping-info-item {
  padding: 24px;
  background: #f8fafc;
  border: 1px solid #e2e8f0;
  border-radius: 12px;
  transition: all 0.2s;
}
.shipping-info-item:hover {
  background: #ffffff;
  border-color: #cbd5e1;
}

.shipping-info-item h3 {
  font-size: 18px;
  color: #0f172a;
  margin: 0 0 14px 0;
  font-weight: 700;
}

.shipping-meta {
  font-size: 14px;
  color: #334155;
  margin: 0 0 8px 0;
}
.shipping-meta strong {
  color: #0f172a;
}

.info-desc {
  font-size: 13.5px;
  color: #64748b;
  margin: 12px 0 0 0;
  padding-top: 12px;
  border-top: 1px solid #e2e8f0;
}

.full-width-item {
  grid-column: 1 / -1;
  background: #f0fdf4;
  border-color: #bbf7d0;
}
.full-width-item h3 {
  color: #16a34a;
}

/* Khối Cảnh báo/Lưu ý nâng cấp trực quan */
.important-notice-block {
  background: #fffbeb;
  border: 1px solid #fde68a;
  border-left: 5px solid #f59e0b;
  padding: 28px;
  border-radius: 12px;
  margin-top: 32px;
}

.important-notice-block h3 {
  color: #b45309;
  margin: 0 0 14px 0;
  font-size: 16px;
  font-weight: 700;
}

.notice-list {
  margin: 0;
  padding-left: 20px;
}

.notice-list li {
  color: #78350f;
  font-size: 14px;
  margin-bottom: 10px;
  line-height: 1.6;
}
.notice-list li:last-child {
  margin-bottom: 0;
}

/* ==========================================================================
   RESPONSIVE LAYOUTS (Tối ưu thiết bị di động mượt mà)
   ========================================================================== */
@media (max-width: 768px) {
  .page-header-banner {
    padding: 40px 20px;
    border-radius: 16px;
  }
  .banner-title { font-size: 28px; }
  .banner-subtitle { font-size: 14px; }
  
  .guide-tabs-container {
    padding: 0 4px;
    overflow-x: auto;
    justify-content: flex-start;
  }
  .tabs-pill-wrapper {
    width: 100%;
    overflow-x: auto;
    white-space: nowrap;
  }
  .tab-pill-btn {
    padding: 10px 22px;
    font-size: 13px;
  }

  .text-article-card {
    padding: 24px;
  }
  
  .shipping-info-grid {
    grid-template-columns: 1fr;
    gap: 16px;
  }
  
  .step-card {
    flex-direction: column;
    gap: 12px;
  }
}
</style>