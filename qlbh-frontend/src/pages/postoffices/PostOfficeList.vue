<template>
  <div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
      <h2 class="fw-bold">Danh sách bưu cục</h2>
      <router-link to="/admin/postoffices/create" class="btn btn-primary shadow-sm">
        Thêm bưu cục
      </router-link>
    </div>

    <div class="search-filter mb-3">
      <input
        v-model="searchQuery"
        @input="filterPostOffices"
        type="text"
        class="form-control shadow-sm"
        placeholder="Tìm kiếm bưu cục theo tên chi nhánh, hotline..."
        style="max-width: 400px;"
      >
    </div>

    <div v-if="filteredPostOffices.length === 0 && searchQuery" class="alert alert-info shadow-sm">
      Không tìm thấy bưu cục nào phù hợp với "{{ searchQuery }}"
    </div>

    <div class="table-responsive shadow-sm rounded">
      <table class="table table-bordered table-hover align-middle mb-0">
        <thead class="table-dark">
          <tr>
            <th style="width: 70px;">ID</th>
            <th>Người bán</th>
            <th>Chi nhánh</th>
            <th>Hotline</th>
            <th class="text-center" style="width: 150px;">Thao tác</th>
            <th class="text-center" style="width: 80px;">Xem</th>
          </tr>
        </thead>

        <tbody>
          <tr v-for="p in paginatedPostOffices" :key="p.id">
            <td class="fw-bold text-secondary">#{{ p.id }}</td>
            <td class="fw-semibold">{{ p.seller?.seller_name || 'N/A' }}</td>
            <td>{{ p.branch_office }}</td>
            <td>{{ p.hotline }}</td>
            
            <td>
              <div class="d-flex justify-content-center gap-2">
                <button @click="editPostOffice(p.id)" class="btn btn-light btn-sm border shadow-sm px-2">
                  Sửa
                </button>
                <button @click="remove(p.id)" class="btn btn-danger btn-sm shadow-sm px-2">
                  Xóa
                </button>
              </div>
            </td>

            <td class="text-center">
              <a 
                href="javascript:void(0)" 
                @click="viewPostOffice(p.id)" 
                class="view-icon-link" 
                title="Xem chi tiết"
              >
                👁️
              </a>
            </td>
          </tr>

          <tr v-if="postOffices.length === 0">
            <td colspan="6" class="text-center py-4 text-muted">Đang tải dữ liệu bưu cục...</td>
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
import { getPostOffices, deletePostOffice } from "../../services/postOfficeService"

const route = useRoute()
const router = useRouter()
const postOffices = ref([])
const searchQuery = ref('')
const currentPage = ref(1)
const itemsPerPage = ref(10)

onMounted(async () => {
  const urlSearch = route.query.search
  if (urlSearch) searchQuery.value = urlSearch
  await loadPostOffices()
})

const loadPostOffices = async () => {
  try {
    const res = await getPostOffices()
    // Giữ cấu trúc cũ: res.data.data.data
    postOffices.value = res.data.data.data || res.data.data || []
  } catch (error) {
    console.error('Error loading post offices:', error)
    postOffices.value = []
  }
}

const filteredPostOffices = computed(() => {
  if (!searchQuery.value.trim()) return postOffices.value
  const query = searchQuery.value.toLowerCase().trim()
  return postOffices.value.filter(po =>
    po.branch_office?.toLowerCase().includes(query) ||
    po.hotline?.toLowerCase().includes(query) ||
    po.seller?.seller_name?.toLowerCase().includes(query) ||
    po.id?.toString().includes(query)
  )
})

const totalPages = computed(() => Math.ceil(filteredPostOffices.value.length / itemsPerPage.value))

const paginatedPostOffices = computed(() => {
  const start = (currentPage.value - 1) * itemsPerPage.value
  const end = start + itemsPerPage.value
  return filteredPostOffices.value.slice(start, end)
})

const visiblePages = computed(() => {
  const pages = []
  for (let i = 1; i <= totalPages.value; i++) pages.push(i)
  return pages
})

const filterPostOffices = () => { currentPage.value = 1 }
const viewPostOffice = (id) => router.push(`/admin/postoffices/${id}`)
const editPostOffice = (id) => router.push(`/admin/postoffices/edit/${id}`)

const remove = async (id) => {
  if (confirm("Bạn có chắc chắn muốn xoá bưu cục này?")) {
    try {
      await deletePostOffice(id)
      await loadPostOffices()
    } catch (error) {
      alert('Có lỗi xảy ra khi xoá bưu cục!')
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