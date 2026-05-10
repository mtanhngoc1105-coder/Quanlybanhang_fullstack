<template>
  <div class="recruitment-page">
    <div class="page-header">
      <h1>{{ getSectionTitle() }}</h1>
      <p>{{ getSectionDescription() }}</p>
    </div>

    <!-- Navigation Tabs -->
    <div class="recruitment-tabs">
      <button 
        v-for="tab in recruitmentTabs" 
        :key="tab.id"
        :class="['tab', { active: activeSection === tab.id }]"
        @click="activeSection = tab.id"
      >
        {{ tab.label }}
      </button>
    </div>

    <div class="recruitment-content">
      <!-- TUYỂN DỤNG Section -->
      <div v-if="activeSection === 'jobs'" class="section">
        <div class="recruitment-section">
          <div class="job-listings">
            <div class="job-item">
              <h3>Cộng Tác Viên Bán Hàng Online</h3>
              <p class="job-location">Remote / Online</p>
              <p class="job-description">
                Tìm kiếm cộng tác viên bán hàng online cho các sản phẩm mô hình anime.
                Yêu cầu: Có kinh nghiệm bán hàng online, am hiểu về anime.
              </p>
              <div class="job-requirements">
                <strong>Yêu cầu:</strong>
                <ul>
                  <li>Có kinh nghiệm bán hàng online</li>
                  <li>Am hiểu về anime và mô hình</li>
                  <li>Có khả năng giao tiếp tốt</li>
                  <li>Tư duy kinh doanh</li>
                </ul>
              </div>
              <button class="apply-btn">Ứng tuyển ngay</button>
            </div>

            <div class="job-item">
              <h3>Nhân Viên Tư Vấn Khách Hàng</h3>
              <p class="job-location"> Hà Nội</p>
              <p class="job-description">
                Tư vấn và hỗ trợ khách hàng về các sản phẩm mô hình anime.
                Làm việc tại cửa hàng hoặc online.
              </p>
              <div class="job-requirements">
                <strong>Yêu cầu:</strong>
                <ul>
                  <li>Yêu thích anime</li>
                  <li>Kỹ năng giao tiếp tốt</li>
                  <li>Có thể làm việc full-time</li>
                  <li>Ưu tiên có kinh nghiệm</li>
                </ul>
              </div>
              <button class="apply-btn">Ứng tuyển ngay</button>
            </div>

            <div class="job-item">
              <h3>Designer Đồ Họa</h3>
              <p class="job-location">Remote</p>
              <p class="job-description">
                Thiết kế banner, poster và content marketing cho cửa hàng.
              </p>
              <div class="job-requirements">
                <strong>Yêu cầu:</strong>
                <ul>
                  <li>Thành thạo Photoshop, Illustrator</li>
                  <li>Có portfolio</li>
                  <li>Yêu thích anime/manga</li>
                  <li>Sáng tạo và có gu thẩm mỹ</li>
                </ul>
              </div>
              <button class="apply-btn">Ứng tuyển ngay</button>
            </div>
          </div>
        </div>
      </div>

      <!-- CỘNG TÁC VIÊN Section -->
      <div v-if="activeSection === 'affiliates'" class="section">
        <div class="recruitment-section">
          <div class="affiliate-info">
            <div class="info-card">
              <h3>Chương Trình Cộng Tác Viên</h3>
              <p>Hãy trở thành cộng tác viên của Shop Của Ngọc và kiếm thêm thu nhập.</p>
              
              <div class="benefits">
                <h4>Lợi Ích:</h4>
                <ul>
                  <li> Hoa hồng cao lên đến 20% cho mỗi đơn bán được</li>
                  <li> Không cần vốn đầu tư</li>
                  <li> Hỗ trợ marketing materials miễn phí</li>
                  <li> Hỗ trợ kỹ thuật từ đội ngũ chuyên nghiệp</li>
                  <li> Có thể làm việc từ nhà, thời gian linh hoạt</li>
                  <li> Thanh toán hoa hồng hàng tuần</li>
                </ul>
              </div>

              <div class="requirements">
                <h4>Yêu Cầu Để Tham Gia:</h4>
                <ul>
                  <li> Yêu thích anime và mô hình</li>
                  <li> Có tiếp cận được với nhóm khách hàng tiềm năng</li>
                  <li> Có trách nhiệm cao trong công việc</li>
                  <li> Tuổi từ 18 trở lên</li>
                </ul>
              </div>

              <button class="apply-btn">Đăng Ký Cộng Tác Viên</button>
            </div>
          </div>
        </div>
      </div>

      <!-- LIÊN HỆ QUẢNG CÁO Section -->
      <div v-if="activeSection === 'advertising'" class="section">
        <div class="recruitment-section">
          <div class="advertising-info">
            <div class="info-card">
              <h3> Liên Hệ Quảng Cáo & Hợp Tác</h3>
              <p>Bạn muốn quảng cáo sản phẩm của bạn trên Shop Của Ngọc? Liên hệ với chúng tôi ngay!</p>
              
              <div class="advertising-options">
                <h4>Các Hình Thức Quảng Cáo:</h4>
                <div class="options-grid">
                  <div class="option-item">
                    <h5> Banner Advertisement</h5>
                    <p>Quảng cáo trên trang chủ hoặc các trang danh mục.</p>
                  </div>
                  <div class="option-item">
                    <h5> Sponsored Products</h5>
                    <p>Nâng cao visibility cho sản phẩm của bạn.</p>
                  </div>
                  <div class="option-item">
                    <h5> Blog & Content</h5>
                    <p>Viết bài review hoặc bài quảng cáo trên blog của chúng tôi.</p>
                  </div>
                  <div class="option-item">
                    <h5> Email Marketing</h5>
                    <p>Gửi email quảng cáo đến danh sách khách hàng của chúng tôi.</p>
                  </div>
                </div>
              </div>

              <div class="contact-for-advertising">
                <h4>Liên Hệ Chúng Tôi:</h4>
                <div class="contact-details">
                  <div class="contact-item">
                    <span class="icon">📧</span>
                    <div>
                      <strong>Email:</strong>
                      <a href="mailto:advertising@animenei.com">advertising@animenei.com</a>
                    </div>
                  </div>
                  <div class="contact-item">
                    <span class="icon">📞</span>
                    <div>
                      <strong>Phone:</strong>
                      <a href="tel:0363961832">0363 961 832</a>
                    </div>
                  </div>
                  <div class="contact-item">
                    <span class="icon">📘</span>
                    <div>
                      <strong>Facebook:</strong>
                      <a href="#" target="_blank">fb.com/animenei</a>
                    </div>
                  </div>
                </div>
              </div>

              <button class="apply-btn">Gửi Yêu Cầu Quảng Cáo</button>
            </div>
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
const activeSection = ref('jobs')

const recruitmentTabs = [
  { id: 'jobs', label: 'TUYỂN DỤNG' },
  { id: 'affiliates', label: 'CỘNG TÁC VIÊN' },
  { id: 'advertising', label: 'LIÊN HỆ QUẢNG CÁO' }
]

onMounted(() => {
  const section = route.query.section || 'jobs'
  activeSection.value = section
})

const getSectionTitle = () => {
  const titles = {
    'jobs': 'Tuyển Dụng',
    'affiliates': 'Chương Trình Cộng Tác Viên',
    'advertising': 'Liên Hệ Quảng Cáo & Hợp Tác'
  }
  return titles[activeSection.value] || 'Khác'
}

const getSectionDescription = () => {
  const descriptions = {
    'jobs': 'Tham gia đội ngũ của chúng tôi',
    'affiliates': 'Kiếm thêm thu nhập cùng Shop Của Ngọc',
    'advertising': 'Quảng cáo sản phẩm của bạn trên Shop Của Ngọc'
  }
  return descriptions[activeSection.value] || ''
}
</script>

<style scoped>
.recruitment-page {
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
.recruitment-tabs {
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

.recruitment-content {
  display: flex;
  flex-direction: column;
  gap: 40px;
}

.recruitment-section {
  background: white;
  border-radius: 12px;
  padding: 30px;
  box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
}

.recruitment-section h2 {
  color: #2c3e50;
  margin-bottom: 20px;
  font-size: 24px;
}

.job-listings {
  display: flex;
  flex-direction: column;
  gap: 30px;
}

.job-item {
  border: 1px solid #e9ecef;
  border-radius: 8px;
  padding: 20px;
  transition: all 0.3s ease;
}

.job-item:hover {
  border-color: #667eea;
  box-shadow: 0 4px 12px rgba(102, 126, 234, 0.1);
}

.job-item h3 {
  color: #2c3e50;
  margin-bottom: 5px;
  font-size: 20px;
}

.job-location {
  color: #667eea;
  font-weight: 600;
  margin-bottom: 10px;
}

.job-description {
  color: #555;
  line-height: 1.6;
  margin-bottom: 15px;
}

.job-requirements {
  margin-bottom: 20px;
}

.job-requirements strong {
  color: #2c3e50;
}

.job-requirements ul {
  margin-top: 10px;
  padding-left: 20px;
}

.job-requirements li {
  color: #555;
  margin-bottom: 5px;
}

.apply-btn {
  background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
  color: white;
  border: none;
  border-radius: 6px;
  padding: 10px 20px;
  font-weight: 600;
  cursor: pointer;
  transition: all 0.3s ease;
}

.apply-btn:hover {
  transform: translateY(-2px);
  box-shadow: 0 4px 12px rgba(102, 126, 234, 0.3);
}

/* Affiliate Info */
.affiliate-info,
.advertising-info {
  display: flex;
  justify-content: center;
}

.info-card {
  background: white;
  border-radius: 12px;
  padding: 30px;
  max-width: 800px;
  width: 100%;
}

.info-card h3 {
  color: #2c3e50;
  margin-bottom: 15px;
  font-size: 22px;
}

.info-card > p {
  color: #555;
  line-height: 1.6;
  margin-bottom: 20px;
}

.benefits,
.requirements {
  background: #f8f9fa;
  padding: 20px;
  border-radius: 8px;
  margin-bottom: 20px;
}

.benefits h4,
.requirements h4 {
  color: #2c3e50;
  margin-bottom: 15px;
}

.benefits ul,
.requirements ul {
  margin: 0;
  padding-left: 20px;
  display: flex;
  flex-direction: column;
  gap: 8px;
}

.benefits li,
.requirements li {
  color: #555;
  line-height: 1.6;
}

/* Advertising Options Grid */
.advertising-options {
  background: #f8f9fa;
  padding: 20px;
  border-radius: 8px;
  margin-bottom: 20px;
}

.advertising-options h4 {
  color: #2c3e50;
  margin-bottom: 20px;
}

.options-grid {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
  gap: 20px;
}

.option-item {
  background: white;
  padding: 15px;
  border-radius: 8px;
  border: 1px solid #e9ecef;
  transition: all 0.3s ease;
}

.option-item:hover {
  border-color: #667eea;
  box-shadow: 0 4px 12px rgba(102, 126, 234, 0.1);
}

.option-item h5 {
  color: #2c3e50;
  margin-bottom: 8px;
  font-size: 16px;
}

.option-item p {
  color: #7f8c8d;
  font-size: 14px;
  margin: 0;
}

/* Contact For Advertising */
.contact-for-advertising {
  background: #e8f4f8;
  padding: 20px;
  border-radius: 8px;
  margin-bottom: 20px;
  border-left: 4px solid #667eea;
}

.contact-for-advertising h4 {
  color: #2c3e50;
  margin-bottom: 15px;
}

.contact-details {
  display: flex;
  flex-direction: column;
  gap: 15px;
}

.contact-item {
  display: flex;
  align-items: flex-start;
  gap: 15px;
}

.contact-item .icon {
  font-size: 24px;
  flex-shrink: 0;
}

.contact-item div {
  flex: 1;
}

.contact-item strong {
  display: block;
  color: #2c3e50;
  margin-bottom: 3px;
}

.contact-item a {
  color: #667eea;
  text-decoration: none;
  transition: color 0.3s ease;
}

.contact-item a:hover {
  color: #764ba2;
}

.contact-item p {
  color: #555;
  margin: 0;
  font-size: 14px;
}
</style>