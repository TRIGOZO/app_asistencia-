<script setup>
  import jwt_decode from 'jwt-decode'
  import { ref, onMounted } from 'vue';
  import { defineTitle } from '@/Helpers';
  import useHelper from '@/Helpers';  
  import usePersonal from '@/Composables/personal.js';
  import usePermiso from '@/Composables/permiso.js';
  import ContentHeader from '@/Componentes/ContentHeader.vue';
  import PermisoForm from './Form.vue'

  const { openModal, Toast, Swal, formatoFecha } = useHelper();

  const {
        personales,
        obtenerPersonales,obtenerPersonal, personal
    } = usePersonal();
  const {
        permisos,
        listarHoy,
        obtenerPermiso,
        permiso,
        eliminarPermiso,
        errors,
        respuesta
    } = usePermiso();    
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
    //const hoy=new Date().toISOString().split('T')[0];
    const hoy= formatoFecha(null,"YYYY-MM-DD")
    const horaHoy = formatoFecha(null,"HH:mm")

    const form = ref({
        id:'',
        personal_id:'',
        nombre:'',
        fecha_desde: hoy,
        hora_inicio:horaHoy,
        fecha_hasta:hoy,
        hora_hasta:horaHoy,
        tipo_permiso_id:'',
        motivo:'',
        establecimiento_id:'',
        estadoCrud:'',
        errors:[]
    });

    const limpiar = ()=> {
        form.value.id =''
        form.value.personal_id='',
        form.value.nombre=''
        form.value.fecha_desde=hoy,
        form.value.hora_inicio=horaHoy,
        form.value.fecha_hasta=hoy,
        form.value.hora_hasta=horaHoy,
        form.value.tipo_permiso_id='',
        form.value.motivo='',
        form.value.establecimiento_id='',        
        form.value.errors = []
    }
    const buscar = () => {
        listarPersonales()
    }
    const solicitar = (id) => {
        obtenerDatos(id)
        form.value.estadoCrud = 'nuevo'
        document.getElementById("modalpermisoLabel").innerHTML = 'Solicitud Permiso';
        openModal('#modalpermiso')
    }
    const editar = (id) => {
        obtenerDatosPermiso(id)
        form.value.estadoCrud = 'editar'
        document.getElementById("modalpermisoLabel").innerHTML = 'Editar Permiso';
        openModal('#modalpermiso')        
    }
    const eliminar = (id) => {
        Swal.fire({
            title: '¿Estás seguro de Eliminar?',
            text: "Permiso",
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Si, Eliminalo!'
        }).then((result) => {
            if (result.isConfirmed) {
                elimina(id)
            }
        })
    }
    const elimina = async(id) => {
        await eliminarPermiso(id)
        form.value.errors = []
        if(errors.value){
            form.value.errors = errors.value
        }
        if(respuesta.value.ok==1){
            form.value.errors = []
            Toast.fire({icon:'success', title:respuesta.value.mensaje})
            listarPermisos()
        }
    }

    const obtenerDatos = async(id) => {
        limpiar()
        await obtenerPersonal(id);
        if(personal.value)
        {
            form.value.personal_id=personal.value.id,
            form.value.nombre=personal.value.nombres + ' ' + personal.value.apellido_paterno + ' ' + personal.value.apellido_materno
        }
    }
    const obtenerDatosPermiso = async(id) => {
        limpiar()
        await obtenerPermiso(id);
        if(permiso.value)
        {
            form.value.id=permiso.value.id,
            form.value.personal_id=permiso.value.personal_id,
            form.value.nombre=permiso.value.personal.nombres + ' ' + permiso.value.personal.apellido_paterno + ' ' + permiso.value.personal.apellido_materno
            form.value.fecha_desde=permiso.value.fecha_desde,
            form.value.hora_inicio=permiso.value.hora_inicio,
            form.value.fecha_hasta=permiso.value.fecha_hasta,
            form.value.hora_hasta=permiso.value.hora_hasta,
            form.value.tipo_permiso_id=permiso.value.tipo_permiso_id,
            form.value.motivo=permiso.value.motivo,
            form.value.establecimiento_id=permiso.value.establecimiento_id,        
            form.value.value.errors = []
        }
    }
    const listarPersonales = async(page=1) => {
        dato.value.page= page
        await obtenerPersonales(dato.value)
    }
    const listarPermisos = async(page=1) => {
        dato.value.page= page
        await listarHoy(dato.value)
    }
    // CARGA
    onMounted(() => {
        defineTitle(titleHeader.value.titulo)
        listarPermisos()
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
                                        <th>Accion</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="(personal,index) in personales.data" :key="personal.id">
                                        <td class="text-center">{{ index + personales.from }}</td>
                                        <td>{{ personal.nombres }}</td>
                                        <td>{{ personal.cargo.nombre }}</td>
                                        <td>
                                            <button class="btn btn-info btn-sm" title="Solicitar Permiso" @click.prevent="solicitar(personal.id)">
                                                <i class="fas fa-hand-paper"></i>
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
        <br><br>
        <div class="card card-primary card-outline">
            <div class="card-header">
                <h6 class="card-title">
                    Permisos El día de Hoy
                </h6>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12 mb-1">
                        <div class="table-responsive">         
                            <table class="table table-bordered table-hover table-sm table-striped">
                                <thead class="table-dark">
                                    <tr>
                                        <th class="text-center">#</th>
                                        <th>Personal</th>
                                        <th>Fecha Desde</th>
                                        <th>Hora Inicio</th>
                                        <th>Fecha Hasta</th>
                                        <th>Hora Hasta</th>
                                        <th>Tipo Permiso</th>
                                        <th>Motivo</th>
                                        <th>Accion</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-if="permisos.total == 0">
                                        <td class="text-danger text-center" colspan="7">
                                            -- Datos No Registrados - Tabla Vacía --
                                        </td>
                                    </tr>
                                    <tr v-else v-for="(permiso,index) in permisos" :key="permiso.id">
                                        <td class="text-center">{{ index+1 }}</td>
                                        <td>{{ permiso.personal.nombres + ' ' + permiso.personal.apellido_paterno + ' ' + permiso.personal.apellido_materno }}</td>
                                        <td>{{ permiso.fecha_desde }}</td>
                                        <td>{{ permiso.hora_inicio }}</td>
                                        <td>{{ permiso.fecha_hasta }}</td>
                                        <td>{{ permiso.hora_hasta }}</td>
                                        <td>{{ permiso.tipopermiso.nombre }}</td>
                                        <td>{{ permiso.motivo }}</td>
                                        <td>
                                            <button class="btn btn-warning btn-sm" title="Editar Permiso" @click.prevent="editar(permiso.id)">
                                                <i class="fas fa-edit"></i>
                                            </button>&nbsp;
                                            <button class="btn btn-danger btn-sm" title="Eliminar Permiso" @click.prevent="eliminar(permiso.id)">
                                                <i class="fas fa-trash"></i>
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
    <PermisoForm :form="form" @onListar="listarPermisos" :currentPage="personales.current_page"></PermisoForm>
</template>




