
<script setup>
import { cargarClasesPrincipalLayout } from '@/Helpers';
import { onMounted } from 'vue';
// import PreLoader from '@/Components/PreLoader.vue';
import NavBar from '@/Componentes/partials/MainHeader.vue';
import SideBar from '@/Componentes/partials/Sidebar.vue';
import Footer from '@/Componentes/partials/Footer.vue';
onMounted(() => {
    cargarClasesPrincipalLayout();
})
</script>

<template>
    <div class="app-wrapper">
        <!-- <PreLoader></PreLoader> -->
        <nav-bar></nav-bar>
        <side-bar></side-bar>
        <main class="app-main">
            <router-view></router-view>
        </main>
        <Footer></Footer>
        <!-- <Aside></Aside> -->
    </div>
</template>
