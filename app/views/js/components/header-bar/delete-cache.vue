<script setup lang="ts">
import { useI18n } from 'vue-i18n';

const { t } = useI18n();

const deleteCache = () => {
    localStorage.removeItem('allRecords');
    localStorage.removeItem('currentMonth');
    localStorage.removeItem('lang');
    localStorage.removeItem('theme');
    window.location.reload();
};
</script>

<template>
    <button
    @click="deleteCache"
    class="p-2 rounded hover:bg-gray-200 dark:hover:bg-gray-600"
    :title="t('delete-cache.action')"
  >
    🗑️
  </button>
</template>