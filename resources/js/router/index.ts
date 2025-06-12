import { createRouter, createWebHistory } from 'vue-router'
import MainLayout from '../layouts/MainLayout.vue'
import DashboardPage from '../views/DashboardPage.vue'
import PartitePage from '../views/PartitePage.vue'
import GiocatoriPage from '../views/GiocatoriPage.vue'

const router = createRouter({
    history: createWebHistory('/crm'),
    routes: [
        {
            path: '/',
            component: MainLayout,
            children: [
                {
                    path: '', // Empty path will redirect to dashboard
                    redirect: '/dashboard',
                },
                {
                    path: 'dashboard',
                    name: 'dashboard',
                    component: DashboardPage,
                },
                {
                    path: 'partite',
                    name: 'partite',
                    component: PartitePage,
                },
                {
                    path: 'contact',
                    name: 'contact',
                    component: GiocatoriPage,
                },
            ],
        },
    ],
})

// Navigation guard to check authentication
router.beforeEach((to, from, next) => {
    // Check if user is authenticated
    const isAuthenticated = document.cookie.includes('XSRF-TOKEN')

    if (!isAuthenticated) {
        // Redirect to login with return URL
        const loginPath = `/login?redirect=${encodeURIComponent(to.fullPath)}`
        window.location.href = loginPath
        return
    }
    next()
})

export default router
