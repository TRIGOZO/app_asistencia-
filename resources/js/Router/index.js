import { createRouter, createWebHistory } from "vue-router";
import jwt_decode from 'jwt-decode';

//PLANTILLAS
import LayoutLogin from '@/Layouts/AppLayoutLogin.vue'
import LayoutDefault from '@/Layouts/AppLayoutDefault.vue'
// import { useUsuarioStore } from "../Store/UsuarioStore";
// import { storeToRefs } from 'pinia';
//vistas
import Principal from '@/Paginas/Principal.vue'
import Usuario from '@/Paginas/usuarios/Inicio.vue'
import Login from '@/Paginas/Auth/Login.vue'
import Profile from '@/Paginas/Profile/Inicio.vue'
import Profesion from '@/Paginas/profesiones/Inicio.vue'
import Cargo from '@/Paginas/cargos/Inicio.vue'
import TipoTurno from '@/Paginas/tipoturno/Inicio.vue'

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
    {
        path: '/perfil', name:'Perfil', component: Profile ,
        meta:{layout: LayoutDefault}
    }, 
    {
        path: '/cargo', name:'Cargo', component: Cargo ,
        meta:{layout: LayoutDefault}
    },
    {
        path: '/profesion', name:'Profesion', component: Profesion ,
        meta:{layout: LayoutDefault}
    },   
    {
        path: '/tipo-turno', name:'Tipo Turno', component: TipoTurno ,
        meta:{layout: LayoutDefault}
    },     
    
]

export default createRouter({
    history: createWebHistory(),
    routes
})
