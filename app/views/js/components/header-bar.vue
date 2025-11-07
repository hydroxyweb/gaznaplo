<script setup lang="ts">
import LanguageSelector from './header-bar/language-selector.vue';
import ThemeToggle from './header-bar/theme-toggle.vue';
import ConnectionStatus from './header-bar/connection-status.vue';
</script>

<template>
  <header
    class="fixed top-0 left-0 w-full bg-white dark:bg-gray-800 border-b border-gray-200 dark:border-gray-700
         flex justify-center md:justify-between items-center px-4 py-2 shadow-sm z-50"
    >
    <div class="flex items-center gap-4">
      <LanguageSelector />
      <ThemeToggle />
      <ConnectionStatus />
    </div>
  </header>
</template>
