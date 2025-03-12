<!-- https://dribbble.com/shots/4074902-Restaurant-Dashboard-Orders/attachments/934702?mode=media -->
<template>
  <div>
    <div class="container py-16">
      <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-10">
        <h1 class="font-semibold text-2xl">Lista de vendas</h1>
        <button 
          class="mt-4 sm:mt-0 bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700" 
          @click="openModal"
        >
          Nova Venda
        </button>
      </div>

      <div class="box-border grid grid-cols-5 gap-5">
        <div class="box-number">
          <h1 class="box-number-value">{{ account }}</h1>
          <p class="box-text">Valor Vendido</p>
        </div>
        <div class="box-number">
          <h1 class="box-number-pix">{{ store.sales?.payment_methods_count?.pix }}</h1>
          <p class="box-text">Venda no PIX</p>
        </div>
        <div class="box-number">
          <h1 class="box-number-cred">{{ store.sales?.payment_methods_count?.credit_card }}</h1>
          <p class="box-text">Venda no Crédito</p>
        </div>
        <div class="box-number">
          <h1 class="box-number-debit">{{ store.sales?.payment_methods_count?.debit_card }}</h1>
          <p class="box-text">Venda no Débito</p>
        </div>
        <div class="box-number">
          <h1 class="box-number-cash">{{ store.sales?.payment_methods_count?.cash }}</h1>
          <p class="box-text">Venda no Dinheiro</p>
        </div>
      </div>

      <div 
        class="
          relative 
          overflow-x-auto 
          shadow-md
          sm:rounded-lg
        ">
          <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
              <tr>
                <th scope="col" class="px-6 py-3 font-bold">Produto</th>
                <th scope="col" class="px-6 py-3 font-bold">Quantidade</th>
                <th scope="col" class="px-6 py-3 font-bold">Preço</th>
                <th scope="col" class="px-6 py-3 font-bold">Modo de pagamento</th>
                <th scope="col" class="px-6 py-3 font-bold">Ação</th>
              </tr>
            </thead>
            <tbody>
              <tr
                v-for="sale in store.sales.sales" 
                :key="sale.id"
                class="
                  bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-600
                  border-b dark:border-gray-700 border-gray-200
                ">
                  <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                    {{ sale.product }}
                  </th>
                    <td class="px-6 py-4">
                      {{ sale.quantity }}
                    </td>
                    <td class="px-6 py-4">
                      {{ sale.price }}
                    </td>
                    <td class="px-6 py-4">
                      {{ sale.payment_method.type }}
                    </td>
                    <td class="px-6 py-4">
                      <div class="relative group inline-block">
                        <button @click="edit(sale)" class="text-green flex items-center">
                          <span class="material-symbols-outlined">edit</span>
                        </button>
                        <!-- Tooltip -->
                        <span class="absolute left-1/2 -translate-x-1/2 mb-2 w-max bg-gray-800 text-white text-xs px-2 py-1 rounded opacity-0 group-hover:opacity-100 transition-opacity">
                          Editar venda
                        </span>
                      </div>
                    </td>
                </tr>
            </tbody>
          </table>
      </div>
    </div>
    <Modal :isOpen="isModalOpen" :saleDataEdit="saleDataEdit" @close="isModalOpen = false" />
  </div>
</template>

<script setup>
  import { useSalesStore } from '/src/stores/SalesStore.js';
  import { computed, onMounted, ref } from 'vue';
  import Modal from '../components/Modal.vue';

  const store = useSalesStore();
  const isModalOpen = ref(false);
  const saleDataEdit = ref(null);

  onMounted(() => {
    store.salesListAction();
  });

  const account = computed(() => {
    return store.sales?.sales?.reduce((total, sale) => {
      return total + sale.quantity;
    }, 0) || 0;
  });
  
  function openModal() {
    store.setSaleForm({
      id: null,
      product: '',
      quantity: 0,
      price: 0,
      paymentMethod: 0,
    })
    isModalOpen.value = true;
  }

  function edit(data) {
    store.setSaleForm(data);
    isModalOpen.value = true;
  }

</script>