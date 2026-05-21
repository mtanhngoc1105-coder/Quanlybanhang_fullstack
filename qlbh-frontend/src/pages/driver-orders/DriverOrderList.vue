<template>
  <div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
      <h2 class="fw-bold">Danh sách đơn tài xế</h2>
      <router-link to="/admin/driver-orders/create" class="btn btn-primary shadow-sm">
        Gán tài xế
      </router-link>
    </div>

    <div class="search-filter mb-3 d-flex align-items-center gap-2">
      <div class="d-flex gap-2 align-items-center flex-nowrap" style="flex: 1 1 auto;">
        <input
          v-model="searchQuery"
          @input="handleSearchInput"
          type="text"
          class="form-control shadow-sm"
          placeholder="Tìm kiếm đơn tài xế theo ID đơn hàng, tài xế..."
          style="min-width: 300px; flex: 1 1 400px;"
        >
        <button
          @click="reloadDriverOrders"
          class="btn btn-outline-secondary shadow-sm"
          :disabled="loading"
        >
          <span v-if="loading" class="spinner-border spinner-border-sm me-2"></span>
          Reload
        </button>
      </div>
    </div>
    
    <div v-if="driverOrders.length === 0 && searchQuery && !loading" class="alert alert-info shadow-sm">
      Không tìm thấy đơn tài xế nào phù hợp.
    </div>

    <div 
      class="table-responsive shadow-sm rounded"
      :class="{ 'table-loading': loading }"
    >
      <table class="table table-bordered table-hover align-middle mb-0">
        <thead class="table-dark">
          <tr>
            <th style="width: 120px;">ID đơn hàng</th>
            <th>Tài xế</th>
            <th>Ngày gán</th>
            <th class="text-center" style="width: 150px;">Thao tác</th>
            <th class="text-center" style="width: 80px;">Xem</th>
          </tr>
        </thead>

        <tbody>
          <!-- FACEBOOK-STYLE SKELETON LOADING -->
          <template v-if="loading">
            <tr v-for="n in 8" :key="'skeleton-' + n" class="skeleton-row">
              <!-- Order ID -->
              <td class="skeleton-cell">
                <div class="skeleton-block skeleton-id"></div>
              </td>
              
              <!-- Driver ID -->
              <td class="skeleton-cell">
                <div class="skeleton-line skeleton-line-medium"></div>
              </td>
              
              <!-- Assign Date -->
              <td class="skeleton-cell">
                <div class="skeleton-line skeleton-line-short"></div>
              </td>
              
              <!-- Actions -->
              <td class="skeleton-cell text-center">
                <div class="skeleton-actions">
                  <div class="skeleton-btn skeleton-btn-edit"></div>
                  <div class="skeleton-btn skeleton-btn-delete"></div>
                </div>
              </td>
              
              <!-- View -->
              <td class="skeleton-cell text-center">
                <div class="skeleton-eye"></div>
              </td>
            </tr>
          </template>

          <!-- DATA -->
          <template v-else-if="paginatedDriverOrders.length > 0">
            <tr v-for="item in paginatedDriverOrders" :key="item.id">
              <td class="fw-bold text-secondary">#{{ item.order_id }}</td>
              <td>{{ item.driver_id }}</td>
              <td>{{ formatDate(item.assign_date) }}</td>
              
              <td>
                <div class="d-flex justify-content-center gap-2">
                  <router-link :to="`/admin/driver-orders/edit/${item.order_id}`" class="btn btn-light btn-sm border shadow-sm px-2">
                    Sửa
                  </router-link>
                  <button @click="remove(item.order_id)" class="btn btn-danger btn-sm shadow-sm px-2">
                    Xóa
                  </button>
                </div>
              </td>

              <td class="text-center">
                <router-link 
                  :to="`/admin/driver-orders/${item.order_id}`" 
                  class="view-icon-link"
                  title="Xem chi tiết"
                >
                  👁️
                </router-link>
              </td>
            </tr>
          </template>

          <!-- EMPTY -->
          <template v-else>
            <tr>
              <td colspan="5" class="text-center py-4 text-muted">
                Không có đơn tài xế để hiển thị.
              </td>
            </tr>
          </template>
        </tbody>
      </table>
    </div>

    <nav v-if="totalPages > 1" class="mt-4">
      <ul class="pagination justify-content-center">
        <li class="page-item" :class="{ disabled: currentPage === 1 }">
          <a class="page-link" @click.prevent="goToPage(currentPage - 1)" href="#">Trước</a>
        </li>
        <li v-for="page in visiblePages" :key="page" class="page-item" :class="{ active: page === currentPage }">
          <a class="page-link" @click.prevent="goToPage(page)" href="#">{{ page }}</a>
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
import { getDriverOrders, deleteDriverOrder } from "../../services/driverOrderService"

const loading = ref(false)
const route = useRoute()
const driverOrders = ref([])
const searchQuery = ref('')
const currentPage = ref(1)
const pagination = ref({ current_page: 1, last_page: 1, total: 0 })
let searchTimeout = null

onMounted(async () => {
  const urlSearch = route.query.search
  if (urlSearch) searchQuery.value = urlSearch
  await loadDriverOrders()
})

const loadDriverOrders = async () => {
  try {
    loading.value = true
    // GIỮ NGUYÊN API CŨ - KHÔNG TRUYỀN PARAMS
    const res = await getDriverOrders()
    
    // Client-side filter
    let filtered = res.data.data || []
    
    // Filter theo search
    if (searchQuery.value.trim()) {
      const query = searchQuery.value.toLowerCase().trim()
      filtered = filtered.filter(item =>
        item.order_id?.toString().includes(query) ||
        item.driver_id?.toString().includes(query)
      )
    }
    
    driverOrders.value = filtered
    
    // Client-side pagination
    const itemsPerPage = 10
    pagination.value = {
      current_page: currentPage.value,
      last_page: Math.ceil(filtered.length / itemsPerPage),
      total: filtered.length
    }
  } catch (error) {
    console.error('Error loading driver orders:', error)
    driverOrders.value = []
    pagination.value = { current_page: 1, last_page: 1, total: 0 }
  } finally {
    loading.value = false
  }
}

const handleSearchInput = () => {
  clearTimeout(searchTimeout)
  searchTimeout = setTimeout(() => {
    currentPage.value = 1
    loadDriverOrders()
  }, 350)
}

const totalPages = computed(() => pagination.value.last_page || 1)

const visiblePages = computed(() => {
  const pages = []
  const startIdx = Math.max(1, currentPage.value - 2)
  const endIdx = Math.min(totalPages.value, currentPage.value + 2)
  
  for (let i = startIdx; i <= endIdx; i++) {
    pages.push(i)
  }
  return pages
})

const paginatedDriverOrders = computed(() => {
  const itemsPerPage = 10
  const start = (currentPage.value - 1) * itemsPerPage
  const end = start + itemsPerPage
  return driverOrders.value.slice(start, end)
})

const goToPage = async (page) => {
  if (page < 1 || page > totalPages.value) return
  currentPage.value = page
  await loadDriverOrders()
}

const reloadDriverOrders = async () => {
  searchQuery.value = ''
  currentPage.value = 1
  await loadDriverOrders()
}

const formatDate = (dateString) => {
  if (!dateString) return 'Chưa cập nhật'
  return new Date(dateString).toLocaleDateString('vi-VN')
}

const remove = async (id) => {
  if (confirm("Bạn có chắc chắn muốn xoá đơn tài xế này?")) {
    try {
      await deleteDriverOrder(id)
      await loadDriverOrders()
    } catch (error) {
      alert('Có lỗi xảy ra khi xoá!')
    }
  }
}

watch(() => route.query.search, (newSearch) => {
  if (newSearch !== undefined) {
    searchQuery.value = newSearch || ''
    currentPage.value = 1
    loadDriverOrders()
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

/* ========================================
   FACEBOOK-STYLE SKELETON LOADING 
======================================== */
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
.skeleton-btn,
.skeleton-eye {
  position: relative;
  background: linear-gradient(
    90deg,
    #f0f2f5 0%,
    #e9ebee 25%,
    #f0f2f5 50%,
    #e9ebee 75%,
    #f0f2f5 100%
  );
  background-size: 400% 100%;
  border-radius: 8px;
  animation: facebook-shimmer 1.6s ease-in-out infinite;
  overflow: hidden;
}

@keyframes facebook-shimmer {
  0% {
    background-position: 400% 0;
    transform: translateX(-10px);
  }
  50% {
    background-position: -400% 0;
    transform: translateX(10px);
  }
  100% {
    background-position: 400% 0;
    transform: translateX(-10px);
  }
}

.skeleton-id {
  width: 80px;
  height: 20px;
  margin: 0 auto;
  border-radius: 4px;
}

.skeleton-line-medium {
  width: 70%;
  height: 14px;
  margin: 4px 0;
}

.skeleton-line-short {
  width: 50%;
  height: 14px;
  margin: 4px 0;
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

/* Enhanced shimmer */
@keyframes facebook-shimmer {
  0% { background-position: 400% 0; filter: brightness(1); }
  25% { background-position: 200% 0; filter: brightness(1.02); }
  50% { background-position: 0% 0; filter: brightness(1.05); }
  75% { background-position: -200% 0; filter: brightness(1.02); }
  100% { background-position: -400% 0; filter: brightness(1); }
}

/* Table loading overlay */
.table-loading {
  opacity: 0.7;
  transition: opacity 0.4s cubic-bezier(0.4, 0, 0.2, 1);
}

.table-loading table {
  position: relative;
}

.table-loading::after {
  content: '';
  position: absolute;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  background: linear-gradient(90deg, transparent 0%, rgba(255,255,255,0.4) 50%, transparent 100%);
  animation: table-shimmer-overlay 2s infinite;
  pointer-events: none;
  z-index: 1;
}

@keyframes table-shimmer-overlay {
  0% { transform: translateX(-100%); }
  100% { transform: translateX(100%); }
}

@media (max-width: 768px) {
  .skeleton-line-medium { width: 85% !important; }
}
</style>