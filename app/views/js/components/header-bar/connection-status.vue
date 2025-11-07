<script setup lang="ts">
import { useNetworkStatus } from '../../composables/use-network-status';

const { isOnline } = useNetworkStatus();
</script>

<template>
  <div
    :class="[
      'flex items-center gap-1 text-sm rounded px-2 py-1',
      isOnline ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700'
    ]"
  >
    <span :class="isOnline ? 'text-green-500' : 'text-red-500'">●</span>
    <span>{{ isOnline ? 'Online' : 'Offline' }}</span>
  </div>
</template>