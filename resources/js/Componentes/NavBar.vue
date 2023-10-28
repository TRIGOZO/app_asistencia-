<script setup>
import { ref, toRefs, onMounted } from 'vue';
import useHelper from '@/Helpers';
import jwt_decode from 'jwt-decode'
import usePersonal from '@/Composables/personal'
import useUsuario from '@/Composables/usuario.js'
import { useAutenticacion } from '@/Composables/autenticacion';
import imgAvatar from '../../../public/img/avatar.png';
const { obtenerUsuario2, usuario2 } = useUsuario();
const { errors, personal, obtenerPersonaldetalle } = usePersonal();
    const props = defineProps({
        usuario: Object
    });

    const { logoutUsuario }= useAutenticacion();
    const { Swal } = useHelper();
    const {usuario} = toRefs(props)

    const logout = async() => {
        await logoutUsuario(usuario.value.id)
    }
    const obtenerdatospersonal = async() =>{
        const user_id = localStorage.getItem('userSession') ? JSON.parse( JSON.stringify(jwt_decode(localStorage.getItem('userSession')).user)) : null;
        await obtenerUsuario2(user_id)
        if(user_id != null) await obtenerPersonaldetalle(usuario2.value.personal_id);
    }
    onMounted(() => {
      obtenerdatospersonal()
  })
    const cerrarSesion = async() => {
        Swal.fire({
            title:'¿Está seguro de Cerrar Sesión?',
            text:'ASISTENCIA APP',
            icon:'question',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Si',
            cancelButtonText: 'No'
        }).then((result) => {
            if(result.isConfirmed) {
                logout()
            }
        })
    }
</script>

<template>
    <nav class="app-header navbar navbar-expand bg-body">
        <div class="container-fluid">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" data-lte-toggle="sidebar" href="#" role="button">
                        <i class="fa-solid fa-bars"></i>
                    </a>
                </li>
                <li class="nav-item d-none d-md-block">
                    <a href="/principal" class="nav-link">Home</a>
                </li>
            </ul>
            <ul class="navbar-nav ms-auto">
                <!--begin::Navbar Search-->
                <li class="nav-item">
                    <a class="nav-link" data-widget="navbar-search" href="#" role="button">
                        <i class="fa-solid fa-search"></i>
                    </a>
                </li>
                <!--begin::User Menu Dropdown-->
                <li class="nav-item dropdown user-menu">
                    <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">
                        <img :src="imgAvatar" class="user-image rounded-circle shadow" alt="User Image">
                        <span class="d-none d-md-inline">{{ usuario.username }}</span>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-lg dropdown-menu-end">
                        <!--begin::User Image-->
                        <li class="user-header text-bg-primary">
                            <img :src="imgAvatar" class="rounded-circle shadow" alt="User Image">
                            <p>
                                {{ usuario.username }}
                            </p>
                        </li>
                        <!--end::User Image-->
                        <!--begin::Menu Body-->
                        <li class="user-body">
                            <!--begin::Row-->
                            <div class="row">
                                <div class="col-12 text-center" v-text="personal.establecimiento">
                                </div>
                            </div>
                            <!--end::Row-->
                        </li>
                        <!--end::Menu Body-->
                        <!--begin::Menu Footer-->
                        <li class="user-footer">
                            <a href="perfil" class="btn btn-default btn-flat">Mi Perfil</a>
                            <a href="#" class="btn btn-default btn-flat float-end"
                                @click.prevent="cerrarSesion">
                                Cerrar Sesi&oacute;n
                            </a>
                        </li>
                        <!--end::Menu Footer-->
                    </ul>
                </li>
            </ul>
        </div>
    </nav>
</template>
