import { createRouter, createWebHistory, RouteRecordRaw } from 'vue-router';
import HomePage from '@/pages/guest/HomePage.vue'
import AboutPage from '@/pages/guest/AboutPage.vue'
import BusinessLinesPage from '@/pages/guest/BusinessLinesPage.vue'
import ProjectPage from '@/pages/guest/ProjectPage.vue'
import NewsPage from '@/pages/guest/NewsPage.vue'
import CareersPage from '@/pages/guest/CareersPage.vue'
import ContactUsPage from '@/pages/guest/ContactUs.vue'
import NewsDetailView from '@/pages/guest/NewsDetailView.vue'
import { useAuthStore } from '@/stores/auth'
import CoursePage from '@/pages/guest/CoursePage.vue';
import CourseDetailView from '@/pages/guest/CourseDetailView.vue';


const routes: RouteRecordRaw[] = [
    {
        path: '/',
        component: () => import('@/layouts/DefaultLayout.vue'),
        children: [
            {
                path: '/',
                name: 'home',
                component: HomePage,
            },
            {
                path: '/about-us',
                name: 'about-us',
                component: AboutPage
            },
            {
                path: '/business-lines',
                name: 'business-lines',
                component: BusinessLinesPage
            },
            {
                path: '/project',
                name: 'project',
                component: ProjectPage
            },
            {
                path: '/courses',
                name: 'courses',
                component: CoursePage
            },
            {
                path: '/courses/:slug',
                name: 'courses-detail',
                component: CourseDetailView,
                meta: { public: true }
            },
            {
                path: '/news',
                name: 'news',
                component: NewsPage
            },
            {
                path: '/careers',
                name: 'careers',
                component: CareersPage
            },
            {
                path: '/contact-us',
                name: 'contact-us',
                component: ContactUsPage
            },
            {
                path: '/news/:slug',
                name: 'news-detail',
                component: NewsDetailView,
                meta: { public: true }
            }
        ]
      },
    
  

    { path: '/admin/login', name: 'admin-login', component: () => import('@/pages/admin/Login.vue'), meta: { guestOnly: true } },
    {
        path: '/admin',
        component: () => import('@/layouts/AdminLayout.vue'),
        meta: { requiresAuth: true },
        children: [
            { path: '', redirect: { name: 'admin-news' } },
            { path: 'news', name: 'admin-news', component: () => import('@/pages/admin/new/NewsList.vue') },
            { path: 'news/new', name: 'admin-news-new', component: () => import('@/pages/admin/new/NewsForm.vue') },
            { path: 'news/:id', name: 'admin-news-edit', component: () => import('@/pages/admin/new/NewsDetailView.vue') },

            { path: 'courses', name: 'admin-courses', component: () => import('@/pages/admin/course/CourseList.vue') },
            { path: 'courses/new', name: 'admin-course-new', component: () => import('@/pages/admin/course/CourseForm.vue') },
            { path: 'courses/:id', name: 'admin-course-edit', component: () => import('@/pages/admin/course/CourseDetailView.vue') },

            { path: 'careers', name: 'admin-careers', component: () => import('@/pages/admin/careers/CareerList.vue') },
            { path: 'careers/new', name: 'admin-careers-new', component: () => import('@/pages/admin/careers/CareerForm.vue') },
            { path: 'careers/:id', name: 'admin-careers-edit', component: () => import('@/pages/admin/careers/CareerForm.vue') },

            { path: 'contacts', name: 'admin-contacts', component: () => import('@/pages/admin/contact/ContactList.vue') },
            { path: 'contacts/:id', name: 'admin-contacts-detail', component: () => import('@/pages/admin/contact/ContactDetailView.vue') },

            { path: 'career-applications', name: 'admin-career-applications', component: () => import('@/pages/admin/career-applications/CareerApplicationList.vue') },
            { path: 'career-applications/:id', name: 'admin-career-applications-detail', component: () => import('@/pages/admin/career-applications/CareerApplicationDetailView.vue') },
        ]
    },
];

const router = createRouter({
    history: createWebHistory(),
    routes,
    scrollBehavior(to, from, saved) {
        if (saved) return saved
        if (to.hash) {
            const el = document.querySelector(to.hash) as HTMLElement | null
            if (el) {
                const y = el.getBoundingClientRect().top + window.scrollY - 80
                return { left: 0, top: y, behavior: 'smooth' }
            }
        }
        return { left: 0, top: 0 }
    }
})

router.beforeEach(async (to) => {
    const auth = useAuthStore()
    if (to.meta.requiresAuth && !auth.isAuth) {
        return { name: 'admin-login', query: { redirect: to.fullPath } }
    }
    if (to.meta.guestOnly && auth.isAuth) {
        return { path: '/admin' }
    }
})
export default router;
