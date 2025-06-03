<template>
  <aside 
      class="
        w-52
        bg-blue 
        text-white
        py-4 pl-4 
        flex flex-col
      ">
      <nav>
        <ul>
          <li
            v-for="(item, index) in menuItems"
            :key="index"
            @click="selectedIndex = index"
            class="p-2 cursor-pointer rounded-l-full"
            :class="selectedIndex === index ? 'bg-blueBackground' : 'bg-blue'"
          >
            {{ item }}
          </li>
        </ul>
      </nav>
    </aside>
</template>

<script setup>
  import { ref } from 'vue';

  const menuItems = ref([
    'Opção 1',
    'Opção 2',
    'Opção 3',
  ]);
  const selectedIndex = ref(0);
</script>