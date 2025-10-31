<script setup lang="ts">
import { ref } from 'vue';
import Card from './card.vue';
import axios from 'axios';
import { StatResponse } from '../types/stat-response';
import StatisticSmiley from './statistic-smiley.vue';
import MonthSelector from './month-selector.vue';

const stats = ref<StatResponse>({
  month: '',
  year: '',
  monthNumber: 0,
  consumption: 0,
  lastReportedAmount: 0,
  maxLimit: 0,
  lastReading: 0,
  overConsumption: 0,
  remaining: 0,
  clockSetting: 0
})

const errorMessage = ref('');
const isCurrentMonth = ref(true);

async function fetchActualMonthStatistics() {
  const { data } = await axios.get<StatResponse>('stat')
  stats.value = data
}

async function fetchMonthStatistics(date : string) {
  try {
    const { data } = await axios.get<StatResponse>('stat', {
      params: {
        date
      }
    });
    stats.value = data;
    errorMessage.value = '';
    isCurrentMonth.value = `${stats.value.year}-${stats.value.monthNumber}` === date;
  } catch (error: any) {
    errorMessage.value = error.response.data.message || 'Ismeretlen hiba';
  }
}

fetchActualMonthStatistics();

defineExpose({
  fetchActualMonthStatistics
});
</script>
<template>
  <Card :title="`${stats.year} ${stats.month}`" class="text-center">
    <template #content>
      <MonthSelector @change-month="fetchMonthStatistics" />
      <p v-if="errorMessage.length > 0" class="text-red-500">
        {{ errorMessage }}
      </p>
      <template v-if="errorMessage.length === 0">
        <StatisticSmiley :consumption="stats.consumption" :max-limit="stats.maxLimit"/>
        <p class="pt-3"><b>Kedvezményes mennyiség:</b> {{ stats.maxLimit }} m<sup>3</sup></p>
        <p><b>Eddigi fogyasztás:</b> {{ stats.consumption }} m<sup>3</sup></p>
        <p><b>Még felhasználható kedv.m.:</b> {{  stats.remaining }} m<sup>3</sup></p>
        <p><b>Túlfogyasztott mennyiség.:</b> {{ stats.overConsumption }} m<sup>3</sup></p>
        <template v-if="isCurrentMonth">
          <p><b>Legutóbbi bediktált óraállás:</b> {{ stats.lastReportedAmount }} m<sup>3</sup></p>
          <p><b>Legutóbbi leolvasott óraállás:</b> {{ stats.lastReading }} m<sup>3</sup></p>
          <p><b>Javasolt időzítő beállítás:</b> {{ stats.clockSetting }}</p>
        </template>
      </template>
    </template>
  </Card>
</template>
