import { defineStore } from 'pinia'
import http from '@/api/http'


type User = { id: number; name: string; email: string }


type LoginPayload = { email: string; password: string }


export const useAuthStore = defineStore('auth', {
    state: () => ({
        user: null as User | null,
        token: localStorage.getItem('token') || ''
    }),
    getters: { isAuth: (s) => !!s.token },
    actions: {
        async login(payload: LoginPayload) {
            const { data } = await http.post('/api/auth/login', payload)
            this.token = data.token
            this.user = data.user
            localStorage.setItem('token', this.token)
        },
        async fetchMe() {
            if (!this.token) return
            const { data } = await http.get('/api/auth/me')
            this.user = data
        },
        async logout() {
            try { await http.post('/api/auth/logout') } catch { }
            this.user = null
            this.token = ''
            localStorage.removeItem('token')
        }
    }
})