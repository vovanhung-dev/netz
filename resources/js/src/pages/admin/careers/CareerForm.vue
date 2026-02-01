<template>
    <div class="detail-career">
        <h1 class="heading">{{ title }}</h1>

        <div v-if="isLoading" class="loading-container">
            <span class="loader"></span>
            <p>Đang tải...</p>
        </div>

        <form v-else method="post" @submit.prevent=" submit ">
            <div class="row">
                <div class="col-md-8 mb-3">
                    <label for="position" class="form-label">Tên Tuyển Dụng:</label>
                    <input type="text" class="form-control" id="position" v-model.trim=" position " />
                </div>
                <div class="col-md-4 mb-3">
                    <label for="number" class="form-label">Số lượng:</label>
                    <input type="number" min="1" class="form-control" id="number" v-model.number=" number " />
                </div>
            </div>
            <div class="row" v-if="isEdit">
                <div class="col-md-6 mb-3">
                    <label for="is_open" class="form-label">Trạng thái:</label>
                    <select id="is_open" class="form-select" v-model=" isOpen ">
                        <option :value=" true ">Hoạt động</option>
                        <option :value=" false ">Ẩn</option>
                    </select>
                </div>
                <div class="col-md-6 mb-3">
                    <label for="expiration_date" class="form-label">Hạn đăng ký:</label>
                    <input type="date" class="form-control" id="expiration_date" v-model=" expirationDate " />
                </div>

            </div>

            <div class="mb-3 mt-3">
                <label class="form-label">Nội dung chi tiết:</label>
                <el-tiptap v-model:content=" description " :extensions=" extensions " content-type="html" />
            </div>

            <div class="footer-button">
                <button :disabled=" isSubmit ">
                    <span v-if="isSubmit" class="loader"></span>
                    <span v-else>{{ isEdit ? 'Cập nhật' : 'Thêm ngay' }}</span>
                </button>
            </div>
        </form>
    </div>
</template>

<script setup lang="ts">
import { ref, computed, onMounted } from 'vue'
import { useRouter, useRoute } from 'vue-router'
import Swal from 'sweetalert2'
import http from '@/api/http'
import {
    Doc, Text, Paragraph, Image, Heading, Bold, Underline, Italic, Strike,
    BulletList, OrderedList, Iframe, TextAlign, LineHeight, Table, Color,
    Fullscreen, FontFamily, FontSize
} from 'element-tiptap-vue3-fixed'
import 'element-tiptap-vue3-fixed/lib/style.css'


// ====== State (đúng field BE) ======
const position = ref<string>('')
const number = ref<number | null>(1)
const futureDate = new Date();
futureDate.setDate(futureDate.getDate() + 10);
const expirationDate = ref<string>(futureDate.toISOString().slice(0, 10)); const description = ref<string>('')

const isOpen = ref<boolean>(true)

const isLoading = ref(true) // Start in loading state

// TipTap extensions
const extensions: any[] = [
    Doc, Text, Paragraph,
    Heading.configure({ levels: [1, 2, 3, 4, 5] }),
    Bold, Underline, Italic, Strike,
    BulletList, OrderedList, Image, Iframe,
    TextAlign, LineHeight, Table, Color,
    Fullscreen, FontFamily, FontSize
]

// Router/flags
const router = useRouter()
const route = useRoute()
const id = computed(() => route.params.id as string | undefined)
const isEdit = computed(() => !!id.value)
const isSubmit = ref(false)
// Thay đổi text của tiêu đề trang
const title = computed(() => (isEdit.value ? 'Chỉnh sửa Tuyển Dụng' : 'Thêm Tuyển Dụng Mới'))

// Toast
const Toast = Swal.mixin({
    toast: true, position: 'top-end', showConfirmButton: false, timer: 3000, timerProgressBar: true,
    didOpen: (t: any) => { t.addEventListener('mouseenter', Swal.stopTimer); t.addEventListener('mouseleave', Swal.resumeTimer) }
})

// Validate
const validate = () =>
    !!position.value &&
    !!number.value &&
    Number(number.value) > 0 &&
    !!expirationDate.value &&
    !!description.value

// Load data when edit
const load = async () => {
    if (!isEdit.value) {
        isLoading.value = false
        return
    }

    isLoading.value = true
    try {
        const response = await http.get(`/api/admin/careers/${ id.value }`)
        const careerData = response.data.data || response.data

        position.value = careerData.position || ''
        number.value = Number(careerData.number ?? 1)
        expirationDate.value = (careerData.expiration_date || '').slice(0, 10)
        description.value = careerData.description || ''
        isOpen.value = !!careerData.is_open
    } catch (err) {
        console.error("Failed to load career data:", err);
        // Thay đổi text của thông báo lỗi
        Toast.fire({ icon: 'error', title: 'Không thể tải dữ liệu khóa học.' })
        router.replace({ name: 'admin-careers' })
    } finally {
        isLoading.value = false
    }
}

// Submit (create/update)
const submit = async () => {
    if (!validate()) {
        // Thay đổi text của thông báo lỗi
        Toast.fire({ icon: 'error', title: 'Vui lòng nhập đầy đủ thông tin' })
        return
    }
    isSubmit.value = true
    try {
        const payload: Record<string, any> = {
            position: position.value,
            number: number.value,
            expiration_date: expirationDate.value,
            description: description.value,
            is_open: isOpen.value,
        }

        if (isEdit.value) {
            const { data: res } = await http.put(`/api/admin/careers/${ id.value }`, payload)
            // Thay đổi text của thông báo thành công
            Toast.fire({ icon: 'success', title: res?.message || 'Cập nhật thành công' })
        } else {
            const { data: res } = await http.post('/api/admin/careers', payload)
            // Thay đổi text của thông báo thành công
            Toast.fire({ icon: 'success', title: res?.message || 'Tạo thành công' })
        }
        router.replace({ name: 'admin-careers' })
    } catch (err: any) {
        // Thay đổi text của thông báo lỗi
        const msg = err?.response?.data?.message || (isEdit.value ? 'Cập nhật thất bại' : 'Tạo mới thất bại')
        Toast.fire({ icon: 'error', title: msg })
    } finally {
        isSubmit.value = false
    }
}

onMounted(load)
</script>

<style scoped>
h1 {
    font-size: 50px;
    font-weight: 800;
    text-align: center;
    margin-bottom: 50px;
    color: #3ea9e0;
    text-transform: uppercase;
}

.footer-button {
    text-align: center;
    margin-top: 40px;
    padding-bottom: 50px;
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
    box-shadow: rgba(0, 0, 0, .4) 0 2px 4px, rgba(0, 0, 0, .3) 0 7px 13px -3px, rgba(0, 0, 0, .2) 0 -3px 0 inset;
}

.loading-container {
    text-align: center;
    padding: 50px;
}

.loader {
    border: 5px solid #f3f3f3;
    border-top: 5px solid #3ea9e0;
    border-radius: 50%;
    width: 50px;
    height: 50px;
    animation: spin 1.5s linear infinite;
    display: inline-block;
}

@keyframes spin {
    0% {
        transform: rotate(0deg);
    }

    100% {
        transform: rotate(360deg);
    }
}
</style>