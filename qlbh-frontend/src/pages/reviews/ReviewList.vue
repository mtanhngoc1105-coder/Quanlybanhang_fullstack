<template>
  <div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
      <h2 class="fw-bold">Danh sách đánh giá</h2>
      <router-link to="/admin/reviews/create" class="btn btn-primary shadow-sm">
         Thêm đánh giá
      </router-link>
    </div>

    <div class="search-filter mb-3">
      <input
        v-model="searchQuery"
        @input="filterReviews"
        type="text"
        class="form-control shadow-sm"
        placeholder="Tìm kiếm đánh giá theo ID đơn hàng, khách hàng..."
        style="max-width: 400px;"
      >
    </div>

    <div v-if="filteredReviews.length === 0 && searchQuery" class="alert alert-info shadow-sm">
      Không tìm thấy đánh giá nào phù hợp với "{{ searchQuery }}"
    </div>

    <div class="table-responsive shadow-sm rounded">
      <table class="table table-bordered table-hover align-middle mb-0">
        <thead class="table-dark">
          <tr>
            <th style="width: 70px;">ID</th>
            <th>Đơn hàng</th>
            <th>Khách hàng</th>
            <th>Đánh giá</th>
            <th class="text-center" style="width: 150px;">Thao tác</th>
            <th class="text-center" style="width: 80px;">Xem</th>
          </tr>
        </thead>

        <tbody>
          <tr v-for="r in paginatedReviews" :key="r.id">
            <td class="fw-bold text-secondary">#{{ r.id }}</td>
            <td>#{{ r.order_id }}</td>
            <td>#{{ r.customer_id }}</td>
            <td class="text-warning fw-bold">⭐ {{ r.rating }}/5</td>
            
            <td>
              <div class="d-flex justify-content-center gap-2">
                <button @click="editReview(r.id)" class="btn btn-light btn-sm border shadow-sm px-2">
                  Sửa
                </button>
                <button @click="remove(r.id)" class="btn btn-danger btn-sm shadow-sm px-2">
                  Xóa
                </button>
              </div>
            </td>

            <td class="text-center">
              <a 
                href="javascript:void(0)" 
                @click="viewReview(r.id)" 
                class="view-icon-link" 
                title="Xem chi tiết"
              >
                👁️
              </a>
            </td>
          </tr>

          <tr v-if="reviews.length === 0">
            <td colspan="6" class="text-center py-4 text-muted">Đang tải dữ liệu đánh giá...</td>
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
import { getReviews, deleteReview } from "../../services/reviewService"

const route = useRoute()
const router = useRouter()
const reviews = ref([])
const searchQuery = ref('')
const currentPage = ref(1)
const itemsPerPage = ref(10)

onMounted(async () => {
  const urlSearch = route.query.search
  if (urlSearch) searchQuery.value = urlSearch
  await loadReviews()
})

const loadReviews = async () => {
  try {
    const res = await getReviews()
    // Theo cấu trúc res.data.data.data
    reviews.value = res.data.data.data || res.data.data || []
  } catch (error) {
    console.error('Error loading reviews:', error)
    reviews.value = []
  }
}

const filteredReviews = computed(() => {
  if (!searchQuery.value.trim()) return reviews.value
  const query = searchQuery.value.toLowerCase().trim()
  return reviews.value.filter(review =>
    review.id?.toString().includes(query) ||
    review.order_id?.toString().includes(query) ||
    review.customer_id?.toString().includes(query) ||
    review.rating?.toString().includes(query)
  )
})

const totalPages = computed(() => Math.ceil(filteredReviews.value.length / itemsPerPage.value))

const paginatedReviews = computed(() => {
  const start = (currentPage.value - 1) * itemsPerPage.value
  const end = start + itemsPerPage.value
  return filteredReviews.value.slice(start, end)
})

const visiblePages = computed(() => {
  const pages = []
  for (let i = 1; i <= totalPages.value; i++) pages.push(i)
  return pages
})

const filterReviews = () => { currentPage.value = 1 }
const viewReview = (id) => router.push(`/admin/reviews/${id}`)
const editReview = (id) => router.push(`/admin/reviews/edit/${id}`)

const remove = async (id) => {
  if (confirm("Bạn có chắc chắn muốn xoá đánh giá này?")) {
    try {
      await deleteReview(id)
      await loadReviews()
    } catch (error) {
      alert('Có lỗi xảy ra khi xoá đánh giá!')
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