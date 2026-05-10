<template>
  <div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
      <h2 class="fw-bold">Danh sách tài xế</h2>
      <router-link to="/admin/drivers/create" class="btn btn-primary shadow-sm">
        Thêm tài xế
      </router-link>
    </div>

    <div class="search-filter mb-3">
      <input
        v-model="searchQuery"
        @input="filterDrivers"
        type="text"
        class="form-control shadow-sm"
        placeholder="Tìm kiếm tài xế theo tên, SĐT, biển số..."
        style="max-width: 400px;"
      >
    </div>

    <div v-if="filteredDrivers.length === 0 && searchQuery" class="alert alert-info shadow-sm">
      Không tìm thấy tài xế nào phù hợp với "{{ searchQuery }}"
    </div>

    <div class="table-responsive shadow-sm rounded">
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
          <tr v-for="d in paginatedDrivers" :key="d.id">
            <td class="fw-bold text-secondary">#{{ d.id }}</td>
            <td class="fw-semibold">{{ d.driver_name }}</td>
            <td>{{ d.driver_phone }}</td>
            <td>
              {{ d.status }}
            </td>
            <td>{{ d.plate_number }}</td>
            
            <td>
              <div class="d-flex justify-content-center gap-2">
                <button @click="editDriver(d.id)" class="btn btn-light btn-sm border shadow-sm px-2">
                  Sửa
                </button>
                <button @click="removeDriver(d.id)" class="btn btn-danger btn-sm shadow-sm px-2">
                  Xóa
                </button>
              </div>
            </td>

            <td class="text-center">
              <a 
                href="javascript:void(0)" 
                @click="viewDriver(d.id)" 
                class="view-icon-link" 
                title="Xem chi tiết"
              >
                👁️
              </a>
            </td>
          </tr>

          <tr v-if="drivers.length === 0">
            <td colspan="7" class="text-center py-4 text-muted">Đang tải dữ liệu tài xế...</td>
          </tr>
        </tbody>
      </table>
    </div>

    <nav v-if="totalPages > 1" class="mt-4">
      <ul class="pagination justify-content-center">
        <li class="page-item" :class="{ disabled: currentPage === 1 }">
          <a class="page-link" @click.prevent="currentPage > 1 && currentPage--" href="#">Trước</a>
        </li>
        <li v-for="page in visiblePages" :key="page" class="page-item" :class="{ active: page === currentPage }">
          <a class="page-link" @click.prevent="currentPage = page" href="#">{{ page }}</a>
        </li>
        <li class="page-item" :class="{ disabled: currentPage === totalPages }">
          <a class="page-link" @click.prevent="currentPage < totalPages && currentPage++" href="#">Sau</a>
        </li>
      </ul>
    </nav>
  </div>
</template>

<script setup>
import { ref, computed, onMounted, watch } from "vue"
import { useRoute, useRouter } from "vue-router"
import { getDrivers, deleteDriver } from "../../services/driverService"

const route = useRoute()
const router = useRouter()
const drivers = ref([])
const searchQuery = ref('')
const currentPage = ref(1)
const itemsPerPage = ref(10)

onMounted(async () => {
  const urlSearch = route.query.search
  if (urlSearch) searchQuery.value = urlSearch
  await loadDrivers()
})

const loadDrivers = async () => {
  try {
    const res = await getDrivers()
    // Theo cấu trúc res.data.data.data trong code cũ của bạn
    drivers.value = res.data.data.data || res.data.data || []
  } catch (error) {
    console.error('Error loading drivers:', error)
    drivers.value = []
  }
}

const filteredDrivers = computed(() => {
  if (!searchQuery.value.trim()) return drivers.value
  const query = searchQuery.value.toLowerCase().trim()
  return drivers.value.filter(driver =>
    driver.driver_name?.toLowerCase().includes(query) ||
    driver.driver_phone?.toLowerCase().includes(query) ||
    driver.plate_number?.toLowerCase().includes(query) ||
    driver.id?.toString().includes(query)
  )
})

const totalPages = computed(() => Math.ceil(filteredDrivers.value.length / itemsPerPage.value))

const paginatedDrivers = computed(() => {
  const start = (currentPage.value - 1) * itemsPerPage.value
  const end = start + itemsPerPage.value
  return filteredDrivers.value.slice(start, end)
})

const visiblePages = computed(() => {
  const pages = []
  for (let i = 1; i <= totalPages.value; i++) pages.push(i)
  return pages
})

const filterDrivers = () => { currentPage.value = 1 }

const viewDriver = (id) => { router.push(`/admin/drivers/${id}`) }
const editDriver = (id) => { router.push(`/admin/drivers/edit/${id}`) }

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
  if (newSearch) {
    searchQuery.value = newSearch
    currentPage.value = 1
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
  cursor: pointer;
}

.view-icon-link:hover {
  transform: scale(1.3);
}

.page-link {
  cursor: pointer;
}
</style>