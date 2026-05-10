<template>
  <tr>
    <!-- ID -->
    <td>{{ category.id }}</td>

    <!-- TÊN DANH MỤC (có expand tree) -->
    <td>
      <div class="d-flex align-items-center">
        <button
          v-if="hasChildren"
          type="button"
          class="btn btn-link p-0 me-2"
          @click="toggle"
          :aria-label="expanded ? 'Collapse' : 'Expand'"
        >
          <span class="toggle-icon">{{ expanded ? '−' : '+' }}</span>
        </button>

        <span :style="indentStyle">{{ category.name }}</span>
      </div>
    </td>

    <!-- SLUG -->
    <td>{{ category.slug }}</td>

    <!-- PARENT -->
    <td>{{ parentLabel }}</td>

    <!-- NÚT SỬA + XOÁ -->
    <td class="text-center">
      <router-link 
        :to="`/admin/categories/${category.id}/edit`"
        class="btn btn-sm btn-edit me-2">
        Sửa
      </router-link>

      <button 
        type="button"
        class="btn btn-sm btn-delete"
        @click="removeCategory">
        Xóa
      </button>
    </td>

    <!-- NÚT XEM -->
    <td class="text-center">
      <router-link 
        :to="`/admin/categories/${category.id}`"
        class="btn-view">
        👁
      </router-link>
    </td>
  </tr>
</template>

<script setup>
import { computed } from "vue"

const props = defineProps({
  category: {
    type: Object,
    required: true
  },
  level: {
    type: Number,
    default: 0
  },
  expandedNodes: {
    type: Object,
    required: true
  }
})

const emit = defineEmits(["toggle-expand", "remove"])

const expanded = computed(() =>
  props.expandedNodes.has(props.category.id)
)

const hasChildren = computed(() =>
  Array.isArray(props.category.children) &&
  props.category.children.length > 0
)

const indentStyle = computed(() => ({
  paddingLeft: `${props.level * 18}px`
}))

const parentLabel = computed(() =>
  props.category.parent_id
    ? `#${props.category.parent_id}`
    : "Danh mục gốc"
)

const toggle = () => {
  emit("toggle-expand", props.category.id)
}

const removeCategory = () => {
  emit("remove", props.category.id)
}
</script>

<style scoped>
/* dấu + - expand */
.toggle-icon {
  font-weight: bold;
  font-size: 18px;
  color: #0d6efd;
}

/* ===== NÚT SỬA ===== */
.btn-edit {
  background: #f1f3f5;
  border: none;
  color: #333;
  padding: 6px 14px;
  border-radius: 8px;
  font-weight: 500;
  text-decoration: none;
}

.btn-edit:hover {
  background: #e5e7eb;
}

/* ===== NÚT XOÁ ===== */
.btn-delete {
  background: #e03131;
  border: none;
  color: white;
  padding: 6px 14px;
  border-radius: 8px;
  font-weight: 500;
}

.btn-delete:hover {
  background: #c92a2a;
}

/* ===== NÚT XEM (ICON TRÒN) ===== */
.btn-view {
  background: #fff;
  border: 2px solid #e9ecef;
  width: 34px;
  height: 34px;
  border-radius: 50%;
  display: inline-flex;
  align-items: center;
  justify-content: center;
  font-size: 16px;
  text-decoration: none;
}

.btn-view:hover {
  background: #f8f9fa;
}

/* button link expand */
.btn-link {
  font-weight: bold;
  color: #0d6efd;
}
</style>