<template>
  <div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
      <h2 class="fw-bold">Quản lý danh mục</h2>
      <router-link to="/admin/categories/create" class="btn btn-primary shadow-sm">
         Thêm danh mục
      </router-link>
    </div>

    <div class="search-filter mb-3">
      <input
        v-model="searchQuery"
        @input="filterCategories"
        type="text"
        class="form-control shadow-sm"
        placeholder="Tìm kiếm danh mục theo tên, ID..."
        style="max-width: 400px;"
      >
    </div>

    <div v-if="filteredCategories.length === 0 && searchQuery" class="alert alert-info shadow-sm">
      Không tìm thấy danh mục nào phù hợp với "{{ searchQuery }}"
    </div>

    <div class="table-responsive shadow-sm rounded">
      <table class="table table-bordered table-hover align-middle mb-0">
        <thead class="table-dark">
          <tr>
            <th style="width: 70px;">ID</th>
            <th>Tên danh mục</th>
            <th>Slug</th>
            <th>Danh mục cha</th>
            <th class="text-center" style="width: 150px;">Thao tác</th>
            <th class="text-center" style="width: 80px;">Xem</th>
          </tr>
        </thead>

        <tbody>
          <template v-for="category in treeCategories" :key="category.id">
            <CategoryTreeRow
              :category="category"
              :level="category.level"
              :expanded-nodes="expandedNodes"
              @toggle-expand="toggleExpand"
              @remove="remove"
            />
          </template>

          <tr v-if="categories.length === 0">
            <td colspan="6" class="text-center py-4 text-muted">Đang tải dữ liệu danh mục...</td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
</template>

<script setup>
import { ref, computed, onMounted, watch } from "vue"
import { useRoute } from "vue-router"
import categoryService from "../../services/categoryService"
import CategoryTreeRow from "./CategoryTreeRow.vue"

const route = useRoute()
const categories = ref([])
const searchQuery = ref('')
const currentPage = ref(1)
const itemsPerPage = ref(10)
const expandedNodes = ref(new Set())

const filteredCategories = computed(() => {
  if (!searchQuery.value.trim()) return categories.value
  const query = searchQuery.value.toLowerCase().trim()
  return categories.value.filter(category =>
    category.name?.toLowerCase().includes(query) ||
    category.id?.toString().includes(query) ||
    category.slug?.toLowerCase().includes(query)
  )
})

const treeCategories = computed(() => {
  const items = filteredCategories.value || []
  const map = new Map()

  items.forEach(category => {
    map.set(category.id, { ...category, children: [] })
  })

  const roots = []
  map.forEach(category => {
    if (category.parent_id && map.has(category.parent_id)) {
      map.get(category.parent_id).children.push(category)
    } else {
      roots.push(category)
    }
  })

  const sortTree = (nodes) => {
    nodes.sort((a, b) => {
      const nameA = a.name?.toString().toLowerCase() || ''
      const nameB = b.name?.toString().toLowerCase() || ''
      return nameA.localeCompare(nameB)
    })
    nodes.forEach(node => sortTree(node.children))
  }

  const flattenTree = (nodes, level = 0) => {
    return nodes.flatMap(node => {
      const row = { ...node, level }
      if (node.children.length > 0 && expandedNodes.value.has(node.id)) {
        return [row, ...flattenTree(node.children, level + 1)]
      }
      return [row]
    })
  }

  sortTree(roots)
  return flattenTree(roots)
})

const toggleExpand = (categoryId) => {
  const next = new Set(expandedNodes.value)
  if (next.has(categoryId)) {
    next.delete(categoryId)
  } else {
    next.add(categoryId)
  }
  expandedNodes.value = next
}

onMounted(async () => {
  const urlSearch = route.query.search
  if (urlSearch) searchQuery.value = urlSearch
  await loadCategories()
})

const loadCategories = async () => {
  try {
    const res = await categoryService.getAll()
    categories.value = res.data.data || []
  } catch (error) {
    console.error('Error loading categories:', error)
    categories.value = []
  }
}

const totalPages = computed(() => Math.ceil(filteredCategories.value.length / itemsPerPage.value))

const paginatedCategories = computed(() => {
  const start = (currentPage.value - 1) * itemsPerPage.value
  const end = start + itemsPerPage.value
  return filteredCategories.value.slice(start, end)
})

const visiblePages = computed(() => {
  const pages = []
  for (let i = 1; i <= totalPages.value; i++) {
    pages.push(i)
  }
  return pages
})

const remove = async (id) => {
  if (confirm("Bạn có chắc chắn muốn xoá danh mục này?")) {
    try {
      await categoryService.delete(id)
      await loadCategories()
    } catch (error) {
      alert('Có lỗi xảy ra khi xoá danh mục!')
    }
  }
}

const filterCategories = () => {
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