import { defineStore } from 'pinia';
import { ref } from 'vue';
import api from '../services/axios';

export const useSalesStore = defineStore('sales', () => {
  // States
  const sales = ref([]);
  const saleForm = ref({
    id: null,
    product: '',
    quantity: 0,
    price: 0,
    paymentMethod: 0,
  });

  // Actions
  const salesListAction = async () => {
    try {
      const response = await api.get('/sales');
      sales.value = response.data;
    } catch (error) {
      console.error('Error ao buscar', error);
    }
  };

  const salesSaveAction = async (payload) => {
    try {
      const response = await api.post('/sales/create', payload);
      sales.value = response.data;
      await salesListAction();
    } catch (error) {
      console.error('Error ao salvar', error);
    }
  };

  const salesUpdateAction = async (payload) => {
    try {
      const response = await api.put(`/sales/edit/${payload.id}`, payload);
      sales.value = response.data;
      await salesListAction();
    } catch (error) {
      console.error('Error ao salvar', error);
    }
  };

  const setSaleForm = async (sale) => {
    saleForm.value = { ...sale };
  };

  return {
    sales,
    saleForm,
    salesListAction,
    salesSaveAction,
    salesUpdateAction,
    setSaleForm,
  };
});
