<script setup lang="ts">
import { ref, computed, onMounted } from 'vue';
import axios from 'axios';
import Card from './card.vue';

const records = ref<any[]>([]);
const loading = ref(true);
const error = ref<string | null>(null);
const showAll = ref(false);

async function fetchRecords() {
    try {
        const response = await axios.get('/all-records')
        records.value = response.data
    } catch (err: any) {
        error.value = err.message || 'Ismeretlen hiba';
    } finally {
        loading.value = false;
    }
}

const formatDate = (dateStr: string) : string => {
    const date = new Date(dateStr);
    return date.toLocaleDateString('hu-HU');
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
    <Card title="Leolvasások" class="text-center">
        <template #content>
            <p v-if="loading" class="text-gray-500">Betöltés...</p>

            <p v-else-if="error" class="text-red-500">
            Hiba történt: {{ error }}
            </p>

            <div v-else>
                <table class="min-w-full bg-white border border-gray-300 mt-2">
                    <thead class="bg-gray-100 text-left">
                    <tr>
                        <th class="p-2 border-b">Dátum</th>
                        <th class="p-2 border-b">Menny.</th>
                        <th class="p-2 border-b">Fogy. </th>
                        <th class="p-2 border-b">Napi átl.f. </th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr
                        v-for="record in displayedRecords"
                        :key="record.id"
                        class="hover:bg-gray-50"
                        :class="{
                            'bg-green-300': record.reported
                        }"
                    >
                        <td class="p-2 border-b"> {{ formatDate(record.created_at) }}</td>
                        <td class="p-2 border-b text-center">{{ record.amount }} m<sup>3</sup></td>
                        <td class="p-2 border-b text-center">{{ record.diff_by_amount }} m<sup>3</sup></td>
                        <td class="p-2 border-b text-center">{{ record.average_consumption }} m<sup>3</sup></td>
                    </tr>
                    </tbody>
                </table>

                <!-- Gomb az összes megjelenítéséhez -->
                <div class="text-center mt-4">
                    <button
                    @click="toggleShowAll"
                    class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition"
                    >
                    {{ showAll ? 'Összecsuk' : 'Összes rekord megjelenítése' }}
                    </button>
                </div>
            </div>
        </template>
    </Card>
    
  </div>
</template>