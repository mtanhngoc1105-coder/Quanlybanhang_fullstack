<template>
  <div class="promotions-page">
    <header class="page-header-banner">
      <div class="banner-content">
        <h1 class="banner-title">Khuyến Mãi Đặc Biệt</h1>
        <p class="banner-subtitle">
          Săn ngay những ưu đãi độc quyền, mã giảm giá giá trị cao dành riêng cho fan cứng Anime và Figures.
        </p>
      </div>
    </header>

    <nav class="promo-tabs-container" role="tablist">
      <div class="tabs-info">
        <p class="filter-label">Đang xem: <strong>{{ getFilterLabel() }}</strong></p>
      </div>
    </nav>

    <main class="promotions-content">
      
      <div v-if="filteredPromos.length > 0" class="promo-grid-layout">
        <div 
          v-for="(promo, index) in filteredPromos" 
          :key="index" 
          :class="['promo-coupon-card', { 'flash-sale-border': promo.tag === 'FLASH' }]"
        >
          <div class="coupon-left-badge">
            <span class="badge-icon">{{ promo.icon }}</span>
            <span class="badge-type-text">{{ promo.badgeText }}</span>
          </div>

          <div class="coupon-divider">
            <span class="notch top-notch"></span>
            <span class="notch bottom-notch"></span>
          </div>

          <div class="coupon-right-details">
            <div class="coupon-header">
              <span :class="['promo-tag', promo.tag.toLowerCase()]">{{ promo.tag }}</span>
              <span v-if="promo.expiry" class="expiry-text">⏳ Hết hạn: {{ promo.expiry }}</span>
            </div>
            
            <h3 class="coupon-title">{{ promo.title }}</h3>
            <p class="coupon-desc">{{ promo.description }}</p>
            
            <div class="coupon-action-row">
              <div class="code-display-box">
                <span class="code-label">MÃ:</span>
                <strong class="code-string">{{ promo.code }}</strong>
              </div>
              <button @click="copyCode(promo.code)" class="btn btn-primary-action">
                Sao chép mã
              </button>
            </div>
          </div>
        </div>
      </div>

      <div v-else class="empty-state">
        <div class="empty-icon">🎫</div>
        <p>Hiện tại chương trình ưu đãi thuộc danh mục này đã kết thúc, vui lòng quay lại sau.</p>
      </div>

      <div class="important-notice-block">
        <h3>⚠️ Lưu ý quan trọng khi áp dụng mã khuyến mãi</h3>
        <ul class="notice-list">
          <li>Mỗi tài khoản khách hàng và mỗi hóa đơn mua sắm chỉ được áp dụng tối đa <strong>01 mã giảm giá</strong>.</li>
          <li>Chương trình khuyến mãi không áp dụng đồng thời cùng lúc với các chiến dịch ưu đãi khác trừ trường hợp có ghi chú đặc biệt từ hệ thống.</li>
          <li>Số lượng quà tặng đi kèm và số lượt sử dụng mã ưu đãi có giới hạn hệ thống, ưu tiên phân phối cho các đơn hàng hoàn tất thanh toán sớm nhất.</li>
          <li>Mọi hành vi gian lận tạo nhiều tài khoản ảo để săn trùng lặp mã có thể dẫn đến việc hủy đơn hàng tự động mà không cần thông báo trước.</li>
        </ul>
      </div>

    </main>
  </div>
</template>

<script setup>
import { ref, computed, onMounted, watch } from 'vue'
import { useRoute } from 'vue-router'

const route = useRoute()
const activeFilter = ref('all')

const promoTabs = [
  { id: 'all', label: 'TẤT CẢ ƯU ĐÃI' },
  { id: 'flash', label: 'FLASH SALE' },
  { id: 'gift', label: 'TẶNG QUÀ' },
  { id: 'combo', label: 'MUA THEO COMBO' }
]

const promotionsList = [
  {
    icon: '⚡',
    badgeText: 'GIẢM 50%',
    tag: 'FLASH',
    title: 'SIÊU FLASH SALE ĐỒNG GIÁ',
    description: 'Giảm giá cực sâu lên đến 50% cho danh mục các sản phẩm mô hình Anime/Manga Scale Figure trong thời gian có hạn.',
    code: 'ANIME50K',
    expiry: 'Hôm nay',
    category: 'flash'
  },
  {
    icon: '🎁',
    badgeText: 'FREE GIFT',
    tag: 'GIFT',
    title: 'ƯU ĐÃI QUÀ TẶNG FAN CỨNG',
    description: 'Nhận ngay một Set Standee Acrylic hoặc móc khóa giới hạn ngẫu nhiên khi hoàn tất đơn hàng có giá trị từ 499.000đ trở lên.',
    code: 'NEIGIFT',
    expiry: '31/05/2026',
    category: 'gift'
  },
  {
    icon: '🔥',
    badgeText: 'BUY 2 GET 1',
    tag: 'COMBO',
    title: 'MUA 2 NENDOROID TẶNG 1 PHỤ KIỆN',
    description: 'Chương trình tri ân đặc biệt dành cho dòng Chibi Figure. Tặng kèm 01 hộp Box bảo vệ chống bụi cao cấp khi đặt mua combo 2 mô hình bất kỳ.',
    code: 'COMBO3',
    expiry: '15/06/2026',
    category: 'combo'
  }
]

// Khởi tạo filter từ query parameter
onMounted(() => {
  const filterParam = route.query.filter
  if (filterParam && promoTabs.some(tab => tab.id === filterParam)) {
    activeFilter.value = filterParam
  }
})

// Cập nhật khi query parameter thay đổi
watch(() => route.query.filter, (newFilter) => {
  if (newFilter && promoTabs.some(tab => tab.id === newFilter)) {
    activeFilter.value = newFilter
  }
})

const filteredPromos = computed(() => {
  if (activeFilter.value === 'all') return promotionsList
  return promotionsList.filter(promo => promo.category === activeFilter.value)
})

const getFilterLabel = () => {
  const tab = promoTabs.find(t => t.id === activeFilter.value)
  return tab ? tab.label : 'TẤT CẢ ƯU ĐÃI'
}

const copyCode = (codeText) => {
  if (navigator.clipboard) {
    navigator.clipboard.writeText(codeText)
      .then(() => {
        alert(`🎉 Đã sao chép thành công mã: ${codeText}. Hãy dán vào ô giảm giá khi thanh toán!`)
      })
      .catch(() => {
        alert('Có lỗi xảy ra khi sao chép, vui lòng gõ tay mã này.')
      })
  } else {
    alert(`Mã giảm giá của bạn là: ${codeText}`)
  }
}
</script>

<style scoped>
.promotions-page {
  max-width: 1240px;
  margin: 0 auto;
  padding: 40px 24px;
  font-family: 'Inter', system-ui, -apple-system, sans-serif;
  color: #334155;
  line-height: 1.6;
}

/* ==========================================================================
   HEADER BANNER (Đồng bộ dải màu Gradient tím - xanh dương)
   ========================================================================== */
.page-header-banner {
  background: linear-gradient(135deg, #4f46e5 0%, #7c3aed 50%, #9333ea 100%);
  border-radius: 24px;
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
   NAVIGATION TABSPILL (Đồng bộ dải viên thuốc bo tròn mềm mại)
   ========================================================================== */
.promo-tabs-container {
  display: flex;
  justify-content: center;
  margin-bottom: 40px;
}

.tabs-info {
  text-align: center;
  padding: 16px 24px;
  background: linear-gradient(135deg, #6366f1 0%, #7c3aed 100%);
  border-radius: 12px;
  box-shadow: 0 4px 14px rgba(99, 102, 241, 0.3);
}

.filter-label {
  color: #ffffff;
  font-size: 16px;
  font-weight: 600;
  margin: 0;
  letter-spacing: 0.3px;
}

.filter-label strong {
  font-weight: 700;
  text-transform: uppercase;
}

/* ==========================================================================
   PROMOTIONS CONTENT: Thiết kế mô hình Coupon/Voucher sáng tạo
   ========================================================================== */
.promo-grid-layout {
  display: flex;
  flex-direction: column;
  gap: 24px;
  margin-bottom: 40px;
  animation: fadeIn 0.4s cubic-bezier(0.16, 1, 0.3, 1);
}
@keyframes fadeIn {
  from { opacity: 0; transform: translateY(10px); }
  to { opacity: 1; transform: translateY(0); }
}

.promo-coupon-card {
  display: flex;
  background: #ffffff;
  border: 1px solid #e2e8f0;
  border-radius: 16px;
  overflow: hidden;
  box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.02), 0 10px 15px -3px rgba(0, 0, 0, 0.04);
  transition: transform 0.25s, box-shadow 0.25s;
}
.promo-coupon-card:hover {
  transform: translateY(-2px);
  box-shadow: 0 12px 20px -8px rgba(15, 23, 42, 0.08);
}

/* Highlight riêng cho thẻ Flash Sale bằng viền trái đặc trưng */
.flash-sale-border {
  border-left: 4px solid #ef4444;
}

/* Khối nhãn thông số bên trái voucher */
.coupon-left-badge {
  background: #f8fafc;
  min-width: 180px;
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: center;
  padding: 24px;
  flex-shrink: 0;
}
.badge-icon {
  font-size: 36px;
  margin-bottom: 8px;
}
.badge-type-text {
  font-size: 16px;
  font-weight: 800;
  color: #0f172a;
  text-align: center;
  letter-spacing: -0.2px;
}

/* Đường phân cách voucher đục lỗ răng cưa phong cách cổ điển */
.coupon-divider {
  width: 1px;
  border-left: 2px dashed #cbd5e1;
  position: relative;
  background: #ffffff;
}
.notch {
  position: absolute;
  width: 16px;
  height: 16px;
  background: #f1f5f9; /* Đồng bộ theo màu nền của trang chứa */
  border: 1px solid #e2e8f0;
  border-radius: 50%;
  left: -9px;
}
.top-notch { top: -9px; }
.bottom-notch { bottom: -9px; }

/* Chi tiết nội dung coupon bên phải */
.coupon-right-details {
  flex: 1;
  padding: 28px 32px;
  display: flex;
  flex-direction: column;
  justify-content: space-between;
}

.coupon-header {
  display: flex;
  justify-content: space-between;
  align-items: center;
  margin-bottom: 12px;
}
.promo-tag {
  font-size: 11px;
  font-weight: 700;
  padding: 3px 10px;
  border-radius: 4px;
  letter-spacing: 0.5px;
}
.promo-tag.flash { background: #fee2e2; color: #ef4444; }
.promo-tag.gift { background: #e0f2fe; color: #0284c7; }
.promo-tag.combo { background: #dcfce7; color: #16a34a; }

.expiry-text {
  font-size: 13px;
  color: #64748b;
  font-weight: 500;
}

.coupon-title {
  font-size: 20px;
  font-weight: 700;
  color: #0f172a;
  margin: 0 0 8px 0;
}
.coupon-desc {
  font-size: 14px;
  color: #475569;
  margin: 0 0 20px 0;
  line-height: 1.6;
}

/* Khối hiển thị code và nút copy */
.coupon-action-row {
  display: flex;
  align-items: center;
  gap: 16px;
  padding-top: 16px;
  border-top: 1px dashed #f1f5f9;
}

.code-display-box {
  background: #f1f5f9;
  border: 1px dashed #cbd5e1;
  padding: 8px 16px;
  border-radius: 8px;
  display: inline-flex;
  align-items: center;
  gap: 8px;
}
.code-label {
  font-size: 12px;
  color: #64748b;
  font-weight: 600;
}
.code-string {
  font-size: 15px;
  color: #0f172a;
  font-family: 'Courier New', Courier, monospace;
  letter-spacing: 1px;
}

.btn-primary-action {
  background: #7c3aed;
  color: #ffffff;
  border: none;
  font-weight: 600;
  font-size: 13.5px;
  padding: 9px 20px;
  border-radius: 8px;
  cursor: pointer;
  transition: background 0.2s;
}
.btn-primary-action:hover {
  background: #6d28d9;
}

/* Khối Cảnh báo/Lưu ý điều khoản */
.important-notice-block {
  background: #fffbeb;
  border: 1px solid #fde68a;
  border-left: 5px solid #f59e0b;
  padding: 28px;
  border-radius: 12px;
  margin-top: 40px;
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

.empty-state {
  text-align: center;
  padding: 60px 20px;
  color: #94a3b8;
  border: 2px dashed #e2e8f0;
  border-radius: 16px;
  background: #f8fafc;
}
.empty-icon { font-size: 40px; margin-bottom: 12px; }

/* ==========================================================================
   RESPONSIVE LAYOUT DETAILS (Tối ưu giao diện mobile linh hoạt)
   ========================================================================== */
@media (max-width: 768px) {
  .page-header-banner {
    padding: 40px 20px;
    border-radius: 16px;
  }
  .banner-title { font-size: 28px; }
  .banner-subtitle { font-size: 14px; }
  
  .tabs-info {
    padding: 12px 16px;
  }
  .filter-label {
    font-size: 14px;
  }

  .promo-coupon-card {
    flex-direction: column;
  }
  .coupon-left-badge {
    min-width: 100%;
    flex-direction: row;
    justify-content: flex-start;
    gap: 12px;
    padding: 16px 24px;
    border-bottom: 1px dashed #cbd5e1;
  }
  .badge-icon { font-size: 24px; margin-bottom: 0; }
  
  .coupon-divider { display: none; } /* Ẩn răng cưa dọc khi chuyển sang cấu trúc dọc mobile */
  
  .coupon-right-details {
    padding: 24px;
  }
  .coupon-title { font-size: 18px; }
  .coupon-action-row {
    flex-direction: column;
    align-items: flex-start;
    gap: 12px;
  }
  .code-display-box { width: 100%; justify-content: center; box-sizing: border-box; }
  .btn-primary-action { width: 100%; text-align: center; }
}
</style>