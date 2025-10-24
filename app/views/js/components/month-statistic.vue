<script setup lang="ts">
import { ref, computed } from 'vue';
import Card from './card.vue';
import axios from 'axios';
import { StatResponse } from '../types/stat-response';

const stats = ref<StatResponse>({
  month: '',
  year: '',
  consumption: 0,
  lastReportedAmount: 0,
  maxLimit: 0,
  lastReading: 0
})

const remaining = computed(() => stats.value.maxLimit - stats.value.consumption)

async function fetchMonthStatistics() {
  const { data } = await axios.get<StatResponse>('stat')
  stats.value = data
}

fetchMonthStatistics();
</script>
<template>
  <Card :title="`${stats.year} ${stats.month}`" class="text-center">
    <template #content>
      <p>Kedvezményes mennyiség: {{ stats.maxLimit }}</p>
      <p>Eddigi fogyasztás: {{ stats.consumption }}</p>
      <p>Még felhasználható kedv.m.: {{  remaining }}</p>
      <p>Legutóbbi bediktált óraállás: {{ stats.lastReportedAmount }}</p>
      <p>Legutóbbi leolvasott óraállás: {{ stats.lastReading }}</p>
    </template>
  </Card>
</template>
