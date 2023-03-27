<template>
<MainHeader />
<div id="layoutSidenav">
    <Sidebar />
    <div id="layoutSidenav_content">
        <router-view></router-view>
        <Footer />
    </div>
</div>
</template>

<script>
import { onMounted } from 'vue';
import { cargarClasesDefaultLayout } from '@/Helpers';
import MainHeader from '@/Componentes/partials/MainHeader.vue';
import Sidebar from '@/Componentes/partials/Sidebar.vue';
import Footer from '@/Componentes/partials/Footer.vue';


export default {
    components:{
        Sidebar, MainHeader, Footer
    },
    setup() {
        onMounted(() => {
            cargarClasesDefaultLayout()
        });

        return {

        }
    },
}
</script>
