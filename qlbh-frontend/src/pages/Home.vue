<template>
  <div class="home">
    <!-- Hero Section -->
    <section class="hero">
      <div class="slider-shell">
        <div class="slides">
          <div
            v-for="(slide, index) in slides"
            :key="slide.src"
            :class="['slide', { active: index === currentSlide } ]"
          >
            <img :src="slide.src" :alt="slide.alt" />
          </div>
        </div>
        <div class="slider-indicators">
          <button
            v-for="(_, index) in slides"
            :key="index"
            :class="['indicator', { active: index === currentSlide } ]"
            @click="currentSlide = index"
            aria-label="Chuyển slide"
          ></button>
        </div>
      </div>
    </section>

    <!-- Featured Products -->
    <section class="featured-products">
      <div class="section-header">
        <h2>Sản phẩm nổi bật</h2>
        <p>Những lựa chọn mô hình anime tốt nhất đang được ưu đãi</p>
      </div>

      <div v-if="loading" class="loader">
        <p>Đang tải sản phẩm...</p>
      </div>

      <div v-if="error" class="error-message">
        <p>{{ error }}</p>
      </div>

      <div v-if="products.length > 0" class="products-grid">
        <div v-for="product in products" :key="product.id" class="product-card">
          <router-link :to="`/products/${product.id}`" class="image-wrap">
            <img :src="getProductImage(product)" :alt="product.product_name" />
          </router-link>
          <div class="content">
            <h3>{{ product.product_name || 'Mô hình anime' }}</h3>
            <p>{{ product.description ? truncateText(product.description, 70) : 'Mô hình anime chất lượng cao.' }}</p>
            <div class="actions">
              <span class="price">{{ formatPrice(product.price || 0) }} đ</span>
              <button class="btn" @click="addToCart(product)">🛒 Thêm vào giỏ</button>
            </div>
          </div>
        </div>
      </div>

      <div v-if="!loading && products.length === 0" class="empty-grid">
        <p>Không có sản phẩm nào. Quay lại sau nhé.</p>
      </div>
    </section>

    <!-- Info Section -->
    <section class="info-grid">
      <div class="info-card">
        <span class="info-icon">🚚</span>
        <strong>Miễn phí giao hàng</strong> cho đơn trên 299k.
      </div>
      <div class="info-card">
        <span class="info-icon">⏰</span>
        <strong>Giao hàng nhanh</strong> trong 1-2 ngày.
      </div>
      <div class="info-card">
        <span class="info-icon">🔄</span>
        <strong>Đổi trả trong 30 ngày</strong> nhanh chóng.
      </div>
      <div class="info-card">
        <span class="info-icon">✅</span>
        <strong>100% chính hãng</strong> có bảo hành.
      </div>
    </section>

    <div class="chat-float">
      <button class="chat-toggle" @click="toggleChat" aria-label="Mở chat hỗ trợ">
        <span>💬</span>
      </button>

      <div v-show="chatOpen" class="chat-box" role="dialog" aria-label="Chat hỗ trợ khách hàng">
        <div class="chat-header">
          <div>
            <strong>Anime Assistant</strong>
            <p>Tư vấn sản phẩm, giá và quà tặng anime.</p>
          </div>
          <button class="chat-close" @click="toggleChat" aria-label="Đóng chat">✕</button>
        </div>

        <div class="chat-body">
          <div
            v-for="(message, index) in chatMessages"
            :key="index"
            :class="['message', message.role]"
          >
            <div class="message-text">{{ message.text }}</div>
          </div>
          <div v-if="isTyping" class="typing-indicator">
            <span></span><span></span><span></span>
            <span>Anime Assistant đang trả lời...</span>
          </div>
        </div>

        <div class="chat-suggestions">
          <button
            v-for="(reply, index) in quickReplies"
            :key="index"
            type="button"
            @click="sendQuickReply(reply)"
          >
            {{ reply }}
          </button>
        </div>

        <div class="chat-input">
          <input
            type="text"
            v-model="userInput"
            placeholder="Nhập câu hỏi của bạn..."
            @keydown.enter.prevent="sendMessage"
            aria-label="Nhập tin nhắn chat"
          />
          <button type="button" @click="sendMessage" aria-label="Gửi tin nhắn">
            Gửi
          </button>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted, onUnmounted, nextTick } from "vue"
import { useRouter } from "vue-router"
import { getProducts } from "../services/productService"
import { addToCartService } from "../services/cartService.js"

const router = useRouter()

const products = ref([])
const loading = ref(true)
const error = ref("")
const slides = ref([
  { src: "/images/slide/anh1.jpg", alt: "Ảnh slide 1" },
  { src: "/images/slide/anh2.jpg", alt: "Ảnh slide 2" },
  { src: "/images/slide/anh3.jpg", alt: "Ảnh slide 3" },
  { src: "/images/slide/anh4.jpg", alt: "Ảnh slide 4" },
])
const currentSlide = ref(0)
const slideTimer = ref(null)
const chatOpen = ref(false)
const userInput = ref("")
const isTyping = ref(false)
const quickReplies = ref([
  'Tư vấn mô hình nổi bật',
  'Hỏi giá sản phẩm',
  'Mẫu One Piece hot',
  'Thời gian giao hàng'
])
const chatMessages = ref([
  {
    role: "bot",
    text: "Xin chào 👋 tôi có thể tư vấn mô hình anime, đánh giá sản phẩm và ưu đãi hiện có."
  }
])

const toggleChat = () => {
  chatOpen.value = !chatOpen.value
  if (chatOpen.value) {
    nextTick(() => {
      const input = document.querySelector('.chat-input input')
      input?.focus()
    })
  }
}

const addMessage = (role, text) => {
  chatMessages.value.push({ role, text })
  nextTick(() => {
    const el = document.querySelector('.chat-body')
    if (el) el.scrollTop = el.scrollHeight
  })
}

const sendQuickReply = (text) => {
  userInput.value = text
  sendMessage()
}

const sendMessage = () => {
  const text = userInput.value.trim()
  if (!text) return

  addMessage('user', text)
  userInput.value = ''
  isTyping.value = true

  const lower = text.toLowerCase()
  let reply = 'Xin lỗi tôi chưa hiểu 😅 Hãy thử hỏi về Naruto, One Piece, Gundam hoặc giá sản phẩm.'

  if (lower.includes('naruto') || lower.includes('sasuke') || lower.includes('kakashi')) {
    reply = 'Shop có mô hình Naruto, Sasuke, Kakashi và phụ kiện ninja cực ngầu 🔥'
  } else if (lower.includes('giá') || lower.includes('giá cả') || lower.includes('tốn')) {
    reply = 'Mô hình có giá từ 200k đến 2 triệu tùy mẫu, mình giúp bạn chọn ngay nhé.'
  } else if (lower.includes('one piece') || lower.includes('luffy') || lower.includes('zoro') || lower.includes('sanji')) {
    reply = 'Hiện có Luffy Gear 5, Zoro, Sanji và nhiều siêu phẩm One Piece 😆'
  } else if (lower.includes('gundam') || lower.includes('mg') || lower.includes('rg')) {
    reply = 'Có nhiều mẫu Gundam MG, RG, phù hợp bộ sưu tập và quà tặng.'
  } else if (lower.includes('tư vấn') || lower.includes('mô hình') || lower.includes('anime')) {
    reply = 'Bạn đang tìm mô hình theo nhân vật hay theo chủ đề? Mình có thể tư vấn mẫu hot ngay.'
  }

  setTimeout(() => {
    addMessage('bot', reply)
    isTyping.value = false
  }, 650)
}

const startSlideShow = () => {
  stopSlideShow()
  slideTimer.value = setInterval(() => {
    currentSlide.value = (currentSlide.value + 1) % slides.value.length
  }, 4000)
}

const stopSlideShow = () => {
  if (slideTimer.value) {
    clearInterval(slideTimer.value)
    slideTimer.value = null
  }
}


const loadProducts = async () => {
  loading.value = true
  error.value = ""

  try {
    const res = await getProducts({ page: 1 })
    const apiData = res.data

    console.log("FULL API =", apiData)

    //  Laravel pagination chuẩn
    if (apiData.data && apiData.data.data) {
      products.value = apiData.data.data
    }
    // fallback nếu API trả mảng trực tiếp
    else if (Array.isArray(apiData.data)) {
      products.value = apiData.data
    }
    else if (Array.isArray(apiData)) {
      products.value = apiData
    }
    else {
      products.value = []
    }

    console.log("FINAL PRODUCTS =", products.value)

  } catch (err) {
    console.error(err)
    error.value = "Không thể tải sản phẩm. Vui lòng thử lại sau."
  } finally {
    loading.value = false
  }
}

const getProductImage = (product) => {
  if (product.image) return product.image

  const normalize = (text) =>
    text
      .toLowerCase()
      .normalize("NFD")
      .replace(/\p{Diacritic}/gu, "")
      .replace(/[^a-z0-9\s]/g, "")
      .trim()

  const name = normalize(product.product_name || "")

  const imageMap = {
    "one piece": "/images/product/one piece.jpg",
    "hastune miku": "/images/product/hastune miku.jpg",
    "tanjiro": "/images/product/kamdo tanjiro.jpg",
    "shinobu": "/images/product/kochou shinobu.jpg",
    "naruto": "/images/product/naruto.jpg",
    "giyuu": "/images/product/tomioka giyuu.jpg",
  }

  for (const key in imageMap) {
    if (name.includes(key)) {
      return imageMap[key]
    }
  }

  //  ẢNH MẶC ĐỊNH LOCAL nếu API không có ảnh hoặc tên không khớp
  return "/images/product/default.jpg"
}
const formatPrice = (value) => {
  return new Intl.NumberFormat("vi-VN").format(value)
}

const truncateText = (text, length) => {
  if (!text) return ""
  return text.length > length ? `${text.substring(0, length)}...` : text
}

const addToCart = (product) => {
  addToCartService(product)
  alert(`${product.product_name || 'Mô hình anime'} đã được thêm vào giỏ hàng`)
}

const goToCategory = (categoryId) => {
  router.push('/shop')
}

onMounted(() => {
  loadProducts()
  startSlideShow()
})

onUnmounted(() => {
  stopSlideShow()
})
</script>

<style scoped>
.home {
  width: 100%;
}

/* Hero Section */
.hero {
  margin-bottom: 20px;
  border-radius: 16px;
  overflow: hidden;
}

.slider-shell {
  width: 100%;
  border-radius: 16px;
  overflow: hidden;
  box-shadow: 0 18px 45px rgba(15, 40, 95, 0.12);
  background: #000;
  position: relative;
}

.slides {
  position: relative;
  width: 100%;
  padding-bottom: 45%;
}

.slide {
  position: absolute;
  inset: 0;
  opacity: 0;
  transform: scale(0.98);
  transition: opacity 0.7s ease, transform 0.7s ease;
}

.slide.active {
  opacity: 1;
  transform: scale(1);
  z-index: 1;
}

.slide img {
  width: 100%;
  height: 100%;
  object-fit: cover;
  display: block;
}

.slider-indicators {
  position: absolute;
  left: 50%;
  bottom: 16px;
  transform: translateX(-50%);
  display: flex;
  gap: 10px;
  padding: 0 12px;
  z-index: 10;
}

.indicator {
  width: 12px;
  height: 12px;
  border-radius: 999px;
  border: 1px solid rgba(255, 255, 255, 0.75);
  background: rgba(255, 255, 255, 0.18);
  cursor: pointer;
  transition: width 0.25s ease, background 0.25s ease;
}

.indicator.active {
  width: 18px;
  background: rgba(255, 255, 255, 0.95);
  border-color: transparent;
}

/* Featured Products */
.featured-products {
  margin-bottom: 20px;
}

.section-header {
  margin-bottom: 15px;
}

.section-header h2 {
  font-size: 28px;
  color: #2c3e50;
  margin-bottom: 8px;
}

.section-header p {
  color: #6c7a91;
  font-size: 16px;
}

.products-grid {
  display: grid;
  grid-template-columns: repeat(auto-fill, minmax(220px, 1fr));
  gap: 18px;
}

.product-card {
  background: white;
  border: 1px solid #e5ebf5;
  border-radius: 12px;
  overflow: hidden;
  transition: all 0.3s ease;
  box-shadow: 0 4px 10px rgba(7, 54, 86, 0.05);
}

.product-card:hover {
  transform: translateY(-8px);
  box-shadow: 0 12px 24px rgba(7, 54, 86, 0.12);
}

.image-wrap {
  display: block;
  width: 100%;
  height: 220px;
  overflow: hidden;
  background: #f5f7fa;
}

.image-wrap img {
  width: 100%;
  height: 100%;
  object-fit: cover;
  transition: transform 0.3s ease;
}

.product-card:hover .image-wrap img {
  transform: scale(1.05);
}

.content {
  padding: 16px;
}

.content h3 {
  font-size: 16px;
  margin-bottom: 8px;
  color: #2c3e50;
  min-height: 40px;
  font-weight: 600;
}

.content p {
  color: #77869d;
  font-size: 14px;
  margin-bottom: 12px;
  line-height: 1.4;
}

.actions {
  display: flex;
  align-items: center;
  justify-content: space-between;
  gap: 10px;
}

.price {
  color: #e74c3c;
  font-weight: 700;
  font-size: 16px;
}

.btn {
  background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
  color: white;
  border: none;
  border-radius: 8px;
  padding: 8px 12px;
  font-weight: 600;
  cursor: pointer;
  transition: all 0.2s ease;
  font-size: 14px;
}

.btn:hover {
  transform: scale(1.02);
}

.loader,
.error-message,
.empty-grid {
  padding: 30px 20px;
  text-align: center;
  color: #414a5c;
  font-size: 16px;
}

/* Info Section */
.info-grid {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
  gap: 12px;
}

.info-card {
  background: linear-gradient(135deg, #fff 0%, #f8f9fa 100%);
  border: 1px solid #e9ecef;
  border-radius: 12px;
  padding: 20px;
  font-weight: 600;
  color: #2c3e50;
  display: flex;
  align-items: center;
  gap: 12px;
  transition: all 0.3s ease;
}

.chat-float {
  position: fixed;
  right: 20px;
  bottom: 20px;
  z-index: 999;
  display: flex;
  flex-direction: column;
  align-items: flex-end;
  gap: 12px;
  font-family: inherit;
}

.chat-toggle {
  width: 60px;
  height: 60px;
  border-radius: 50%;
  border: none;
  background: linear-gradient(135deg, #ff4d6d 0%, #ff7a92 100%);
  color: white;
  font-size: 28px;
  display: flex;
  align-items: center;
  justify-content: center;
  box-shadow: 0 14px 30px rgba(255, 77, 109, 0.28);
}

.chat-box {
  width: 320px;
  min-width: 320px;
  max-width: min(92vw, 320px);
  max-height: 520px;
  background: white;
  border-radius: 24px;
  box-shadow: 0 20px 50px rgba(0, 0, 0, 0.18);
  display: flex;
  flex-direction: column;
  overflow: hidden;
  border: 1px solid rgba(113, 116, 217, 0.12);
}

.chat-header {
  display: flex;
  align-items: center;
  justify-content: space-between;
  gap: 12px;
  background: linear-gradient(135deg, #4f46e5 0%, #ec4899 100%);
  color: white;
  padding: 18px 18px 16px;
}

.chat-header strong {
  display: block;
  font-size: 16px;
  letter-spacing: 0.02em;
}

.chat-header p {
  margin: 6px 0 0;
  font-size: 13px;
  color: rgba(255, 255, 255, 0.9);
  line-height: 1.5;
}

.chat-close {
  appearance: none;
  background: rgba(255, 255, 255, 0.18);
  color: white;
  border: none;
  border-radius: 50%;
  width: 34px;
  height: 34px;
  cursor: pointer;
  font-size: 18px;
  display: inline-flex;
  align-items: center;
  justify-content: center;
}

.chat-body {
  flex: 1;
  min-width: 0;
  overflow-y: auto;
  padding: 16px;
  background: linear-gradient(180deg, #fff 0%, #f9f5f8 100%);
}

.message {
  margin-bottom: 12px;
  padding: 12px 14px;
  border-radius: 16px;
  max-width: 86%;
  overflow-wrap: anywhere;
  max-width: 86%;
  line-height: 1.5;
  word-break: break-word;
  box-shadow: 0 8px 18px rgba(24, 40, 80, 0.05);
}

.message.bot {
  background: #f1f1f1;
  color: #1f1f1f;
  align-self: flex-start;
}

.message.user {
  background: #ffd6de;
  color: #1b1b18;
  text-align: right;
  align-self: flex-end;
}

.message-text {
  white-space: pre-wrap;
}

.typing-indicator {
  display: flex;
  align-items: center;
  gap: 10px;
  padding: 12px 14px;
  background: rgba(255, 255, 255, 0.95);
  border-radius: 18px;
  width: fit-content;
  box-shadow: 0 8px 18px rgba(24, 40, 80, 0.05);
}

.typing-indicator span:first-child,
.typing-indicator span:nth-child(2),
.typing-indicator span:nth-child(3) {
  width: 8px;
  height: 8px;
  border-radius: 50%;
  background: #4f46e5;
  animation: pulse 1.2s infinite ease-in-out;
}

.typing-indicator span:nth-child(2) {
  animation-delay: 0.2s;
}

.typing-indicator span:nth-child(3) {
  animation-delay: 0.4s;
}

@keyframes pulse {
  0%, 100% { opacity: 0.3; transform: scale(0.9); }
  50% { opacity: 1; transform: scale(1.15); }
}

.chat-suggestions {
  display: flex;
  flex-wrap: wrap;
  gap: 10px;
  padding: 14px 18px 10px;
  background: #ffffff;
  border-bottom: 1px solid rgba(226, 232, 240, 0.9);
}

.chat-suggestions button {
  flex: 1 1 auto;
  min-width: 110px;
  border: 1px solid rgba(79, 70, 229, 0.18);
  background: rgba(79, 70, 229, 0.06);
  color: #4338ca;
  border-radius: 999px;
  padding: 10px 12px;
  font-size: 13px;
  cursor: pointer;
  transition: background 0.2s ease, transform 0.2s ease;
}

.chat-suggestions button:hover {
  background: rgba(79, 70, 229, 0.14);
  transform: translateY(-1px);
}

.chat-input {
  display: flex;
  min-width: 0;
  border-top: 1px solid #eee;
  background: #fff;
}

.chat-input input {
  flex: 1;
  min-width: 0;
  border: none;
  padding: 14px 16px;
  font-size: 14px;
  color: #1b1b18;
  outline: none;
  background: #f8fafc;
}

.chat-input input:focus {
  border-color: #6366f1;
  box-shadow: 0 0 0 4px rgba(99, 102, 241, 0.12);
}

.chat-input input::placeholder {
  color: #9ca3af;
}

.chat-input button {
  border: none;
  border-radius: 999px;
  padding: 12px 18px;
  background: linear-gradient(135deg, #4f46e5 0%, #ec4899 100%);
  color: white;
  padding: 0 18px;
  font-weight: 700;
  cursor: pointer;
  transition: transform 0.2s ease, box-shadow 0.2s ease;
}

.chat-input button:hover {
  transform: translateY(-1px);
  box-shadow: 0 12px 20px rgba(79, 70, 229, 0.18);
}

.chat-body::-webkit-scrollbar {
  width: 8px;
}

.chat-body::-webkit-scrollbar-thumb {
  background: rgba(0, 0, 0, 0.12);
  border-radius: 999px;
}

.chat-body::-webkit-scrollbar-track {
  background: transparent;
}

.info-card:hover {
  border-color: #667eea;
  box-shadow: 0 4px 12px rgba(102, 126, 234, 0.1);
}

.info-icon {
  font-size: 28px;
  flex-shrink: 0;
}

/* Responsive Design */
@media (max-width: 768px) {
  .categories-container {
    gap: 10px;
    padding: 0 15px;
  }

  .category-card {
    padding: 10px 12px;
  }

  .hero {
    padding: 50px 15px;
  }

  .hero-content h1 {
    font-size: 32px;
  }

  .hero-content p {
    font-size: 16px;
  }

  .products-grid {
    grid-template-columns: repeat(auto-fill, minmax(160px, 1fr));
    gap: 12px;
  }

  .image-wrap {
    height: 160px;
  }

  .section-header h2 {
    font-size: 24px;
  }

  .info-grid {
    grid-template-columns: 1fr;
  }
}
</style>
