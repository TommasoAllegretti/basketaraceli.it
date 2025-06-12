<script setup lang="ts">
import { RouterView } from 'vue-router'
import MainNavbar from '../components/MainNavbar.vue'
</script>

<template>
    <div class="min-h-screen bg-gray-100">
        <!-- Navigation Bar -->
        <MainNavbar />

        <!-- Main Content -->
        <main class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
            <RouterView />
        </main>
    </div>
</template>
