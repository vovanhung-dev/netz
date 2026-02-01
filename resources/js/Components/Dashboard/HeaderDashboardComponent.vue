<template>
    <header>
        <div class="admin">
            <img
                src="../../src/assets/images/admin.jpg"
                alt="SHAREWORK"
                @click="isMenuUpdate = true"
            />
            <div class="name" v-if="info">{{ info.name }}</div>
        </div>
        <div class="logout" @click="onLogout" :aria-disabled="loadingLogout">
            {{ loadingLogout ? 'Logging out...' : 'Logout' }}
        </div>
    </header>

    <div class="modal-edit-admin" :class="{ active: isMenuUpdate }">
        <i class="fa-solid fa-xmark" @click="isMenuUpdate = false"></i>
        <form method="post" @submit.prevent="updateInfo">
            <div class="mb-3 mt-3">
                <label for="password" class="form-label">Password:</label>
                <input
                    type="password"
                    class="form-control"
                    id="password"
                    name="password"
                    placeholder="Enter password"
                    v-model.trim="infoUpdate.password"
                />
            </div>
            <div class="mb-3 mt-3">
                <label for="verify-password" class="form-label">Verify Password:</label>
                <input
                    type="password"
                    class="form-control"
                    id="verify-password"
                    name="verify-password"
                    placeholder="Re-enter password"
                    v-model.trim="infoUpdate.verify_password"
                />
            </div>
            <div class="footer-form">
                <button :disabled="loadingUpdate">
                    {{ loadingUpdate ? 'Updating...' : 'Update now' }}
                </button>
            </div>
        </form>
    </div>
</template>

<script setup lang="ts">
import { computed, reactive, ref, onMounted } from 'vue';
import Swal from 'sweetalert2';
import http from '@/api/http';
import { useAuthStore } from '@/stores/auth';
import { useRouter } from 'vue-router';

const auth = useAuthStore();
const router = useRouter();

// Lấy thông tin user từ Pinia
const info = computed(() => auth.user);

const isMenuUpdate = ref(false);
const loadingUpdate = ref(false);
const loadingLogout = ref(false);

const infoUpdate = reactive({
    password: '',
    verify_password: '',
});

// Toast helper
const Toast = Swal.mixin({
    toast: true,
    position: 'top-end',
    showConfirmButton: false,
    timer: 3000,
    timerProgressBar: true,
    didOpen: (toast: any) => {
        toast.addEventListener('mouseenter', Swal.stopTimer);
        toast.addEventListener('mouseleave', Swal.resumeTimer);
    },
});

const onLogout = async () => {
    try {
        loadingLogout.value = true;
        await auth.logout();
        router.replace({ name: 'admin-login' });
    } finally {
        loadingLogout.value = false;
    }
};

const updateInfo = async () => {
    if (!info.value) {
        Toast.fire({ icon: 'error', title: 'No user loaded' });
        return;
    }
    if (!infoUpdate.password || !infoUpdate.verify_password) {
        Toast.fire({ icon: 'error', title: 'Enter full information' });
        return;
    }
    if (infoUpdate.password !== infoUpdate.verify_password) {
        Toast.fire({ icon: 'error', title: 'Password mismatch' });
        return;
    }

    loadingUpdate.value = true;
    try {
        const id = (info.value as any).id;
        // Gọi API cập nhật mật khẩu
        // Giữ nguyên endpoint theo code cũ của bạn:
        const { data } = await http.post(`/api/admin/user/update/${id}`, {
            password: infoUpdate.password,
            verify_password: infoUpdate.verify_password,
        });

        Toast.fire({ icon: 'success', title: data?.data || 'Updated successfully' });
        infoUpdate.password = '';
        infoUpdate.verify_password = '';
        isMenuUpdate.value = false;

        // (tuỳ chọn) refresh lại user
        try {
            await auth.fetchMe();
        } catch {}
    } catch (err: any) {
        const msg =
            err?.response?.data?.message ||
            err?.response?.data?.errors?.password?.[0] ||
            'Update failed';
        Toast.fire({ icon: 'error', title: msg });
    } finally {
        loadingUpdate.value = false;
    }
};

// bảo đảm có info khi header mount
onMounted(async () => {
    if (!auth.user && auth.token) {
        try {
            await auth.fetchMe();
        } catch {}
    }
});
</script>

<style scoped>
header {
    width: 100%;
    height: 100%;
    background: #fff;
    border-radius: 10px 0 0 10px;
    display: flex;
    align-items: center;
    justify-content: space-between;
}
.admin {
    display: flex;
    align-items: center;
    justify-content: center;
    width: 200px;
    overflow: hidden;
    height: 100%;
    cursor: pointer;
}
.admin img {
    width: 40px;
    margin-right: 5px;
    box-shadow:
        rgba(0, 0, 0, 0.4) 0px 2px 4px,
        rgba(0, 0, 0, 0.3) 0px 7px 13px -3px,
        rgba(0, 0, 0, 0.2) 0px -3px 0px inset;
    border-radius: 50%;
}
.admin .name {
    font-size: 16px;
    font-weight: 800;
    text-transform: capitalize;
}
.logout {
    width: 150px;
    height: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: 800;
    cursor: pointer;
    background: #3ea9e0;
    color: #fff;
    margin-right: 30px;
    box-shadow:
        rgba(0, 0, 0, 0.4) 0px 2px 4px,
        rgba(0, 0, 0, 0.3) 0px 7px 13px -3px,
        rgba(0, 0, 0, 0.2) 0px -3px 0px inset;
    border-radius: 50px;
}
.modal-edit-admin {
    position: fixed;
    width: 30%;
    height: 100vh;
    background: #fff;
    top: 0;
    right: -30%;
    box-shadow: rgba(0, 0, 0, 0.24) 0px 3px 8px;
    transition: 0.5s;
    z-index: 1000;
}
.modal-edit-admin.active {
    right: 0;
}
.modal-edit-admin i {
    font-size: 30px;
    position: absolute;
    top: 15px;
    right: 20px;
    cursor: pointer;
}
.modal-edit-admin form {
    width: 80%;
    margin: auto;
    margin-top: 100px;
}
.modal-edit-admin form button {
    width: 100%;
    border-radius: 10px;
    padding: 10px 0;
    outline: none;
    border: none;
    margin-top: 20px;
    background: #3ea9e0;
    color: #fff;
    box-shadow:
        rgba(0, 0, 0, 0.4) 0px 2px 4px,
        rgba(0, 0, 0, 0.3) 0px 7px 13px -3px,
        rgba(0, 0, 0, 0.2) 0px -3px 0px inset;
    font-weight: 800;
}
</style>
