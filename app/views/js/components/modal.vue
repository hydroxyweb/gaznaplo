<script lang="ts" setup>
import { ref } from 'vue';
import { useI18n } from 'vue-i18n'

const { t } = useI18n();
const showModal = ref(false)

const _show = () => {
    showModal.value = true;
}

const _hide = () => {
    showModal.value = false;
}

defineExpose({show: _show, hide: _hide})
</script>

<template>
    <!-- Modal -->
  <transition name="fade">
    <div
      v-if="showModal"
      class="fixed inset-0 bg-black/60 dark:bg-black/80 backdrop-blur-sm flex items-center justify-center z-50"
      @click.self="_hide"
    >
      <div
        class="bg-white dark:bg-slate-800 text-gray-900 dark:text-gray-100 rounded-2xl shadow-xl p-6 w-11/12 max-w-md border border-transparent dark:border-slate-700 transition-colors duration-300"
      >
        <slot></slot>

        <div class="flex justify-end mt-4">
          <button
            @click="_hide"
            class="text-gray-600 dark:text-gray-300 hover:text-gray-800 dark:hover:text-gray-100 transition"
          >
            {{ t('general.cancel') }}
          </button>
        </div>
      </div>
    </div>
  </transition>
</template>