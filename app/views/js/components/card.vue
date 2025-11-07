<script lang="ts" setup>
const props = defineProps<{
    title?: string
}>();
</script>

<template>
    <div
        class="bg-white dark:bg-slate-800 rounded-xl shadow-sm p-4 hover:shadow-md transition 
                text-gray-900 dark:text-gray-100 border border-transparent dark:border-slate-700"
        >
        <h2 class="text-xl font-bold mb-2">{{ props.title }}</h2>
        <slot name="content"></slot>
    </div>
</template>