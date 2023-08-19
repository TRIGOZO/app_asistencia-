<script setup>
  import jwt_decode from 'jwt-decode'
  import { ref, onMounted } from 'vue';
  import { defineTitle } from '@/Helpers';
  import useHelper from '@/Helpers';  
  import usePersonal from '@/Composables/personal.js';
  import ContentHeader from '@/Componentes/ContentHeader.vue';
  import PermisoForm from './Form.vue'
  const { openModal, Toast, Swal } = useHelper();
  const {
        personales,
        obtenerPersonales,
    } = usePersonal();
    const titleHeader = ref({
      titulo: "Solicitud Permisos",
      subTitulo: "Inicio",
      icon: "",
      vista: ""
    });
    const dato = ref({
        page:'',
        buscar:'',
        paginacion: 10
    });
    const form = ref({
        id:'',
        nombre:'',
        estadoCrud:'',
        errors:[]
    });
    const limpiar = ()=> {
        form.value.id =""
        form.value.nombre=''
        form.value.errors = []
        errors.value = []
    }
    const buscar = () => {
        listarPersonales()
    }
    // const obtenerDatos = async(id) => {
    //     await obtenerCargo(id);
    //     if(cargo.value)
    //     {
    //         form.value.id=cargo.value.id
    //         form.value.nombre=cargo.value.nombre
    //     }
    // }
    const listarPersonales = async(page=1) => {
        dato.value.page= page
        await obtenerPersonales(dato.value)
    }
    // CARGA
    onMounted(() => {
        defineTitle(titleHeader.value.titulo)
        //listarPersonales()
    })
</script>
<template>
    <ContentHeader :title-header="titleHeader"></ContentHeader>
    <div class="app-content">
      <div class="container-fluid">
        <div class="card card-primary card-outline">
            <div class="card-header">
                <h6 class="card-title">
                    Busqueda de Personal
                </h6>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-8">
                        <div class="input-group mb-1">
                            <span class="input-group-text" id="basic-addon1">Apellidos y Nombres</span>
                            <input class="form-control" placeholder="Ingrese nombre, código ciiu" type="text" v-model="dato.buscar"
                                @change="buscar" />
                        </div>
                    </div>
                    <div class="col-md-4 mb-1">
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12 mb-1">
                        <div class="table-responsive">         
                            <table class="table table-bordered table-hover table-sm table-striped">
                                <thead class="table-dark">
                                    <tr>
                                        <th class="text-center">#</th>
                                        <th>Nombre</th>
                                        <th>Accion</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-if="personales.total == 0">
                                        <td class="text-danger text-center" colspan="7">
                                            -- Datos No Registrados - Tabla Vacía --
                                        </td>
                                    </tr>
                                    <tr v-else v-for="(personal,index) in personales.data" :key="personal.id">
                                        <td class="text-center">{{ index + personales.from }}</td>
                                        <td>{{ personal.nombres }}</td>
                                        <td>
                                            <button class="btn btn-info btn-sm" title="Generar Horario" @click.prevent="editar(personal.id)">
                                                <i class="fas fa-clock"></i>
                                            </button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
      </div>
    </div>
    <PermisoForm :form="form" @onListar="listarpersonales" :currentPage="personales.current_page"></PermisoForm>
</template>




