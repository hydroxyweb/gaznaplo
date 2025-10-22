<script setup lang="ts">
import { ref } from 'vue';

const amount = ref(0);
const date = ref(new Date().toISOString().substr(0, 10));
const description = ref('');

function addLogEntry() {
    // Logic to add a log entry
}
</script>
<template>
  <div class="add-log-entry">
    <h2>Új bejegyzés hozzáadása</h2>
    <form @submit.prevent="addLogEntry">
      <div>
        <label for="amount">Mennyiség:</label>
        <input type="number" v-model="amount" id="amount" required />
      </div>
      <div>
        <label for="date">Dátum:</label>
        <input type="date" v-model="date" id="date" required readonly />
      </div>
      <button type="submit">Hozzáadás</button>
    </form>
  </div>
</template>
