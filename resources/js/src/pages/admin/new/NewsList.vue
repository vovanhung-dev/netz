<template>
    <div class="news">
        <div class="head">
            <router-link :to="{ name: 'admin-news-new' }" class="btn-add">Add News</router-link>
            <input @keyup.enter="searchNow" type="search" class="form-control w-25" placeholder="Search title..."
                v-model.trim="q" />
        </div>

        <div class="content">
            <table class="table table-fixed table-hover">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Trạng thái</th>
                        <th>Tiêu đề</th>
                        <th>Slug</th>
                        <th>Ngày đăng</th>
                        <th>Tác giả</th>
                        <th>Hành động</th>
                    </tr>
                </thead>

                <tbody>
                    <tr v-for="(item, i) in rows" :key="item.id">
                        <td>{{ (page - 1) * perPage + i + 1 }}</td>
                        <td>
                            <div :class="item.status === 'published' ? 'active' : 'not'">
                                {{ item.status }}
                            </div>
                        </td>
                        <td class="text-left">{{ item.title }}</td>
                        <td class="text-left">{{ item.slug }}</td>
                        <td>{{ item.published_at?.slice(0, 16).replace('T', ' ') || '—' }}</td>
                        <td>{{ item.author_id ?? '—' }}</td>
                        <td style="width:100px">
                            <router-link class="detail" :to="{ name: 'admin-news-edit', params: { id: item.id } }">
                                View more
                            </router-link>
                        </td>
                    </tr>
                    <tr v-if="!rows.length">
                        <td colspan="7" class="text-center py-4 text-muted">No data</td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div class="paginate">
            <v-pagination v-model="page" :pages="pageCount" :range-size="0" active-color="#3ea9e0" hide-first-button
                hide-last-button @update:modelValue="load" />
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
    title: r.title ?? '',
    slug: r.slug ?? '',
    excerpt: r.excerpt ?? '',
    body: r.body ?? '',
    cover_image_url: r.cover_image_url ?? r.cover ?? '',
    status: r.status ?? 'draft',
    published_at: r.published_at ?? r.publishedAt ?? '',
    author_id: r.author_id ?? r.authorId ?? null,
})

const load = async () => {
    const { data } = await http.get('/api/admin/news', { params: { page: page.value, search: q.value || undefined } })
    const list = data?.data ?? data?.news?.data ?? data?.news ?? data
    const last = data?.last_page ?? data?.news?.last_page ?? 1
    rows.value = (Array.isArray(list) ? list : []).map(mapRow)
    pageCount.value = last || 1
}

const searchNow = async () => { page.value = 1; await load() }
onMounted(load)
</script>

<style scoped>
.news {
    width: 100%;
    height: 100%
}

.head {
    display: flex;
    justify-content: space-between;
    margin-bottom: 20px
}

.head .btn-add {
    height: 40px;
    line-height: 40px;
    padding: 0 20px;
    border-radius: 20px;
    color: #fff;
    font-size: 14px;
    font-weight: 800;
    background: #3ea9e0;
    box-shadow: rgba(0, 0, 0, .4)0 2px 4px, rgba(0, 0, 0, .3)0 7px 13px -3px, rgba(0, 0, 0, .2)0 -3px 0 inset;
    text-decoration: none;
    display: block
}

.paginate {
    margin-top: 20px;
    display: flex;
    align-items: center;
    justify-content: center;
    padding-bottom: 50px
}

.detail {
    text-decoration: none;
    display: block;
    background: #3ea9e0;
    border-radius: 20px;
    color: #fff;
    font-weight: 800
}

table {
    width: 100%
}

td div {
    font-size: 12px;
    display: block;
    text-align: center;
    border-radius: 50px;
    color: #fff;
    font-weight: 800;
    cursor: pointer
}

td div.active {
    background: green
}

td div.not {
    background: gray
}

td,
th {
    text-align: center
}

th {
    font-weight: 800;
    text-transform: uppercase;
    font-size: 14px
}

td {
    font-size: 14px
}

tr {
    margin: 0;
    padding: 0
}
</style>
<style>
.PaginationControl {
    width: max-content
}

.Control {
    display: none;
    width: 30px;
    height: 30px;
    border-radius: 10px
}

.Control-active {
    border: 1px solid #ccc;
    display: block;
    background: #3ea9e0;
    fill: #fff
}

.Page {
    width: 30px;
    height: 30px;
    border-radius: 10px;
    color: #000;
    transition: .3s;
    font-weight: 900
}

.Page-active {
    width: 30px;
    height: 30px;
    border-radius: 10px;
    background: #3ea9e0;
    color: #fff
}
</style>