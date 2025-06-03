<template>
  <div 
    v-if="isOpen" 
    class="fixed inset-0 flex items-center justify-center z-50"
  >
    <div class="absolute inset-0 bg-gray-900 opacity-50" @click="close"></div>
    <div 
      class="
        relative 
        bg-white rounded-lg shadow-lg 
        p-6 
        max-w-4xl w-full 
        z-10
    ">
      <button 
        @click="close" 
        class="
          absolute 
          top-2 right-2 
          text-gray-600 hover:text-gray-900
      ">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
          <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"></path>
        </svg>
      </button>
      
      <form @submit.prevent="save">
        <div class="mb-4 flex gap-3">
          <div class="flex-1">
            <label for="product" class="block text-sm font-medium text-gray-700">Produto</label>
            <select 
              v-model="product" 
                class="
                  bg-gray-50 dark:bg-gray-700 dark:placeholder-gray-400
                  border border-gray-300 dark:border-gray-600
                  text-gray-900 text-sm dark:text-white
                  rounded-lg
                  focus:ring-blue-500 focus:border-blue-500 dark:focus:ring-blue-500 dark:focus:border-blue-500
                  block w-full p-2.5 
            ">
              <option value="" disabled selected>Selecione um produto</option>
              <option v-for="product in products" :key="product.id" :value="product.id">{{ product.name }}</option>
            </select>
          </div>
          <button 
            @click="setProduct" 
            type="button" 
            class="
              text-white text-sm text-center 
              bg-blue hover:bg-blue dark:bg-blue dark:hover:bg-blue
              focus:ring-4 focus:outline-none focus:ring-blue-300 dark:focus:ring-blue
              font-medium 
              rounded-lg 
              p-2.5 me-2
              inline-flex items-center
            " 
            style="max-height: 40px; margin-top: 20px;"
          >
            <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 10">
              <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 5h12m0 0L9 1m4 4L9 9"/>
            </svg>
            <span class="sr-only">Icon description</span>
          </button>
        </div>
        <table class="w-full mb-5">
          <thead class="bg-gray-800 text-white">
            <tr>
              <th class="p-2 text-left">Nome</th>
              <th class="p-2">Preço</th>
              <th class="p-2">Ação</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="product in selectedProducts" :key="product.id">
              <td>{{ product.name }}</td>
              <td class="text-center p-2">{{ product.price }}</td>
              <td class="text-center p-2">Excluir</td>
            </tr>
          </tbody>
        </table>
        <div class="mb-4">
          <label for="quantity" class="block text-sm font-medium text-gray-700">Quantidade</label>
          <input 
            v-model="store.saleForm.quantity"
            type="number"
            id="quantity"
            name="quantity"
            readonly
            class="
              mt-1 px-3 py-2 
              block 
              w-full
              border border-gray-300 
              rounded-md 
              shadow-sm 
              focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 
              sm:text-sm" 
          />
        </div>
        <div class="mb-4">
          <label for="price" class="block text-sm font-medium text-gray-700">Preço Total</label>
          <input 
            v-model="store.saleForm.totalPrice" 
            type="number" 
            id="price" 
            name="price"
            readonly
            class="
              mt-1 px-3 py-2
              block w-full 
              border border-gray-300 
              rounded-md 
              shadow-sm 
              focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 
              sm:text-sm" 
          />
        </div>
        <div class="mb-4">
          <label for="paymentMethod" class="block text-sm font-medium text-gray-700">Modo de pagamento</label>
          <select 
            v-model="store.saleForm.paymentMethod" 
            id="paymentMethod" 
            name="paymentMethod" 
            value="paymentMethod" 
            class="
              mt-1 px-3 py-2
              block 
              w-full 
              border border-gray-300 
              rounded-md 
              shadow-sm 
              focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 
              sm:text-sm"
          >
            <option value="1">PIX</option>
            <option value="2">Cartão de Crédito</option>
            <option value="3">Cartão de Débito</option>
            <option value="4">Dinheiro</option>
          </select>
        </div>
        <div class="flex justify-end">
          <button type="submit" class="bg-blue text-white px-4 py-2 rounded hover:bg-blue-700">Salvar</button>
        </div>
      </form>
    </div>
  </div>
</template>

<script setup>
import { useSalesStore } from '/src/stores/SalesStore.js';
import { useProductStore } from '/src/stores/ProductsStore.js';
import { defineProps, defineEmits, ref, onMounted, computed } from 'vue';

const store = useSalesStore();
const productStore = useProductStore();
const products = computed(() => productStore.products);
const product = ref(null);

const props = defineProps({
  isOpen: {
    type: Boolean,
    default: false
  }
});

const selectedProducts = ref([]);
const totalPrice = ref(0);
const setProduct = () => {
  const productItem = products.value.find(p => p.id === product.value);
  if(productItem) {
    selectedProducts.value.push(productItem);    
    store.saleForm.products = selectedProducts.value;
    store.saleForm.quantity = selectedProducts.value.length;
    totalPrice.value = selectedProducts.value.reduce((acc, item) => acc + parseFloat(item.price), 0);
    store.saleForm.totalPrice = totalPrice.value;
  }
};

const save = () => {  
  if (store.saleForm.id) {
    store.salesUpdateAction(store.saleForm);
  } else {
    store.salesSaveAction(store.saleForm);
    clearForm();
    emit('close');
  }
};

const clearForm = () => {
  store.saleForm = {
    id: null,
    products: [],
    quantity: 0,
    totalPrice: 0,
    paymentMethod: '1'
  }
}

const emit = defineEmits(['close']);

const close = () => {
  emit('close');
};

onMounted( async () => {
  await productStore.getProducts();
});

</script>
