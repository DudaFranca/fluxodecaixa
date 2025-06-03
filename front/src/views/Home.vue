<template>
  <div class="flex h-screen">
    <Menu />
    <div 
      class="
        flex-1 flex flex-col 
        bg-blueBackground
      ">
      <div 
        class="
          bg-white 
          p-2 mb-2
          shadow-md
        ">
        <h1 class="text-xl font-semibold">Bem-vindo!</h1>
      </div>
      <div 
        class="
          flex-1 
          bg-white 
          p-2
          shadow-md 
          rounded-lg
          m-4
          max-h-52
        ">
        <p>Over View</p>
        <div 
          class="
            grid grid-cols-4 gap-6
            p-6
          ">
          <div 
            class="
              flex
              items-center
              gap-4
              bg-greenBackground
              border border-greenLightBorder rounded-lg
              p-4
              shadow-md
            ">
            <span 
              class="
                material-symbols-outlined outline outline-greenLightBorder
                rounded-lg
                bg-greenLightBackground 
                p-4
                col-4
              ">
              point_of_sale
            </span>
            <div>
              <h1 class="text-2xl font-bold">5483</h1>
              <p class="text-gray-500 text-sm">Total de Vendas</p>
            </div>
          </div>
          <div 
            class="
              flex
              items-center
              gap-4
              bg-greenBackground
              border border-greenLightBorder rounded-lg
              p-4
              shadow-md
            ">
            <span 
              class="
                material-symbols-outlined outline outline-greenLightBorder
                rounded-lg
                bg-greenLightBackground 
                p-4
                col-4
              ">
              point_of_sale
            </span>
            <div>
              <!-- <h1 class="text-2xl font-bold">{{ totalSalesToday.toFixed(2) }}</h1> -->
              <p class="text-gray-500 text-sm">Total de Vendas do dia</p>
            </div>
          </div>
          <div 
            class="
              flex
              items-center
              gap-4
              bg-greenBackground
              border border-greenLightBorder rounded-lg
              p-4
              shadow-md
            ">
            <span 
              class="
                material-symbols-outlined outline outline-greenLightBorder
                rounded-lg
                bg-greenLightBackground 
                p-4
                col-4
              ">
              point_of_sale
            </span>
            <div>
              <h1 class="text-2xl font-bold">5483</h1>
              <p class="text-gray-500 text-sm">Total de Vendas</p>
            </div>
          </div>
          <div 
            class="
              flex
              items-center
              gap-4
              bg-greenBackground
              border border-greenLightBorder rounded-lg
              p-4
              shadow-md
            ">
            <span 
              class="
                material-symbols-outlined outline outline-greenLightBorder
                rounded-lg
                bg-greenLightBackground 
                p-4
                col-4
              ">
              point_of_sale
            </span>
            <div>
              <h1 class="text-2xl font-bold">5483</h1>
              <p class="text-gray-500 text-sm">Total de vendas do dia</p>
            </div>
          </div>
        </div>
      </div>
      <div class="flex-1 bg-white p-4 shadow-md rounded-lg m-4">
        <p>Tela</p>
        {{ totalSalesToday }}
      </div>
    </div>
  </div>
</template>

<script setup>
  import Menu from '../components/Menu.vue';
  import { computed, ref, onMounted } from 'vue';
  import { useSalesStore } from '../stores/SalesStore';

  const store = useSalesStore();

  onMounted( async () => {
    await store.salesListAction();
  });
  
  const today = new Date().toISOString().split('T')[0];
  const totalSalesToday = computed(() => {
    return store.sales?.filter(sale => sale.date.startsWith(today))
      .reduce((total, sale) => total + Number(sale.price), 0) || 0;
  });
</script>