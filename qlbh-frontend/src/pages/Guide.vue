<template>
  <div class="guide-page">
    <div class="page-header">
      <h1>{{ getSectionTitle() }}</h1>
      <p>{{ getSectionDescription() }}</p>
    </div>

    <!-- Navigation Tabs -->
    <div class="guide-tabs">
      <button 
        v-for="tab in guideTabs" 
        :key="tab.id"
        :class="['tab', { active: activeSection === tab.id }]"
        @click="activeSection = tab.id"
      >
        {{ tab.label }}
      </button>
    </div>

    <div class="guide-content">
      <!-- CÁCH MUA Section -->
      <div v-if="activeSection === 'how-to-buy'" class="section">
        <div class="guide-section">
          <div class="guide-steps">
            <div class="step">
              <div class="step-number">1</div>
              <div class="step-content">
                <h3>Chọn sản phẩm</h3>
                <p>Duyệt qua các danh mục sản phẩm và chọn sản phẩm bạn yêu thích.</p>
              </div>
            </div>
            <div class="step">
              <div class="step-number">2</div>
              <div class="step-content">
                <h3>Thêm vào giỏ hàng</h3>
                <p>Click vào nút "Thêm vào giỏ" để thêm sản phẩm vào giỏ hàng của bạn.</p>
              </div>
            </div>
            <div class="step">
              <div class="step-number">3</div>
              <div class="step-content">
                <h3>Điền thông tin</h3>
                <p>Điền thông tin giao hàng và địa chỉ nhận hàng.</p>
              </div>
            </div>
            <div class="step">
              <div class="step-number">4</div>
              <div class="step-content">
                <h3>Thanh toán</h3>
                <p>Chọn phương thức thanh toán và hoàn tất đơn hàng.</p>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- THANH TOÁN Section -->
      <div v-if="activeSection === 'payment'" class="section">
        <div class="guide-section">
          <h2>Phương Thức Thanh Toán</h2>
          <div class="payment-methods">
            <div class="payment-method">
              <span class="payment-icon"></span>
              <h3>Thẻ tín dụng / Debit</h3>
              <p>Thanh toán bằng Visa, Mastercard hoặc thẻ nội địa.</p>
              <p class="info">Nhanh chóng, an toàn và bảo mật với công nghệ mã hóa.</p>
            </div>
            <div class="payment-method">
              <span class="payment-icon"></span>
              <h3>Chuyển khoản ngân hàng</h3>
              <p>Thanh toán trực tiếp qua tài khoản ngân hàng.</p>
              <p class="info">Miễn phí, không mất thời gian.</p>
            </div>
            <div class="payment-method">
              <span class="payment-icon"></span>
              <h3>Tiền mặt khi nhận hàng</h3>
              <p>Thanh toán khi bạn nhận được hàng (COD).</p>
              <p class="info">Không rủi ro, chỉ thanh toán khi chắc chắn hàng.</p>
            </div>
            <div class="payment-method">
              <span class="payment-icon"></span>
              <h3>Ví điện tử</h3>
              <p>Thanh toán qua Momo, Zalo Pay, Grab Pay.</p>
              <p class="info">Tiện lợi và nhanh chóng.</p>
            </div>
          </div>
        </div>
      </div>

      <!-- GIAO HÀNG Section -->
      <div v-if="activeSection === 'shipping'" class="section">
        <div class="guide-section">
          <h2>Thông Tin Giao Hàng</h2>
          <div class="shipping-info">
            <div class="shipping-item">
              <h3> Giao hàng nội thành Hà Nội</h3>
              <p><strong>Phí giao hàng:</strong> Miễn phí cho đơn hàng từ 299.000đ</p>
              <p><strong>Thời gian:</strong> 1-2 ngày làm việc</p>
              <p class="info">Giao tận tay, nhanh chóng và an toàn.</p>
            </div>
            <div class="shipping-item">
              <h3> Giao hàng ngoại thành / tỉnh khác</h3>
              <p><strong>Phí giao hàng:</strong> 30.000đ - 60.000đ tùy vào khoảng cách</p>
              <p><strong>Thời gian:</strong> 2-5 ngày làm việc</p>
              <p class="info">Hợp tác với các đơn vị vận chuyển uy tín.</p>
            </div>
            <div class="shipping-item">
              <h3>Đóng gói & Bảo vệ sản phẩm</h3>
              <p><strong>Đóng gói:</strong> Cẩn thận với vật liệu chất lượng cao</p>
              <p><strong>Bảo hiểm:</strong> Hỗ trợ tuyên bố giá trị nếu hàng bị hư</p>
              <p class="info">Sản phẩm được bảo vệ tối đa trong quá trình vận chuyển.</p>
            </div>
          </div>

          <div class="important-note">
            <h3> Lưu ý quan trọng</h3>
            <ul>
              <li>Vui lòng kiểm tra hàng khi nhận, nếu có vấn đề hãy liên hệ ngay</li>
              <li>Chúng tôi không chịu trách nhiệm nếu bạn từ chối hàng quá 24h sau khi nhận</li>
              <li>Các đơn hàng có thể bị trì hoãn do thời tiết xấu hoặc sự cố bất ngờ</li>
            </ul>
          </div>
        </div>
      </div>
    </div>
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
  const section = route.query.section || 'how-to-buy'
  activeSection.value = section
})

const getSectionTitle = () => {
  const titles = {
    'how-to-buy': 'Cách Mua Hàng',
    'payment': 'Phương Thức Thanh Toán',
    'shipping': 'Thông Tin Giao Hàng'
  }
  return titles[activeSection.value] || 'Hướng Dẫn'
}

const getSectionDescription = () => {
  const descriptions = {
    'how-to-buy': 'Hướng dẫn chi tiết các bước mua hàng tại shop',
    'payment': 'Nhiều phương thức thanh toán tiện lợi cho bạn',
    'shipping': 'Thông tin vận chuyển và đóng gói sản phẩm'
  }
  return descriptions[activeSection.value] || ''
}
</script>

<style scoped>
.guide-page {
  max-width: 1200px;
  margin: 0 auto;
  padding: 20px;
}

.page-header {
  text-align: center;
  margin-bottom: 40px;
}

.page-header h1 {
  font-size: 36px;
  color: #2c3e50;
  margin-bottom: 10px;
}

.page-header p {
  font-size: 16px;
  color: #7f8c8d;
}

/* Tabs */
.guide-tabs {
  display: flex;
  gap: 10px;
  margin-bottom: 30px;
  border-bottom: 2px solid #e9ecef;
  overflow-x: auto;
}

.tab {
  padding: 12px 24px;
  background: transparent;
  border: none;
  color: #7f8c8d;
  font-weight: 600;
  cursor: pointer;
  border-bottom: 3px solid transparent;
  transition: all 0.3s ease;
  white-space: nowrap;
}

.tab:hover {
  color: #667eea;
}

.tab.active {
  color: #667eea;
  border-bottom-color: #667eea;
}

.section {
  animation: fadeIn 0.3s ease;
}

@keyframes fadeIn {
  from { opacity: 0; }
  to { opacity: 1; }
}

.guide-content {
  display: flex;
  flex-direction: column;
  gap: 40px;
}

.guide-section {
  background: white;
  border-radius: 12px;
  padding: 30px;
  box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
}

.guide-section h2 {
  color: #2c3e50;
  margin-bottom: 20px;
  font-size: 24px;
}

.guide-steps {
  display: flex;
  flex-direction: column;
  gap: 20px;
}

.step {
  display: flex;
  align-items: flex-start;
  gap: 15px;
}

.step-number {
  width: 40px;
  height: 40px;
  background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
  color: white;
  border-radius: 50%;
  display: flex;
  align-items: center;
  justify-content: center;
  font-weight: bold;
  flex-shrink: 0;
}

.step-content h3 {
  color: #2c3e50;
  margin-bottom: 5px;
}

.step-content p {
  color: #7f8c8d;
  line-height: 1.5;
}

.payment-methods {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
  gap: 20px;
}

.payment-method {
  text-align: center;
  padding: 20px;
  border: 1px solid #e9ecef;
  border-radius: 8px;
  transition: all 0.3s ease;
}

.payment-method:hover {
  border-color: #667eea;
  box-shadow: 0 4px 12px rgba(102, 126, 234, 0.1);
}

.payment-icon {
  font-size: 32px;
  margin-bottom: 10px;
}

.payment-method h3 {
  color: #2c3e50;
  margin-bottom: 5px;
}

.payment-method p {
  color: #7f8c8d;
  font-size: 14px;
  margin: 5px 0;
}

.payment-method .info {
  font-size: 13px;
  font-style: italic;
  color: #95a5a6;
}

.shipping-info {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
  gap: 20px;
}

.shipping-item {
  padding: 20px;
  border: 1px solid #e9ecef;
  border-radius: 8px;
  transition: all 0.3s ease;
}

.shipping-item:hover {
  border-color: #667eea;
  background: #f8f9fa;
}

.shipping-item h3 {
  color: #2c3e50;
  margin-bottom: 10px;
}

.shipping-item p {
  color: #7f8c8d;
  margin-bottom: 5px;
  line-height: 1.5;
}

.shipping-item .info {
  font-size: 13px;
  font-style: italic;
  color: #95a5a6;
}

.important-note {
  background: #fff3cd;
  border-left: 4px solid #ffc107;
  padding: 20px;
  border-radius: 8px;
  margin-top: 20px;
}

.important-note h3 {
  color: #856404;
  margin-bottom: 15px;
}

.important-note ul {
  margin: 0;
  padding-left: 20px;
}

.important-note li {
  color: #856404;
  margin-bottom: 8px;
  line-height: 1.6;
}
</style>