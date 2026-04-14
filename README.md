# Netz - Website Doanh Nghiệp

## Danh Mục

`Full Stack` `Ứng Dụng Web`

## Giới Thiệu

Website doanh nghiệp xây dựng theo kiến trúc Laravel (backend) + Vue 3 + TypeScript (frontend SPA), hỗ trợ giới thiệu công ty và quản lý tin tức.

## Chức Năng

- Trang chủ giới thiệu công ty
- Quản lý tin tức (News) - CRUD
- Giao diện SPA mượt mà với Vue 3
- Responsive design với TailwindCSS
- Quản trị nội dung qua admin panel

## Công Nghệ Sử Dụng

- **Backend:** Laravel 10 (PHP)
- **Frontend:** Vue 3 + TypeScript
- **CSS:** TailwindCSS
- **Build Tool:** Vite
- **Database:** MySQL

## Yêu Cầu Hệ Thống

- PHP >= 8.1
- Composer
- Node.js >= 16
- MySQL >= 5.7

## Cài Đặt

```bash
composer install
npm install
cp .env.example .env
php artisan key:generate
php artisan migrate
```

Import database từ file `database.sql` nếu cần.

## Chạy Ứng Dụng

```bash
php artisan serve
npm run dev
```
