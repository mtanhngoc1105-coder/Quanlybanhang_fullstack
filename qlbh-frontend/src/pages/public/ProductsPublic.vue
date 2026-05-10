<template>
  <div class="products-public">
    <div class="products-header">
      <h1>{{ getPageTitle() }}</h1>
      <p>{{ getPageDescription() }}</p>
    </div>

    <div class="products-filters">
      <input 
        v-model="search" 
        type="text" 
        class="search-input" 
        placeholder="Tìm sản phẩm..."
      />
      <select v-model="sortBy" class="sort-select">
        <option value="newest">Mới nhất</option>
        <option value="price-asc">Giá: Từ thấp đến cao</option>
        <option value="price-desc">Giá: Từ cao đến thấp</option>
        <option value="popular">Phổ biến nhất</option>
      </select>
    </div>

    <div class="loading" v-if="loading">
      <div class="spinner"></div>
      <p>Đang tải sản phẩm...</p>
    </div>

    <div class="error-message" v-if="error">
      <p>{{ error }}</p>
      <button @click="loadData" class="retry-btn">Thử lại</button>
    </div>

    <div class="products-grid" v-if="!loading && products.length > 0">
      <div v-for="product in products" :key="product.id" class="product-card">
        <div class="product-image">
          <img :src="getProductImage(product)" :alt="product.product_name" />
          <div class="product-badge">{{ getProductRating(product) }}⭐</div>
        </div>
        <div class="product-info">
          <h3>{{ product.product_name }}</h3>
          <p class="product-description">{{ truncateText(product.description || 'Sản phẩm chất lượng', 50) }}</p>
          <div class="product-footer">
            <div class="product-price">
              <span class="price">{{ formatPrice(product.price) }} đ</span>
              <span class="original-price" v-if="product.price">{{ formatPrice(product.price * 1.2) }} đ</span>
            </div>
            <button class="add-to-cart-btn" @click="addToCart(product)">
              🛍️ Thêm vào giỏ
            </button>
          </div>
        </div>
      </div>
    </div>

    <div class="empty-state" v-if="!loading && products.length === 0">
      <div class="empty-icon">📦</div>
      <h2>Không có sản phẩm nào</h2>
      <p>Hãy thử tìm kiếm với từ khóa khác</p>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted, watch } from "vue"
import { useRoute } from "vue-router"
import { getProducts } from "../../services/productService"

const route = useRoute()
const products = ref([])
const search = ref("")
const sortBy = ref("newest")
const loading = ref(false)
const error = ref("")

const loadData = async () => {
  try {
    loading.value = true
    error.value = ""
    
    // Get category_id from route params
    const categoryId = route.params.categoryId
    
    const params = {}
    if (search.value) params.search = search.value
    if (categoryId) params.category_id = categoryId
    
    const res = await getProducts(params)
    products.value = res.data.data || res.data || []
  } catch (err) {
    error.value = "Không thể tải sản phẩm. Vui lòng thử lại."
    console.error(err)
  } finally {
    loading.value = false
  }
}

const truncateText = (text, length) => {
  if (text.length > length) {
    return text.substring(0, length) + "..."
  }
  return text
}

const formatPrice = (price) => {
  return new Intl.NumberFormat("vi-VN").format(price)
}

const getProductImage = (product) => {
  return product.image || "https://via.placeholder.com/250x250?text=Sản+phẩm"
}

const getProductRating = (product) => {
  return product.rating || 4.5
}

const addToCart = (product) => {
  alert(`${product.product_name} đã được thêm vào giỏ hàng!`)
}

const getPageTitle = () => {
  const categoryId = route.params.categoryId
  if (categoryId) {
    // In a real app, you'd fetch the category name from API
    return `Danh mục sản phẩm`
  }
  return "Cửa hàng của chúng tôi"
}

const getPageDescription = () => {
  const categoryId = route.params.categoryId
  if (categoryId) {
    return "Khám phá các sản phẩm trong danh mục này"
  }
  return "Khám phá các sản phẩm tốt nhất với giá tốt nhất"
}

onMounted(loadData)
watch(() => route.params.categoryId, loadData)
watch(search, loadData)
</script>

<style scoped>
.products-public {
  width: 100%;
}

.products-header {
  text-align: center;
  margin-bottom: 40px;
}

.products-header h1 {
  font-size: 36px;
  color: #2c3e50;
  margin-bottom: 10px;
}

.products-header p {
  font-size: 16px;
  color: #7f8c8d;
}

.products-filters {
  display: flex;
  gap: 15px;
  margin-bottom: 40px;
  flex-wrap: wrap;
}

.search-input,
.sort-select {
  padding: 12px 15px;
  border: 1px solid #e0e0e0;
  border-radius: 6px;
  font-size: 14px;
  transition: border-color 0.3s ease;
}

.search-input {
  flex: 1;
  min-width: 200px;
}

.search-input:focus,
.sort-select:focus {
  outline: none;
  border-color: #667eea;
  box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
}

.products-grid {
  display: grid;
  grid-template-columns: repeat(auto-fill, minmax(220px, 1fr));
  gap: 20px;
  margin-bottom: 40px;
}

.product-card {
  background: white;
  border-radius: 8px;
  overflow: hidden;
  transition: all 0.3s ease;
  box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
}

.product-card:hover {
  transform: translateY(-8px);
  box-shadow: 0 12px 24px rgba(102, 126, 234, 0.15);
}

.product-image {
  position: relative;
  width: 100%;
  padding-bottom: 100%;
  overflow: hidden;
  background: #f5f5f5;
}

.product-image img {
  position: absolute;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  object-fit: cover;
  transition: transform 0.3s ease;
}

.product-card:hover .product-image img {
  transform: scale(1.05);
}

.product-badge {
  position: absolute;
  top: 10px;
  right: 10px;
  background: #ffa500;
  color: white;
  padding: 5px 10px;
  border-radius: 4px;
  font-size: 12px;
  font-weight: bold;
}

.product-info {
  padding: 15px;
  display: flex;
  flex-direction: column;
}

.product-info h3 {
  font-size: 15px;
  color: #2c3e50;
  margin-bottom: 8px;
  font-weight: 600;
  line-height: 1.4;
  min-height: 32px;
}

.product-description {
  font-size: 12px;
  color: #95a5a6;
  margin-bottom: 10px;
  flex: 1;
}

.product-footer {
  display: flex;
  justify-content: space-between;
  align-items: flex-end;
  gap: 10px;
}

.product-price {
  display: flex;
  flex-direction: column;
}

.price {
  font-size: 16px;
  font-weight: bold;
  color: #e74c3c;
}

.original-price {
  font-size: 12px;
  color: #95a5a6;
  text-decoration: line-through;
}

.add-to-cart-btn {
  background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
  color: white;
  border: none;
  padding: 8px 12px;
  border-radius: 6px;
  cursor: pointer;
  font-weight: 600;
  font-size: 12px;
  transition: all 0.3s ease;
  white-space: nowrap;
}

.add-to-cart-btn:hover {
  transform: scale(1.05);
  box-shadow: 0 4px 12px rgba(102, 126, 234, 0.3);
}

/* LOADING STATE */
.loading {
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: center;
  padding: 80px 20px;
}

.spinner {
  width: 40px;
  height: 40px;
  border: 4px solid rgba(102, 126, 234, 0.1);
  border-top-color: #667eea;
  border-radius: 50%;
  animation: spin 1s linear infinite;
  margin-bottom: 20px;
}

@keyframes spin {
  to {
    transform: rotate(360deg);
  }
}

.loading p {
  color: #667eea;
  font-weight: 600;
}

/* ERROR STATE */
.error-message {
  background: #ffe5e5;
  border: 1px solid #ff6b6b;
  color: #c92a2a;
  padding: 20px;
  border-radius: 8px;
  margin-bottom: 20px;
  display: flex;
  justify-content: space-between;
  align-items: center;
}

.retry-btn {
  background: #c92a2a;
  color: white;
  border: none;
  padding: 8px 16px;
  border-radius: 4px;
  cursor: pointer;
  font-weight: 600;
}

.retry-btn:hover {
  background: #a61e1e;
}

/* EMPTY STATE */
.empty-state {
  text-align: center;
  padding: 80px 20px;
}

.empty-icon {
  font-size: 80px;
  margin-bottom: 20px;
  opacity: 0.6;
}

.empty-state h2 {
  font-size: 24px;
  color: #2c3e50;
  margin-bottom: 10px;
}

.empty-state p {
  color: #7f8c8d;
}

/* RESPONSIVE */
@media (max-width: 768px) {
  .products-grid {
    grid-template-columns: repeat(auto-fill, minmax(150px, 1fr));
  }

  .products-filters {
    flex-direction: column;
  }

  .search-input {
    width: 100%;
  }
}
</style>
