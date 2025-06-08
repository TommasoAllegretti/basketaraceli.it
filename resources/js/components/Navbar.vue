<script setup lang="ts">
import { ref, onMounted, onUnmounted } from 'vue'
import { RouterLink, useRoute } from 'vue-router'

// Import the logo
const logoUrl = new URL('/public/assets/logo_araceli.png', import.meta.url).href

const route = useRoute()
const isOpen = ref(false)
const isDark = ref(window.matchMedia('(prefers-color-scheme: dark)').matches)

// Watch for system theme changes
const darkModeMediaQuery = window.matchMedia('(prefers-color-scheme: dark)')
const handleThemeChange = (e: MediaQueryListEvent | MediaQueryList) => {
    isDark.value = e.matches
    if (isDark.value) {
        document.documentElement.classList.add('dark')
    } else {
        document.documentElement.classList.remove('dark')
    }
}

// Initialize dark mode on mount and set up listeners
onMounted(() => {
    handleThemeChange(darkModeMediaQuery)
    darkModeMediaQuery.addEventListener('change', handleThemeChange)
})

// Clean up listener on unmount
onUnmounted(() => {
    darkModeMediaQuery.removeEventListener('change', handleThemeChange)
})

const toggleMenu = () => {
    isOpen.value = !isOpen.value
}
</script>

<template>
    <nav class="bg-white dark:bg-gray-800 shadow-lg">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-24">
                <div class="flex">
                    <!-- Logo -->
                    <div class="flex-shrink-0 flex items-center">
                            <img 
                                :src="logoUrl"
                                alt="Basket Araceli Logo"
                                class="h-12 w-auto object-contain"
                            >
                    </div>

                    <!-- Desktop Navigation Links -->
                    <div class="hidden sm:ml-6 sm:flex sm:space-x-8">
                        <RouterLink
                            to="/dashboard"
                            class="inline-flex items-center px-1 pt-1 border-b-2 border-transparent text-sm font-medium text-gray-500 dark:text-gray-300 hover:text-gray-700 dark:hover:text-white hover:border-gray-300 dark:hover:border-gray-700"
                            :class="{ 'border-indigo-500 dark:border-indigo-400 text-gray-900 dark:text-white': route.path === '/dashboard' }"
                        >
                            Dashboard
                        </RouterLink>
                        <RouterLink
                            to="/about"
                            class="inline-flex items-center px-1 pt-1 border-b-2 border-transparent text-sm font-medium text-gray-500 dark:text-gray-300 hover:text-gray-700 dark:hover:text-white hover:border-gray-300 dark:hover:border-gray-700"
                            :class="{ 'border-indigo-500 dark:border-indigo-400 text-gray-900 dark:text-white': route.path === '/about' }"
                        >
                            About
                        </RouterLink>
                        <RouterLink
                            to="/contact"
                            class="inline-flex items-center px-1 pt-1 border-b-2 border-transparent text-sm font-medium text-gray-500 dark:text-gray-300 hover:text-gray-700 dark:hover:text-white hover:border-gray-300 dark:hover:border-gray-700"
                            :class="{ 'border-indigo-500 dark:border-indigo-400 text-gray-900 dark:text-white': route.path === '/contact' }"
                        >
                            Contact
                        </RouterLink>
                    </div>
                </div>

                <div class="flex items-center">
                    <!-- Mobile menu button -->
                    <button
                        @click="toggleMenu"
                        class="ml-4 inline-flex items-center justify-center p-2 rounded-md text-gray-400 dark:text-gray-500 hover:text-gray-500 dark:hover:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-indigo-500 sm:hidden"
                    >
                        <span class="sr-only">Open main menu</span>
                        <svg
                            :class="{ 'hidden': isOpen, 'block': !isOpen }"
                            class="h-6 w-6"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke="currentColor"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M4 6h16M4 12h16M4 18h16"
                            />
                        </svg>
                        <svg
                            :class="{ 'block': isOpen, 'hidden': !isOpen }"
                            class="h-6 w-6"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke="currentColor"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M6 18L18 6M6 6l12 12"
                            />
                        </svg>
                    </button>
                </div>
            </div>
        </div>

        <!-- Mobile menu -->
        <div
            :class="{ 'block': isOpen, 'hidden': !isOpen }"
            class="sm:hidden"
        >
            <div class="pt-2 pb-3 space-y-1">
                <RouterLink
                    to="/dashboard"
                    class="block pl-3 pr-4 py-2 border-l-4 text-base font-medium text-gray-500 dark:text-gray-400 hover:text-gray-800 dark:hover:text-gray-200 hover:bg-gray-50 dark:hover:bg-gray-700 hover:border-gray-300 dark:hover:border-gray-600"
                    :class="{ 'border-indigo-500 dark:border-indigo-400 text-indigo-700 dark:text-indigo-400 bg-indigo-50 dark:bg-indigo-900/50': route.path === '/dashboard' }"
                    @click="isOpen = false"
                >
                    Dashboard
                </RouterLink>
                <RouterLink
                    to="/about"
                    class="block pl-3 pr-4 py-2 border-l-4 text-base font-medium text-gray-500 dark:text-gray-400 hover:text-gray-800 dark:hover:text-gray-200 hover:bg-gray-50 dark:hover:bg-gray-700 hover:border-gray-300 dark:hover:border-gray-600"
                    :class="{ 'border-indigo-500 dark:border-indigo-400 text-indigo-700 dark:text-indigo-400 bg-indigo-50 dark:bg-indigo-900/50': route.path === '/about' }"
                    @click="isOpen = false"
                >
                    About
                </RouterLink>
                <RouterLink
                    to="/contact"
                    class="block pl-3 pr-4 py-2 border-l-4 text-base font-medium text-gray-500 dark:text-gray-400 hover:text-gray-800 dark:hover:text-gray-200 hover:bg-gray-50 dark:hover:bg-gray-700 hover:border-gray-300 dark:hover:border-gray-600"
                    :class="{ 'border-indigo-500 dark:border-indigo-400 text-indigo-700 dark:text-indigo-400 bg-indigo-50 dark:bg-indigo-900/50': route.path === '/contact' }"
                    @click="isOpen = false"
                >
                    Contact
                </RouterLink>
            </div>
        </div>
    </nav>
</template>

<style scoped>
.router-link-active {
    border-bottom: 2px solid #4F46E5;
    color: #4F46E5;
}
</style> 