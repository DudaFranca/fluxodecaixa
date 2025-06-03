import { defineStore } from 'pinia';
import { ref } from 'vue';
import api from '../services/axios';

export const useSalesStore = defineStore('sales', () => {
  // States
  const sales = ref([]);
  const saleForm = ref({
    id: null,
    products: [],
    quantity: 0,
    totalPrice: 0,
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
      await salesListAction();
    } catch (error) {
      console.error('Erro ao salvar', error);
    }
  };

  const salesUpdateAction = async (payload) => {
    try {
      const response = await api.post(`/sales/edit/${payload.id}`, payload);
      sales.value = response.data;
      await salesListAction();
    } catch (error) {
      console.error('Error ao salvar', error);
    }
  };

  const saleAction = async (id) => {
    try {
      const response = await api.get(`/sales/${id}`);
      saleForm.value = { ...response.data.sale };
      return saleForm.value;
    } catch (error) {
      console.error('Error ao buscar venda', error);
      return null;
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
    saleAction,
    setSaleForm,
  };
});
