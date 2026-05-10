<template>
  <div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
      <h2 class="fw-bold">Danh sách người bán</h2>
      <router-link to="/admin/sellers/create" class="btn btn-primary shadow-sm">
        Thêm người bán
      </router-link>
    </div>

    <div class="search-filter mb-3">
      <input
        v-model="searchQuery"
        @input="filterSellers"
        type="text"
        class="form-control shadow-sm"
        placeholder="Tìm kiếm người bán theo tên, SĐT..."
        style="max-width: 400px;"
      >
    </div>

    <div v-if="filteredSellers.length === 0 && searchQuery" class="alert alert-info shadow-sm">
      Không tìm thấy người bán nào phù hợp với "{{ searchQuery }}"
    </div>

    <div class="table-responsive shadow-sm rounded">
      <table class="table table-bordered table-hover align-middle mb-0">
        <thead class="table-dark">
          <tr>
            <th style="width: 70px;">ID</th>
            <th>Tên người bán</th>
            <th>Số điện thoại</th>
            <th class="text-center" style="width: 150px;">Thao tác</th>
            <th class="text-center" style="width: 80px;">Xem</th>
          </tr>
        </thead>

        <tbody>
          <tr v-for="s in paginatedSellers" :key="s.id">
            <td class="fw-bold text-secondary">#{{ s.id }}</td>
            <td class="fw-semibold">{{ s.seller_name }}</td>
            <td>{{ s.seller_phone_number }}</td>
            
            <td>
              <div class="d-flex justify-content-center gap-2">
                <button @click="editSeller(s.id)" class="btn btn-light btn-sm border shadow-sm px-2">
                  Sửa
                </button>
                <button @click="remove(s.id)" class="btn btn-danger btn-sm shadow-sm px-2">
                  Xóa
                </button>
              </div>
            </td>

            <td class="text-center">
              <a 
                href="javascript:void(0)" 
                @click="viewSeller(s.id)" 
                class="view-icon-link" 
                title="Xem chi tiết"
              >
                👁️
              </a>
            </td>
          </tr>

          <tr v-if="sellers.length === 0">
            <td colspan="5" class="text-center py-4 text-muted">Đang tải dữ liệu người bán...</td>
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
import { getSellers, deleteSeller } from "../../services/sellerService"

const route = useRoute()
const router = useRouter()
const sellers = ref([])
const searchQuery = ref('')
const currentPage = ref(1)
const itemsPerPage = ref(10)

onMounted(async () => {
  const urlSearch = route.query.search
  if (urlSearch) searchQuery.value = urlSearch
  await loadSellers()
})

const loadSellers = async () => {
  try {
    const res = await getSellers()
    // Theo cấu trúc cũ của bạn: res.data.data
    sellers.value = res.data.data || []
  } catch (error) {
    console.error('Error loading sellers:', error)
    sellers.value = []
  }
}

const filteredSellers = computed(() => {
  if (!searchQuery.value.trim()) return sellers.value
  const query = searchQuery.value.toLowerCase().trim()
  return sellers.value.filter(seller =>
    seller.seller_name?.toLowerCase().includes(query) ||
    seller.seller_phone_number?.toLowerCase().includes(query) ||
    seller.id?.toString().includes(query)
  )
})

const totalPages = computed(() => Math.ceil(filteredSellers.value.length / itemsPerPage.value))

const paginatedSellers = computed(() => {
  const start = (currentPage.value - 1) * itemsPerPage.value
  const end = start + itemsPerPage.value
  return filteredSellers.value.slice(start, end)
})

const visiblePages = computed(() => {
  const pages = []
  for (let i = 1; i <= totalPages.value; i++) pages.push(i)
  return pages
})

const filterSellers = () => { currentPage.value = 1 }
const viewSeller = (id) => router.push(`/admin/sellers/${id}`)
const editSeller = (id) => router.push(`/admin/sellers/edit/${id}`)

const remove = async (id) => {
  if (confirm("Bạn có chắc chắn muốn xoá người bán này?")) {
    try {
      await deleteSeller(id)
      await loadSellers()
    } catch (error) {
      alert('Có lỗi xảy ra khi xoá người bán!')
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