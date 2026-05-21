<template>
  <div class="news-page">
    <!-- Page Header Banner -->
    <div class="page-header">
      <div class="header-overlay">
        <h1>{{ getSectionTitle() }}</h1>
        <p>{{ getSectionDescription() }}</p>
      </div>
    </div>

    <!-- Navigation Tabs -->
    <div class="news-tabs-container">
      <div class="news-tabs">
        <button 
          v-for="tab in newsTabs" 
          :key="tab.id"
          :class="['tab', { active: activeSection === tab.id }]"
          type="button"
          @click="activeSection = tab.id"
        >
          <span class="tab-icon">{{ tab.icon }}</span>
          {{ tab.label }}
        </button>
      </div>
    </div>

    <!-- Main Content Area -->
    <div class="news-content">
      <!-- Grid Sections (Latest, Reviews, Events) -->
      <div v-if="activeSection !== 'contact'" class="section-grid-wrapper">
        <div class="news-grid">
          <article 
            v-for="(item, index) in filteredContent" 
            :key="index" 
            class="news-item"
          >
            <div class="news-image">
              <img :src="item.image" :alt="item.title" loading="lazy" />
              <span class="badge" :class="activeSection">{{ item.tag }}</span>
            </div>
            <div class="news-body">
              <div class="meta-info">
                <span class="news-date">🗓️ {{ item.date }}</span>
                <span v-if="item.readTime" class="read-time">⏱️ {{ item.readTime }}</span>
              </div>
              <h3 class="news-title">{{ item.title }}</h3>
              <p class="news-excerpt">{{ item.excerpt }}</p>
              <a href="#" class="read-more-btn">
                Xem chi tiết 
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                  <path fill-rule="evenodd" d="M1 8a.5.5 0 0 1 .5-.5h11.793l-3.147-3.146a.5.5 0 0 1 .708-.708l4 4a.5.5 0 0 1 0 .708l-4 4a.5.5 0 0 1-.708-.708L13.293 8.5H1.5A.5.5 0 0 1 1 8z"/>
                </svg>
              </a>
            </div>
          </article>
        </div>
      </div>

      <!-- LIÊN HỆ Section -->
      <div v-else class="contact-wrapper">
        <div class="contact-grid">
          <!-- Info Card -->
          <div class="contact-card info-card">
            <h3>Thông Tin Liên Hệ</h3>
            <p class="contact-subtext">Đừng ngần ngại liên hệ với Shop Của Ngọc để được tư vấn bộ sưu tập Figure chất lượng nhất!</p>
            
            <div class="contact-info">
              <div class="info-item">
                <div class="icon-box">📍</div>
                <div>
                  <strong>Địa chỉ</strong>
                  <p>Ngõ 32 Đỗ Đức Dục, Mễ Trì, Nam Từ Liêm, Hà Nội</p>
                </div>
              </div>
              
              <div class="info-item">
                <div class="icon-box">📞</div>
                <div>
                  <strong>Hotline Hỗ Trợ</strong>
                  <a href="tel:0363961832">0363 961 832</a>
                </div>
              </div>

              <div class="info-item">
                <div class="icon-box">✉️</div>
                <div>
                  <strong>Email Doanh Nghiệp</strong>
                  <a href="mailto:ngocmt363@gmail.com">ngocmt363@gmail.com</a>
                </div>
              </div>

              <div class="info-item">
                <div class="icon-box">🌐</div>
                <div>
                  <strong>Cộng Đồng Facebook</strong>
                  <a href="https://fb.com/animenei" target="_blank" rel="noopener noreferrer">fb.com/animenei</a>
                </div>
              </div>
            </div>
          </div>

          <!-- Feedback/Contact Form -->
          <div class="contact-card form-card">
            <h3>Gửi Lời Nhắn Cho Ngọc</h3>
            <form class="premium-form" @submit.prevent="handleSubmit">
              <div class="form-row">
                <div class="form-group">
                  <label for="fullName">Họ và tên</label>
                  <input id="fullName" v-model="formData.name" type="text" placeholder="Nguyễn Văn A" required />
                </div>
                <div class="form-group">
                  <label for="phoneNumber">Số điện thoại</label>
                  <input id="phoneNumber" v-model="formData.phone" type="tel" placeholder="0901 234 567" required />
                </div>
              </div>
              <div class="form-group">
                <label for="emailAddress">Địa chỉ Email</label>
                <input id="emailAddress" v-model="formData.email" type="none" placeholder="username@gmail.com" required />
              </div>
              <div class="form-group">
                <label for="messageContent">Nội dung cần tư vấn</label>
                <textarea id="messageContent" v-model="formData.message" rows="4" placeholder="Nhập câu hỏi tại đây..." required></textarea>
              </div>
              <button type="submit" class="submit-btn">Gửi Liên Hệ Ngay</button>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted, computed } from 'vue'
import { useRoute } from 'vue-router'

// Định nghĩa cấu trúc dữ liệu rõ ràng để tránh lỗi "nhận diện kiểu" (Type Inference)
const route = useRoute()
const activeSection = ref('latest')

const formData = ref({
  name: '',
  phone: '',
  email: '',
  message: ''
})

const newsTabs = [
  { id: 'latest', label: 'TIN MỚI', icon: '' },
  { id: 'reviews', label: 'REVIEW', icon: '' },
  { id: 'events', label: 'SỰ KIỆN', icon: '' },
  { id: 'contact', label: 'LIÊN HỆ', icon: '' }
]

const contentData = {
  latest: [
    {
      title: 'Sản phẩm mới về: Figure Naruto Shippuden',
      date: '15/04/2026',
      readTime: '3 phút đọc',
      tag: 'New Arrival',
      excerpt: 'Bộ sưu tập figure Naruto mới nhất bản giới hạn đã chính thức cập bến tại cửa hàng với độ chi tiết cực cao, nước sơn sắc nét và giá cực ưu đãi.',
      image: 'https://images.unsplash.com/photo-1578632767115-351597cf2477?w=500&q=80'
    },
    {
      title: 'Bộ sưu tập Figure Jujutsu Kaisen Sức Mạnh Nguyền Hồn',
      date: '14/04/2026',
      readTime: '4 phút đọc',
      tag: 'Hot Item',
      excerpt: 'Các figure nhân vật chính như Gojo Satoru, Itadori Yuji từ anime bom tấn Jujutsu Kaisen đã có mặt đầy đủ, cam kết chính hãng với mức giá hợp lý.',
      image: 'https://images.unsplash.com/photo-1607604276583-eef5d076aa5f?w=500&q=80'
    },
    {
      title: 'Khai trương hệ thống cửa hàng Online - Giao hàng toàn quốc',
      date: '13/04/2026',
      readTime: '2 phút đọc',
      tag: 'Thông Báo',
      excerpt: 'Shop Của Ngọc chính thức vận hành hệ thống website mua sắm online thế hệ mới. Đặt hàng dễ dàng, thanh toán linh hoạt và ship COD an toàn.',
      image: 'https://images.unsplash.com/photo-1601924994987-69e26d50dc26?w=500&q=80'
    }
  ],
  reviews: [
    {
      title: 'Review chi tiết: Mô hình Kimetsu no Yaiba Nezuko Kamado',
      date: '12/04/2026',
      readTime: '6 phút đọc',
      tag: 'Đánh Giá',
      excerpt: 'Đánh giá chuyên sâu về bộ mô hình Nezuko từ thiết kế bục nền, hiệu ứng chiêu thức cho tới chất liệu nhựa PVC cao cấp chống phai màu.',
      image: 'https://images.unsplash.com/photo-1563089145-599997674d42?w=500&q=80'
    },
    {
      title: 'Phân tích Figure One Piece Luffy Gear 5 "Thần Mặt Trời"',
      date: '11/04/2026',
      readTime: '5 phút đọc',
      tag: 'Phân Tích',
      excerpt: 'Đón đầu xu hướng với bài phân tích chi tiết phiên bản mô hình Luffy Gear 5. Trọng lượng đầm tay, hiệu ứng mây khói sắc sảo.',
      image: 'https://images.unsplash.com/photo-1551269901-5c5e14c25df7?w=500&q=80'
    },
    {
      title: 'Bí quyết chọn lựa: Nên mua Figure chất liệu PVC hay Resin?',
      date: '10/04/2026',
      readTime: '7 phút đọc',
      tag: 'Hướng Dẫn',
      excerpt: 'Hướng dẫn toàn tập giúp phân biệt hai loại chất liệu phổ biến nhất trong giới sưu tầm. Cách bảo quản tốt nhất.',
      image: 'https://images.unsplash.com/photo-1542751371-adc38448a05e?w=500&q=80'
    }
  ],
  events: [
    {
      title: 'Đại Tiệc Ưu Đãi: Giảm giá lên tới 50% toàn bộ sản phẩm',
      date: '10/04/2026',
      tag: 'Khuyến Mãi',
      excerpt: 'Chào mừng mùa lễ hội, Shop Của Ngọc mang đến chương trình tri ân cực khủng. Cơ hội sở hữu các mẫu mô hình đỉnh cao với nửa giá.',
      image: 'https://images.unsplash.com/photo-1511556532299-8f662fc26c06?w=500&q=80'
    },
    {
      title: 'Giờ Vàng Flash Sale: Mua 2 Mô Hình Tặng Ngay 1 Chibi',
      date: '09/04/2026',
      tag: 'Flash Sale',
      excerpt: 'Áp dụng duy nhất cho các đơn hàng đặt trực tiếp tại website trong tuần này. Sưu tầm càng nhiều, quà tặng kèm theo càng chất lượng!',
      image: 'https://images.unsplash.com/photo-1472851294608-062f824d29cc?w=500&q=80'
    },
    {
      title: 'Offline Event: Gặp Gỡ & Giao Lưu Cộng Đồng Fan Anime Hà Nội',
      date: '08/04/2026',
      tag: 'Sự Kiện',
      excerpt: 'Buổi gặp gỡ thân mật dành riêng cho anh em có niềm đam mê Figures tại Hà Nội. Tham gia mini-game nhận quà miễn phí.',
      image: 'https://images.unsplash.com/photo-1511671782779-c97d3d27a1d4?w=500&q=80'
    }
  ]
}

const filteredContent = computed(() => {
  return contentData[activeSection.value] || []
})

onMounted(() => {
  const section = route.query.section
  if (section && typeof section === 'string') {
    activeSection.value = section
  }
})

const getSectionTitle = () => {
  const titles = {
    'latest': 'Trung Tâm Tin Tức & Xu Hướng',
    'reviews': 'Góc Nhìn Chuyên Gia & Review',
    'events': 'Ưu Đãi Độc Quyền & Sự Kiện',
    'contact': 'Kết Nối Với Chúng Tôi'
  }
  return titles[activeSection.value] || 'Tin Tức Figure'
}

const getSectionDescription = () => {
  const descriptions = {
    'latest': 'Nơi cập nhật nhanh nhất các xu hướng, sản phẩm mô hình Anime/Manga hot nhất toàn cầu.',
    'reviews': 'Các bài đánh giá khách quan, chi tiết giúp bạn chọn lựa được mẫu Figure xứng đáng nhất.',
    'events': 'Đừng bỏ lỡ các chương trình giảm giá sốc, mini-game nhận quà và lịch offline cực vui.',
    'contact': 'Mọi thắc mắc hay yêu cầu đặt hàng, hãy gửi tin nhắn ngay để đội ngũ Shop hỗ trợ bạn!'
  }
  return descriptions[activeSection.value] || ''
}

const handleSubmit = () => {
  alert(`Cảm ơn ${formData.value.name}! Ngọc đã nhận được tin nhắn và sẽ gọi lại qua số ${formData.value.phone} nhé!`)
  formData.value = { name: '', phone: '', email: '', message: '' }
}
</script>

<style scoped>
.news-page {
  max-width: 1200px;
  margin: 0 auto;
  padding: 40px 20px;
  font-family: 'Segoe UI', Roboto, sans-serif;
  background-color: #f8fafc;
}

.page-header {
  background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
  border-radius: 20px;
  padding: 60px 20px;
  text-align: center;
  color: white;
  margin-bottom: 40px;
}

.page-header h1 {
  font-size: 36px;
  font-weight: 800;
  margin-bottom: 12px;
}

.page-header p {
  font-size: 16px;
  opacity: 0.9;
  max-width: 600px;
  margin: 0 auto;
}

.news-tabs-container {
  display: flex;
  justify-content: center;
  margin-bottom: 40px;
}

.news-tabs {
  display: flex;
  background: white;
  padding: 6px;
  border-radius: 12px;
  box-shadow: 0 4px 12px rgba(0,0,0,0.05);
  gap: 4px;
}

.tab {
  padding: 12px 28px;
  background: transparent;
  border: none;
  color: #64748b;
  font-weight: 600;
  font-size: 15px;
  cursor: pointer;
  border-radius: 8px;
  transition: all 0.25s ease;
  display: flex;
  align-items: center;
  gap: 8px;
}

.tab:hover {
  color: #667eea;
  background-color: #f1f5f9;
}

.tab.active {
  color: white;
  background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
}

.news-grid {
  display: grid;
  grid-template-columns: repeat(auto-fill, minmax(340px, 1fr));
  gap: 30px;
}

.news-item {
  background: white;
  border-radius: 16px;
  overflow: hidden;
  box-shadow: 0 4px 6px rgba(0,0,0,0.05);
  transition: transform 0.3s ease, box-shadow 0.3s ease;
  display: flex;
  flex-direction: column;
}

.news-item:hover {
  transform: translateY(-8px);
  box-shadow: 0 20px 25px rgba(0,0,0,0.1);
}

.news-image {
  width: 100%;
  height: 220px;
  position: relative;
}

.news-image img {
  width: 100%;
  height: 100%;
  object-fit: cover;
}

.badge {
  position: absolute;
  top: 15px;
  left: 15px;
  padding: 6px 14px;
  border-radius: 20px;
  font-size: 12px;
  font-weight: 700;
  color: white;
}
.badge.latest { background-color: #ef4444; }
.badge.reviews { background-color: #eab308; color: black; }
.badge.events { background-color: #10b981; }

.news-body {
  padding: 24px;
  display: flex;
  flex-direction: column;
  flex-grow: 1;
}

.meta-info {
  display: flex;
  gap: 15px;
  font-size: 13px;
  color: #94a3b8;
  margin-bottom: 12px;
}

.news-title {
  color: #1e293b;
  font-size: 19px;
  font-weight: 700;
  margin-bottom: 12px;
}

.news-excerpt {
  color: #475569;
  font-size: 14px;
  line-height: 1.6;
  margin-bottom: 20px;
}

.read-more-btn {
  margin-top: auto;
  color: #667eea;
  text-decoration: none;
  font-weight: 700;
  display: inline-flex;
  align-items: center;
  gap: 6px;
}

.contact-grid {
  display: grid;
  grid-template-columns: 1fr 1.3fr;
  gap: 40px;
}

.contact-card {
  background: white;
  border-radius: 20px;
  padding: 40px;
  box-shadow: 0 10px 15px rgba(0,0,0,0.05);
}

.info-card {
  background: linear-gradient(180deg, #1e293b 0%, #0f172a 100%);
  color: white;
}

.contact-subtext {
  color: #94a3b8;
  font-size: 14px;
  margin-bottom: 35px;
}

.contact-info {
  display: flex;
  flex-direction: column;
  gap: 25px;
}

.info-item {
  display: flex;
  align-items: center;
  gap: 20px;
}

.icon-box {
  width: 48px;
  height: 48px;
  background: rgba(255, 255, 255, 0.1);
  border-radius: 12px;
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 20px;
}

.info-item strong {
  display: block;
  font-size: 13px;
  color: #94a3b8;
}

.info-item p, .info-item a {
  color: #f1f5f9;
  font-size: 15px;
  text-decoration: none;
}

.premium-form {
  display: flex;
  flex-direction: column;
  gap: 20px;
}

.form-row {
  display: grid;
  grid-template-columns: 1fr 1fr;
  gap: 20px;
}

.form-group {
  display: flex;
  flex-direction: column;
  gap: 8px;
}

.form-group label {
  font-size: 14px;
  font-weight: 600;
  color: #475569;
}

.form-group input, .form-group textarea {
  padding: 12px 16px;
  border: 1px solid #cbd5e1;
  border-radius: 10px;
  background-color: #f8fafc;
}

.form-group input:focus, .form-group textarea:focus {
  outline: none;
  border-color: #667eea;
  background-color: white;
}

.submit-btn {
  background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
  color: white;
  padding: 14px;
  border: none;
  border-radius: 10px;
  font-weight: 700;
  cursor: pointer;
}

@media (max-width: 968px) {
  .contact-grid { grid-template-columns: 1fr; }
}
@media (max-width: 576px) {
  .form-row { grid-template-columns: 1fr; }
}
</style>