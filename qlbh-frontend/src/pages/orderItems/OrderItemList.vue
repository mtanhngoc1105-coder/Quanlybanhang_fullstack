<template>
  <div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
      <h2 class="fw-bold">Danh sách chi tiết đơn hàng</h2>
      <router-link to="/admin/order-items/create" class="btn btn-primary shadow-sm">
        Thêm sản phẩm vào đơn
      </router-link>
    </div>

    <div class="search-filter mb-3">
      <input
        v-model="searchQuery"
        @input="filterOrderItems"
        type="text"
        class="form-control shadow-sm"
        placeholder="Tìm kiếm chi tiết đơn theo ID đơn hàng, sản phẩm..."
        style="max-width: 400px;"
      >
    </div>

    <div v-if="filteredOrderItems.length === 0 && searchQuery" class="alert alert-info shadow-sm">
      Không tìm thấy chi tiết đơn nào phù hợp với "{{ searchQuery }}"
    </div>

    <div class="table-responsive shadow-sm rounded">
      <table class="table table-bordered table-hover align-middle mb-0">
        <thead class="table-dark">
          <tr>
            <th style="width: 70px;">ID</th>
            <th style="width: 120px;">ID đơn hàng</th>
            <th>Sản phẩm</th>
            <th style="width: 100px;">Số lượng</th>
            <th>Giá</th>
            <th class="text-center" style="width: 150px;">Thao tác</th>
            <th class="text-center" style="width: 80px;">Xem</th>
          </tr>
        </thead>

        <tbody>
          <tr v-for="i in paginatedOrderItems" :key="i.id">
            <td class="fw-bold text-secondary">#{{ i.id }}</td>
            <td>#{{ i.order_id }}</td>
            <td class="fw-semibold">{{ i.product?.name || 'N/A' }}</td>
            <td class="text-center">{{ i.quantity }}</td>
            <td class="text-danger fw-semibold">{{ formatPrice(i.price) }}</td>
            
            <td>
              <div class="d-flex justify-content-center gap-2">
                <button @click="editOrderItem(i.id)" class="btn btn-light btn-sm border shadow-sm px-2">
                  Sửa
                </button>
                <button @click="remove(i.id)" class="btn btn-danger btn-sm shadow-sm px-2">
                  Xóa
                </button>
              </div>
            </td>

            <td class="text-center">
              <a 
                href="javascript:void(0)" 
                @click="viewOrderItem(i.id)" 
                class="view-icon-link" 
                title="Xem chi tiết"
              >
                👁️
              </a>
            </td>
          </tr>

          <tr v-if="orderItems.length === 0">
            <td colspan="7" class="text-center py-4 text-muted">Đang tải dữ liệu chi tiết đơn hàng...</td>
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
import { getOrderItems, deleteOrderItem } from "../../services/orderItemService"

const route = useRoute()
const router = useRouter()
const orderItems = ref([])
const searchQuery = ref('')
const currentPage = ref(1)
const itemsPerPage = ref(10)

onMounted(async () => {
  const urlSearch = route.query.search
  if (urlSearch) searchQuery.value = urlSearch
  await loadOrderItems()
})

const loadOrderItems = async () => {
  try {
    const res = await getOrderItems()
    orderItems.value = res.data.data || []
  } catch (error) {
    console.error('Error loading order items:', error)
    orderItems.value = []
  }
}

const filteredOrderItems = computed(() => {
  if (!searchQuery.value.trim()) return orderItems.value
  const query = searchQuery.value.toLowerCase().trim()
  return orderItems.value.filter(item =>
    item.id?.toString().includes(query) ||
    item.order_id?.toString().includes(query) ||
    item.product?.name?.toLowerCase().includes(query)
  )
})

const totalPages = computed(() => Math.ceil(filteredOrderItems.value.length / itemsPerPage.value))

const paginatedOrderItems = computed(() => {
  const start = (currentPage.value - 1) * itemsPerPage.value
  const end = start + itemsPerPage.value
  return filteredOrderItems.value.slice(start, end)
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

const viewOrderItem = (id) => router.push(`/admin/order-items/${id}`)
const editOrderItem = (id) => router.push(`/admin/order-items/edit/${id}`)

const remove = async (id) => {
  if (confirm("Bạn có chắc chắn muốn xoá chi tiết đơn hàng này?")) {
    try {
      await deleteOrderItem(id)
      await loadOrderItems()
    } catch (error) {
      alert('Có lỗi xảy ra khi xoá!')
    }
  }
}

const filterOrderItems = () => { currentPage.value = 1 }

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