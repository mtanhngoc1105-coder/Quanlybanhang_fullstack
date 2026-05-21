<template>
  <div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
      <h2 class="fw-bold">Danh sách đơn hàng</h2>
      <router-link to="/admin/orders/create" class="btn btn-primary shadow-sm">
        Thêm đơn hàng
      </router-link>
    </div>

    <div class="search-filter mb-3 d-flex align-items-center gap-2">
      <div class="d-flex gap-2 align-items-center flex-nowrap" style="flex: 1 1 auto;">
        <input
          v-model="searchQuery"
          @input="handleSearchInput"
          type="text"
          class="form-control shadow-sm"
          placeholder="Tìm kiếm đơn hàng theo tên khách hàng, ID..."
          style="min-width: 300px; flex: 1 1 400px;"
        >
        <select
          v-model="selectedStatus"
          @change="onFilterChange"
          class="form-select shadow-sm"
          style="min-width: 200px;"
        >
          <option value="">Tất cả trạng thái</option>
          <option value="pending">Chờ xử lý</option>
          <option value="processing">Đang xử lý</option>
          <option value="shipped">Đã giao</option>
          <option value="delivered">Hoàn thành</option>
          <option value="cancelled">Đã hủy</option>
        </select>
        <button
          @click="reloadOrders"
          class="btn btn-outline-secondary shadow-sm"
          :disabled="loading"
        >
          <span v-if="loading" class="spinner-border spinner-border-sm me-2"></span>
          Reload
        </button>
      </div>
    </div>
    
    <div v-if="orders.length === 0 && (searchQuery || selectedStatus) && !loading" class="alert alert-info shadow-sm">
      Không tìm thấy đơn hàng nào phù hợp.
    </div>
    
    <div 
      class="table-responsive shadow-sm rounded"
      :class="{ 'table-loading': loading }"
    >
      <table class="table table-bordered table-hover align-middle mb-0">
        <thead class="table-dark">
          <tr>
            <th style="width: 70px;">ID</th>
            <th>Khách hàng</th>
            <th>Bưu cục</th>
            <th>Tổng tiền</th>
            <th>Thanh toán</th>
            <th>Vận chuyển</th>
            <th class="text-center" style="width: 150px;">Thao tác</th>
            <th class="text-center" style="width: 80px;">Xem</th>
          </tr>
        </thead>

        <tbody>
          <!-- FACEBOOK-STYLE SKELETON LOADING -->
          <template v-if="loading">
            <tr v-for="n in 8" :key="'skeleton-' + n" class="skeleton-row">
              <!-- ID Column -->
              <td class="skeleton-cell">
                <div class="skeleton-block skeleton-id"></div>
              </td>
              
              <!-- Customer Name -->
              <td class="skeleton-cell">
                <div class="skeleton-line skeleton-line-long"></div>
              </td>
              
              <!-- Post Office -->
              <td class="skeleton-cell">
                <div class="skeleton-line skeleton-line-medium"></div>
              </td>
              
              <!-- Total Amount -->
              <td class="skeleton-cell">
                <div class="skeleton-line skeleton-line-medium"></div>
              </td>
              
              <!-- Payment Status -->
              <td class="skeleton-cell">
                <div class="skeleton-line skeleton-line-short"></div>
              </td>
              
              <!-- Shipping Status -->
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
          <template v-else-if="paginatedOrders.length > 0">
            <tr v-for="o in paginatedOrders" :key="o.id">
              <td class="fw-bold text-secondary">#{{ o.id }}</td>
              <td class="fw-semibold">{{ o.customer?.name || 'N/A' }}</td>
              <td>{{ o.post_office?.name || 'N/A' }}</td>
              <td class="text-danger fw-semibold">{{ formatPrice(o.total_amount) }}</td>
              <td>
                <span 
                  :class="{
                    'text-success': o.payment_status === 'paid',
                    'text-warning': o.payment_status === 'pending',
                    'text-danger': o.payment_status === 'failed'
                  }"
                  class="text-capitalize fw-semibold"
                >
                  {{ o.payment_status || 'N/A' }}
                </span>
              </td>
              <td>
                <span 
                  :class="{
                    'text-success': o.shipping_status === 'delivered',
                    'text-info': o.shipping_status === 'shipped',
                    'text-warning': o.shipping_status === 'processing',
                    'text-secondary': o.shipping_status === 'pending'
                  }"
                  class="text-capitalize fw-semibold"
                >
                  {{ o.shipping_status || 'N/A' }}
                </span>
              </td>
              
              <td>
                <div class="d-flex justify-content-center gap-2">
                  <router-link :to="`/admin/orders/edit/${o.id}`" class="btn btn-light btn-sm border shadow-sm px-2">
                    Sửa
                  </router-link>
                  <button @click="remove(o.id)" class="btn btn-danger btn-sm shadow-sm px-2">
                    Xóa
                  </button>
                </div>
              </td>

              <td class="text-center">
                <router-link 
                  :to="`/admin/orders/${o.id}`" 
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
              <td colspan="8" class="text-center py-4 text-muted">
                Không có đơn hàng để hiển thị.
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
import orderService from "../../services/orderService"

const loading = ref(false)
const route = useRoute()
const orders = ref([])
const searchQuery = ref('')
const selectedStatus = ref('')
const currentPage = ref(1)
const pagination = ref({ current_page: 1, last_page: 1, total: 0 })
let searchTimeout = null

onMounted(async () => {
  const urlSearch = route.query.search
  const urlStatus = route.query.status
  if (urlSearch) searchQuery.value = urlSearch
  if (urlStatus) selectedStatus.value = urlStatus
  await loadOrders(1)
})

const loadOrders = async (page = 1) => {
  try {
    loading.value = true
    const res = await orderService.getAll({
      search: searchQuery.value.trim(),
      status: selectedStatus.value,
      page
    })

    const data = res.data?.data || {}
    orders.value = data.data || []
    pagination.value = {
      current_page: data.current_page || page,
      last_page: data.last_page || 1,
      total: data.total || 0
    }
    currentPage.value = pagination.value.current_page
  } catch (error) {
    console.error('Error loading orders:', error)
    orders.value = []
    pagination.value = { current_page: 1, last_page: 1, total: 0 }
  } finally {
    loading.value = false
  }
}

const handleSearchInput = () => {
  clearTimeout(searchTimeout)
  searchTimeout = setTimeout(() => {
    currentPage.value = 1
    loadOrders(1)
  }, 350)
}

const onFilterChange = async () => {
  currentPage.value = 1
  await loadOrders(1)
}

const totalPages = computed(() => pagination.value.last_page || 1)

const visiblePages = computed(() => {
  const pages = []
  for (let i = 1; i <= totalPages.value; i++) {
    pages.push(i)
  }
  return pages
})

const paginatedOrders = computed(() => orders.value)

const goToPage = async (page) => {
  if (page < 1 || page > totalPages.value) return
  currentPage.value = page
  await loadOrders(page)
}

const formatPrice = (price) => {
  return new Intl.NumberFormat('vi-VN', { 
    style: 'currency', 
    currency: 'VND' 
  }).format(price || 0)
}

const reloadOrders = async () => {
  await loadOrders(currentPage.value)
}

const remove = async (id) => {
  if (confirm("Bạn có chắc chắn muốn xoá đơn hàng này?")) {
    try {
      await orderService.delete(id)
      await loadOrders(currentPage.value)
    } catch (error) {
      alert('Có lỗi xảy ra khi xoá đơn hàng!')
    }
  }
}

watch(() => route.query.search, (newSearch) => {
  if (newSearch !== undefined) {
    searchQuery.value = newSearch || ''
    currentPage.value = 1
    loadOrders(1)
  }
})

watch(() => route.query.status, (newStatus) => {
  if (newStatus !== undefined) {
    selectedStatus.value = newStatus || ''
    currentPage.value = 1
    loadOrders(1)
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
   Hiệu ứng luồng sáng chuyên nghiệp
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
.skeleton-dot,
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

/* Các loại skeleton block khác nhau */
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

/* Tăng độ mượt cho animation */
@keyframes facebook-shimmer {
  0% {
    background-position: 400% 0;
    filter: brightness(1);
  }
  25% {
    background-position: 200% 0;
    filter: brightness(1.02);
  }
  50% {
    background-position: 0% 0;
    filter: brightness(1.05);
  }
  75% {
    background-position: -200% 0;
    filter: brightness(1.02);
  }
  100% {
    background-position: -400% 0;
    filter: brightness(1);
  }
}

/* Làm mờ bảng khi loading */
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

/* Responsive */
@media (max-width: 768px) {
  .skeleton-line-long { width: 95% !important; }
  .skeleton-line-medium { width: 85% !important; }
}
</style>