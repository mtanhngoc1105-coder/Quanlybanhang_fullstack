<template>
  <div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
  <h2 class="mb-0">Danh sách sản phẩm</h2>

  <router-link to="/admin/products/create" class="btn btn-primary shadow-sm">
     Thêm sản phẩm
  </router-link>
</div>
<div class="search-filter mb-3 d-flex justify-content-between align-items-center">

  
  <input 
    v-model="searchQuery" 
    @input="filterProducts"
    type="text" 
    class="form-control shadow-sm"
    placeholder="Tìm kiếm sản phẩm theo tên, ID, giá..."
    style="max-width: 420px;"
  >

  <button 
    @click="reloadProducts"
    class="btn btn-outline-secondary shadow-sm"
    :disabled="loading"
  >
    <span v-if="loading" class="spinner-border spinner-border-sm me-2"></span>
     Reload
  </button>

</div>
    <div v-if="filteredProducts.length === 0 && searchQuery" class="alert alert-info shadow-sm">
      Không tìm thấy sản phẩm nào phù hợp với "{{ searchQuery }}"
    </div>

    <div class="table-responsive shadow-sm rounded">
      <table class="table table-bordered table-hover align-middle mb-0">
        <thead class="table-dark">
          <tr>
            <th style="width: 70px;">ID</th>
            <th>Tên sản phẩm</th>
            <th>Giá</th>
            <th>Danh mục</th>
            <th>Số lượng</th>
            <th>Trạng thái</th>
            <th class="text-center" style="width: 150px;">Thao tác</th>
            <th class="text-center" style="width: 80px;">Xem</th>
          </tr>
        </thead>

        <tbody>
          <tr v-for="p in paginatedProducts" :key="p.id">
            <td class="fw-bold text-secondary">#{{ p.id }}</td>
            <td>{{ p.product_name }}</td>
            <td class="text-danger fw-semibold">{{ formatPrice(p.price) }}</td>
            
            <td>
              {{ p.category?.name || 'Chưa phân loại' }}
            </td>
            
            <td>{{ p.quantity || 0 }}</td>
            
            <td>
              <span :class="p.state === 'active' ? 'text-success' : 'text-warning'">
                ● {{ p.state || 'unknown' }}
              </span>
            </td>
            
            <td>
              <div class="d-flex justify-content-center gap-2">
                <router-link :to="`/admin/products/edit/${p.id}`" class="btn btn-light btn-sm border shadow-sm px-2">
                  Sửa
                </router-link>
                <button @click="remove(p.id)" class="btn btn-danger btn-sm shadow-sm px-2">
                  Xóa
                </button>
              </div>
            </td>

            <td class="text-center">
              <router-link 
                :to="`/admin/products/${p.id}`" 
                class="view-icon-link" 
                title="Xem chi tiết"
              >
                👁️
              </router-link>
            </td>
          </tr>

          <tr v-if="products.length === 0">
            <td colspan="8" class="text-center py-4 text-muted">Đang tải dữ liệu sản phẩm...</td>
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
import { getProducts, deleteProduct } from "../../services/productService"

const loading = ref(false)
const route = useRoute()
const products = ref([])
const searchQuery = ref('')
const currentPage = ref(1)
const itemsPerPage = ref(10)

onMounted(async () => {
  const urlSearch = route.query.search
  if (urlSearch) searchQuery.value = urlSearch
  await loadProducts()
})

const loadProducts = async () => {
  try {
    loading.value = true
    const res = await getProducts()
    products.value = res.data.data.data || []
  } catch (error) {
    console.error('Error loading products:', error)
    products.value = []
  } finally {
    loading.value = false
  }
}
/**
 * Lọc sản phẩm dựa trên searchQuery. Tìm kiếm sẽ được thực hiện trên tên sản phẩm, mã sản phẩm, ID và giá.
 * Nếu searchQuery rỗng, sẽ trả về tất cả sản phẩm. Kết quả sẽ được cập nhật mỗi khi searchQuery thay đổi.
  * @returns {Array} Mảng sản phẩm đã được lọc
 */
const filteredProducts = computed(() => {
  if (!searchQuery.value.trim()) return products.value

  const query = searchQuery.value.toLowerCase().trim()

  return products.value.filter(product =>
    product.product_name?.toLowerCase().includes(query) ||     
    product.product_code?.toLowerCase().includes(query) ||     
    product.id?.toString().includes(query) ||                  
    product.price?.toString().includes(query)                  
  )
})

const totalPages = computed(() => Math.ceil(filteredProducts.value.length / itemsPerPage.value))

const paginatedProducts = computed(() => {
  const start = (currentPage.value - 1) * itemsPerPage.value
  const end = start + itemsPerPage.value
  return filteredProducts.value.slice(start, end)
})

const visiblePages = computed(() => {
  const pages = []
  for (let i = 1; i <= totalPages.value; i++) {
    pages.push(i)
  }
  return pages
})

const formatPrice = (price) => {
  return new Intl.NumberFormat('vi-VN', { 
    style: 'currency', 
    currency: 'VND' 
  }).format(price || 0)
}
const reloadProducts = async () => {
  currentPage.value = 1
  await loadProducts()
}
const remove = async (id) => {
  if (confirm("Bạn có chắc chắn muốn xoá sản phẩm này?")) {
    try {
      await deleteProduct(id)
      await reloadProducts() 
    } catch (error) {
      alert('Có lỗi xảy ra khi xoá sản phẩm!')
    }
  }
}

const filterProducts = () => {
  currentPage.value = 1
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