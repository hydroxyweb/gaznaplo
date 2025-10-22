<script setup>
import AddLogEntry from '../components/add-log-entry.vue';
import MonthStatistic from '../components/month-statistic.vue';
// import Navbar from '@/components/welcome/navbar.vue';

defineProps({
    phpVersion: String,
});

function handleImageError() {
    document.getElementById('screenshot-container')?.classList.add('!hidden');
    document.getElementById('docs-card')?.classList.add('!row-span-1');
    document.getElementById('docs-card-content')?.classList.add('!flex-row');
    document.getElementById('background')?.classList.add('!hidden');
}
</script>

<template>

    <main
        class="antialiased bg-gradient-to-br from-transparent via-white to-green-100 dark:from-[#102e36] dark:via-[#001318] dark:to-[#001318] dark:text-white/50">
        <div class="text-black/50 dark:text-white/50 flex flex-col items-center min-h-screen">
            <h1 class="text-4xl font-bold my-8">Gáznapló</h1>
            <AddLogEntry />
            <MonthStatistic />
        </div>
    </main>
</template>
