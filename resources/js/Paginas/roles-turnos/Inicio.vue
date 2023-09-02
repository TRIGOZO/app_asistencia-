<script setup>
  import jwt_decode from 'jwt-decode'
  import { ref, onMounted } from 'vue';
  import { defineTitle } from '@/Helpers';
  import useHelper from '@/Helpers';  
  import usePersonal from '@/Composables/personal.js';
  import ContentHeader from '@/Componentes/ContentHeader.vue';
  import RoleTurnoForm from './Form.vue'

  const { openModal, Toast, Swal, formatoFecha } = useHelper();

  const {
        personales,
        obtenerPersonales,obtenerPersonal, personal
    } = usePersonal();
  
    const titleHeader = ref({
      titulo: "Generacion de Horarios",
      subTitulo: "Inicio",
      icon: "",
      vista: ""
    });

    const dato = ref({
        page:'',
        buscar:'',
        paginacion: 10
    });

    const hoy= formatoFecha(null,"YYYY-MM-DD")
    const horaHoy = formatoFecha(null,"HH:mm")

    const form = ref({
        id:'',
        tipo_turno_id:'',
        fecha_desde: hoy,
        fecha_hasta:hoy,
        errors:[]
    });

    const limpiar = ()=> {
        form.value.id =''
        form.value.tipo_turno_id='',
        form.value.fecha_desde=hoy,
        form.value.fecha_hasta=hoy,   
        form.value.errors = []
    }
    const buscar = () => {
        listarPersonales()
    }
    const generar = (id) => {
        document.getElementById("modalformlroleturnoLabel").innerHTML = 'Solicitud Permiso';
        openModal('#modalformlroleturno')
    }
    // const editar = (id) => {
    //     obtenerDatosPermiso(id)
    //     form.value.estadoCrud = 'editar'
    //     document.getElementById("modalformlroleturnoLabel").innerHTML = 'Editar Permiso';
    //     openModal('#modalformlroleturno')        
    // }
    // const eliminar = (id) => {
    //     Swal.fire({
    //         title: '¿Estás seguro de Eliminar?',
    //         text: "Permiso",
    //         icon: 'question',
    //         showCancelButton: true,
    //         confirmButtonColor: '#3085d6',
    //         cancelButtonColor: '#d33',
    //         confirmButtonText: 'Si, Eliminalo!'
    //     }).then((result) => {
    //         if (result.isConfirmed) {
    //             elimina(id)
    //         }
    //     })
    // }
    // const elimina = async(id) => {
    //     await eliminarPermiso(id)
    //     form.value.errors = []
    //     if(errors.value){
    //         form.value.errors = errors.value
    //     }
    //     if(respuesta.value.ok==1){
    //         form.value.errors = []
    //         Toast.fire({icon:'success', title:respuesta.value.mensaje})
    //         listarPermisos()
    //     }
    // }

    // const obtenerDatos = async(id) => {
    //     limpiar()
    //     await obtenerPersonal(id);
    //     if(personal.value)
    //     {
    //         form.value.personal_id=personal.value.id,
    //         form.value.nombre=personal.value.nombres + ' ' + personal.value.apellido_paterno + ' ' + personal.value.apellido_materno
    //     }
    // }
    // const obtenerDatosPermiso = async(id) => {
    //     limpiar()
    //     await obtenerPermiso(id);
    //     if(permiso.value)
    //     {
    //         form.value.id=permiso.value.id,
    //         form.value.personal_id=permiso.value.personal_id,
    //         form.value.nombre=permiso.value.personal.nombres + ' ' + permiso.value.personal.apellido_paterno + ' ' + permiso.value.personal.apellido_materno
    //         form.value.fecha_desde=permiso.value.fecha_desde,
    //         form.value.hora_inicio=permiso.value.hora_inicio,
    //         form.value.fecha_hasta=permiso.value.fecha_hasta,
    //         form.value.hora_hasta=permiso.value.hora_hasta,
    //         form.value.tipo_permiso_id=permiso.value.tipo_permiso_id,
    //         form.value.motivo=permiso.value.motivo,
    //         form.value.establecimiento_id=permiso.value.establecimiento_id,        
    //         form.value.value.errors = []
    //     }
    // }
    const listarPersonales = async(page=1) => {
        dato.value.page= page
        await obtenerPersonales(dato.value)
    }
    // const listarPermisos = async(page=1) => {
    //     dato.value.page= page
    //     await listarHoy(dato.value)
    // }
    // CARGA
    onMounted(() => {
        defineTitle(titleHeader.value.titulo)
        // listarPermisos()
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
                        <div class="table-responsive" v-if="personales.total> 0">         
                            <table class="table table-bordered table-hover table-sm table-striped">
                                <thead class="table-dark">
                                    <tr>
                                        <th class="text-center">#</th>
                                        <th>Nombre</th>
                                        <th>Cargo</th>
                                        <th>Establecimiento</th>
                                        <th>Accion</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="(personal,index) in personales.data" :key="personal.id">
                                        <td class="text-center">{{ index + personales.from }}</td>
                                        <td>{{ personal.nombres }}</td>
                                        <td>{{ personal.cargo.nombre }}</td>
                                        <td>{{ personal.establecimiento.nombre }}</td>
                                        <td>
                                            <button class="btn btn-info btn-sm" title="Generar Horario" @click.prevent="generar(personal.id)">
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
    <RoleTurnoForm :form="form" :currentPage="personales.current_page"></RoleTurnoForm>
</template>




