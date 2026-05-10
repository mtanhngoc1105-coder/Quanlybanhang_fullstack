<template>
  <div class="news-page">
    <div class="page-header">
      <h1>{{ getSectionTitle() }}</h1>
      <p>{{ getSectionDescription() }}</p>
    </div>

    <!-- Navigation Tabs -->
    <div class="news-tabs">
      <button 
        v-for="tab in newsTabs" 
        :key="tab.id"
        :class="['tab', { active: activeSection === tab.id }]"
        @click="activeSection = tab.id"
      >
        {{ tab.label }}
      </button>
    </div>

    <div class="news-content">
      <!-- TIN MỚI Section -->
      <div v-if="activeSection === 'latest'" class="section">
        <div class="news-grid">
          <div class="news-item">
            <div class="news-image">
              <img src="https://via.placeholder.com/400x250?text=Tin+Tức+1" alt="Tin tức 1" />
            </div>
            <div class="news-content">
              <h3>Sản phẩm mới về: Figure Naruto</h3>
              <p class="news-date">15/04/2026</p>
              <p>Bộ sưu tập figure Naruto mới nhất đã có mặt tại cửa hàng với chất lượng cao và giá ưu đãi.</p>
            </div>
          </div>

          <div class="news-item">
            <div class="news-image">
              <img src="https://via.placeholder.com/400x250?text=Tin+Tức+2" alt="Tin tức 2" />
            </div>
            <div class="news-content">
              <h3>Bộ sưu tập Figure Jujutsu Kaisen mới</h3>
              <p class="news-date">14/04/2026</p>
              <p>Các figure nhân vật chính từ anime Jujutsu Kaisen đã có hàng, với mức giá hợp lý.</p>
            </div>
          </div>

          <div class="news-item">
            <div class="news-image">
              <img src="https://via.placeholder.com/400x250?text=Tin+Tức+3" alt="Tin tức 3" />
            </div>
            <div class="news-content">
              <h3>Khai trương cửa hàng online mới</h3>
              <p class="news-date">13/04/2026</p>
              <p>Shop Của Ngọc chính thức khai trương hệ thống mua sắm online, giao hàng toàn quốc.</p>
            </div>
          </div>
        </div>
      </div>

      <!-- REVIEW Section -->
      <div v-if="activeSection === 'reviews'" class="section">
        <div class="news-grid">
          <div class="news-item">
            <div class="news-image">
              <img src="https://via.placeholder.com/400x250?text=Review+1" alt="Review 1" />
            </div>
            <div class="news-content">
              <h3>Review: Mô hình Kimetsu no Yaiba</h3>
              <p class="news-date">12/04/2026</p>
              <p>Đánh giá chi tiết về bộ mô hình Kimetsu no Yaiba với độ tinh xảo cao và chất liệu tốt.</p>
            </div>
          </div>

          <div class="news-item">
            <div class="news-image">
              <img src="https://via.placeholder.com/400x250?text=Review+2" alt="Review 2" />
            </div>
            <div class="news-content">
              <h3>Review: Figure One Piece Luffy</h3>
              <p class="news-date">11/04/2026</p>
              <p>Phân tích chi tiết về figure Luffy từ One Piece, gồm chất lượng, chi tiết và giá cả.</p>
            </div>
          </div>

          <div class="news-item">
            <div class="news-image">
              <img src="https://via.placeholder.com/400x250?text=Review+3" alt="Review 3" />
            </div>
            <div class="news-content">
              <h3>So sánh: Figure PVC vs Resin</h3>
              <p class="news-date">10/04/2026</p>
              <p>Hướng dẫn chi tiết để bạn hiểu rõ sự khác biệt giữa figure PVC và Resin.</p>
            </div>
          </div>
        </div>
      </div>

      <!-- SỰ KIỆN Section -->
      <div v-if="activeSection === 'events'" class="section">
        <div class="news-grid">
          <div class="news-item">
            <div class="news-image">
              <img src="https://via.placeholder.com/400x250?text=Sự+Kiện+1" alt="Sự kiện 1" />
            </div>
            <div class="news-content">
              <h3>Sự kiện giảm giá 50% nhân dịp lễ</h3>
              <p class="news-date">10/04/2026</p>
              <p>Nhân dịp lễ đặc biệt, cửa hàng giảm giá 50% cho tất cả sản phẩm trong tuần này.</p>
            </div>
          </div>

          <div class="news-item">
            <div class="news-image">
              <img src="https://via.placeholder.com/400x250?text=Sự+Kiện+2" alt="Sự kiện 2" />
            </div>
            <div class="news-content">
              <h3>Flash Sale: Mua 2 tặng 1</h3>
              <p class="news-date">09/04/2026</p>
              <p>Chương trình khuyến mãi đặc biệt: mua 2 figure, tặng 1 figure miễn phí.</p>
            </div>
          </div>

          <div class="news-item">
            <div class="news-image">
              <img src="https://via.placeholder.com/400x250?text=Sự+Kiện+3" alt="Sự kiện 3" />
            </div>
            <div class="news-content">
              <h3>Offline Event: Gặp gỡ fan anime</h3>
              <p class="news-date">08/04/2026</p>
              <p>Sự kiện offline để gặp gỡ cộng đồng fan anime, giveaway và ưu đãi đặc biệt.</p>
            </div>
          </div>
        </div>
      </div>

      <!-- LIÊN HỆ Section -->
      <div v-if="activeSection === 'contact'" class="section">
        <div class="contact-section">
          <div class="contact-card">
            <h3>Liên hệ chúng tôi</h3>
            <div class="contact-info">
              <div class="info-item">
                <span class="icon"></span>
                <div>
                  <strong>Email:</strong>
                  <a href="mailto:ngocmt363@gmail.com">ngocmt363@gmail.com</a>
                </div>
              </div>
              <div class="info-item">
                <span class="icon"></span>
                <div>
                  <strong>Phone:</strong>
                  <a href="tel:0363961832">0363 961 832</a>
                </div>
              </div>
              <div class="info-item">
                <span class="icon"></span>
                <div>
                  <strong>Địa chỉ:</strong>
                  <p>Ngõ 32 Đỗ Đức Dục, Mễ Trì, Hà Nội</p>
                </div>
              </div>
              <div class="info-item">
                <span class="icon"></span>
                <div>
                  <strong>Facebook:</strong>
                  <a href="#" target="_blank">fb.com/animenei</a>
                </div>
              </div>
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
const activeSection = ref('latest')

const newsTabs = [
  { id: 'latest', label: 'TIN MỚI' },
  { id: 'reviews', label: 'REVIEW' },
  { id: 'events', label: 'SỰ KIỆN' },
  { id: 'contact', label: 'LIÊN HỆ' }
]

onMounted(() => {
  const section = route.query.section || 'latest'
  activeSection.value = section
})

const getSectionTitle = () => {
  const titles = {
    'latest': 'Tin Tức Mới',
    'reviews': 'Reviews & Đánh Giá',
    'events': 'Sự Kiện & Khuyến Mãi',
    'contact': 'Liên Hệ Chúng Tôi'
  }
  return titles[activeSection.value] || 'Tin Tức'
}

const getSectionDescription = () => {
  const descriptions = {
    'latest': 'Cập nhật những tin tức mới nhất về anime và mô hình',
    'reviews': 'Đọc các review và đánh giá chi tiết từ cộng đồng',
    'events': 'Theo dõi các sự kiện và khuyến mãi đặc biệt',
    'contact': 'Liên hệ với chúng tôi qua các kênh khác nhau'
  }
  return descriptions[activeSection.value] || ''
}
</script>

<style scoped>
.news-page {
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
.news-tabs {
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

.news-content {
  margin-top: 20px;
}

.news-grid {
  display: grid;
  grid-template-columns: repeat(auto-fill, minmax(350px, 1fr));
  gap: 30px;
}

.news-item {
  background: white;
  border-radius: 12px;
  overflow: hidden;
  box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
  transition: transform 0.3s ease;
}

.news-item:hover {
  transform: translateY(-5px);
}

.news-image {
  width: 100%;
  height: 200px;
  overflow: hidden;
}

.news-image img {
  width: 100%;
  height: 100%;
  object-fit: cover;
}

.news-content {
  padding: 20px;
}

.news-content h3 {
  color: #2c3e50;
  margin-bottom: 10px;
  font-size: 18px;
}

.news-date {
  color: #7f8c8d;
  font-size: 14px;
  margin-bottom: 10px;
}

.news-content p {
  color: #555;
  line-height: 1.6;
  margin-bottom: 15px;
}

.read-more {
  color: #667eea;
  text-decoration: none;
  font-weight: 600;
  transition: color 0.3s ease;
}

.read-more:hover {
  color: #764ba2;
}

/* Contact Section */
.contact-section {
  display: flex;
  justify-content: center;
}

.contact-card {
  background: white;
  border-radius: 12px;
  padding: 40px;
  box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
  max-width: 600px;
  width: 100%;
}

.contact-card h3 {
  color: #2c3e50;
  margin-bottom: 30px;
  font-size: 24px;
}

.contact-info {
  display: flex;
  flex-direction: column;
  gap: 20px;
}

.info-item {
  display: flex;
  align-items: flex-start;
  gap: 15px;
}

.info-item .icon {
  font-size: 24px;
  flex-shrink: 0;
}

.info-item strong {
  display: block;
  color: #2c3e50;
  margin-bottom: 5px;
}

.info-item a {
  color: #667eea;
  text-decoration: none;
  transition: color 0.3s ease;
}

.info-item a:hover {
  color: #764ba2;
}

.info-item p {
  color: #555;
  margin: 0;
}
</style>