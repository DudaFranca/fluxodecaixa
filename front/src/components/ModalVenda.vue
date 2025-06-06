<template>
  <div 
    v-if="isOpen" 
    class="fixed inset-0 flex items-center justify-center z-50"
  >
    <div class="backdrop absolute inset-0 bg-gray-900 opacity-50" @click="close"></div>
    <div 
      class="
        relative 
        bg-white rounded-lg shadow-lg
        max-w-4xl w-full 
        z-10
    ">
      <div class="modal-header w-full p-6 flex justify-between border-b border-gray-200">
        <h1 class="text-2xl">Nova Venda</h1>
        <button 
          @click="close" 
          class="text-gray-600 hover:text-gray-900"
        >
          <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"></path>
          </svg>
        </button>
      </div>

      <div class="modal-body p-6">
        <slot></slot>
      </div>
      
      <div class="modal-footer w-full p-6 border-t border-gray-200 flex justify-end gap-4">
        <button class="bg-red-700 text-white px-4 py-2 rounded-lg hover:bg-blue-700" @click="close">Cancelar</button>
        <button class="bg-blue text-white px-4 py-2 rounded-lg hover:bg-blue-700" @click="exec">Salvar</button>
      </div>
    </div>
  </div>
</template>

<script setup>
import { defineProps, defineEmits } from 'vue';

const props = defineProps({
  isOpen: {
    type: Boolean,
    default: true
  },
});

const emit = defineEmits(['close', 'exec']);

const close = () => {
  emit('close');
};

const exec = () => {
  emit('exec');
};

</script>
