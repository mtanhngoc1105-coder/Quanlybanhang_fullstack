<template>
  <div class="product-detail-page">
    <div class="top-bar">
      <router-link to="/shop" class="back-link">← Quay lại cửa hàng</router-link>
    </div>

    <div class="detail-panel">
      <div class="gallery-panel">
        <div class="main-image">
          <img :src="selectedImage" :alt="product.product_name || 'Sản phẩm'" />
        </div>
        <div class="thumb-list">
          <button
            v-for="(img, index) in galleryImages"
            :key="index"
            :class="['thumb-button', { active: selectedImage === img }]"
            @click="selectedImage = img"
          >
            <img :src="img" :alt="`Ảnh ${index + 1}`" />
          </button>
        </div>
      </div>

      <div class="info-panel">
        <div class="badge-row">
          <span class="badge-stock" :class="productInStock ? 'available' : 'soldout'">
            {{ productInStock ? 'Còn hàng' : 'Hết hàng' }}
          </span>
          <span class="badge-category">{{ categoryName }}</span>
        </div>

        <h1 class="product-title">{{ product.product_name || 'Sản phẩm' }}</h1>
        <p class="product-price">{{ formatPrice(product.price) }} đ</p>
        <p class="short-description">{{ product.description || 'Mô tả ngắn đang cập nhật.' }}</p>

        <div class="feature-list">
          <div><strong>Kích thước:</strong> {{ product.size || 'Đang cập nhật' }}</div>
          <div><strong>Chất liệu:</strong> {{ product.material || 'PVC / ABS' }}</div>
          <div><strong>Hãng sản xuất:</strong> {{ product.brand || 'Anime Nei Store' }}</div>
          <div><strong>SKU:</strong> {{ product.sku || `SP${product.id || '000'}` }}</div>
        </div>

        <div class="quantity-box">
          <div class="quantity-label">Số lượng</div>
          <div class="quantity-control">
            <button @click="decrementQuantity" class="qty-btn">-</button>
            <input
              type="number"
              min="1"
              :value="quantity"
              @input="onQuantityInput($event)"
            />
            <button @click="incrementQuantity" class="qty-btn">+</button>
          </div>
        </div>

        <div class="action-buttons">
          <button class="btn btn-add" :disabled="!productInStock" @click="addToCart">
            🛒 Thêm vào giỏ hàng
          </button>
          <button class="btn btn-buy" :disabled="!productInStock" @click="buyNow">
            ⚡ Mua ngay
          </button>
        </div>

        <div v-if="toastMessage" class="toast-notice">{{ toastMessage }}</div>
      </div>
    </div>

    <div class="tabs-panel">
      <div class="tab-buttons">
        <button :class="{ active: selectedTab === 'description' }" @click="selectedTab = 'description'">
          Mô tả chi tiết
        </button>
        <button :class="{ active: selectedTab === 'specs' }" @click="selectedTab = 'specs'">
          Thông số kỹ thuật
        </button>
        <button :class="{ active: selectedTab === 'warranty' }" @click="selectedTab = 'warranty'">
          Chính sách bảo hành
        </button>
      </div>

      <div class="tab-content">
        <div v-if="selectedTab === 'description'">
          <h3>Mô tả chi tiết</h3>
          <p>{{ product.long_description || defaultDescription }}</p>
        </div>
        <div v-else-if="selectedTab === 'specs'">
          <h3>Thông số kỹ thuật</h3>
          <ul>
            <li><strong>Chất liệu:</strong> {{ product.material || 'PVC / ABS' }}</li>
            <li><strong>Kích thước:</strong> {{ product.size || 'Đang cập nhật' }}</li>
            <li><strong>Trọng lượng:</strong> {{ product.weight || 'Không xác định' }}</li>
            <li><strong>Thương hiệu:</strong> {{ product.brand || 'Anime Nei Store' }}</li>
            <li><strong>Loại sản phẩm:</strong> {{ product.category?.name || categoryName || 'Mô hình / Phụ kiện' }}</li>
          </ul>
        </div>
        <div v-else>
          <h3>Chính sách bảo hành</h3>
          <p>
            Sản phẩm được bảo hành 7 ngày lỗi kỹ thuật. Miễn phí đổi trả trong 3 ngày nếu sản phẩm bị vỡ, thiếu phụ kiện hoặc lỗi nhà sản xuất.
            Vui lòng giữ lại hóa đơn và bao bì khi liên hệ bảo hành.
          </p>
        </div>
      </div>
    </div>

    <div class="related-section" v-if="relatedProducts.length > 0">
      <h2>Sản phẩm liên quan</h2>
      <div class="related-grid">
        <div class="related-card" v-for="item in relatedProducts" :key="item.id">
          <router-link :to="`/products/${item.id}`" class="related-image">
            <img :src="item.image || '/images/product/default.jpg'" :alt="item.product_name" />
          </router-link>
          <div class="related-info">
            <router-link :to="`/products/${item.id}`" class="related-title">{{ item.product_name }}</router-link>
            <div class="related-price">{{ formatPrice(item.price) }} đ</div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, computed, onMounted, watch } from "vue"
import { useRoute, useRouter } from "vue-router"
import { getProduct } from "../../services/productService"
import { addToCartService } from "../../services/cartService.js"
import { mockProducts } from "../../data/mockProducts"

const route = useRoute()
const router = useRouter()
const product = ref({})
const quantity = ref(1)
const selectedTab = ref("description")
const toastMessage = ref("")
const selectedImage = ref("")
const relatedProducts = ref([])

const defaultDescription =
  "Sản phẩm chất lượng cao, phù hợp làm quà tặng hoặc trang trí bộ sưu tập. Thông tin chi tiết sẽ được cập nhật đầy đủ khi có sẵn."

const formatPrice = (value) => {
  return new Intl.NumberFormat("vi-VN").format(value || 0)
}

const productInStock = computed(() => {
  return Number(product.value.quantity || 0) > 0
})

const categoryName = computed(() => {
  return product.value.category?.name || product.value.category || getCategoryNameFromMock(product.value.id) || "Sản phẩm"
})

const galleryImages = computed(() => {
  const image = product.value.image ? [product.value.image] : ["/images/product/default.jpg"]
  if (product.value.images && Array.isArray(product.value.images) && product.value.images.length) {
    return product.value.images
  }
  if (image.length === 1) {
    return [...image, ...Array(3).fill(image[0])] // duplicate so gallery looks rich
  }
  return image
})

const setInitialImage = () => {
  selectedImage.value = galleryImages.value[0] || "/images/product/default.jpg"
}

const findMockProduct = (id) => {
  const numericId = Number(id)
  for (const slug in mockProducts) {
    const found = mockProducts[slug].find((item) => Number(item.id) === numericId)
    if (found) {
      return { product: found, categorySlug: slug }
    }
  }
  return null
}

const getCategoryNameFromMock = (id) => {
  const found = findMockProduct(id)
  return found ? slugToName(found.categorySlug) : "Sản phẩm"
}

const slugToName = (slug) => {
  const mapping = {
    "mo-hinh-pvc": "MÔ HÌNH PVC",
    "mo-hinh-resin": "MÔ HÌNH RESIN",
    "hang-dat-truoc": "HÀNG ĐẶT TRƯỚC",
    "hang-sap-xuat": "HÀNG SẮP XUẤT",
    "san-pham-noi-bat": "SẢN PHẨM NỔI BẬT",
    "ao-phong": "ÁO PHÔNG",
    "mu-non": "MŨ / NÓN",
    "phu-kien": "PHỤ KIỆN",
  }
  return mapping[slug] || "Sản phẩm"
}

const loadProduct = async () => {
  const id = route.params.id
  try {
    const response = await getProduct(id)
    product.value = response.data?.data || response.data || {}
  } catch (error) {
    const fallback = findMockProduct(id)
    product.value = fallback?.product || {}
  }
  setInitialImage()
  loadRelatedProducts()
}

const loadRelatedProducts = () => {
  const fallback = findMockProduct(product.value.id)
  const categorySlug = product.value.category?.slug || fallback?.categorySlug
  const source = categorySlug ? mockProducts[categorySlug] : Object.values(mockProducts).flat()
  relatedProducts.value = source
    .filter((item) => item.id !== product.value.id)
    .slice(0, 6)
}

const incrementQuantity = () => {
  quantity.value += 1
}

const decrementQuantity = () => {
  if (quantity.value > 1) {
    quantity.value -= 1
  }
}

const onQuantityInput = (event) => {
  const value = Number(event.target.value)
  quantity.value = value < 1 || Number.isNaN(value) ? 1 : Math.floor(value)
}

const addToCart = () => {
  addToCartService(product.value, quantity.value)
  toastMessage.value = "Đã thêm vào giỏ hàng"
  setTimeout(() => {
    toastMessage.value = ""
  }, 2000)
}

const buyNow = () => {
  addToCartService(product.value, quantity.value)
  router.push("/checkout")
}

watch(
  () => route.params.id,
  async () => {
    quantity.value = 1
    selectedTab.value = "description"
    await loadProduct()
  }
)

onMounted(async () => {
  await loadProduct()
})
</script>

<style scoped>
.product-detail-page {
  max-width: 1180px;
  margin: 0 auto;
  padding: 24px 20px;
}

.top-bar {
  margin-bottom: 22px;
}

.back-link {
  color: #2563eb;
  font-weight: 600;
  text-decoration: none;
}

.detail-panel {
  display: grid;
  grid-template-columns: 1.2fr 1fr;
  gap: 30px;
  margin-bottom: 36px;
}

.gallery-panel {
  background: #fff;
  border-radius: 24px;
  padding: 24px;
  box-shadow: 0 16px 32px rgba(15, 23, 42, 0.08);
}

.main-image {
  border-radius: 24px;
  overflow: hidden;
  background: #f7f8fb;
  margin-bottom: 18px;
}

.main-image img {
  width: 100%;
  height: 460px;
  object-fit: contain;
}

.thumb-list {
  display: flex;
  gap: 12px;
  flex-wrap: wrap;
}

.thumb-button {
  width: 80px;
  height: 80px;
  border: 1px solid #d1d5db;
  border-radius: 16px;
  overflow: hidden;
  padding: 0;
  background: white;
  cursor: pointer;
}

.thumb-button.active {
  border-color: #2563eb;
}

.thumb-button img {
  width: 100%;
  height: 100%;
  object-fit: cover;
}

.info-panel {
  background: #fff;
  border-radius: 24px;
  padding: 28px;
  box-shadow: 0 16px 32px rgba(15, 23, 42, 0.08);
}

.badge-row {
  display: flex;
  gap: 10px;
  flex-wrap: wrap;
  margin-bottom: 18px;
}

.badge-stock,
.badge-category {
  padding: 10px 14px;
  border-radius: 999px;
  font-weight: 700;
  font-size: 13px;
}

.badge-stock.available {
  background: #dcfce7;
  color: #166534;
}

.badge-stock.soldout {
  background: #fee2e2;
  color: #b91c1c;
}

.badge-category {
  background: #eff6ff;
  color: #1d4ed8;
}

.product-title {
  font-size: 34px;
  line-height: 1.1;
  margin-bottom: 14px;
}

.product-price {
  font-size: 30px;
  color: #dc2626;
  font-weight: 800;
  margin-bottom: 18px;
}

.short-description {
  color: #374151;
  margin-bottom: 22px;
}

.feature-list {
  display: grid;
  gap: 12px;
  margin-bottom: 24px;
  color: #4b5563;
}

.feature-list div {
  display: flex;
  justify-content: space-between;
}

.quantity-box {
  margin-bottom: 22px;
}

.quantity-label {
  margin-bottom: 10px;
  font-weight: 700;
}

.quantity-control {
  display: flex;
  align-items: center;
  gap: 10px;
  width: max-content;
}

.qty-btn {
  width: 46px;
  height: 46px;
  border: 1px solid #d1d5db;
  border-radius: 14px;
  background: white;
  font-size: 20px;
  cursor: pointer;
}

.quantity-control input {
  width: 78px;
  height: 46px;
  text-align: center;
  border: 1px solid #d1d5db;
  border-radius: 14px;
  font-size: 16px;
}

.action-buttons {
  display: flex;
  gap: 14px;
  flex-wrap: wrap;
}

.btn {
  border: none;
  border-radius: 16px;
  padding: 16px 22px;
  font-size: 15px;
  font-weight: 700;
  cursor: pointer;
}

.btn-add {
  background: #1f2937;
  color: white;
  flex: 1;
}

.btn-buy {
  background: #f97316;
  color: white;
  flex: 1;
}

.toast-notice {
  margin-top: 18px;
  color: #047857;
  font-weight: 700;
}

.tabs-panel {
  background: #fff;
  border-radius: 24px;
  padding: 24px;
  box-shadow: 0 16px 32px rgba(15, 23, 42, 0.08);
  margin-bottom: 32px;
}

.tab-buttons {
  display: flex;
  gap: 14px;
  flex-wrap: wrap;
  margin-bottom: 22px;
}

.tab-buttons button {
  background: #f3f4f6;
  border: none;
  border-radius: 14px;
  padding: 12px 18px;
  cursor: pointer;
  font-weight: 700;
}

.tab-buttons button.active {
  background: #2563eb;
  color: white;
}

.tab-content h3 {
  font-size: 20px;
  margin-bottom: 14px;
}

.tab-content p,
.tab-content ul {
  color: #4b5563;
  line-height: 1.8;
}

.tab-content ul {
  list-style: disc;
  margin-left: 22px;
}

.related-section h2 {
  font-size: 24px;
  margin-bottom: 18px;
}

.related-grid {
  display: grid;
  grid-template-columns: repeat(3, minmax(0, 1fr));
  gap: 18px;
}

.related-card {
  background: white;
  border-radius: 22px;
  padding: 16px;
  box-shadow: 0 12px 28px rgba(15, 23, 42, 0.06);
}

.related-image img {
  width: 100%;
  height: 160px;
  object-fit: cover;
  border-radius: 18px;
}

.related-info {
  margin-top: 12px;
}

.related-title {
  display: block;
  font-weight: 700;
  color: #111827;
  text-decoration: none;
  margin-bottom: 8px;
}

.related-price {
  color: #dc2626;
  font-weight: 700;
}

@media (max-width: 1120px) {
  .detail-panel {
    grid-template-columns: 1fr;
  }

  .related-grid {
    grid-template-columns: 1fr 1fr;
  }
}

@media (max-width: 740px) {
  .related-grid {
    grid-template-columns: 1fr;
  }

  .main-image img {
    height: 320px;
  }
}
</style>
