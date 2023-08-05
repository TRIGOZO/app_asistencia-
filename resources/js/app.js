// import './bootstrap';
import { createApp } from 'vue';
import { createPinia } from 'pinia';


import 'sweetalert2/dist/sweetalert2.min.css'
import SweetAlert2 from 'sweetalert2'
import router from './Router';
import App from './Paginas/App.vue';

const app = createApp(App);


app.use(router);
app.use(createPinia())
app.provide('Swal',SweetAlert2);
app.mount('#wrapper');

