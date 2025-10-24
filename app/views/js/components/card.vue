<script lang="ts" setup>
const props = defineProps<{
    title?: string
}>();
</script>

<template>
    <div class="add-log-entry bg-white rounded-xl shadow-sm p-4 hover:shadow-md transition">
        <h2 class="text-xl font-bold">{{ props.title }}</h2>
        <slot name="content"></slot>
    </div>
</template>