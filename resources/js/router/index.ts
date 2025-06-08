import { createRouter, createWebHistory } from 'vue-router'
import MainLayout from '../layouts/MainLayout.vue'
import Dashboard from '../views/Dashboard.vue'
import About from '../views/Partite.vue'
import Giocatori from '../views/Giocatori.vue'

const router = createRouter({
    history: createWebHistory('/crm'),
    routes: [
        {
            path: '/',
            component: MainLayout,
            children: [
                {
                    path: 'dashboard',
                    name: 'dashboard',
                    component: Dashboard
                },
                {
                    path: 'about',
                    name: 'about',
                    component: About
                },
                {
                    path: 'contact',
                    name: 'contact',
                    component: Giocatori
                }
            ]
        }
    ]
})

// Navigation guard to check authentication
router.beforeEach((to, from, next) => {
    // Check if user is authenticated
    const isAuthenticated = document.cookie.includes('XSRF-TOKEN')
    
    if (!isAuthenticated) {
        // Redirect to login with return URL
        window.location.href = `/login?redirect=${encodeURIComponent(to.fullPath)}`
        return
    }
    next()
})

export default router 