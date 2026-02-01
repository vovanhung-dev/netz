import axios from 'axios';
import { useAuthStore } from '../stores/auth';

const baseURL = import.meta.env.VITE_API_BASE || '/';

export const http = axios.create({
    baseURL,
    headers: { Accept: 'application/json' },
});

http.interceptors.request.use((config) => {
    const auth = useAuthStore();
    if (auth.token) {
        config.headers = config.headers || {};
        (config.headers as any).Authorization = `Bearer ${auth.token}`;
    }
    return config;
});

http.interceptors.response.use(
    (res) => res,
    (err) => {
        if (err?.response?.status === 401) {
            const auth = useAuthStore();
            auth.logout();
            if (location.pathname !== '/admin/login') {
                location.assign('/admin/login');
            }
        }
        return Promise.reject(err);
    },
);

export default http;
