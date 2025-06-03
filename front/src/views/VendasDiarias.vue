<!-- https://dribbble.com/shots/4074902-Restaurant-Dashboard-Orders/attachments/934702?mode=media -->
<template>
  <div>
    <div class="container py-16">
      <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-10">
        <h1 class="font-semibold text-2xl">Lista de vendas</h1>
        <button 
          class="mt-4 sm:mt-0 bg-blue text-white px-4 py-2 rounded hover:bg-blue-700" 
          @click="openModal"
        >
          Nova Venda
        </button>
      </div>

      <div class="box-border grid grid-cols-5 gap-5">
        <div class="box-number">
          <h1 class="box-number-value">R$ {{ account }}</h1>
          <p class="box-text">Valor Vendido</p>
        </div>
        <div class="box-number">
          <h1 class="box-number-pix">{{ storeSales.sales?.payment_methods_count?.pix }}</h1>
          <p class="box-text">Venda no PIX</p>
        </div>
        <div class="box-number">
          <h1 class="box-number-cred">{{ storeSales.sales?.payment_methods_count?.credit_card }}</h1>
          <p class="box-text">Venda no Crédito</p>
        </div>
        <div class="box-number">
          <h1 class="box-number-debit">{{ storeSales.sales?.payment_methods_count?.debit_card }}</h1>
          <p class="box-text">Venda no Débito</p>
        </div>
        <div class="box-number">
          <h1 class="box-number-cash">{{ storeSales.sales?.payment_methods_count?.cash }}</h1>
          <p class="box-text">Venda no Dinheiro</p>
        </div>
      </div>

      <div 
        class="
          relative 
          overflow-x-auto overflow-y-auto 
          shadow-md
          sm:rounded-lg
          max-h-[400px]
        ">
          <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
              <tr>
                <th scope="col" class="px-6 py-3 font-bold">N° da compra</th>
                <th scope="col" class="px-6 py-3 font-bold">Quantidade</th>
                <th scope="col" class="px-6 py-3 font-bold">Preço</th>
                <th scope="col" class="px-6 py-3 font-bold">Modo de pagamento</th>
                <th scope="col" class="px-6 py-3 font-bold">Data</th>
                <th scope="col" class="px-6 py-3 font-bold">Ação</th>
              </tr>
            </thead>
            
            <tbody>
              <tr
                v-for="sale in storeSales.sales.sales" 
                :key="sale.id"
                class="
                  bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-600
                  border-b dark:border-gray-700 border-gray-200
                "
                @click="openModal(sale)"
              >
                  <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                    {{ sale.id }}
                  </th>
                    <td class="px-6 py-4">
                      {{ sale.total_quantity }}
                    </td>
                    <td class="px-6 py-4">
                      {{ sale.total_price }}
                    </td>
                    <td class="px-6 py-4">
                      {{ sale.payment_method.type }}
                    </td>
                    <td class="px-6 py-4">
                      {{ formatDate(sale.created_at) }}
                    </td>
                    <td class="px-6 py-4">
                      <div class="relative group inline-block">
                        <button @click="edit(sale)" class="text-green flex items-center">
                          <svg xmlns="http://www.w3.org/2000/svg" height="20" width="20" viewBox="0 0 512 512"><path fill="#03cc00" d="M441 58.9L453.1 71c9.4 9.4 9.4 24.6 0 33.9L424 134.1 377.9 88 407 58.9c9.4-9.4 24.6-9.4 33.9 0zM209.8 256.2L344 121.9 390.1 168 255.8 302.2c-2.9 2.9-6.5 5-10.4 6.1l-58.5 16.7 16.7-58.5c1.1-3.9 3.2-7.5 6.1-10.4zM373.1 25L175.8 222.2c-8.7 8.7-15 19.4-18.3 31.1l-28.6 100c-2.4 8.4-.1 17.4 6.1 23.6s15.2 8.5 23.6 6.1l100-28.6c11.8-3.4 22.5-9.7 31.1-18.3L487 138.9c28.1-28.1 28.1-73.7 0-101.8L474.9 25C446.8-3.1 401.2-3.1 373.1 25zM88 64C39.4 64 0 103.4 0 152L0 424c0 48.6 39.4 88 88 88l272 0c48.6 0 88-39.4 88-88l0-112c0-13.3-10.7-24-24-24s-24 10.7-24 24l0 112c0 22.1-17.9 40-40 40L88 464c-22.1 0-40-17.9-40-40l0-272c0-22.1 17.9-40 40-40l112 0c13.3 0 24-10.7 24-24s-10.7-24-24-24L88 64z"/></svg>
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
  import Modal from '../components/ModalVenda.vue';

  const storeSales = useSalesStore();
  const isModalOpen = ref(false);
  const saleDataEdit = ref(null);

  onMounted(() => {
    storeSales.salesListAction();
  });

  const account = computed(() => {
    const total = storeSales.sales?.sales?.reduce((sum, sale) => {
      return sum + Number(sale.total_price);
    }, 0) || 0;
    
    return total.toFixed(2);
  });

  const formatDate = (dateString) => {
    if (!dateString) return "";
    
    const date = new Date(dateString);
    const day = String(date.getDate()).padStart(2, "0");
    const month = String(date.getMonth() + 1).padStart(2, "0");
    const year = date.getFullYear();

    return `${day}/${month}/${year}`;
  };
  
  async function openModal(sale = null) {
    if(sale) {
      await storeSales.saleAction(sale.id);
    } 
    else {
      storeSales.setSaleForm({
        id: null,
        products: [],
        quantity: 0,
        totalPrice: 0,
        paymentMethod: 0,
      });
    }
    
    isModalOpen.value = true;
  }

  function edit(data) {    
    storeSales.setSaleForm(data);
    isModalOpen.value = true;
  }

</script>