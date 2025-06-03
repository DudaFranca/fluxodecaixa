import { defineStore } from 'pinia';
import { ref } from 'vue';
import api from '../services/axios';

export const useProductStore = defineStore('products', () => {
  // States
  const products = ref([]);

  // Actions
  const getProducts = async () => {
    try {
      const response = await api.get('/products');
      products.value = response.data.data;
    } catch (error) {
      console.error('Error ao buscar', error);
    }
  };

  return {
    products,
    getProducts,
  };
});
