<script lang="ts" setup>
import { ref } from 'vue';

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
        class="fixed inset-0 bg-black/75 flex items-center justify-center z-50"
        @click.self="_hide"
      >
        <div class="bg-white rounded-2xl shadow-xl p-6 w-11/12 max-w-md">
          <slot></slot>
          <div class="flex justify-end mt-4">
            <button
              @click="_hide"
              class="text-gray-600 hover:text-gray-800 transition"
            >
              Mégse
            </button>
          </div>
        </div>
      </div>
    </transition>
</template>