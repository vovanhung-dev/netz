<template>
  <div class="courses">
    <div class="head">
      <router-link :to=" { name: 'admin-course-new' } " class="btn-add">Add Course</router-link>
      <input @keyup.enter=" searchNow " type="search" class="form-control w-25" placeholder="Search title..."
        v-model.trim=" q " />
    </div>

    <div class="content">
      <table class="table table-fixed table-hover">
        <thead>
          <tr>
            <th>#</th>
            <th>Status</th>
            <th>Title</th>
            <th>Slug</th>
            <th>Published At</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="(item, idx) in items" :key=" item.id ">
            <td>{{ idx + 1 + (meta.current_page - 1) * meta.per_page }}</td>
            <td>
              <span class="badge"
                :class=" item.status === 'published' ? 'bg-success' : 'bg-secondary' ">{{ item.status }}</span>
            </td>
            <td>{{ item.title }}</td>
            <td>{{ item.slug }}</td>
            <td>{{ formatDate(item.published_at) }}</td>
            <td>
              <router-link :to=" { name: 'admin-course-edit', params: { id: item.id } } "
                class="btn btn-sm btn-primary me-2">Edit</router-link>
              <button class="btn btn-sm btn-danger" @click="remove(item)">Delete</button>
            </td>
          </tr>
        </tbody>
      </table>

      <div class="pagination" v-if="meta.last_page > 1">
        <button class="Page" :class=" { 'Page-active': p === meta.current_page } " v-for="p in meta.last_page"
          :key=" p " @click="goto(p)">
          {{ p }}
        </button>
      </div>
    </div>
  </div>
</template>

<script setup lang="ts">
import { ref, onMounted } from 'vue'
import http from '@/api/http'

const items = ref<any[]>([])
const meta = ref({ current_page: 1, last_page: 1, per_page: 10, total: 0 })
const page = ref(1)
const q = ref('')

function formatDate(v?: string) {
  if (!v) return ''
  try { return new Date(v).toLocaleString() } catch (_) { return v }
}

async function fetchList() {
  const res = await http.get('/api/admin/courses', { params: { page: page.value, search: q.value || undefined } })
  items.value = res.data.data || []
  meta.value = {
    current_page: res.data.current_page,
    last_page: res.data.last_page,
    per_page: res.data.per_page,
    total: res.data.total,
  }
}

function searchNow() {
  page.value = 1
  fetchList()
}
function goto(p: number) {
  page.value = p
  fetchList()
}
async function remove(item: any) {
  if (!confirm('Delete this course?')) return
  await http.delete(`/api/admin/courses/${ item.id }`)
  fetchList()
}

onMounted(fetchList)
</script>

<style scoped>
.head {
  display: flex;
  gap: 12px;
  align-items: center;
  margin-bottom: 12px;
}

.btn-add {
  background: #3ea9e0;
  color: #fff;
  padding: 8px 14px;
  border-radius: 10px;
  font-weight: 700;
  text-decoration: none;
}

.table {
  width: 100%;
}

.pagination {
  display: flex;
  gap: 8px;
  margin-top: 12px;
}

.Page {
  width: 30px;
  height: 30px;
  border-radius: 10px;
}

.Page-active {
  background: #3ea9e0;
  color: #fff;
}
</style>
