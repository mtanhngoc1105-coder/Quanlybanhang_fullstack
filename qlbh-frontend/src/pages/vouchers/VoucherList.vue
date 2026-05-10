<template>
  <div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
      <h2 class="fw-bold">Danh sách voucher</h2>
      <router-link to="/admin/vouchers/create" class="btn btn-primary shadow-sm">
        Thêm voucher
      </router-link>
    </div>

    <div class="search-filter mb-3">
      <input
        v-model="searchQuery"
        @input="filterVouchers"
        type="text"
        class="form-control shadow-sm"
        placeholder="Tìm kiếm voucher theo code, loại..."
        style="max-width: 400px;"
      >
    </div>

    <div v-if="filteredVouchers.length === 0 && searchQuery" class="alert alert-info shadow-sm">
      Không tìm thấy voucher nào phù hợp với "{{ searchQuery }}"
    </div>

    <div class="table-responsive shadow-sm rounded">
      <table class="table table-bordered table-hover align-middle mb-0">
        <thead class="table-dark">
          <tr>
            <th style="width: 70px;">ID</th>
            <th>Mã voucher</th>
            <th>Loại</th>
            <th>Giá trị</th>
            <th>Số lượng</th>
            <th>Trạng thái</th>
            <th class="text-center" style="width: 150px;">Thao tác</th>
            <th class="text-center" style="width: 80px;">Xem</th>
          </tr>
        </thead>

        <tbody>
          <tr v-for="v in paginatedVouchers" :key="v.id">
            <td class="fw-bold text-secondary">#{{ v.id }}</td>
            <td><span class="badge bg-light text-dark border">{{ v.code }}</span></td>
            <td class="text-capitalize">{{ v.type }}</td>
            <td class="fw-bold text-success">{{ formatValue(v.value, v.type) }}</td>
            <td>{{ v.quantity }}</td>
            <td>
              <span :class="v.status === 'active' ? 'text-primary' : 'text-danger'">
                ● {{ v.status }}
              </span>
            </td>
            
            <td>
              <div class="d-flex justify-content-center gap-2">
                <button @click="editVoucher(v.id)" class="btn btn-light btn-sm border shadow-sm px-2">
                  Sửa
                </button>
                <button @click="remove(v.id)" class="btn btn-danger btn-sm shadow-sm px-2">
                  Xóa
                </button>
              </div>
            </td>

            <td class="text-center">
              <a 
                href="javascript:void(0)" 
                @click="viewVoucher(v.id)" 
                class="view-icon-link" 
                title="Xem chi tiết"
              >
                👁️
              </a>
            </td>
          </tr>

          <tr v-if="vouchers.length === 0">
            <td colspan="9" class="text-center py-4 text-muted">Đang tải dữ liệu voucher...</td>
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
import voucherService from "../../services/voucherService"

const route = useRoute()
const router = useRouter()
const vouchers = ref([])
const searchQuery = ref('')
const currentPage = ref(1)
const itemsPerPage = ref(10)

onMounted(async () => {
  const urlSearch = route.query.search
  if (urlSearch) searchQuery.value = urlSearch
  await loadVouchers()
})

const loadVouchers = async () => {
  try {
    const res = await voucherService.getAll()
    vouchers.value = res.data.data.data || res.data.data || []
  } catch (error) {
    console.error('Error loading vouchers:', error)
    vouchers.value = []
  }
}

const filteredVouchers = computed(() => {
  if (!searchQuery.value.trim()) return vouchers.value
  const query = searchQuery.value.toLowerCase().trim()
  return vouchers.value.filter(voucher =>
    voucher.code?.toLowerCase().includes(query) ||
    voucher.type?.toLowerCase().includes(query) ||
    voucher.id?.toString().includes(query)
  )
})

const totalPages = computed(() => Math.ceil(filteredVouchers.value.length / itemsPerPage.value))

const paginatedVouchers = computed(() => {
  const start = (currentPage.value - 1) * itemsPerPage.value
  const end = start + itemsPerPage.value
  return filteredVouchers.value.slice(start, end)
})

const visiblePages = computed(() => {
  const pages = []
  for (let i = 1; i <= totalPages.value; i++) pages.push(i)
  return pages
})

const formatValue = (value, type) => {
  if (type === 'percentage') return `${value}%`
  return new Intl.NumberFormat('vi-VN', {
    style: 'currency',
    currency: 'VND'
  }).format(value || 0)
}

const filterVouchers = () => { currentPage.value = 1 }
const viewVoucher = (id) => router.push(`/admin/vouchers/${id}`)
const editVoucher = (id) => router.push(`/admin/vouchers/edit/${id}`)

const remove = async (id) => {
  if (confirm("Bạn có chắc chắn muốn xoá voucher này?")) {
    try {
      await voucherService.delete(id)
      await loadVouchers()
    } catch (error) {
      alert('Có lỗi xảy ra khi xoá voucher!')
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