<script setup lang="ts">
import { ref } from 'vue';
import Card from './card.vue';
import axios from 'axios';

const amount = ref(0);
const date = ref(new Date().toISOString().substr(0, 10));
const description = ref('');

function addLogEntry() {
    axios.post('log', {
      amount: amount.value
    })
    .then((response) => {
      alert('OK');
    })
}
</script>
<template>
  <Card :title="'Új rekord'" class="text-center">
    <template #content>
      <form @submit.prevent="addLogEntry">
        <div class="mb-3">
          <label for="amount" class="font-bold">Óraállás:</label>
          <input type="number" v-model="amount" id="amount" required class="bg-white border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"/>
        </div>
        <div>
          <label for="date" class="font-bold">Dátum:</label>
          <input type="date" v-model="date" id="date" required readonly aria-label="disabled input" class="mb-6 bg-gray-100 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 cursor-not-allowed dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-gray-400 dark:focus:ring-blue-500 dark:focus:border-blue-500" />
        </div>
        <div class="text-center">
          <button type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Hozzáadás</button>
        </div>
      </form>
    </template>
  </Card>
</template>
