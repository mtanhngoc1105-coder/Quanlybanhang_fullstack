<template>
  <div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
      <h2 class="fw-bold">Danh sách khách hàng</h2>
      <router-link to="/admin/customers/create" class="btn btn-success shadow-sm">
        Thêm khách hàng
      </router-link>
    </div>

    <div class="search-filter mb-3">
      <input 
        v-model="searchQuery" 
        @input="filterCustomers"
        type="text" 
        class="form-control shadow-sm" 
        placeholder="Tìm kiếm khách hàng theo tên, email, phone..."
        style="max-width: 400px;"
      >
    </div>

    <div v-if="filteredCustomers.length === 0 && searchQuery" class="alert alert-info shadow-sm">
      Không tìm thấy khách hàng nào phù hợp với "{{ searchQuery }}"
    </div>

    <div class="table-responsive shadow-sm rounded">
      <table class="table table-bordered table-hover align-middle mb-0">
        <thead class="table-dark">
          <tr>
            <th style="width: 70px;">ID</th>
            <th>Tên khách hàng</th>
            <th>Email</th>
            <th>Số điện thoại</th>
            <th class="text-center" style="width: 150px;">Thao tác</th>
            <th class="text-center" style="width: 80px;">Xem</th>
          </tr>
        </thead>

        <tbody>
          <tr v-for="c in paginatedCustomers" :key="c.id">
            <td class="fw-bold text-secondary">#{{ c.id }}</td>
            <td class="fw-semibold">{{ c.name }}</td>
            <td>{{ c.email }}</td>
            <td>{{ c.phone }}</td>
            
            <td>
              <div class="d-flex justify-content-center gap-2">
                <router-link :to="`/admin/customers/edit/${c.id}`" class="btn btn-light btn-sm border shadow-sm px-2">
                  Sửa
                </router-link>
                <button @click="remove(c.id)" class="btn btn-danger btn-sm shadow-sm px-2">
                  Xoá
                </button>
              </div>
            </td>

            <td class="text-center">
              <router-link 
                :to="`/admin/customers/${c.id}`" 
                class="view-icon-link" 
                title="Xem chi tiết"
              >
                👁️
              </router-link>
            </td>
          </tr>

          <tr v-if="customers.length === 0">
            <td colspan="6" class="text-center py-4 text-muted">Đang tải dữ liệu khách hàng...</td>
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
import { useRoute } from "vue-router"
import { getCustomers, deleteCustomer } from "../../api/customerApi"

const route = useRoute()
const customers = ref([])
const searchQuery = ref('')
const currentPage = ref(1)
const itemsPerPage = ref(10)

onMounted(async () => {
  const urlSearch = route.query.search
  if (urlSearch) searchQuery.value = urlSearch
  await loadCustomers()
})

const loadCustomers = async () => {
  try {
    const res = await getCustomers()
    // Lưu ý: data.data.data dựa theo code cũ của bạn
    customers.value = res.data.data.data || []
  } catch (error) {
    console.error('Error loading customers:', error)
    customers.value = []
  }
}

const filteredCustomers = computed(() => {
  if (!searchQuery.value.trim()) return customers.value
  const query = searchQuery.value.toLowerCase().trim()
  return customers.value.filter(customer => 
    customer.name?.toLowerCase().includes(query) ||
    customer.email?.toLowerCase().includes(query) ||
    customer.phone?.toLowerCase().includes(query) ||
    customer.id?.toString().includes(query)
  )
})

const totalPages = computed(() => Math.ceil(filteredCustomers.value.length / itemsPerPage.value))

const paginatedCustomers = computed(() => {
  const start = (currentPage.value - 1) * itemsPerPage.value
  const end = start + itemsPerPage.value
  return filteredCustomers.value.slice(start, end)
})

const visiblePages = computed(() => {
  const pages = []
  for (let i = 1; i <= totalPages.value; i++) pages.push(i)
  return pages
})

const filterCustomers = () => {
  currentPage.value = 1
}

const remove = async (id) => {
  if (confirm("Bạn có chắc chắn muốn xoá khách hàng này?")) {
    try {
      await deleteCustomer(id)
      await loadCustomers()
    } catch (error) {
      alert('Có lỗi xảy ra khi xoá khách hàng!')
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
}

.view-icon-link:hover {
  transform: scale(1.3);
}

.page-link {
  cursor: pointer;
}
</style>