<template>
    <div class="career">
        <div class="head">
            <router-link :to=" { name: 'admin-careers-new' } " class="btn-add">
                Thêm Phần Tuyển Dụng Mới
            </router-link>

            <input @keyup.enter=" search " type="search" class="form-control w-25"
                placeholder="Nhập tên phần tuyển dụng..." v-model.trim=" valueSearch " />
        </div>

        <div class="content">
            <table class="table table-fixed table-hover">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Trạng thái</th>
                        <th scope="col">Tên phần tuyển dụng</th>
                        <th scope="col">Số lượng</th>
                        <th scope="col">Hạn đăng ký</th>
                        <th scope="col">Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(item, index) in data" :key=" item.id ">
                        <th scope="row">{{ (page - 1) * perPage + index + 1 }}</th>
                        <td>
                            <div v-if="item.active == 1" class="active">Hoạt động</div>
                            <div v-else class="not">Ẩn</div>
                        </td>
                        <td>{{ item.position }}</td>
                        <td>{{ item.number }}</td>
                        <td>{{ item.expiration_date }}</td>
                        <td style="width: 100px">
                            <router-link class="detail"
                                :to=" { name: 'admin-careers-edit', params: { id: item.id } } ">Xem chi tiết</router-link>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div class="paginate">
            <v-pagination v-model=" page " :pages=" pageNumber " :range-size=" 0 " active-color="#3ea9e0"
                :hideFirstButton=" true " :hideLastButton=" true " @update:modelValue=" getCareer " />
        </div>
    </div>
</template>

<script setup lang="ts">
import { onMounted, ref } from 'vue'
import VPagination from '@hennge/vue3-pagination'
import '@hennge/vue3-pagination/dist/vue3-pagination.css'
import http from '@/api/http'
import { useAuthStore } from '@/stores/auth'

const auth = useAuthStore()

// state
const page = ref(1)
const perPage = 10
const data = ref<any[]>([])
const pageNumber = ref(1)
const valueSearch = ref('')

const mapRow = (row: any) => ({
    id: row.id,
    active: row.is_open ? 1 : 0,
    position: row.position ?? row.name_en ?? '—',
    number: row.number ?? row.level_en ?? '___',
    expiration_date: formatDate(row.expiration_date),
})

const formatDate = (dateString: string | null): string => {
    if (!dateString) {
        return '___'
    }
    try {
        const date = new Date(dateString)
        return date.toLocaleDateString('vi-VN', {
            day: '2-digit',
            month: '2-digit',
            year: 'numeric',
            timeZone: 'Asia/Ho_Chi_Minh',
        })
    } catch (error) {
        return '___'
    }
}

const getCareer = async () => {
    const params: Record<string, any> = { page: page.value }
    if (valueSearch.value) params.search = valueSearch.value

    const res = await http.get('/api/admin/careers', { params })
    const payload: any = res.data

    const rows = payload?.data
        ?? payload?.careers?.data
        ?? payload?.careers
        ?? payload
    const last = payload?.last_page
        ?? payload?.careers?.last_page
        ?? 1
    const per = payload?.per_page
        ?? payload?.careers?.per_page
        ?? perPage

    let mapped = Array.isArray(rows) ? rows.map(mapRow) : []

    if (valueSearch.value && (!payload?.data && !payload?.careers?.data && !payload?.careers)) {
        const kw = valueSearch.value.toLowerCase()
        mapped = mapped.filter((r: any) => (r.position || '').toLowerCase().includes(kw))
    }

    data.value = mapped
    pageNumber.value = last || 1
        ; (perPage as any).value = per
}

const search = async () => {
    page.value = 1
    await getCareer()
}

onMounted(async () => {
    if (!auth.user && auth.token) {
        try { await auth.fetchMe() } catch { }
    }
    await getCareer()
})
</script>

<style scoped>
.career {
    width: 100%;
    height: 100%;
}

.head {
    display: flex;
    justify-content: space-between;
    margin-bottom: 20px;
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
    box-shadow: rgba(0, 0, 0, 0.4) 0px 2px 4px,
        rgba(0, 0, 0, 0.3) 0px 7px 13px -3px, rgba(0, 0, 0, 0.2) 0px -3px 0px inset;
    text-decoration: none;
    display: block;
}

.paginate {
    margin-top: 20px;
    display: flex;
    align-items: center;
    justify-content: center;
    padding-bottom: 50px;
}

.detail {
    text-decoration: none;
    display: block;
    background: #3ea9e0;
    border-radius: 20px;
    color: #fff;
    font-weight: 800;
}

table {
    width: 100%;
}

td div {
    font-size: 12px;
    display: block;
    text-align: center;
    border-radius: 50px;
    color: #fff;
    font-weight: 800;
    cursor: pointer;
}

td div.active {
    background: green;
}

td div.not {
    background: red;
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

tr {
    margin: 0;
    padding: 0;
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
    fill: #000;
    border: 1px solid #ccc;
    display: block;
    fill: #fff;
    background: #3ea9e0;
}

.Control-active:hover {
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