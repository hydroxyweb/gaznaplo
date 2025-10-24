<script setup lang="ts">
import AddLogEntry from '../components/add-log-entry.vue';
import MonthStatistic from '../components/month-statistic.vue';

const appName = import.meta.env.VITE_APP_NAME || '';
</script>

<template>

    <main
        class="bg-slate-50">
        <div class="text-black flex flex-col items-center min-h-screen">
            <h1 class="text-4xl font-bold my-8">{{ appName }}</h1>
            <div class="flex gap-5">
                <AddLogEntry />
                <MonthStatistic />
            </div>
        </div>
    </main>
</template>
