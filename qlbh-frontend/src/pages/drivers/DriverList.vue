<template>
  <div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
      <h2 class="fw-bold">Danh sách tài xế</h2>
      <router-link to="/admin/drivers/create" class="btn btn-primary shadow-sm">
        Thêm tài xế
      </router-link>
    </div>

    <div class="search-filter mb-3 d-flex align-items-center gap-2">
      <div class="d-flex gap-2 align-items-center flex-nowrap" style="flex: 1 1 auto;">
        <input
          v-model="searchQuery"
          @input="handleSearchInput"
          type="text"
          class="form-control shadow-sm"
          placeholder="Tìm kiếm tài xế theo tên, SĐT, biển số, ID..."
          style="min-width: 300px; flex: 1 1 400px;"
        >
        <select
          v-model="selectedStatus"
          @change="onFilterChange"
          class="form-select shadow-sm"
          style="min-width: 200px;"
        >
          <option value="">Tất cả trạng thái</option>
          <option value="active">Hoạt động</option>
          <option value="inactive">Không hoạt động</option>
          <option value="busy">Bận</option>
          <option value="offline">Ngoại tuyến</option>
        </select>
        <button
          @click="reloadDrivers"
          class="btn btn-outline-secondary shadow-sm"
          :disabled="loading"
        >
          <span v-if="loading" class="spinner-border spinner-border-sm me-2"></span>
          Reload
        </button>
      </div>
    </div>
    
    <div v-if="drivers.length === 0 && (searchQuery || selectedStatus) && !loading" class="alert alert-info shadow-sm">
      Không tìm thấy tài xế nào phù hợp.
    </div>

    <div 
      class="table-responsive shadow-sm rounded"
      :class="{ 'table-loading': loading }"
    >
      <table class="table table-bordered table-hover align-middle mb-0">
        <thead class="table-dark">
          <tr>
            <th style="width: 70px;">ID</th>
            <th>Tên tài xế</th>
            <th>SĐT</th>
            <th>Trạng thái</th>
            <th>Biển số</th>
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
              
              <!-- Driver Name -->
              <td class="skeleton-cell">
                <div class="skeleton-line skeleton-line-long"></div>
              </td>
              
              <!-- Phone -->
              <td class="skeleton-cell">
                <div class="skeleton-line skeleton-line-medium"></div>
              </td>
              
              <!-- Status -->
              <td class="skeleton-cell">
                <div class="skeleton-dot"></div>
              </td>
              
              <!-- Plate Number -->
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
          <template v-else-if="paginatedDrivers.length > 0">
            <tr v-for="d in paginatedDrivers" :key="d.id">
              <td class="fw-bold text-secondary">#{{ d.id }}</td>
              <td class="fw-semibold">{{ d.driver_name }}</td>
              <td>
                <small class="text-muted">{{ d.driver_phone }}</small>
              </td>
              <td>
                <span 
                  :class="{
                    'text-success': d.status === 'active',
                    'text-warning': d.status === 'busy',
                    'text-danger': d.status === 'inactive',
                    'text-secondary': d.status === 'offline'
                  }"
                  class="fw-semibold px-2 py-1 rounded-pill small"
                >
                  {{ d.status }}
                </span>
              </td>
              <td>
                <span class="badge bg-primary">{{ d.plate_number }}</span>
              </td>
              
              <td>
                <div class="d-flex justify-content-center gap-2">
                  <router-link :to="`/admin/drivers/edit/${d.id}`" class="btn btn-light btn-sm border shadow-sm px-2">
                    Sửa
                  </router-link>
                  <button @click="removeDriver(d.id)" class="btn btn-danger btn-sm shadow-sm px-2">
                    Xóa
                  </button>
                </div>
              </td>

              <td class="text-center">
                <router-link 
                  :to="`/admin/drivers/${d.id}`" 
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
              <td colspan="7" class="text-center py-4 text-muted">
                Không có tài xế để hiển thị.
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
import { getDrivers, deleteDriver } from "../../services/driverService"

const loading = ref(false)
const route = useRoute()
const drivers = ref([])
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
  await loadDrivers()
})

const loadDrivers = async () => {
  try {
    loading.value = true
    // GIỮ NGUYÊN API CŨ - KHÔNG TRUYỀN PARAMS
    const res = await getDrivers()
    
    // Client-side filter & pagination
    let filtered = res.data.data.data || res.data.data || []
    
    // Filter theo search
    if (searchQuery.value.trim()) {
      const query = searchQuery.value.toLowerCase().trim()
      filtered = filtered.filter(driver =>
        driver.driver_name?.toLowerCase().includes(query) ||
        driver.driver_phone?.toLowerCase().includes(query) ||
        driver.plate_number?.toLowerCase().includes(query) ||
        driver.id?.toString().includes(query)
      )
    }
    
    // Filter theo status
    if (selectedStatus.value) {
      filtered = filtered.filter(driver => driver.status === selectedStatus.value)
    }
    
    drivers.value = filtered
    
    // Client-side pagination
    const itemsPerPage = 10
    pagination.value = {
      current_page: currentPage.value,
      last_page: Math.ceil(filtered.length / itemsPerPage),
      total: filtered.length
    }
  } catch (error) {
    console.error('Error loading drivers:', error)
    drivers.value = []
    pagination.value = { current_page: 1, last_page: 1, total: 0 }
  } finally {
    loading.value = false
  }
}

const handleSearchInput = () => {
  clearTimeout(searchTimeout)
  searchTimeout = setTimeout(() => {
    currentPage.value = 1
    loadDrivers()
  }, 350)
}

const onFilterChange = async () => {
  currentPage.value = 1
  await loadDrivers()
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

const paginatedDrivers = computed(() => {
  const itemsPerPage = 10
  const start = (currentPage.value - 1) * itemsPerPage
  const end = start + itemsPerPage
  return drivers.value.slice(start, end)
})

const goToPage = async (page) => {
  if (page < 1 || page > totalPages.value) return
  currentPage.value = page
  await loadDrivers()
}

const reloadDrivers = async () => {
  searchQuery.value = ''
  selectedStatus.value = ''
  currentPage.value = 1
  await loadDrivers()
}

const removeDriver = async (id) => {
  if (confirm("Bạn có chắc chắn muốn xoá tài xế này?")) {
    try {
      await deleteDriver(id)
      await loadDrivers()
    } catch (error) {
      alert('Có lỗi xảy ra khi xoá tài xế!')
    }
  }
}

watch(() => route.query.search, (newSearch) => {
  if (newSearch !== undefined) {
    searchQuery.value = newSearch || ''
    currentPage.value = 1
    loadDrivers()
  }
})

watch(() => route.query.status, (newStatus) => {
  if (newStatus !== undefined) {
    selectedStatus.value = newStatus || ''
    currentPage.value = 1
    loadDrivers()
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
  .skeleton-line-long { width: 95% !important; }
  .skeleton-line-medium { width: 85% !important; }
}
</style>