<script setup>
import { ref, onMounted } from 'vue';
import { defineTitle } from '@/Helpers';
import ContentHeader from '@/Componentes/ContentHeader.vue';

const titleHeader = ref({
    titulo: "Principal",
    subTitulo: "",
    icon: "",
    vista: ""
});

onMounted(() => {
    defineTitle(titleHeader.value.titulo)
})

</script>

<template>
    <ContentHeader :title-header="titleHeader"></ContentHeader>
    <div class="app-content">
        <div class="container-fluid">
            <div class="row">

            </div>
        </div>
    </div>
</template>
