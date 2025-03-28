import { createApp } from 'vue';
import { createPinia } from 'pinia';
import './style.css';
import 'material-design-icons-iconfont/dist/material-design-icons.css';
import App from './App.vue';
import router from './router';

const app = createApp(App);
app.use(createPinia());
app.use(router);
app.mount('#app');
