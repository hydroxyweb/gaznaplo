<script setup lang="ts">
import { ref } from 'vue'
import { useI18n } from 'vue-i18n'

const { locale } = useI18n()
const currentLang = ref(locale.value)

function changeLanguage() {
  locale.value = currentLang.value
  localStorage.setItem('lang', currentLang.value)
}
</script>

<template>
  <select
    v-model="currentLang"
    @change="changeLanguage"
    class="bg-gray-100 dark:bg-gray-700 dark:text-white rounded px-2 py-1 text-sm focus:outline-none"
  >
    <option value="hu">Magyar</option>
    <option value="en">English</option>
  </select>
</template>