<script setup lang="ts">
import { ref, computed, onMounted } from 'vue';
import api from '../utils/axios';
import Card from './card.vue';
import { useI18n } from 'vue-i18n'
import { useNetworkStatus } from '../composables/use-network-status';

const { t, locale } = useI18n();
const { isOnline } = useNetworkStatus();
const records = ref<any[]>([]);
const loading = ref(true);
const error = ref<string | null>(null);
const showAll = ref(false);

async function fetchRecords() {
    try {
        if (localStorage.getItem('allRecords') || !isOnline) {
            records.value = JSON.parse(localStorage.getItem('allRecords') ?? '');
        } else {
            const response = await api.get('/all-records');
            records.value = response.data;
            localStorage.setItem('allRecords', JSON.stringify(response.data));
        }
    } catch (err: any) {
        error.value = err.message || t('general.unknown-error');
    } finally {
        loading.value = false;
    }
}

const formatDate = (dateStr: string) : string => {
    const date = new Date(dateStr);
    return date.toLocaleDateString(locale.value === 'hu' ? 'hu-HU' : 'en-BG');
}

const displayedRecords = computed(() => {
    return showAll.value ? records.value : records.value.slice(0, 4);
});

const toggleShowAll = () : void => {
    showAll.value = !showAll.value;
}

onMounted(() => {
    fetchRecords()
});

defineExpose({
    fetchRecords
});
</script>

<template>
  <div class="pt-2">
    <Card :title="t('all-entries.title')" class="text-center">
        <template #content>
            <p v-if="loading" class="text-gray-500 dark:text-gray-400">
                {{ t('general.loading') }}
            </p>

            <p v-else-if="error" class="text-red-500 dark:text-red-400">
                {{ t('general.error') }}: {{ error }}
            </p>

            <div v-else>
                <table
                class="min-w-full bg-white dark:bg-slate-800 border border-gray-300 dark:border-slate-700 rounded-lg mt-2 transition-colors duration-300"
                >
                <thead class="bg-gray-100 dark:bg-slate-700 text-left text-gray-900 dark:text-gray-100">
                    <tr>
                    <th class="p-2 border-b border-gray-300 dark:border-slate-700">
                        {{ t('all-entries.date') }}
                    </th>
                    <th class="p-2 border-b border-gray-300 dark:border-slate-700">
                        {{ t('all-entries.amount') }}
                    </th>
                    <th class="p-2 border-b border-gray-300 dark:border-slate-700">
                        {{ t('all-entries.consumption') }}
                    </th>
                    <th class="p-2 border-b border-gray-300 dark:border-slate-700">
                        {{ t('all-entries.average-consumption') }}
                    </th>
                    </tr>
                </thead>

                <tbody>
                    <tr
                    v-for="record in displayedRecords"
                    :key="record.id"
                    class="hover:bg-gray-50 dark:hover:bg-slate-700 transition-colors"
                    :class="{
                        'bg-green-300 dark:bg-green-700': Number(record.reported) === 1
                    }"
                    >
                    <td class="p-2 border-b border-gray-300 dark:border-slate-700">
                        {{ formatDate(record.created_at) }}
                    </td>
                    <td class="p-2 border-b border-gray-300 dark:border-slate-700 text-center">
                        {{ record.amount }} m<sup>3</sup>
                    </td>
                    <td class="p-2 border-b border-gray-300 dark:border-slate-700 text-center">
                        {{ record.diff_by_amount }} m<sup>3</sup>
                    </td>
                    <td class="p-2 border-b border-gray-300 dark:border-slate-700 text-center">
                        {{ record.average_consumption }} m<sup>3</sup>
                    </td>
                    </tr>
                </tbody>
                </table>

                <div class="text-center mt-4">
                <button
                    @click="toggleShowAll"
                    class="bg-blue-600 dark:bg-blue-500 text-white px-4 py-2 rounded-lg 
                        hover:bg-blue-700 dark:hover:bg-blue-600 transition"
                >
                    {{ showAll ? t('all-entries.close') : t('all-entries.show-all') }}
                </button>
                </div>
            </div>
            </template>
    </Card>
    
  </div>
</template>