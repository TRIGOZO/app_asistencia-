<script setup>
    import jwt_decode from 'jwt-decode'
    import { ref, onMounted } from 'vue';
    import { defineTitle } from '@/Helpers';
    import useHelper from '@/Helpers';  
    import usePersonal from '@/Composables/personal.js';
    import ContentHeader from '@/Componentes/ContentHeader.vue';
    import RoleTurnoForm from './Form.vue'
    import Horario from './Horario.vue'
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
        paginacion: 10,
        horario:'',
        
    });
    const hoy= formatoFecha(null,"YYYY-MM-DD")
    const horaHoy = formatoFecha(null,"HH:mm")
    const form = ref({
        personal_id:'',
        nombres:'',
        apellidos:'',
        tipo_turno_id:'',
        fecha_desde: hoy,
        fecha_hasta:hoy,
        es_lactancia:false,
        errors:[]
    });
    const limpiar = ()=> {
        form.value.personal_id =''
        form.value.tipo_turno_id='',
        form.value.fecha_desde=hoy,
        form.value.fecha_hasta=hoy,
        form.value.es_lactancia=false,
        form.value.errors = []
    }
    const buscar = () => {
        listarPersonales()
    }
    const formgenerar = async(id) => {
        limpiar()
        await obtenerPersonal(id);
        if(personal.value)
        {
            form.value.personal_id=personal.value.id,
            form.value.nombres=personal.value.nombres
            form.value.apellidos=personal.value.apellido_paterno + ' ' + personal.value.apellido_materno
        }
        document.getElementById("modalformlroleturnoLabel").innerHTML = 'Generar Horario';
        openModal('#modalformlroleturno')
    }
    const verhorario=(id) => {
        dato.value.horario=id
    }
    const listarPersonales = async(page=1) => {
        dato.value.page= page
        await obtenerPersonales(dato.value)
    }

    onMounted(() => {
        defineTitle(titleHeader.value.titulo)
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
                                        <td>{{ personal.cargo?.nombre }}</td>
                                        <td>{{ personal.establecimiento.nombre }}</td>
                                        <td>
                                            <button class="btn btn-info btn-sm" title="Generar Horario" @click.prevent="formgenerar(personal.id)">
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
        <Horario v-if="dato.horario"></Horario>
      </div>
    </div>
    <RoleTurnoForm :form="form" @onVerHorario="verhorario"></RoleTurnoForm>
</template>




