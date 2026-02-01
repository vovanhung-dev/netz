<template>
    <div class="detail-news">
        <h1 class="heading">Thêm Tin Tức Mới</h1>

        <form @submit.prevent="submit">
            <div class="row">
                <div class="col-md-8 mb-3">
                    <label class="form-label">Tiêu đề</label>
                    <input class="form-control" v-model.trim="title" />
                </div>
                <div class="col-md-4 mb-3">
                    <label class="form-label">Slug</label>
                    <input class="form-control" v-model.trim="slug" @input="onSlugInput" />
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label">Nội dung tóm tắt</label>
                <textarea class="form-control" rows="3" v-model.trim="excerpt"></textarea>
            </div>

            <div class="mb-3">
                <label class="form-label">Nội dung chi tiết</label>
                <el-tiptap v-model:content="body" :extensions="extensions" />
            </div>

            <div class="row">
                <div class="col-md-8 mb-3">
                    <label class="form-label">Link hình ảnh</label>
                    <input class="form-control" v-model.trim="coverImageUrl" placeholder="https://..." />
                </div>
                <div class="col-md-4 mb-3">
                    <label class="form-label">Hoặc Tải lên hình ảnh</label>
                    <input type="file" class="form-control" accept="image/*" @change="onPickImage" />
                </div>
            </div>

            <div class="row">
                <div class="col-md-4 mb-3">
                    <label class="form-label">Trạng thái</label>
                    <select class="form-control" v-model="status">
                        <option value="draft">draft</option>
                        <option value="published">published</option>
                        <!-- <option value="archived">archived</option> -->
                    </select>
                </div>
                <div class="col-md-4 mb-3">
                    <label class="form-label">Ngày đăng</label>
                    <input type="datetime-local" class="form-control" v-model="publishedAtLocal" />
                </div>
                <!-- <div class="col-md-4 mb-3">
                    <label class="form-label">Author ID</label>
                    <input type="number" class="form-control" v-model.number="authorId" min="1" />
                </div> -->
            </div>

            <div class="footer-button">
                <button><span v-if="submitting" class="loader"></span><span v-else>Thêm ngay</span></button>
            </div>
        </form>
    </div>
</template>

<script setup lang="ts">
import { ref, watch } from 'vue'
import { useRouter } from 'vue-router'
import Swal from 'sweetalert2'
import http from '@/api/http'
import { Doc, Text, Paragraph, Image, Heading, Bold, Underline, Italic, Strike, BulletList, OrderedList, Iframe, TextAlign, LineHeight, Table, Color, Fullscreen, FontFamily, FontSize } from 'element-tiptap-vue3-fixed'

const router = useRouter()
const submitting = ref(false)
const extensions: any[] = [Doc, Text, Paragraph, Heading.configure({ levels: [1, 2, 3, 4, 5] }), Bold, Underline, Italic, Strike, BulletList, OrderedList, Image, Iframe, TextAlign, LineHeight, Table, Color, Fullscreen, FontFamily, FontSize]
const slugEditedByUser = ref(false)

// form fields (khớp BE)
const title = ref(''); const slug = ref(''); const excerpt = ref('')
const body = ref(''); const coverImageUrl = ref(''); const status = ref<'draft' | 'published' | 'archived'>('draft')
const publishedAtLocal = ref('') // datetime-local
const authorId = ref<number | 1>(1)
const imageFile = ref<File | null>(null)


const Toast = Swal.mixin({
    toast: true, position: 'top-end', showConfirmButton: false, timer: 3000, timerProgressBar: true,
    didOpen: (t: any) => { t.addEventListener('mouseenter', Swal.stopTimer); t.addEventListener('mouseleave', Swal.resumeTimer) }
})

const onPickImage = (e: Event) => { const f = (e.target as HTMLInputElement).files?.[0]; if (!f) return; if (!f.type.startsWith('image/')) return Toast.fire({ icon: 'error', title: 'Not an image' }); imageFile.value = f }

const toSqlDateTime = (local: string) => local ? local.replace('T', ' ') + ':00' : '' // YYYY-MM-DDTHH:mm -> YYYY-MM-DD HH:mm:00

const validate = () => !!title.value && !!slug.value && !!status.value && (!!publishedAtLocal.value || status.value !== 'published')

function slugify(input: string): string {
    return input
        .normalize('NFD')
        .replace(/[\u0300-\u036f]/g, '')
        .toLowerCase()
        .replace(/đ/g, 'd')
        .replace(/[^a-z0-9]+/g, '-')
        .replace(/^-+|-+$/g, '')
        .replace(/-{2,}/g, '-')
}

function onSlugInput() {
    slugEditedByUser.value = true
    slug.value = slugify(slug.value)
}



watch(title, (val) => {
    if (!slugEditedByUser.value) {
        slug.value = slugify(val || '')
    }
})

const submit = async () => {
    if (!validate()) return Toast.fire({ icon: 'error', title: 'Please fill required fields' })
    submitting.value = true
    try {
        const payload: any = {
            title: title.value,
            slug: slug.value,
            excerpt: excerpt.value,
            body: body.value,
            cover_image_url: coverImageUrl.value,
            status: status.value,
            published_at: toSqlDateTime(publishedAtLocal.value),
            author_id: authorId.value,
        }

        let res
        if (imageFile.value) {
            const fd = new FormData()
            Object.entries(payload).forEach(([k, v]) => fd.append(k, String(v ?? '')))
            fd.append('cover_image', imageFile.value)
            res = await http.post('/api/admin/news', fd, { headers: { 'Content-Type': 'multipart/form-data' } })
        } else {
            res = await http.post('/api/admin/news', payload)
        }

        Toast.fire({ icon: 'success', title: res.data?.message || 'Created' })
        router.replace({ name: 'admin-news' })
    } catch (e: any) {
        Toast.fire({ icon: 'error', title: e?.response?.data?.message || 'Create failed' })
    } finally {
        submitting.value = false
    }
}
</script>

<style scoped>
h1 {
    font-size: 50px;
    font-weight: 800;
    text-align: center;
    margin-bottom: 50px;
    color: #3ea9e0;
    text-transform: uppercase
}

.footer-button {
    text-align: center;
    margin-top: 40px;
    padding-bottom: 50px
}

.footer-button button {
    width: 30%;
    height: 40px;
    outline: none;
    border: none;
    border-radius: 50px;
    background: #3ea9e0;
    color: #fff;
    font-weight: 800;
    box-shadow: rgba(0, 0, 0, .4)0 2px 4px, rgba(0, 0, 0, .3)0 7px 13px -3px, rgba(0, 0, 0, .2)0 -3px 0 inset
}
</style>