<script setup>
  import jwt_decode from 'jwt-decode'
  import { ref, onMounted } from 'vue';
  import ContentHeader from '@/Componentes/ContentHeader.vue';
    const titleHeader = ref({
      titulo: "Cargo",
      subTitulo: "Inicio",
      icon: "",
      vista: ""
    });

</script>
<template>
    <ContentHeader :title-header="titleHeader"></ContentHeader>
    <div class="app-content">
      <div class="container-fluid">
        <div class="card card-primary card-outline">
            <div class="card-header">
                <h6 class="card-title">
                    Archivos
                </h6>
            </div>
            <div class="card-body">
                <a href="/public/manuales/register_personal.pdf" target="_blank" class="btn btn-info">Registro de Personales</a>&nbsp;
                <a href="/public/manuales/register_update_permiso.pdf" target="_blank" class="btn btn-info">Permisos</a>&nbsp;
                <a href="" target="_blank" class="btn btn-info">Guardar</a>&nbsp;
            </div>
        </div>
      </div>
    </div>
</template>