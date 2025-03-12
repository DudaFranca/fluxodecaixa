<template>
  <div v-if="isOpen" class="fixed inset-0 flex items-center justify-center z-50">
    <div class="absolute inset-0 bg-gray-900 opacity-50" @click="close"></div>
    <div class="relative bg-white rounded-lg shadow-lg p-6 max-w-md w-full z-10">
      <button @click="close" class="absolute top-2 right-2 text-gray-600 hover:text-gray-900">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
          <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"></path>
        </svg>
      </button>
      
      <form @submit.prevent="save">
        <div class="mb-4">
          <label for="product" class="block text-sm font-medium text-gray-700">Produto</label>
          <input v-model="store.saleForm.product" type="text" id="product" name="product" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" />
        </div>
        <div class="mb-4">
          <label for="quantity" class="block text-sm font-medium text-gray-700">Quantidade</label>
          <input v-model="store.saleForm.quantity" type="number" id="quantity" name="quantity" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" />
        </div>
        <div class="mb-4">
          <label for="price" class="block text-sm font-medium text-gray-700">Preço</label>
          <input v-model="store.saleForm.price" type="number" id="price" name="price" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" />
        </div>
        <div class="mb-4">
          <label for="paymentMethod" class="block text-sm font-medium text-gray-700">Modo de pagamento</label>
          <select v-model="store.saleForm.payment_method_id" id="paymentMethod" name="paymentMethod" value="paymentMethod" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
            <option value="1">PIX</option>
            <option value="2">Cartão de Crédito</option>
            <option value="3">Cartão de Débito</option>
            <option value="4">Dinheiro</option>
          </select>
        </div>
        <div class="flex justify-end">
          <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Salvar</button>
        </div>
      </form>
    </div>
  </div>
</template>

<script setup>
import { useSalesStore } from '/src/stores/SalesStore.js';
import { defineProps, defineEmits, ref, onMounted } from 'vue';

const store = useSalesStore();
const props = defineProps({
  isOpen: {
    type: Boolean,
    default: false
  }
});

const save = () => {
  if (store.saleForm.id) {
    store.salesUpdateAction(store.saleForm);
  } else {
    store.salesSaveAction(store.saleForm);
  }
};

const emit = defineEmits(['close']);

const close = () => {
  emit('close');
};
</script>
