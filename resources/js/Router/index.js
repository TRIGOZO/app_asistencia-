import { createRouter, createWebHistory } from "vue-router";

//PLANTILLAS
import LayoutLogin from '@/Layouts/AppLayoutLogin.vue'
import LayoutDefault from '@/Layouts/AppLayoutDefault.vue'

//vistas
import Principal from '@/Paginas/Principal.vue'
import Usuario from '@/Paginas/usuarios/Inicio.vue'
import Login from '@/Paginas/Auth/Login.vue'
const routes = [
    {
        path: '/',name: 'Login', component: Login,
        meta: {layout: LayoutLogin}
    },
    {
        path: '/principal', name:'Principal', component: Principal ,
        meta:{layout: LayoutDefault}
    },
    {
        path: '/usuarios', name:'Usuario', component: Usuario ,
        meta:{layout: LayoutDefault}
    },
]

export default createRouter({
    history: createWebHistory(),
    routes
})
