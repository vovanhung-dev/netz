<template>
    <div class="contacts">
        <div class="head">
            <h2 class="title">Contact Messages</h2>
            <input @keyup.enter=" searchNow " type="search" class="form-control w-25"
                placeholder="Search name / phone..." v-model.trim=" q " />
        </div>

        <div class="content">
            <table class="table table-fixed table-hover">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Phone</th>
                        <th>Email</th>
                        <th>Content</th>
                        <th>Status</th>
                        <th>Created At</th>
                        <th>Actions</th>
                    </tr>
                </thead>

                <tbody>
                    <tr v-for="(item, i) in rows" :key=" item.id ">
                        <td>{{ (page - 1) * perPage + i + 1 }}</td>
                        <td class="text-center">{{ item.name }}</td>
                        <td class="text-center">{{ item.phone }}</td>
                        <td class="text-center">{{ item.email || '—' }}</td>
                        <td class="text-center">
                            <span class="content-text">
                                {{ item.content || '—' }}
                            </span>
                        </td>
                        <td>
                            <div :class=" item.status === 'new' ? 'status-new' : 'status-other' ">
                                {{ item.status || '—' }}
                            </div>
                        </td>
                        <td>{{ item.created_at?.slice(0, 16).replace('T', ' ') || '—' }}</td>
                        <td style="width: 100px">
                            <RouterLink class="detail"
                                :to=" { name: 'admin-contacts-detail', params: { id: item.id } } ">
                                View
                            </RouterLink>
                        </td>
                    </tr>
                    <tr v-if="!rows.length">
                        <td colspan="8" class="text-center py-4 text-muted">No data</td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div class="paginate">
            <v-pagination v-model=" page " :pages=" pageCount " :range-size=" 0 " active-color="#3ea9e0"
                hide-first-button hide-last-button @update:modelValue=" load " />
        </div>
    </div>
</template>

<script setup lang="ts">
import { ref, onMounted } from 'vue'
import VPagination from '@hennge/vue3-pagination'
import '@hennge/vue3-pagination/dist/vue3-pagination.css'
import http from '@/api/http'

const rows = ref<any[]>([])
const page = ref(1)
const pageCount = ref(1)
const perPage = 10
const q = ref('')

const mapRow = (r: any) => ({
    id: r.id,
    name: r.name ?? '',
    phone: r.phone ?? '',
    email: r.email ?? '',
    content: r.content ?? '',
    status: r.status ?? '',
    created_at: r.created_at ?? '',
})

const load = async () => {
    const { data } = await http.get('/api/contacts', {
        params: {
            page: page.value,
            per_page: perPage,
            search: q.value || undefined,
        },
    })

    const list = data?.data ?? []
    const last = data?.last_page ?? 1

    rows.value = (Array.isArray(list) ? list : []).map(mapRow)
    pageCount.value = last || 1
}

const searchNow = async () => {
    page.value = 1
    await load()
}

onMounted(load)
</script>

<style scoped>
.detail {
    display: inline-block;
    padding: 6px 16px;
    border-radius: 20px;
    background: #3ea9e0;
    color: #fff;
    font-weight: 700;
    text-decoration: none;
}

.contacts {
    width: 100%;
    height: 100%;
}

.head {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 20px;
}

.head .title {
    margin: 0;
    font-size: 20px;
    font-weight: 800;
}

.paginate {
    margin-top: 20px;
    display: flex;
    align-items: center;
    justify-content: center;
    padding-bottom: 50px;
}

table {
    width: 100%;
}

td,
th {
    text-align: center;
}

th {
    font-weight: 800;
    text-transform: uppercase;
    font-size: 14px;
}

td {
    font-size: 14px;
}

.text-center {
    text-align: center;
}

.content-text {
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}

td div {
    font-size: 12px;
    display: block;
    text-align: center;
    border-radius: 50px;
    color: #fff;
    font-weight: 800;
    cursor: default;
}

.status-new {
    background: green;
}

.status-other {
    background: gray;
}
</style>

<style>
.PaginationControl {
    width: max-content;
}

.Control {
    display: none;
    width: 30px;
    height: 30px;
    border-radius: 10px;
}

.Control-active {
    border: 1px solid #ccc;
    display: block;
    background: #3ea9e0;
    fill: #fff;
}

.Page {
    width: 30px;
    height: 30px;
    border-radius: 10px;
    color: #000;
    transition: 0.3s;
    font-weight: 900;
}

.Page-active {
    width: 30px;
    height: 30px;
    border-radius: 10px;
    background: #3ea9e0;
    color: #fff;
}
</style>
