<script setup lang="ts">
import AddLogEntry from '../components/add-log-entry.vue';
import MonthStatistic from '../components/month-statistic.vue';
import CharacteristicCurve from '../components/characteristic-curve.vue';
import Modal from '../components/modal.vue';
import { onMounted, ref, shallowRef } from 'vue';
import AllEntries from '../components/all-entries.vue';
import HeaderBar from '../components/header-bar.vue';
import { useI18n } from 'vue-i18n';
import { useNetworkStatus } from '../composables/use-network-status';
import { sendLogEntry } from '../utils/log-service';

const { isOnline } = useNetworkStatus();
const { t, locale } = useI18n();
const logEntryModalRef = shallowRef<typeof Modal>();
const monthStatisticRef = ref<typeof MonthStatistic>();
const allEntriesRef = ref<typeof AllEntries>();
const characteristicCurveRef = ref<typeof CharacteristicCurve>();

const handleSuccess = () : void => {
    if (isOnline.value) {
        localStorage.removeItem('allRecords');
        localStorage.removeItem('currentMonth');
        
        if (monthStatisticRef.value) {
            monthStatisticRef.value.fetchActualMonthStatistics();
        }
        if (allEntriesRef.value) {
            allEntriesRef.value.fetchRecords();
        }

        if (characteristicCurveRef.value) {
            characteristicCurveRef.value.fetchRecords();
        }
    }

    if (logEntryModalRef.value) {
        logEntryModalRef.value.hide();
    }
}

onMounted(() => {
  if (isOnline.value) {
    const readingStorage = localStorage.getItem('readingStorage');
    if (readingStorage) {
      const storedReadings = JSON.parse(readingStorage);
      for(let i = 0, maxLength = storedReadings.length; i < maxLength; i++) {
        const {data} = storedReadings;
        sendLogEntry(data);
      }
      localStorage.removeItem('readingStorage');
      localStorage.removeItem('allRecords');
      localStorage.removeItem('currentMonth');
      alert(t('add-log-entry.all-synced'));
      window.location.reload();
    }
  }
});
</script>

<template>
    <HeaderBar/>
     <main class="bg-slate-50 dark:bg-slate-900 transition-colors duration-300 mt-10">
        <div class="text-black dark:text-gray-100 flex flex-col items-center min-h-screen">
            <div class="flex items-center gap-4 my-8">
            <img
                src="/assets/img/hot-sale.png"
                :alt="t('general.app-name')"
                class="w-10 h-10"
            />
            <h1 class="text-4xl font-bold">{{ t('general.app-name') }}</h1>
            </div>

            <div class="flex flex-col gap-5">
            <MonthStatistic ref="monthStatisticRef" />
            <AllEntries ref="allEntriesRef" />
            <CharacteristicCurve class="mb-20" ref="characteristicCurveRef"/>
            </div>

            <button
                @click="logEntryModalRef?.show()"
                class="fixed bottom-6 right-6 bg-blue-600 dark:bg-blue-500 text-white text-3xl rounded-full w-14 h-14 flex items-center justify-center shadow-lg hover:bg-blue-700 dark:hover:bg-blue-600 transition"
            >
                +
            </button>

            <Modal ref="logEntryModalRef">
                <AddLogEntry @success="handleSuccess" />
            </Modal>
        </div>
  </main>
</template>
