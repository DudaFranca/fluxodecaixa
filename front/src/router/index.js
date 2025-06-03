import { createRouter, createWebHistory } from 'vue-router';
import Home from '../views/Home.vue';
import VendasDiarias from '../views/VendasDiarias.vue';

const routes = [
  { path: '/', component: Home },
  { path: '/vendas-diarias', component: VendasDiarias },
];

const router = createRouter({
  history: createWebHistory(),
  routes,
});

export default router;
