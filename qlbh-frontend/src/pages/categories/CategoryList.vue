<template>
  <div class="container mt-4">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-3">
      <h2 class="mb-0">Danh sách sản phẩm</h2>
      <router-link to="/admin/products/create" class="btn btn-primary shadow-sm">
        Thêm sản phẩm
      </router-link>
    </div>
    
    <!-- Search + Category Filter + Reload -->
    <div class="search-filter mb-3 d-flex align-items-center gap-2">
      <div class="d-flex gap-2 align-items-center flex-nowrap" style="flex: 1 1 auto;">
        <input
          v-model="searchQuery"
          @input="handleSearchInput"
          type="text"
          class="form-control shadow-sm"
          placeholder="Tìm kiếm sản phẩm theo tên, mã, ID..."
          style="min-width: 300px; flex: 1 1 400px;"
        >
        <select
          v-model="selectedCategory"
          @change="onFilterChange"
          class="form-select shadow-sm"
          style="min-width: 200px;"
        >
          <option value="">Tất cả danh mục</option>
          <option v-for="cat in categories" :key="cat.id" :value="cat.id">
            {{ cat.name }}
          </option>
        </select>
        <button
          @click="reloadProducts"
          class="btn btn-outline-secondary shadow-sm"
          :disabled="loading"
        >
          <span v-if="loading" class="spinner-border spinner-border-sm me-2"></span>
          Reload
        </button>
      </div>
    </div>
    
    <!-- No Results Alert -->
    <div v-if="hasNoResults && !loading" class="alert alert-info shadow-sm">
      Không tìm thấy sản phẩm nào phù hợp.
    </div>
    
    <!-- Table -->
    <div 
      class="table-responsive shadow-sm rounded"
      :class="{ 'table-loading': loading }"
    >
      <table class="table table-bordered table-hover align-middle mb-0">
        <thead class="table-dark">
          <tr>
            <th style="width: 70px;">ID</th>
            <th>Tên sản phẩm</th>
            <th>Giá</th>
            <th>Danh mục</th>
            <th>Số lượng</th>
            <th>Trạng thái</th>
            <th class="text-center" style="width: 150px;">Thao tác</th>
            <th class="text-center" style="width: 80px;">Xem</th>
          </tr>
        </thead>

        <tbody>
          <!-- SKELETON LOADING -->
          <template v-if="loading">
            <tr v-for="n in 8" :key="'skeleton-' + n" class="skeleton-row">
              <td class="skeleton-cell">
                <div class="skeleton-block skeleton-id"></div>
              </td>
              <td class="skeleton-cell">
                <div class="skeleton-line skeleton-line-long"></div>
              </td>
              <td class="skeleton-cell">
                <div class="skeleton-line skeleton-line-medium"></div>
              </td>
              <td class="skeleton-cell">
                <div class="skeleton-line skeleton-line-medium"></div>
              </td>
              <td class="skeleton-cell">
                <div class="skeleton-block skeleton-block-small"></div>
              </td>
              <td class="skeleton-cell">
                <div class="skeleton-dot"></div>
              </td>
              <td class="skeleton-cell text-center">
                <div class="skeleton-actions">
                  <div class="skeleton-btn skeleton-btn-edit"></div>
                  <div class="skeleton-btn skeleton-btn-delete"></div>
                </div>
              </td>
              <td class="skeleton-cell text-center">
                <div class="skeleton-eye"></div>
              </td>
            </tr>
          </template>

          <!-- DATA -->
          <template v-else-if="products.length > 0">
            <tr v-for="p in paginatedProducts" :key="p.id">
              <td class="fw-bold text-secondary">#{{ p.id }}</td>
              <td>{{ p.product_name }}</td>
              <td class="text-danger fw-semibold">{{ formatPrice(p.price) }}</td>
              <td>{{ p.category?.name || 'Chưa phân loại' }}</td>
              <td>{{ p.quantity || 0 }}</td>
              <td>
                <span :class="p.state === 'active' ? 'text-success' : 'text-warning'">
                  ● {{ p.state || 'unknown' }}
                </span>
              </td>
              <td>
                <div class="d-flex justify-content-center gap-2">
                  <router-link :to="`/admin/products/edit/${p.id}`" class="btn btn-light btn-sm border shadow-sm px-2">
                    Sửa
                  </router-link>
                  <button @click="remove(p.id)" class="btn btn-danger btn-sm shadow-sm px-2">
                    Xóa
                  </button>
                </div>
              </td>
              <td class="text-center">
                <router-link :to="`/admin/products/${p.id}`" class="view-icon-link">
                  👁️
                </router-link>
              </td>
            </tr>
          </template>

          <!-- EMPTY -->
          <template v-else>
            <tr>
              <td colspan="8" class="text-center py-4 text-muted">
                Không có sản phẩm để hiển thị.
              </td>
            </tr>
          </template>
        </tbody>
      </table>
    </div>

    <!-- Pagination -->
    <nav v-if="totalPages > 1" class="mt-4">
      <ul class="pagination justify-content-center">
        <li class="page-item" :class="{ disabled: currentPage === 1 }">
          <a class="page-link" @click.prevent="goToPage(currentPage - 1)" href="#">Trước</a>
        </li>
        <li v-for="page in visiblePages" :key="page" :class="['page-item', { active: page === currentPage, disabled: page === '...' }]">
          <span v-if="page === '...'" class="page-link">…</span>
          <a v-else class="page-link" @click.prevent="goToPage(page)" href="#">{{ page }}</a>
        </li>
        <li class="page-item" :class="{ disabled: currentPage === totalPages }">
          <a class="page-link" @click.prevent="goToPage(currentPage + 1)" href="#">Sau</a>
        </li>
      </ul>
    </nav>
  </div>
</template>

<script setup>
import { ref, computed, onMounted, watch } from "vue"
import { useRoute } from "vue-router"
import { getProducts, deleteProduct } from "../../services/productService"
import categoryService from "../../services/categoryService"

const loading = ref(false)
const route = useRoute()
const products = ref([])
const categories = ref([])
const searchQuery = ref('')
const selectedCategory = ref('')
const currentPage = ref(1)
const pagination = ref({ current_page: 1, last_page: 1, total: 0 })

let searchTimeout = null

onMounted(async () => {
  const urlSearch = route.query.search
  const urlCategory = route.query.category_id
  if (urlSearch) searchQuery.value = urlSearch
  if (urlCategory) selectedCategory.value = urlCategory
  await Promise.all([loadCategories(), loadProducts(1)])
})

const loadCategories = async () => {
  try {
    const res = await categoryService.getAll()
    categories.value = res.data?.data || []
  } catch (error) {
    console.error('Error loading categories:', error)
    categories.value = []
  }
}

const loadProducts = async (page = 1) => {
  try {
    loading.value = true
    const res = await getProducts({
      search: searchQuery.value.trim(),
      category_id: selectedCategory.value,
      page
    })

    const apiData = res.data
    const paginationData = apiData?.data || {}
    products.value = paginationData.data || []
    pagination.value = {
      current_page: paginationData.current_page || page,
      last_page: paginationData.last_page || 1,
      total: paginationData.total || 0
    }
    currentPage.value = pagination.value.current_page
  } catch (error) {
    console.error('Error loading products:', error)
    products.value = []
    pagination.value = { current_page: 1, last_page: 1, total: 0 }
  } finally {
    loading.value = false
  }
}

const handleSearchInput = () => {
  if (searchTimeout) clearTimeout(searchTimeout)
  searchTimeout = setTimeout(() => {
    currentPage.value = 1
    loadProducts(1)
  }, 350)
}

const onFilterChange = async () => {
  currentPage.value = 1
  await loadProducts(1)
}

const totalPages = computed(() => pagination.value.last_page || 1)

const visiblePages = computed(() => {
  const total = totalPages.value
  const current = currentPage.value
  const pages = []

  if (total <= 7) {
    return Array.from({ length: total }, (_, i) => i + 1)
  }

  if (current <= 4) {
    pages.push(1, 2, 3, 4, 5, '...', total)
    return pages
  }

  if (current >= total - 3) {
    pages.push(1, '...', total - 4, total - 3, total - 2, total - 1, total)
    return pages
  }

  pages.push(1, '...', current - 1, current, current + 1, '...', total)
  return pages
})

const paginatedProducts = computed(() => products.value)

const hasNoResults = computed(() => 
  products.value.length === 0 && (searchQuery.value || selectedCategory.value) && !loading
)

const goToPage = async (page) => {
  if (page < 1 || page > totalPages.value) return
  currentPage.value = page
  await loadProducts(page)
}

const formatPrice = (price) => {
  return new Intl.NumberFormat('vi-VN', { 
    style: 'currency', 
    currency: 'VND' 
  }).format(price || 0)
}

const reloadProducts = async () => {
  await loadProducts(currentPage.value)
}

const remove = async (id) => {
  if (confirm("Bạn có chắc chắn muốn xoá sản phẩm này?")) {
    try {
      await deleteProduct(id)
      await loadProducts(currentPage.value)
    } catch (error) {
      alert('Có lỗi xảy ra khi xoá sản phẩm!')
    }
  }
}

watch(() => route.query.search, (newSearch) => {
  if (newSearch !== undefined) {
    searchQuery.value = newSearch || ''
    currentPage.value = 1
    loadProducts(1)
  }
})

watch(() => route.query.category_id, (newCategory) => {
  if (newCategory !== undefined) {
    selectedCategory.value = newCategory || ''
    currentPage.value = 1
    loadProducts(1)
  }
})
</script>

<style scoped>
.table td, .table th {
  vertical-align: middle;
}

.btn-light:hover {
  background-color: #f8f9fa;
  border-color: #ced4da;
}

.view-icon-link {
  text-decoration: none;
  font-size: 1.2rem;
  transition: transform 0.2s;
  display: inline-block;
}

.view-icon-link:hover {
  transform: scale(1.3);
}

.page-link {
  cursor: pointer;
}

/* SKELETON LOADING */
.skeleton-row {
  height: 64px;
  border-bottom: 1px solid #e4e6ea;
}

.skeleton-cell {
  position: relative;
  overflow: hidden;
  padding: 12px !important;
  background: transparent;
}

.skeleton-block,
.skeleton-line,
.skeleton-dot,
.skeleton-btn,
.skeleton-eye {
  position: relative;
  background: linear-gradient(90deg, #f0f2f5 0%, #e9ebee 25%, #f0f2f5 50%, #e9ebee 75%, #f0f2f5 100%);
  background-size: 400% 100%;
  border-radius: 8px;
  animation: facebook-shimmer 1.6s ease-in-out infinite;
  overflow: hidden;
}

@keyframes facebook-shimmer {
  0% { background-position: 400% 0; }
  100% { background-position: -400% 0; }
}

.skeleton-id {
  width: 40px;
  height: 20px;
  margin: 0 auto;
  border-radius: 4px;
}

.skeleton-line-long {
  width: 85%;
  height: 16px;
  margin: 4px 0;
}

.skeleton-line-medium {
  width: 70%;
  height: 14px;
  margin: 4px 0;
}

.skeleton-block-small {
  width: 32px;
  height: 20px;
  margin: 0 auto;
  border-radius: 4px;
}

.skeleton-dot {
  width: 12px;
  height: 12px;
  border-radius: 50%;
  margin: 0 auto;
  display: block;
}

.skeleton-actions {
  display: flex;
  gap: 8px;
  justify-content: center;
  align-items: center;
}

.skeleton-btn {
  height: 32px;
  border-radius: 6px;
}

.skeleton-btn-edit {
  width: 48px;
  background: linear-gradient(90deg, #f8f9fa 0%, #e9ecef 100%);
}

.skeleton-btn-delete {
  width: 40px;
  background: linear-gradient(90deg, #f8d7da 0%, #f1aeb5 100%);
}

.skeleton-eye {
  width: 24px;
  height: 24px;
  border-radius: 50%;
  margin: 0 auto;
  display: block;
}

.table-loading {
  opacity: 0.7;
  transition: opacity 0.4s cubic-bezier(0.4, 0, 0.2, 1);
}

@media (max-width: 768px) {
  .skeleton-line-long { width: 95% !important; }
  .skeleton-line-medium { width: 85% !important; }
}
</style>