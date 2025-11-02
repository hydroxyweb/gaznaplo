<script setup lang="ts">
import AddLogEntry from '../components/add-log-entry.vue';
import MonthStatistic from '../components/month-statistic.vue';
import Modal from '../components/modal.vue';
import { ref, shallowRef } from 'vue';
import AllEntries from '../components/all-entries.vue';

const appName = import.meta.env.VITE_APP_NAME || '';
const logEntryModalRef = shallowRef<typeof Modal>();
const monthStatisticRef = ref<typeof MonthStatistic>();
const allEntriesRef = ref<typeof AllEntries>();

const handleSuccess = () : void => {
    if (monthStatisticRef.value) {
        monthStatisticRef.value.fetchActualMonthStatistics();
    }
    if (allEntriesRef.value) {
        allEntriesRef.value.fetchRecords();
    }

    if (logEntryModalRef.value) {
        logEntryModalRef.value.hide();
    }
}
</script>

<template>
    <main class="bg-slate-50">
        <div class="text-black flex flex-col items-center min-h-screen">
            <div class="flex items-center gap-4 my-8">
                <img src="/assets/img/hot-sale.png" :alt="appName" />
                <h1 class="text-4xl font-bold">{{ appName }}</h1>
            </div>
            <div class="flex flex-col gap-5">
                <MonthStatistic ref="monthStatisticRef" />
                <AllEntries ref="allEntriesRef" class="mb-20"/>
            </div>

            <button
                @click="logEntryModalRef?.show()"
                class="fixed bottom-6 right-6 bg-blue-600 text-white text-3xl rounded-full w-14 h-14 flex items-center justify-center shadow-lg hover:bg-blue-700 transition"
            >
            +
            </button>

            <Modal
                ref="logEntryModalRef"
            >
                <AddLogEntry @success="handleSuccess" />
            </Modal>
        </div>
    </main>
</template>
