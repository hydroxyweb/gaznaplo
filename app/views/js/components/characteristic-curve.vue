<script lang="ts" setup>
import { ref, computed, onMounted } from 'vue';
import Card from './card.vue';
import { useI18n } from 'vue-i18n';
import { useNetworkStatus } from '../composables/use-network-status';
import api from '../utils/axios';

const { t } = useI18n();
const { isOnline } = useNetworkStatus();
const loading = ref(true);
const records = ref<any[]>([]);
const error = ref<string | null>(null);

async function fetchRecords() {
    try {
        if (localStorage.getItem('characteristicCurveRecords') || !isOnline) {
            records.value = JSON.parse(localStorage.getItem('characteristicCurveRecords') ?? '');
        } else {
            const response = await api.get('/characteristic-curve');
            records.value = response.data.data;
            localStorage.setItem('characteristicCurveRecords', JSON.stringify(response.data.data));
        }
    } catch (err: any) {
        error.value = err.message || t('general.unknown-error');
    } finally {
        loading.value = false;
    }
}

onMounted(() => {
    fetchRecords()
});

defineExpose({
    fetchRecords
});
</script>

<template>
 <Card :title="t('characteristic-curve.title')" class="text-center">
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
                        <th class="p-2 border-b border-gray-300 dark:border-slate-700 text-center">
                            {{ t('characteristic-curve.month') }}
                        </th>
                        <th class="p-2 border-b border-gray-300 dark:border-slate-700 text-center">
                            {{ t('characteristic-curve.amount') }}
                        </th>
                        <th class="p-2 border-b border-gray-300 dark:border-slate-700 text-center">
                            {{ t('characteristic-curve.clock-settings') }}
                        </th>
                    </tr>
                </thead>

                <tbody>
                    <tr
                    v-for="record in records"
                    :key="record.id"
                    class="hover:bg-gray-50 dark:hover:bg-slate-700 transition-colors"
                    >
                    <td class="p-2 border-b border-gray-300 dark:border-slate-700">
                        {{ record.month_name }}
                    </td>
                    <td class="p-2 border-b border-gray-300 dark:border-slate-700 text-center">
                        {{ record.max_limit }} m<sup>3</sup>
                    </td>
                    <td class="p-2 border-b border-gray-300 dark:border-slate-700 text-center">
                        {{ record.clock }}
                    </td>
                    </tr>
                </tbody>
                </table>
            </div>
    </template>
 </Card>
</template>