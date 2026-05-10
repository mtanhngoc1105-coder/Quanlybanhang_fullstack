<template>
  <div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
      <h2 class="fw-bold">Danh sách đơn tài xế</h2>
      <router-link to="/admin/driver-orders/create" class="btn btn-primary shadow-sm">
        Gán tài xế
      </router-link>
    </div>

    <div class="search-filter mb-3">
      <input
        v-model="searchQuery"
        @input="filterDriverOrders"
        type="text"
        class="form-control shadow-sm"
        placeholder="Tìm kiếm đơn tài xế theo ID đơn hàng, tài xế..."
        style="max-width: 400px;"
      >
    </div>

    <div v-if="filteredDriverOrders.length === 0 && searchQuery" class="alert alert-info shadow-sm">
      Không tìm thấy đơn tài xế nào phù hợp với "{{ searchQuery }}"
    </div>

    <div class="table-responsive shadow-sm rounded">
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
          <tr v-for="item in paginatedDriverOrders" :key="item.id">
            <td class="fw-bold text-secondary">#{{ item.order_id }}</td>
            <td>{{ item.driver_id }}</td>
            <td>{{ formatDate(item.assign_date) }}</td>
            
            <td>
              <div class="d-flex justify-content-center gap-2">
                <button @click="editDriverOrder(item.order_id)" class="btn btn-light btn-sm border shadow-sm px-2">
                  Sửa
                </button>
                <button @click="remove(item.order_id)" class="btn btn-danger btn-sm shadow-sm px-2">
                  Xóa
                </button>
              </div>
            </td>

            <td class="text-center">
              <a 
                href="javascript:void(0)" 
                @click="viewDriverOrder(item.order_id)" 
                class="view-icon-link" 
                title="Xem chi tiết"
              >
                👁️
              </a>
            </td>
          </tr>

          <tr v-if="driverOrders.length === 0">
            <td colspan="5" class="text-center py-4 text-muted">Đang tải dữ liệu đơn tài xế...</td>
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
import { getDriverOrders, deleteDriverOrder } from "../../services/driverOrderService"

const route = useRoute()
const router = useRouter()
const driverOrders = ref([])
const searchQuery = ref('')
const currentPage = ref(1)
const itemsPerPage = ref(10)

onMounted(async () => {
  const urlSearch = route.query.search
  if (urlSearch) searchQuery.value = urlSearch
  await loadDriverOrders()
})

const loadDriverOrders = async () => {
  try {
    const res = await getDriverOrders()
    driverOrders.value = res.data.data || []
  } catch (error) {
    console.error('Error loading driver orders:', error)
    driverOrders.value = []
  }
}

const filteredDriverOrders = computed(() => {
  if (!searchQuery.value.trim()) return driverOrders.value
  const query = searchQuery.value.toLowerCase().trim()
  return driverOrders.value.filter(item =>
    item.order_id?.toString().includes(query) ||
    item.driver_id?.toString().includes(query)
  )
})

const totalPages = computed(() => Math.ceil(filteredDriverOrders.value.length / itemsPerPage.value))

const paginatedDriverOrders = computed(() => {
  const start = (currentPage.value - 1) * itemsPerPage.value
  const end = start + itemsPerPage.value
  return filteredDriverOrders.value.slice(start, end)
})

const visiblePages = computed(() => {
  const pages = []
  for (let i = 1; i <= totalPages.value; i++) pages.push(i)
  return pages
})

const formatDate = (dateString) => {
  if (!dateString) return 'Chưa cập nhật'
  return new Date(dateString).toLocaleDateString('vi-VN')
}

const viewDriverOrder = (id) => router.push(`/admin/driver-orders/${id}`)
const editDriverOrder = (id) => router.push(`/admin/driver-orders/edit/${id}`)

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

const filterDriverOrders = () => { currentPage.value = 1 }

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