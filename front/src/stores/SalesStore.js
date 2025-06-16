import { defineStore } from 'pinia';
import { ref } from 'vue';
import { toast } from 'vue3-toastify';
import api from '../services/axios';
import 'vue3-toastify/dist/index.css';

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
      toast.error('Error ao buscar', {
        position: 'top-center',
        autoClose: 2000,
      });
    }
  };

  const salesSaveAction = async (payload) => {
    try {
      await api.post('/sales/create', payload);
      await salesListAction();
      toast.success('Venda salva com sucesso!', {
        position: 'top-center',
        autoClose: 2000,
      });
    } catch (error) {
      toast.error('Erro ao salvar venda!', {
        position: 'top-center',
        autoClose: 2000,
      });
      console.error(error);
    }
  };

  const salesUpdateAction = async (payload) => {
    try {
      const response = await api.put(`/sales/edit/${payload.id}`, payload);
      sales.value = response.data;
      toast.success('Venda editada com sucesso!', {
        position: 'top-center',
        autoClose: 2000,
      });
      await salesListAction();
    } catch (error) {
      toast.error('Erro ao editar venda!', {
        position: 'top-center',
        autoClose: 2000,
      });
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
