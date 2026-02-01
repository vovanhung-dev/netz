<!-- <template>
    <div class="application-detail" v-if="loaded">
        <h1 class="heading">Career Application Detail</h1>

        <div class="actions">
            <RouterLink :to=" { name: 'admin-career-applications' } " class="btn-back">
                Back to list
            </RouterLink>
        </div>

        <div class="card">
            <div class="row">
                <div class="col">
                    <label class="form-label">Name</label>
                    <p class="field">{{ application.name || '—' }}</p>
                </div>
                <div class="col">
                    <label class="form-label">Phone</label>
                    <p class="field">{{ application.phone || '—' }}</p>
                </div>
            </div>

            <div class="row">
                <div class="col">
                    <label class="form-label">Email</label>
                    <p class="field">{{ application.email || '—' }}</p>
                </div>
                <div class="col">
                    <label class="form-label">Position</label>
                    <p class="field">{{ application.position || '—' }}</p>
                </div>
            </div>

            <div class="row">
                <div class="col">
                    <label class="form-label">Address</label>
                    <p class="field multiline">{{ application.address || '—' }}</p>
                </div>
                <div class="col">
                    <label class="form-label">CV File</label>
                    <p class="field">
                    <p class="field">{{ application.cv_path || '—' }}</p>
                    <a v-if="cvUrl" :href=" cvUrl " target="_blank" rel="noopener" class="btn-download">
                        Download CV
                    </a>
                    <span v-else>—</span>
                    </p>
                </div>
            </div>

            <div class="row">
                <div class="col">
                    <label class="form-label">Created At</label>
                    <p class="field">{{ formattedDate(application.created_at) }}</p>
                </div>
                <div class="col">
                    <label class="form-label">Updated At</label>
                    <p class="field">{{ formattedDate(application.updated_at) }}</p>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup lang="ts">
import { ref, computed, onMounted } from 'vue'
import { useRoute } from 'vue-router'
import http from '@/api/http'

const route = useRoute()
const id = computed(() => route.params.id as string)

const loaded = ref(false)
const application = ref<any>({})

const formattedDate = (val?: string | null) => {
    if (!val) return '—'
    return val.slice(0, 16).replace('T', ' ')
}

const cvUrl = computed(() => {
    const p = (application.value as any)?.cv_path as string | undefined
    if (!p) return ''
    return '/storage/' + p.replace(/^public[\\/]/, '')
})

const load = async () => {
    const { data } = await http.get(`/api/career-applications/${ id.value }`)
    const src = (data as any)?.data ?? data
    application.value = src || {}
    loaded.value = true
}

onMounted(load)
</script>

<style scoped>
.application-detail {
    width: 100%;
    height: 100%;
}

.heading {
    font-size: 32px;
    font-weight: 800;
    text-align: center;
    margin-bottom: 30px;
    color: #3ea9e0;
    text-transform: uppercase;
}

.actions {
    margin-bottom: 20px;
    text-align: right;
}

.btn-back {
    display: inline-block;
    padding: 6px 16px;
    border-radius: 20px;
    background: #3ea9e0;
    color: #fff;
    font-weight: 700;
    text-decoration: none;
}

.card {
    border-radius: 10px;
    border: 1px solid #eee;
    padding: 20px;
    background: #fafafa;
}

.row {
    display: flex;
    gap: 20px;
    margin-bottom: 15px;
}

.col {
    flex: 1;
}

.form-label {
    font-weight: 700;
    margin-bottom: 4px;
    display: block;
}

.field {
    min-height: 32px;
    padding: 6px 10px;
    border-radius: 6px;
    background: #fff;
    border: 1px solid #e0e0e0;
    font-size: 14px;
    word-break: break-word;
}

.multiline {
    white-space: pre-wrap;
}

.btn-download {
    display: inline-block;
    padding: 4px 12px;
    border-radius: 20px;
    background: #3ea9e0;
    color: #fff;
    font-size: 13px;
    text-decoration: none;
}
</style> -->
<template>
    <div class="application-detail" v-if="loaded">
        <h1 class="heading">Career Application Detail</h1>

        <div class="actions">
            <RouterLink :to=" { name: 'admin-career-applications' } " class="btn-back">
                Back to list
            </RouterLink>
        </div>

        <div class="card">
            <div class="row">
                <div class="col">
                    <label class="form-label">Name</label>
                    <p class="field">{{ application.name || '—' }}</p>
                </div>
                <div class="col">
                    <label class="form-label">Phone</label>
                    <p class="field">{{ application.phone || '—' }}</p>
                </div>
            </div>

            <div class="row">
                <div class="col">
                    <label class="form-label">Email</label>
                    <p class="field">{{ application.email || '—' }}</p>
                </div>
                <div class="col">
                    <label class="form-label">Position</label>
                    <p class="field">{{ application.position || '—' }}</p>
                </div>
            </div>

            <div class="row">
                <div class="col">
                    <label class="form-label">Address</label>
                    <p class="field multiline">{{ application.address || '—' }}</p>
                </div>
                <div class="col">
                    <label class="form-label">CV File</label>
                    <p class="field">
                        <template v-if="cvUrl">
                            <a :href=" cvUrl " target="_blank" rel="noopener" class="cv-link">
                                {{ cvFileName || 'View CV' }}
                            </a>
                            <a :href=" cvUrl " download class="btn-download">
                                Download
                            </a>
                        </template>
                        <span v-else>—</span>
                    </p>
                </div>
            </div>

            <div class="row">
                <div class="col">
                    <label class="form-label">Created At</label>
                    <p class="field">{{ formattedDate(application.created_at) }}</p>
                </div>
                <div class="col">
                    <label class="form-label">Updated At</label>
                    <p class="field">{{ formattedDate(application.updated_at) }}</p>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup lang="ts">
import { ref, computed, onMounted } from 'vue'
import { useRoute } from 'vue-router'
import http from '@/api/http'

const route = useRoute()
const id = computed(() => route.params.id as string)

const loaded = ref(false)
const application = ref<any>({})

const formattedDate = (val?: string | null) => {
    if (!val) return '—'
    return val.slice(0, 16).replace('T', ' ')
}

// Tạo URL CV chuẩn để mở/ tải về
const cvUrl = computed(() => {
    const p = (application.value as any)?.cv_path as string | undefined
    if (!p) return ''

    // Nếu BE trả về link full (https://...) thì dùng luôn
    if (p.startsWith('http://') || p.startsWith('https://')) {
        return p
    }

    // Nếu đã là /storage/... thì giữ nguyên
    if (p.startsWith('/storage/')) {
        return p
    }

    // Loại bỏ prefix public/ hoặc public\
    const cleaned = p.replace(/^public[\\/]/, '')

    // Map sang symlink storage
    return `/storage/${ cleaned }`
})

// Lấy tên file từ đường dẫn để hiển thị
const cvFileName = computed(() => {
    const p = (application.value as any)?.cv_path as string | undefined
    if (!p) return ''
    const parts = p.split(/[\\/]/)
    return parts[parts.length - 1] || ''
})

const load = async () => {
    const { data } = await http.get(`/api/career-applications/${ id.value }`)
    const src = (data as any)?.data ?? data
    application.value = src || {}
    loaded.value = true
}

onMounted(load)
</script>

<style scoped>
.application-detail {
    width: 100%;
    height: 100%;
}

.heading {
    font-size: 32px;
    font-weight: 800;
    text-align: center;
    margin-bottom: 30px;
    color: #3ea9e0;
    text-transform: uppercase;
}

.actions {
    margin-bottom: 20px;
    text-align: right;
}

.btn-back {
    display: inline-block;
    padding: 6px 16px;
    border-radius: 20px;
    background: #3ea9e0;
    color: #fff;
    font-weight: 700;
    text-decoration: none;
}

.card {
    border-radius: 10px;
    border: 1px solid #eee;
    padding: 20px;
    background: #fafafa;
}

.row {
    display: flex;
    gap: 20px;
    margin-bottom: 15px;
}

.col {
    flex: 1;
}

.form-label {
    font-weight: 700;
    margin-bottom: 4px;
    display: block;
}

.field {
    min-height: 32px;
    padding: 6px 10px;
    border-radius: 6px;
    background: #fff;
    border: 1px solid #e0e0e0;
    font-size: 14px;
    word-break: break-word;
}

.multiline {
    white-space: pre-wrap;
}

.cv-link {
    margin-right: 8px;
    text-decoration: underline;
    font-size: 13px;
}

.btn-download {
    display: inline-block;
    padding: 4px 12px;
    border-radius: 20px;
    background: #3ea9e0;
    color: #fff;
    font-size: 13px;
    text-decoration: none;
}
</style>
