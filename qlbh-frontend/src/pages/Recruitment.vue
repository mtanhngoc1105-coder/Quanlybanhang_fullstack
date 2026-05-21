<template>
  <div class="recruitment-page">
    <header class="page-header-banner">
      <div class="banner-content">
        <h1 class="banner-title">{{ getShortTitle() }}</h1>
        <p class="banner-subtitle">
          Nơi cập nhật nhanh nhất các xu hướng, sản phẩm mô hình Anime/Manga hot nhất toàn cầu.
        </p>
      </div>
    </header>

    <nav class="recruitment-tabs-container" role="tablist">
      <div class="tabs-pill-wrapper">
        <button 
          v-for="tab in recruitmentTabs" 
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

    <main class="recruitment-content">
      
      <div v-if="activeSection === 'jobs'" class="section-pane">
        <div class="filter-bar">
          <div class="search-wrapper">
            <span class="search-icon">🔍</span>
            <input 
              v-model="searchQuery" 
              type="text" 
              placeholder="Tìm kiếm vị trí ứng tuyển công việc..." 
              class="search-input"
            />
          </div>
          <div class="select-wrapper">
            <select v-model="selectedLocation" class="location-select">
              <option value="">🌍 Tất cả địa điểm</option>
              <option value="Hà Nội">📍 Hà Nội</option>
              <option value="Remote">💻 Remote</option>
              <option value="Online">🌐 Online</option>
            </select>
          </div>
        </div>

        <div v-if="filteredJobs.length > 0" class="job-grid-layout">
          <div v-for="(job, index) in filteredJobs" :key="index" class="text-article-card">
            <div class="article-header">
              <h3>{{ job.title }}</h3>
              <span :class="['location-tag', job.location.toLowerCase()]">{{ job.location }}</span>
            </div>
            <p class="article-text lead-text">{{ job.description }}</p>
            
            <div class="article-body-content">
              <h4>📋 Yêu cầu công việc</h4>
              <ul class="text-list">
                <li v-for="(req, rIdx) in job.requirements" :key="rIdx">{{ req }}</li>
              </ul>
            </div>
            
            <div class="article-footer">
              <button @click="openModal(job.title)" class="btn btn-primary">
                Ứng tuyển ngay
                <span class="btn-arrow">→</span>
              </button>
            </div>
          </div>
        </div>
        <div v-else class="empty-state">
          <div class="empty-icon">💨</div>
          <p>Không tìm thấy vị trí phù hợp với tìm kiếm của bạn.</p>
        </div>
      </div>

      <div v-if="activeSection === 'affiliates'" class="section-pane">
        <div class="text-article-card hero-card">
          <p class="article-text lead-text-large">
            Đồng hành cùng <strong>AnimeNei (Shop Của Ngọc)</strong> để lan tỏa đam mê Manga/Anime và xây dựng nguồn thu nhập thụ động không giới hạn. Sau đây là chi tiết chương trình:
          </p>
          
          <div class="article-body-content text-columns">
            <div class="text-column-box benefit-box">
              <h4>🎁 Quyền Lợi Của Bạn</h4>
              <ul class="text-list custom-check">
                <li v-for="(benefit, index) in affiliateBenefits" :key="index">
                  <span class="icon-indicator">✨</span> {{ benefit }}
                </li>
              </ul>
            </div>

            <div class="text-column-box require-box">
              <h4>⚖️ Điều Kiện Tham Gia</h4>
              <ul class="text-list custom-dot">
                <li v-for="(req, index) in affiliateRequirements" :key="index">
                  <span class="icon-indicator">🔹</span> {{ req }}
                </li>
              </ul>
            </div>
          </div>

          <div class="article-footer center-content">
            <button @click="openModal('Đăng Ký Cộng Tác Viên')" class="btn btn-secondary btn-large">
              🤝 Đăng Ký Tham Gia Ngay
            </button>
          </div>
        </div>
      </div>

      <div v-if="activeSection === 'advertising'" class="section-pane">
        <div class="text-article-card">
          <p class="article-text lead-text">
            Tối ưu hóa chiến dịch Marketing, tiếp cận chính xác tệp khách hàng tiềm năng yêu thích Anime/Manga/Figures tại thị trường Việt Nam thông qua các giải pháp truyền thông sau:
          </p>
          
          <div class="article-body-content memory-grid">
            <div v-for="(opt, index) in adOptions" :key="index" class="text-row-item-card">
              <div class="card-icon">{{ opt.icon }}</div>
              <div class="card-info">
                <strong>{{ opt.title }}</strong> 
                <p>{{ opt.desc }}</p>
              </div>
            </div>
          </div>

          <div class="contact-channels">
            <h4>📞 Kênh Liên Hệ Trực Tiếp</h4>
            <div class="inline-channels">
              <a href="mailto:advertising@animenei.com" class="channel-item">
                <span class="c-icon">✉️</span>
                <div>
                  <span class="c-label">Email</span>
                  <span class="c-value">advertising@animenei.com</span>
                </div>
              </a>
              <a href="tel:0363961832" class="channel-item">
                <span class="c-icon">☎️</span>
                <div>
                  <span class="c-label">Hotline</span>
                  <span class="c-value">0363 961 832</span>
                </div>
              </a>
              <a href="https://fb.com/animenei" target="_blank" class="channel-item">
                <span class="c-icon">🌐</span>
                <div>
                  <span class="c-label">Facebook</span>
                  <span class="c-value">fb.com/animenei</span>
                </div>
              </a>
            </div>
          </div>

          <div class="article-footer center-content">
            <button @click="openModal('Yêu Cầu Tư Vấn Quảng Cáo')" class="btn btn-primary btn-large">
              📢 Gửi Yêu Cầu Tư Vấn Chi Chiến Dịch
            </button>
          </div>
        </div>
      </div>
    </main>

    <transition name="fade">
      <div v-if="isModalOpen" class="modal-overlay" @click.self="closeModal">
        <div class="modal-window">
          <button class="modal-close-btn" @click="closeModal">&times;</button>
          <div class="modal-header">
            <h3>Biểu mẫu: {{ modalTarget }}</h3>
            <p>Vui lòng điền thông tin, chúng tôi sẽ phản hồi trong vòng 24h làm việc.</p>
          </div>
          <form @submit.prevent="handleSubmit" class="modal-form">
            <div class="form-group">
              <label>Họ và tên *</label>
              <input type="text" required placeholder="Nguyễn Văn A" v-model="formData.name">
            </div>
            <div class="form-group-row">
              <div class="form-group">
                <label>Số điện thoại *</label>
                <input type="tel" required placeholder="09xxxxxxx" v-model="formData.phone">
              </div>
              <div class="form-group">
                <label>Email liên hệ *</label>
                <input type="email" required placeholder="name@example.com" v-model="formData.email">
              </div>
            </div>
            <div class="form-group">
              <label>Lời nhắn / Link Portfolio</label>
              <textarea rows="4" placeholder="Nhập nội dung thông điệp hoặc link sản phẩm của bạn tại đây..." v-model="formData.message"></textarea>
            </div>
            <button type="submit" class="btn btn-primary btn-full">Gửi Đơn Đăng Ký</button>
          </form>
        </div>
      </div>
    </transition>
  </div>
</template>

<script setup>
import { ref, computed, onMounted } from 'vue'
import { useRoute } from 'vue-router'

const route = useRoute()
const activeSection = ref('jobs')
const searchQuery = ref('')
const selectedLocation = ref('')

const isModalOpen = ref(false)
const modalTarget = ref('')
const formData = ref({ name: '', phone: '', email: '', message: '' })

const recruitmentTabs = [
  { id: 'jobs', label: 'Tuyển Dụng' },
  { id: 'affiliates', label: 'Cộng Tác Viên' },
  { id: 'advertising', label: 'Liên hệ Quảng Cáo' }
]

const getShortTitle = () => {
  const titles = {
    'jobs': 'Trung Tâm Tin Tức & Xu Hướng',
    'affiliates': 'Chương Trình Đối Tác & Review',
    'advertising': 'Hoạt Động & Sự Kiện Nổi Bật'
  }
  return titles[activeSection.value] || 'Trung Tâm Thông Tin'
}

const jobListings = [
  {
    title: 'Cộng Tác Viên Bán Hàng Online',
    location: 'Remote',
    description: 'Tìm kiếm cộng tác viên bán hàng online năng động phát triển phân phối các sản phẩm mô hình anime chính hãng chất lượng cao.',
    requirements: [
      'Có kinh nghiệm bán hàng online hoặc làm affiliate marketing.',
      'Am hiểu sâu sắc về văn hóa anime/manga và thế giới mô hình.',
      'Có khả năng giao tiếp, tư vấn thuyết phục tốt trên môi trường số.',
      'Tư duy kinh doanh nhạy bén, chủ động tìm kiếm tệp khách hàng.'
    ]
  },
  {
    title: 'Nhân Viên Tư Vấn Khách Hàng',
    location: 'Hà Nội',
    description: 'Tư vấn, chăm sóc giải đáp thắc mắc của khách hàng về các sản phẩm mô hình anime trực tiếp tại Store hoặc thông qua các kênh Online.',
    requirements: [
      'Yêu thích đam mê anime, am hiểu sản phẩm để tư vấn chính xác.',
      'Kỹ năng giao tiếp khéo léo, giọng nói dễ nghe, không nói ngọng.',
      'Có thể cam kết làm việc full-time xoay ca linh hoạt.',
      'Ưu tiên ứng viên có kinh nghiệm trong ngành bán lẻ/CSKH.'
    ]
  },
  {
    title: 'Designer Đồ Họa',
    location: 'Remote',
    description: 'Chịu trách nhiệm thiết kế bộ nhận diện Key Visual, banner, poster sự kiện và xây dựng content visual marketing độc đáo cho thương hiệu trên mạng xã hội.',
    requirements: [
      'Thành thạo các công cụ đồ họa chuyên nghiệp Photoshop, Illustrator.',
      'Bắt buộc có Portfolio đính kèm hiển thị các dự án thiết kế trước đây.',
      'Yêu thích phong cách thiết kế, văn hóa anime/manga là điểm cộng lớn.',
      'Sáng tạo cao, có tư duy bố cục tốt và gu thẩm mỹ hiện đại.'
    ]
  }
]

const affiliateBenefits = [
  'Mức hoa hồng siêu hấp dẫn lên đến 20% trên giá trị mỗi đơn hàng thành công.',
  'Hoàn toàn không cần bỏ vốn ôm hàng, không rủi ro tồn kho tài chính.',
  'Cung cấp kho tài nguyên Marketing materials (hình ảnh, video, bài viết) miễn phí.',
  'Hệ thống theo diện tracking đơn hàng minh bạch, cập nhật real-time.',
  'Thời gian làm việc tự do, làm tại nhà linh hoạt tối đa.',
  'Cơ chế đối soát và thanh toán hoa hồng định kỳ nhanh gọn hàng tuần.'
]

const affiliateRequirements = [
  'Là người yêu thích, am hiểu cộng đồng anime và thị trường mô hình.',
  'Sở hữu hoặc có khả năng tiếp cận sâu rộng tới các hội nhóm khách hàng tiềm năng.',
  'Làm việc có trách nhiệm cao, văn minh, bảo vệ uy tín hình ảnh thương hiệu.',
  'Độ tuổi yêu cầu: Từ đủ 18 tuổi trở lên.'
]

const adOptions = [
  { icon: '🖼️', title: 'Banner Advertisement', desc: 'Đặt banner hiển thị tại vị trí đắc địa trên trang chủ hoặc các danh mục ngành hàng nổi bật.' },
  { icon: '🚀', title: 'Sponsored Products', desc: 'Tăng mức độ tiếp cận tối đa đưa sản phẩm của bạn lên đầu trang tìm kiếm.' },
  { icon: '✍️', title: 'Blog & Content Marketing', desc: 'Thiết kế bài viết Review chuyên sâu, PR thương hiệu khéo léo truyền tải trên trang Blog.' },
  { icon: '✉️', title: 'Email Marketing Blast', desc: 'Tiếp cận trực tiếp tệp Data khách hàng ngách trung thành thông qua hệ thống Mail Newsletter.' }
]

const filteredJobs = computed(() => {
  return jobListings.filter(job => {
    const matchesSearch = job.title.toLowerCase().includes(searchQuery.value.toLowerCase()) || 
                          job.description.toLowerCase().includes(searchQuery.value.toLowerCase())
    const matchesLocation = selectedLocation.value ? job.location === selectedLocation.value : true
    return matchesSearch && matchesLocation
  })
})

onMounted(() => {
  const section = route?.query?.section || 'jobs'
  activeSection.value = section
})

const openModal = (target) => {
  modalTarget.value = target
  isModalOpen.value = true
}

const closeModal = () => {
  isModalOpen.value = false
  formData.value = { name: '', phone: '', email: '', message: '' }
}

const handleSubmit = () => {
  alert(`Cảm ơn bạn ${formData.value.name}! Yêu cầu của bạn đã được ghi nhận thành công.`)
  closeModal()
}
</script>

<style scoped>
.recruitment-page {
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
.recruitment-tabs-container {
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
  text-transform: uppercase; /* Chữ in hoa giống ảnh mẫu */
  letter-spacing: 0.5px;
  cursor: pointer;
  border-radius: 12px;
  transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
}

.tab-pill-btn:hover {
  color: #7c3aed;
}

/* Khi tab được kích hoạt: Chuyển màu nền gradient phối tím nhẹ */
.tab-pill-btn.active {
  background: linear-gradient(135deg, #6366f1 0%, #7c3aed 100%);
  color: #ffffff;
  font-weight: 700;
  box-shadow: 0 4px 14px rgba(99, 102, 241, 0.3);
}

/* ==========================================================================
   MAIN CONTENT AREA & COMPONENTS
   ========================================================================== */
.section-pane {
  animation: fadeIn 0.4s cubic-bezier(0.16, 1, 0.3, 1);
}
@keyframes fadeIn {
  from { opacity: 0; transform: translateY(10px); } 
  to { opacity: 1; transform: translateY(0); }
}

.filter-bar {
  display: flex;
  gap: 16px;
  margin-bottom: 32px;
}
.search-wrapper {
  flex: 1;
  position: relative;
}
.search-icon {
  position: absolute;
  left: 14px;
  top: 50%;
  transform: translateY(-50%);
  font-size: 16px;
  color: #94a3b8;
}
.search-input {
  width: 100%;
  padding: 12px 14px 12px 42px;
  border: 1px solid #e2e8f0;
  border-radius: 10px;
  font-size: 15px;
  box-shadow: 0 1px 2px rgba(0,0,0,0.02);
  transition: all 0.2s ease;
  box-sizing: border-box;
}
.search-input:focus, .location-select:focus {
  border-color: #7c3aed;
  box-shadow: 0 0 0 4px rgba(124, 58, 237, 0.1);
  outline: none;
}
.select-wrapper {
  min-width: 200px;
}
.location-select {
  width: 100%;
  padding: 12px 14px;
  border: 1px solid #e2e8f0;
  border-radius: 10px;
  background: white;
  font-size: 15px;
  cursor: pointer;
  box-shadow: 0 1px 2px rgba(0,0,0,0.02);
}

.job-grid-layout {
  display: grid;
  grid-template-columns: repeat(auto-fill, minmax(380px, 1fr));
  gap: 24px;
}

.text-article-card {
  background: #ffffff;
  border: 1px solid #e2e8f0;
  border-radius: 14px;
  padding: 32px;
  box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
  transition: all 0.3s ease;
  display: flex;
  flex-direction: column;
  justify-content: space-between;
}
.text-article-card:hover {
  transform: translateY(-4px);
  box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.08);
  border-color: #cbd5e1;
}

.hero-card {
  grid-column: 1 / -1;
}

.article-header {
  display: flex;
  justify-content: space-between;
  align-items: flex-start;
  gap: 12px;
  margin-bottom: 16px;
}
.article-header h3 {
  font-size: 20px;
  font-weight: 700;
  color: #0f172a;
  margin: 0;
  line-height: 1.4;
}

.location-tag {
  font-size: 12px;
  font-weight: 600;
  padding: 4px 12px;
  border-radius: 100px;
  white-space: nowrap;
}
.location-tag.ha-noi { background: #fef2f2; color: #ef4444; border: 1px solid #fee2e2; }
.location-tag.remote { background: #f0f9ff; color: #0284c7; border: 1px solid #e0f2fe; }
.location-tag.online { background: #f0fdf4; color: #16a34a; border: 1px solid #dcfce7; }

.lead-text {
  font-size: 14.5px;
  color: #475569;
  margin-bottom: 20px;
}
.lead-text-large {
  font-size: 16px;
  color: #334155;
  max-width: 800px;
  margin-bottom: 32px;
}

.article-body-content h4 {
  font-size: 15px;
  font-weight: 700;
  color: #0f172a;
  margin: 0 0 12px 0;
}
.text-list {
  list-style: none;
  padding: 0;
  margin: 0 0 24px 0;
}
.text-list li {
  font-size: 14px;
  color: #475569;
  margin-bottom: 10px;
  position: relative;
  padding-left: 18px;
}
.text-list li::before {
  content: "•";
  position: absolute;
  left: 4px;
  color: #7c3aed;
  font-weight: bold;
}

.text-columns {
  display: grid;
  grid-template-columns: 1fr 1fr;
  gap: 24px;
  margin-bottom: 32px;
}
.text-column-box {
  background: #f8fafc;
  padding: 24px;
  border-radius: 12px;
  border: 1px solid #f1f5f9;
}
.text-column-box .text-list li::before { content: none; }
.text-column-box .text-list li { padding-left: 0; display: flex; gap: 8px; }
.icon-indicator { color: #7c3aed; flex-shrink: 0; }

.memory-grid {
  display: grid;
  grid-template-columns: repeat(auto-fill, minmax(260px, 1fr));
  gap: 20px;
  margin: 24px 0 32px 0;
}
.text-row-item-card {
  background: #f8fafc;
  border: 1px solid #e2e8f0;
  padding: 20px;
  border-radius: 12px;
  display: flex;
  gap: 16px;
  align-items: flex-start;
}
.card-icon {
  font-size: 24px;
  background: white;
  padding: 10px;
  border-radius: 10px;
  box-shadow: 0 2px 4px rgba(0,0,0,0.02);
}
.card-info strong {
  display: block;
  font-size: 15px;
  color: #0f172a;
  margin-bottom: 4px;
}
.card-info p {
  margin: 0;
  font-size: 13.5px;
  color: #64748b;
  line-height: 1.5;
}

.contact-channels {
  background: #f4f4f5;
  padding: 28px;
  border-radius: 14px;
  margin-top: 32px;
  border: 1px solid #e4e4e7;
}
.contact-channels h4 { margin: 0 0 16px 0; font-size: 16px; font-weight: 700; }
.inline-channels {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
  gap: 16px;
}
.channel-item {
  background: white;
  padding: 16px;
  border-radius: 10px;
  display: flex;
  align-items: center;
  gap: 14px;
  text-decoration: none;
  border: 1px solid #e4e4e7;
  transition: all 0.2s ease;
}
.channel-item:hover {
  border-color: #7c3aed;
  transform: translateY(-2px);
}
.c-icon { font-size: 20px; }
.c-label { display: block; font-size: 12px; color: #a1a1aa; font-weight: 600; text-transform: uppercase; }
.c-value { font-size: 14px; color: #18181b; font-weight: 600; }

.article-footer {
  margin-top: auto;
  padding-top: 20px;
  border-top: 1px solid #f1f5f9;
}
.center-content { text-align: center; border-top: none; padding-top: 0; }

.btn {
  display: inline-flex;
  align-items: center;
  justify-content: center;
  font-weight: 600;
  font-size: 14px;
  padding: 10px 22px;
  border-radius: 8px;
  border: none;
  cursor: pointer;
  transition: all 0.2s ease;
}
.btn-primary { background: #7c3aed; color: white; }
.btn-primary:hover { background: #6d28d9; }
.btn-arrow { margin-left: 6px; transition: transform 0.2s ease; }
.btn-primary:hover .btn-arrow { transform: translateX(3px); }

.btn-secondary { background: #10b981; color: white; }
.btn-secondary:hover { background: #059669; }
.btn-large { padding: 14px 36px; font-size: 15px; border-radius: 10px; }
.btn-full { width: 100%; padding: 12px; font-size: 15px; }

.empty-state {
  text-align: center;
  padding: 60px 20px;
  color: #94a3b8;
  border: 2px dashed #e2e8f0;
  border-radius: 14px;
  background: #f8fafc;
}
.empty-icon { font-size: 40px; margin-bottom: 12px; }

.modal-overlay {
  position: fixed;
  top: 0; left: 0; right: 0; bottom: 0;
  background: rgba(15, 23, 42, 0.6);
  backdrop-filter: blur(4px);
  display: flex; justify-content: center; align-items: center;
  z-index: 1000;
  padding: 16px;
}
.modal-window {
  background: white; border-radius: 16px; padding: 32px;
  width: 100%; max-width: 520px; position: relative;
  box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
  animation: modalSlide 0.3s cubic-bezier(0.34, 1.56, 0.64, 1);
}
@keyframes modalSlide {
  from { transform: scale(0.95); opacity: 0; } to { transform: scale(1); opacity: 1; }
}
.modal-close-btn {
  position: absolute; top: 16px; right: 20px;
  background: none; border: none; font-size: 28px; color: #94a3b8; cursor: pointer;
}
.modal-close-btn:hover { color: #334155; }
.modal-header h3 { font-size: 20px; font-weight: 700; margin: 0 0 6px 0; color: #0f172a; }
.modal-header p { font-size: 14px; color: #64748b; margin: 0 0 24px 0; }
.modal-form { display: flex; flex-direction: column; gap: 16px; }
.form-group { display: flex; flex-direction: column; gap: 6px; flex: 1; }
.form-group-row { display: flex; gap: 16px; }
.form-group label { font-size: 13px; font-weight: 600; color: #475569; }
.form-group input, .form-group textarea {
  padding: 11px 14px; border: 1px solid #cbd5e1; border-radius: 8px; font-size: 14px; outline: none; transition: all 0.2s;
}
.form-group input:focus, .form-group textarea:focus { 
  border-color: #7c3aed; box-shadow: 0 0 0 4px rgba(124, 58, 237, 0.1); 
}

.fade-enter-active, .fade-leave-active { transition: opacity 0.25s ease; }
.fade-enter-from, .fade-leave-to { opacity: 0; }

/* ==========================================================================
   RESPONSIVE (Đa thiết bị mượt mà)
   ========================================================================== */
@media (max-width: 1024px) {
  .job-grid-layout { grid-template-columns: 1fr 1fr; }
}

@media (max-width: 768px) {
  .page-header-banner {
    padding: 40px 20px;
    border-radius: 16px;
  }
  .banner-title { font-size: 28px; }
  .banner-subtitle { font-size: 14px; }
  
  .recruitment-tabs-container {
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
  
  .job-grid-layout { grid-template-columns: 1fr; }
  .text-columns { grid-template-columns: 1fr; gap: 16px; }
  .form-group-row { flex-direction: column; gap: 16px; }
  .filter-bar { flex-direction: column; gap: 12px; }
  .select-wrapper { min-width: 100%; }
  .text-article-card { padding: 24px; }
}
</style>