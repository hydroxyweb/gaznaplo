<script lang="ts" setup>
import { computed } from 'vue';

const props = defineProps<{
    consumption: number,
    maxLimit: number
}>();

const percent = computed(() => Math.round(((props.consumption / props.maxLimit) - 1) * 100));
</script>

<template>
    <p v-if="percent <= 0" class="bg-green-500 text-4xl font-bold p-2 text-white rounded-xl">
        :)
    </p>
    <p v-if="percent >= 30 && percent <= 50" class="bg-yellow-500 text-4xl p-2 font-bold text-white rounded-xl">
        :|
    </p>

    <p v-if="percent >= 50" class="bg-red-500 text-4xl p-2 font-bold text-white rounded-xl">
        :(
    </p>
</template>