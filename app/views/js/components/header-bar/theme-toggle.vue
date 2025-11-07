<script setup lang="ts">
import { ref, watchEffect } from 'vue'
import { useI18n } from 'vue-i18n'

const { t } = useI18n();
const isDark = ref(localStorage.getItem('theme') === 'dark')

watchEffect(() => {
  document.documentElement.classList.toggle('dark', isDark.value)
  localStorage.setItem('theme', isDark.value ? 'dark' : 'light')
})

const toggleTheme = () => {
  isDark.value = !isDark.value
}
</script>

<template>
  <button
    @click="toggleTheme"
    class="p-2 rounded hover:bg-gray-200 dark:hover:bg-gray-600"
    :title="isDark ? t('theme-toggle.light-mode') : t('theme-toggle.dark-mode')"
  >
    <span v-if="isDark">🌙</span>
    <span v-else>☀️</span>
  </button>
</template>