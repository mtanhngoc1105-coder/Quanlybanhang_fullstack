<template>
  <div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
      <h2 class="fw-bold">Danh sách đơn hàng</h2>
      <router-link to="/admin/orders/create" class="btn btn-primary shadow-sm">
         Thêm đơn hàng
      </router-link>
    </div>

    <div class="search-filter mb-3">
      <input
        v-model="searchQuery"
        @input="filterOrders"
        type="text"
        class="form-control shadow-sm"
        placeholder="Tìm kiếm đơn hàng theo tên khách hàng, ID..."
        style="max-width: 400px;"
      >
    </div>

    <div v-if="filteredOrders.length === 0 && searchQuery" class="alert alert-info shadow-sm">
      Không tìm thấy đơn hàng nào phù hợp với "{{ searchQuery }}"
    </div>

    <div class="table-responsive shadow-sm rounded">
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
          <tr v-for="o in paginatedOrders" :key="o.id">
            <td class="fw-bold text-secondary">#{{ o.id }}</td>
            <td class="fw-semibold">{{ o.customer?.name || 'N/A' }}</td>
            <td>{{ o.post_office?.name || 'N/A' }}</td>
            <td class="text-danger fw-semibold">{{ formatPrice(o.total_amount) }}</td>
            <td>
              <span class="text-capitalize">{{ o.payment_status }}</span>
            </td>
            <td>
              <span class="text-capitalize">{{ o.shipping_status }}</span>
            </td>
            
            <td>
              <div class="d-flex justify-content-center gap-2">
                <button @click="editOrder(o.id)" class="btn btn-light btn-sm border shadow-sm px-2">
                  Sửa
                </button>
                <button @click="remove(o.id)" class="btn btn-danger btn-sm shadow-sm px-2">
                  Xóa
                </button>
              </div>
            </td>

            <td class="text-center">
              <a 
                href="javascript:void(0)" 
                @click="viewOrder(o.id)" 
                class="view-icon-link" 
                title="Xem chi tiết"
              >
                👁️
              </a>
            </td>
          </tr>

          <tr v-if="orders.length === 0">
            <td colspan="8" class="text-center py-4 text-muted">Đang tải dữ liệu đơn hàng...</td>
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
import orderService from "../../services/orderService"

const route = useRoute()
const router = useRouter()
const orders = ref([])
const searchQuery = ref('')
const currentPage = ref(1)
const itemsPerPage = ref(10)

onMounted(async () => {
  const urlSearch = route.query.search
  if (urlSearch) searchQuery.value = urlSearch
  await loadOrders()
})

const loadOrders = async () => {
  try {
    const res = await orderService.getAll()
    // Theo cấu trúc res.data.data.data cũ của bạn
    orders.value = res.data.data.data || res.data.data || []
  } catch (error) {
    console.error('Error loading orders:', error)
    orders.value = []
  }
}

const filteredOrders = computed(() => {
  if (!searchQuery.value.trim()) return orders.value
  const query = searchQuery.value.toLowerCase().trim()
  return orders.value.filter(order =>
    order.id?.toString().includes(query) ||
    order.customer?.name?.toLowerCase().includes(query) ||
    order.post_office?.name?.toLowerCase().includes(query)
  )
})

const totalPages = computed(() => Math.ceil(filteredOrders.value.length / itemsPerPage.value))

const paginatedOrders = computed(() => {
  const start = (currentPage.value - 1) * itemsPerPage.value
  const end = start + itemsPerPage.value
  return filteredOrders.value.slice(start, end)
})

const visiblePages = computed(() => {
  const pages = []
  for (let i = 1; i <= totalPages.value; i++) pages.push(i)
  return pages
})

const formatPrice = (price) => {
  return new Intl.NumberFormat('vi-VN', {
    style: 'currency',
    currency: 'VND'
  }).format(price || 0)
}

const filterOrders = () => { currentPage.value = 1 }
const viewOrder = (id) => router.push(`/admin/orders/${id}`)
const editOrder = (id) => router.push(`/admin/orders/edit/${id}`)

const remove = async (id) => {
  if (confirm("Bạn có chắc chắn muốn xoá đơn hàng này?")) {
    try {
      await orderService.delete(id)
      await loadOrders()
    } catch (error) {
      alert('Có lỗi xảy ra khi xoá đơn hàng!')
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