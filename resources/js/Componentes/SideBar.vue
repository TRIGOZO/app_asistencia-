<script setup>
import { toRefs } from 'vue';
import {useRoute } from 'vue-router';

const props = defineProps({
    usuario: Object,
    menus: Array
});

const { usuario, menus} = toRefs(props);
const route = useRoute();
const ruta = (String(route.path).toLowerCase()).substring(1);

</script>

<template>
    <aside class="app-sidebar bg-body-secondary shadow" data-bs-theme="dark">
        <!--begin::Sidebar Brand-->
        <div class="sidebar-brand">
            <!--begin::Brand Link-->
            <a href="/principal" class="brand-link">
                <!--begin::Brand Image-->
                <img src="adminlte4/assets/img/AdminLTELogo.png" alt="SufragioADP Logo"
                    class="brand-image opacity-75 shadow rounded-circle" />
                <!--end::Brand Image-->
                <!--begin::Brand Text-->
                <span class="brand-text fw-light">ASISTENCIA APP</span>
                <!--end::Brand Text-->
            </a>
            <!--end::Brand Link-->
        </div>
        <!--end::Sidebar Brand-->
        <!--begin::Sidebar Wrapper-->
        <div class="sidebar-wrapper">
            <nav class="mt-2">
                <!--begin::Sidebar Menu-->
                <ul class="nav sidebar-menu flex-column" data-lte-toggle="treeview" role="menu" data-accordion="false">
                    <li class="nav-header">MEN&Uacute; PRINCIPAL</li>
                    <li class="nav-item" v-for="menu in menus" :key="menu.id">
                        <a :href="menu.menus.length ? '#' : menu.slug" class="nav-link" :class="{ 'active': menu.slug == ruta }">
                            <i class="nav-icon" :class="menu.icono"></i>
                            <p>
                                {{ menu.nombre }} 
                                <i v-if="menu.menus.length" class="nav-arrow bi bi-chevron-right"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview" v-if="menu.menus.length">
                            <li class="nav-item" v-for="menu in menu.menus" :key="menu.id">
                                <a :href="menu.slug" class="nav-link" :class="{ 'active': menu.slug == ruta }">
                                    <i class="nav-icon" :class="menu.icono"></i>
                                    <p>{{ menu.nombre }}</p>
                                </a>
                            </li>
                        </ul>                        
                    </li>
                </ul>
                <!--end::Sidebar Menu-->
            </nav>
        </div>
        <!--end::Sidebar Wrapper-->
    </aside>
</template>
