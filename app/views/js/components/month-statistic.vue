<script setup lang="ts">
import { ref } from 'vue';

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
  <div class="month-statistic">
    <h2>{{ month }} {{ year }} Statisztika</h2>
    <p>Összes bejegyzés: {{ totalEntries }}</p>
    <p>Összes mennyiség: {{ totalAmount }} egység</p>
  </div>    
</template>
