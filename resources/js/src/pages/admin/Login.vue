<!-- !
<template>
    <div class="container-fluid">
        <div class="content">
            <form @submit.prevent="login">
                <div class="top">
                    <div class="logo">
                        <img loading="lazy" src="../../assets/images/logo.png" alt="Logo footer" />
                    </div>
                    <h1 class="title">Welcome Admin</h1>
                </div>

                <div class="center">
                    <div class="mb-3 mt-3">
                        <label for="user" class="form-label">Email:</label>
                        <input
                            type="email"
                            class="form-control"
                            id="user"
                            placeholder="Your Email"
                            v-model.trim="info.email"
                            required
                        />
                    </div>
                    <div class="mb-3 mt-3">
                        <label for="password" class="form-label">Password:</label>
                        <input
                            type="password"
                            class="form-control"
                            id="password"
                            placeholder="Password"
                            v-model="info.password"
                            required
                        />
                    </div>
                    <p v-if="error" class="text-danger mt-2" style="color: #dc2626">{{ error }}</p>
                </div>

                <div class="bottom">
                    <button type="submit" :disabled="loading">
                        {{ loading ? 'Signing in…' : 'Login' }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</template>

<script setup>
import { reactive, ref } from 'vue';
import { useRouter, useRoute } from 'vue-router';
import { useAuthStore } from '@/stores/auth';

const router = useRouter();
const route = useRoute();
const auth = useAuthStore();

const info = reactive({ email: '', password: '' });
const loading = ref(false);
const error = ref('');

const login = async () => {
    if (!info.email || !info.password) return;
    loading.value = true;
    error.value = '';
    try {
        await auth.login({ email: info.email, password: info.password });
        await auth.fetchMe();
        const redirect = route.query.redirect ?? '/admin';
        router.replace(redirect);
    } catch (e) {
        error.value = e?.response?.data?.message || 'Invalid credentials';
    } finally {
        loading.value = false;
    }
};
</script>

<style scoped>
.container-fluid {
    padding: 0;
    width: 100vw;
    height: 100vh;
    overflow: hidden;
    background: #3ea9e0;
}
.content {
    width: 100%;
    height: 100%;
    background: rgba(255, 255, 255, 0.2);
    box-shadow: 0 8px 32px 0 rgba(31, 38, 135, 0.37);
    backdrop-filter: blur(2px);
    -webkit-backdrop-filter: blur(2px);
    border-radius: 10px;
    border: 1px solid rgba(255, 255, 255, 0.18);
}
form {
    width: 40%;
    height: 90%;
    position: fixed;
    left: 30%;
    top: 5%;
    background: #fff;
    border-radius: 10px;
    padding: 50px;
}
form .logo img {
    width: 100px;
}
form .title {
    font-family: 'Lobster', cursive;
    text-align: center;
    margin-top: 80px;
    font-size: 35px;
    margin-bottom: 50px;
}
form .center label {
    font-family: 'Lobster', cursive;
}
form .center input {
    font-family: 'Oswald', sans-serif;
    color: #000;
    font-size: 16px;
}
form .bottom {
    margin-top: 50px;
    text-align: center;
}
form .bottom button {
    width: 150px;
    height: 50px;
    border-radius: 20px;
    border: none;
    outline: none;
    font-family: 'Lobster', cursive;
    background: #3ea9e0;
    color: #fff;
    box-shadow:
        rgba(0, 0, 0, 0.4) 0 2px 4px,
        rgba(0, 0, 0, 0.3) 0 7px 13px -3px,
        rgba(0, 0, 0, 0.2) 0 -3px 0 inset;
}
</style> -->
<template>
    <div class="login-container">
        <div class="login-box">
            <div class="logo">
                <img loading="lazy" src="../../assets/images/logo.png" alt="Logo" />
            </div>
            <h1 class="title">Welcome Admin</h1>
            <form @submit.prevent="login">
                <div class="input-group">
                    <label for="email" class="form-label">Email:</label>
                    <input
                        type="email"
                        class="form-control"
                        id="email"
                        placeholder="Your Email"
                        v-model.trim="info.email"
                        required
                    />
                </div>
                <div class="input-group">
                    <label for="password" class="form-label">Password:</label>
                    <input
                        type="password"
                        class="form-control"
                        id="password"
                        placeholder="Password"
                        v-model="info.password"
                        required
                    />
                </div>
                <p v-if="error" class="error-message">{{ error }}</p>
                <button type="submit" :disabled="loading" class="login-button">
                    {{ loading ? 'Signing in…' : 'Login' }}
                </button>
            </form>
        </div>
    </div>
</template>

<script setup>
import { reactive, ref } from 'vue';
import { useRouter, useRoute } from 'vue-router';
import { useAuthStore } from '@/stores/auth';

const router = useRouter();
const route = useRoute();
const auth = useAuthStore();

const info = reactive({ email: '', password: '' });
const loading = ref(false);
const error = ref('');

const login = async () => {
    if (!info.email || !info.password) return;
    loading.value = true;
    error.value = '';
    try {
        await auth.login({ email: info.email, password: info.password });
        await auth.fetchMe();
        const redirect = route.query.redirect ?? '/admin';
        router.replace(redirect);
    } catch (e) {
        error.value = e?.response?.data?.message || 'Invalid credentials';
    } finally {
        loading.value = false;
    }
};
</script>

<style scoped>
.login-container {
    display: flex;
    justify-content: center;
    align-items: center;
    width: 100vw;
    height: 100vh;
    background: #3ea9e0;
    overflow: hidden;
}

.login-box {
    width: 100%;
    max-width: 400px;
    padding: 40px;
    background: #fff;
    border-radius: 10px;
    box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
    text-align: center;
}

.logo img {
    width: 100px;
    margin-bottom: 20px;
}

.title {
    font-family: 'Lobster', cursive;
    font-size: 28px;
    margin-bottom: 30px;
    color: #333;
}

.input-group {
    margin-bottom: 20px;
    text-align: left;
}

.form-label {
    font-family: 'Lobster', cursive;
    display: block;
    margin-bottom: 5px;
    color: #555;
}

.form-control {
    width: 100%;
    padding: 10px;
    border: 1px solid #ddd;
    border-radius: 5px;
    font-family: 'Oswald', sans-serif;
    font-size: 16px;
    color: #000;
}

.error-message {
    color: #dc2626;
    margin-top: -10px;
    margin-bottom: 20px;
    font-size: 14px;
}

.login-button {
    width: 100%;
    height: 50px;
    border-radius: 25px;
    border: none;
    outline: none;
    font-family: 'Lobster', cursive;
    background: #3ea9e0;
    color: #fff;
    font-size: 18px;
    cursor: pointer;
    box-shadow:
        rgba(0, 0, 0, 0.2) 0 2px 4px,
        rgba(0, 0, 0, 0.2) 0 7px 13px -3px;
    transition: background-color 0.3s;
}

.login-button:disabled {
    background-color: #99c9e2;
    cursor: not-allowed;
}
</style>
