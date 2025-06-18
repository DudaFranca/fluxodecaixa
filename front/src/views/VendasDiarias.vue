<!-- https://dribbble.com/shots/4074902-Restaurant-Dashboard-Orders/attachments/934702?mode=media -->
<template>
  <div>
    <div class="container py-16">
      <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-10">
        <h1 class="font-semibold text-2xl">Lista de vendas</h1>
        <button 
          class="mt-4 sm:mt-0 bg-blue text-white px-4 py-2 rounded-lg hover:bg-blue-700" 
          @click="toggleModal"
        >
          Nova Venda
        </button>
      </div>

      <div class="box-border grid grid-cols-5 gap-5">
        <div class="box-number">
          <h1 class="box-number-value">R$ {{ account }}</h1>
          <p class="box-text">Valor Vendido</p>
        </div>
        
        <div class="box-number" data-popover-target="popover-default">
          <h1 class="box-number-pix">R$ {{ accountPix }}</h1>
          <p class="box-text">Venda no PIX </p>
        </div>
        <div 
          data-popover
          id="popover-default"
          role="tooltip"
          class="
            absolute
            z-10
            invisible invisible-block
            w-64
            text-sm text-gray-500 dark:text-gray-400
            transition-opacity duration-300
            bg-white border border-gray-200 rounded-lg shadow-xs dark:bg-gray-800 dark:border-gray-600
            opacity-0
          " 
        >
          <div class="px-3 py-2">
              <p>{{ storeSales.sales?.payment_methods_count?.pix }} vendas realizadas no PIX</p>
          </div>
          <div data-popper-arrow></div>
        </div>

        <div class="box-number" data-popover-target="popover-default-cred">
          <h1 class="box-number-cred">R$ {{ accountCred }}</h1>
          <p class="box-text">Venda no Crédito</p>
        </div>
        <div 
          data-popover
          id="popover-default-cred"
          role="tooltip"
          class="
            absolute
            z-10
            invisible invisible-block
            w-64
            text-sm text-gray-500 dark:text-gray-400
            transition-opacity duration-300
            bg-white border border-gray-200 rounded-lg shadow-xs dark:bg-gray-800 dark:border-gray-600
            opacity-0
          " 
        >
          <div class="px-3 py-2">
              <p>{{ storeSales.sales?.payment_methods_count?.credit_card }} vendas realizadas no Crédito</p>
          </div>
          <div data-popper-arrow></div>
        </div>

        <div class="box-number" data-popover-target="popover-default-debit">
          <h1 class="box-number-debit">R$ {{ accountDebit }}</h1>
          <p class="box-text">Venda no Débito</p>
        </div>
        <div 
          data-popover
          id="popover-default-debit"
          role="tooltip"
          class="
            absolute
            z-10
            invisible invisible-block
            w-64
            text-sm text-gray-500 dark:text-gray-400
            transition-opacity duration-300
            bg-white border border-gray-200 rounded-lg shadow-xs dark:bg-gray-800 dark:border-gray-600
            opacity-0
          " 
        >
          <div class="px-3 py-2">
              <p>{{ storeSales.sales?.payment_methods_count?.debit_card }} vendas realizadas no Débito</p>
          </div>
          <div data-popper-arrow></div>
        </div>

        <div class="box-number" data-popover-target="popover-default-cash">
          <h1 class="box-number-cash">R$ {{ accountCash }}</h1>
          <p class="box-text">Venda no Dinheiro</p>
        </div>
        <div 
          data-popover
          id="popover-default-cash"
          role="tooltip"
          class="
            absolute
            z-10
            invisible invisible-block
            w-64
            text-sm text-gray-500 dark:text-gray-400
            transition-opacity duration-300
            bg-white border border-gray-200 rounded-lg shadow-xs dark:bg-gray-800 dark:border-gray-600
            opacity-0
          " 
        >
          <div class="px-3 py-2">
              <p>{{ storeSales.sales?.payment_methods_count?.cash }} vendas realizadas no Dinheiro</p>
          </div>
          <div data-popper-arrow></div>
        </div>
      </div>

      <!-- Table -->
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
                    <button @click="edit(sale, true)" class="text-green flex items-center p-2 mr-1">
                      <img src="../assets/images/view.svg" alt="Visualizar" class="w-6 h-6">
                    </button>
                    <!-- Tooltip -->
                    <span class="absolute left-1/2 -translate-x-1/2 mb-2 w-max bg-gray-800 text-white text-xs px-2 py-1 rounded opacity-0 group-hover:opacity-100 transition-opacity">
                      Visualizar venda
                    </span>
                  </div>
                  
                  <div class="relative group inline-block">
                    <button @click="edit(sale, false)" class="text-green flex items-center p-2">
                      <img src="../assets/images/editIcon.svg" alt="" class="w-6 h-6">
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
    <Modal :isOpen="isModalOpen" :view="!viewSale" :title="titleModal" @exec="save" @close="toggleModal">
      <form>
        <div class="mb-4 flex gap-3">
          <div v-if="!viewSale" class="flex-1">
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
            v-if="!viewSale"
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
            <img src="../assets/images/arrow.svg" class="w-6 h-6" alt="Adicionar produto">
            <span class="sr-only">Icon description</span>
          </button>
        </div>
        <table class="w-full mb-5">
          <thead class="bg-gray-800 text-white">
            <tr>
              <th class="p-2 text-left">Nome</th>
              <th class="p-2">Preço</th>
              <th class="p-2">Quantidade</th>
              <th  v-if="!viewSale" class="p-2">Ação</th>
            </tr>
          </thead>
          
          <tbody>
            <tr v-for="product in selectedProducts" :key="product.id">
              <td>{{ product.name }}</td>
              <td class="text-center p-2">{{ product.price }}</td>
              <td class="text-center p-2">{{ product.quantity }}</td>
              <td v-if="!viewSale" class="text-center p-2">
                <button 
                  type="button"
                  @click="removeProduct(product.id)"
                  class="text-red-600 hover:text-red-800"
                >
                  Excluir
                </button>
              </td>
            </tr>
          </tbody>
        </table>
        <div class="quantity mb-4">
          <label for="quantity" class="block text-sm font-medium text-gray-700">Quantidade</label>
          <input 
            v-model="saleForm.quantity"
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
        <div class="price mb-4">
          <label for="price" class="block text-sm font-medium text-gray-700">Preço Total</label>
          <input 
            v-model="saleForm.totalPrice" 
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
        <div class="paymentMethod mb-4">
          <label for="paymentMethod" class="block text-sm font-medium text-gray-700">Modo de pagamento</label>
          <select 
            v-model="saleForm.paymentMethod" 
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
              :disabled="viewSale"
          >
            <option value="1">PIX</option>
            <option value="2">Cartão de Crédito</option>
            <option value="3">Cartão de Débito</option>
            <option value="4">Dinheiro</option>
          </select>
        </div>
      </form>
    </Modal>
  </div>
</template>

<script setup>
  import { computed, onMounted, ref, watch } from 'vue';
  import { useSalesStore } from '/src/stores/SalesStore.js';
  import { useProductStore } from '/src/stores/ProductsStore.js';
  import Modal from '../components/Modal.vue';

  const storeSales = useSalesStore();
  const productStore = useProductStore();
  const products = computed(() => productStore.products);
  const product = ref(null);
  const isModalOpen = ref(false);
  const viewSale = ref(false);
  const titleModal = ref('');
  const selectedProducts = ref([]);
  const totalPrice = ref(0);
  const saleForm = ref({
    id: null,
    products: [],
    quantity: 0,
    totalPrice: 0,
    paymentMethod: '1'
  });

  const account = computed(() => {
    const total = storeSales.sales?.sales?.reduce((sum, sale) => {
      return sum + Number(sale.total_price);
    }, 0) || 0;
    
    return total.toFixed(2);
  });

  const accountPix = computed(() => {
    const totalPix = storeSales.sales?.sales?.reduce((sum, sale) => {
      return sale.payment_method.type === 'PIX' ? sum + Number(sale.total_price) : sum;
    }, 0) || 0;
    return totalPix.toFixed(2);
  });

  const accountCred = computed(() => {
    const totalCred = storeSales.sales?.sales?.reduce((sum, sale) => {      
      return sale.payment_method.type === 'Crédito' ? sum + Number(sale.total_price) : sum;
    }, 0) || 0;
    return totalCred.toFixed(2);
  });

  const accountDebit = computed(() => {
    const totalDebit = storeSales.sales?.sales?.reduce((sum, sale) => {
      return sale.payment_method.type === 'Débito' ? sum + Number(sale.total_price) : sum;
    }, 0) || 0;
    return totalDebit.toFixed(2);
  });

  const accountCash = computed(() => {
    const totalCash = storeSales.sales?.sales?.reduce((sum, sale) => {
      return sale.payment_method.type === 'Dinheiro' ? sum + Number(sale.total_price) : sum;
    }, 0) || 0;
    return totalCash.toFixed(2);
  });

  const formatDate = (dateString) => {
    if (!dateString) return "";
    
    const date = new Date(dateString);
    const day = String(date.getDate()).padStart(2, "0");
    const month = String(date.getMonth() + 1).padStart(2, "0");
    const year = date.getFullYear();

    return `${day}/${month}/${year}`;
  };
  
  function toggleModal() {
    isModalOpen.value = !isModalOpen.value;
    clearForm();
  }

  function edit(data, view) {
    toggleModal();
    selectedProducts.value = [...data.products];
    saleForm.value = {
      id: data.id,
      products: selectedProducts.value,
      quantity: data.total_quantity,
      totalPrice: data.total_price,
      paymentMethod: data.payment_method_id.toString()
    };
    
    viewSale.value = view ? true : false;
    titleModal.value = view ? 'Venda Realizada' : 'Venda';
  }

  const setProduct = () => {
    const productItem = products.value.find(p => p.id === product.value);
    const existingProduct = selectedProducts.value.find(p => p.id === productItem.id);

    if (existingProduct) {
      existingProduct.quantity += 1;      
    } else {
      selectedProducts.value.push({
        ...productItem,
        quantity: 1
      });      
    }
    
    if(productItem) {
      saleForm.value.products = selectedProducts.value;      
      saleForm.value.quantity = selectedProducts.value.reduce((acc, p) => acc + p.quantity, 0);
      totalPrice.value = selectedProducts.value.reduce((acc, item) => acc + item.quantity * parseFloat(item.price), 0);
      saleForm.value.totalPrice = totalPrice.value;
    }    
  };

  const save = () => {
    if (saleForm.value.id) {
      storeSales.salesUpdateAction(saleForm.value);
      toggleModal();
    } else {  
      storeSales.salesSaveAction(saleForm.value);
      clearForm();
    }
  };

  const clearForm = () => {
    saleForm.value = {
      id: null,
      products: [],
      quantity: 0,
      totalPrice: 0,
      paymentMethod: '1'
    };
    selectedProducts.value = [];
     viewSale.value = false;
  }

  const removeProduct = (productId) => {
    selectedProducts.value = selectedProducts.value.filter(product => product.id !== productId);
    saleForm.value.products = selectedProducts.value;
    saleForm.value.quantity = selectedProducts.value.length;
    totalPrice.value = selectedProducts.value.reduce((acc, item) => acc + parseFloat(item.price), 0);
    saleForm.value.totalPrice = totalPrice.value;
  };

  onMounted( async () => {
    storeSales.salesListAction();
    await productStore.getProducts();
  });

</script>