// resources/js/src/services/apiClient.ts
import axios from 'axios';

const api = axios.create({
    baseURL: import.meta.env.VITE_API_BASE_URL || '/api',
    withCredentials: true,
    headers: { 'Content-Type': 'application/json' },
});

api.interceptors.response.use(
    (res) => res,
    (err) => {
        if (err.response) {
            // Xử lý các mã lỗi phổ biến
            switch (err.response.status) {
                case 401:
                    // Xử lý lỗi chưa xác thực (ví dụ: chuyển hướng đến trang đăng nhập)
                    console.error("Unauthorized access - 401");
                    break;
                case 419:
                    // Lỗi CSRF token hết hạn
                    console.error("CSRF token mismatch - 419");
                    break;
                case 422:
                    // Lỗi validation
                    console.error("Validation error - 422", err.response.data.errors);
                    break;
                default:
                    console.error(`An error occurred: ${err.response.status}`);
            }
        }
        return Promise.reject(err);
    }
);

export default api;