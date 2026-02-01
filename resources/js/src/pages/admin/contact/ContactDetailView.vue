<template>
    <div class="contact-detail" v-if="loaded">
        <h1 class="heading">Contact Message Detail</h1>

        <div class="actions">
            <RouterLink :to="{ name: 'admin-contacts' }" class="btn-back">
                Back to list
            </RouterLink>
        </div>

        <div class="card">
            <div class="row">
                <div class="col">
                    <label class="form-label">Name</label>
                    <p class="field">{{ contact.name || '—' }}</p>
                </div>
                <div class="col">
                    <label class="form-label">Phone</label>
                    <p class="field">{{ contact.phone || '—' }}</p>
                </div>
            </div>

            <div class="row">
                <div class="col">
                    <label class="form-label">Email</label>
                    <p class="field">{{ contact.email || '—' }}</p>
                </div>
                <div class="col">
                    <label class="form-label">Status</label>
                    <p class="field">
                        <span :class="contact.status === 'new' ? 'badge badge-new' : 'badge badge-other'">
                            {{ contact.status || '—' }}
                        </span>
                    </p>
                </div>
            </div>

            <div class="row">
                <div class="col">
                    <label class="form-label">Content</label>
                    <p class="field multiline">
                        {{ contact.content || '—' }}
                    </p>
                </div>
            </div>

            <div class="row">
                <div class="col">
                    <label class="form-label">IP</label>
                    <p class="field">{{ contact.ip || '—' }}</p>
                </div>
                <div class="col">
                    <label class="form-label">User Agent</label>
                    <p class="field multiline">{{ contact.user_agent || '—' }}</p>
                </div>
            </div>

            <div class="row">
                <div class="col">
                    <label class="form-label">Created At</label>
                    <p class="field">{{ formattedDate(contact.created_at) }}</p>
                </div>
                <div class="col">
                    <label class="form-label">Updated At</label>
                    <p class="field">{{ formattedDate(contact.updated_at) }}</p>
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
const contact = ref<any>({})

const formattedDate = (val?: string | null) => {
    if (!val) return '—'
    return val.slice(0, 16).replace('T', ' ')
}

const load = async () => {
    const { data } = await http.get(`/api/contacts/${id.value}`)
    const src = (data as any)?.data ?? data
    contact.value = src || {}
    loaded.value = true
}

onMounted(load)
</script>

<style scoped>
.contact-detail {
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

.badge {
    display: inline-block;
    padding: 2px 10px;
    border-radius: 20px;
    font-size: 12px;
    font-weight: 700;
    color: #fff;
}

.badge-new {
    background: green;
}

.badge-other {
    background: gray;
}
</style>

