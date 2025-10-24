<script setup lang="ts">
import { ref } from 'vue';
import Card from './card.vue';

const month = ref(new Date().toLocaleString('default', { month: 'long' }));
const year = ref(new Date().getFullYear());
const totalEntries = ref(0);
const totalAmount = ref(0);

function fetchMonthStatistics() {
    // Fetch statistics for the current month
}

fetchMonthStatistics();
</script>
<template>
  <Card title="Statisztika">
    <template #content>
      <p>Összes bejegyzés: {{ totalEntries }}</p>
      <p>Összes mennyiség: {{ totalAmount }} egység</p>
    </template>
  </Card>
</template>
