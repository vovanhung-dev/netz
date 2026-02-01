<template>
    <div class="applications">
        <div class="head">
            <h2 class="title">Career Applications</h2>
            <input
                @keyup.enter="searchNow"
                type="search"
                class="form-control w-25"
                placeholder="Search name / phone / email..."
                v-model.trim="q"
            />
        </div>

        <div class="content">
            <table class="table table-fixed table-hover">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Phone</th>
                        <th>Email</th>
                        <th>Position</th>
                        <th>Created At</th>
                        <th>Actions</th>
                    </tr>
                </thead>

                <tbody>
                    <tr v-for="(item, i) in rows" :key="item.id">
                        <td>{{ (page - 1) * perPage + i + 1 }}</td>
                        <td class="text-center">{{ item.name }}</td>
                        <td class="text-center">{{ item.phone }}</td>
                        <td class="text-center">{{ item.email || '—' }}</td>
                        <td class="text-center">{{ item.position || '—' }}</td>
                        <td>{{ item.created_at?.slice(0, 16).replace('T', ' ') || '—' }}</td>
                        <td style="width: 100px">
                            <RouterLink
                                class="detail"
                                :to="{ name: 'admin-career-applications-detail', params: { id: item.id } }"
                            >
                                View
                            </RouterLink>
                        </td>
                    </tr>
                    <tr v-if="!rows.length">
                        <td colspan="7" class="text-center py-4 text-muted">No data</td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div class="paginate">
            <v-pagination
                v-model="page"
                :pages="pageCount"
                :range-size="0"
                active-color="#3ea9e0"
                hide-first-button
                hide-last-button
                @update:modelValue="load"
            />
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
    position: r.position ?? '',
    created_at: r.created_at ?? '',
})

const load = async () => {
    const { data } = await http.get('/api/career-applications', {
        params: {
            page: page.value,
            per_page: perPage,
            search: q.value || undefined,
        },
    })

    const list = (data as any)?.data ?? []
    const last = (data as any)?.last_page ?? 1

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
.applications {
    width: 100%;
    height: 100%;
}

.head {
    display: flex;
    justify-content: space-between;
    margin-bottom: 20px;
}

.title {
    font-size: 24px;
    font-weight: 700;
}

.paginate {
    margin-top: 20px;
    display: flex;
    align-items: center;
    justify-content: center;
    padding-bottom: 50px;
}

.detail {
    display: inline-block;
    padding: 6px 16px;
    border-radius: 20px;
    background: #3ea9e0;
    color: #fff;
    font-weight: 700;
    text-decoration: none;
}
</style>

