<script setup>
    import jwt_decode from 'jwt-decode'
    import { ref, onMounted } from 'vue';
    import { defineTitle } from '@/Helpers';
    import useHelper from '@/Helpers';  
    import usePersonal from '@/Composables/personal.js';
    import useHorario from '@/Composables/horario.js';
    import useEstablecimiento from '@/Composables/establecimientos.js';  
    import ContentHeader from '@/Componentes/ContentHeader.vue';
    import RoleTurnoForm from './Form.vue'
    import Horario from './Horario.vue'
    import useDatosSession from '@/Composables/session';
    import useUsuario from '@/Composables/usuario.js'
    const { usuario } = useDatosSession();
    const { openModal, Toast, Swal, formatoFecha, meses } = useHelper();
    const {
        personales,
        obtenerPersonales,obtenerPersonal, personal
    } = usePersonal();
    const {
        listaEstablecimientos, establecimientos
    } = useEstablecimiento();
    const {
        guardarHorarioMasivo, errors, respuesta
    } = useHorario();  
    const { usuario2, obtenerUsuario2 } = useUsuario();
    

    ;    
    // const {
    //     horario, obtenerHorario
    // } = useHorario();

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
        mes : formatoFecha(null,"MM"),
        establecimiento_id: usuario2.value.establecimiento_id,
        errors:[],
    });
    const limpiarDato = ()=> {
        dato.value.establecimiento_id =usuario2.value.establecimiento_id

    }    
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
    const horario = ref({});
    const verhorario = async(registros) => {
        horario.value = registros
        // await obtenerHorario(id);
        dato.value.horario='true'

    }
    const listarPersonales = async(page=1) => {
        dato.value.page= page
        await obtenerPersonales(dato.value)
    }
    const cargarMasivo = async()=>{
        await guardarHorarioMasivo(dato.value)
        dato.value.errors = []
        if(errors.value)
        {
            dato.value.errors = errors.value
        }else{
            if(respuesta.value.ok==1){
                dato.value.errors = []
                Toast.fire({icon:'success', title:respuesta.value.mensaje})
            }else{
                Swal.fire({icon:'error', text:respuesta.value.mensaje})
            }        
        }

    }
    const getUsuario=async()=>{
        const user_id =  localStorage.getItem('userSession') ? JSON.parse( JSON.stringify(jwt_decode(localStorage.getItem('userSession')).user)) : null;
        await obtenerUsuario2(user_id)
        limpiarDato()
    }
    onMounted(() => {
        defineTitle(titleHeader.value.titulo)
        listaEstablecimientos()
        getUsuario()
        
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
                    <div class="col-md-4">
                        <div class="input-group mb-2">
                            <span class="input-group-text" id="basic-addon1">Apellidos y Nombres</span>
                            <input class="form-control" placeholder="Ingrese nombre, código ciiu" type="text" v-model="dato.buscar"
                                @change="buscar" />
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="input-group mb-1">
                            <span class="input-group-text" id="basic-addon1">Mes</span>
                            <select v-model="dato.mes" class="form-control" :class="{ 'is-invalid': dato.errors.mes }">
                                <option value="">--Seleccione--</option>
                                <option v-for="mes in meses" :key="mes.numero" :value="mes.numero">
                                    {{ mes.nombre }}
                                </option>
                            </select>
                        </div>
                        <small class="text-danger" v-for="error in dato.errors.mes" :key="error">{{ error
                                }}<br></small>
                    </div>
                    <div class="col-md-3" v-if="usuario.role_id!=2">
                        <div class="input-group">
                            <div class="input-group mb-1">
                                <span class="input-group-text" id="basic-addon1">Establecimiento</span>

                                <select v-model="dato.establecimiento_id" class="form-control" :class="{ 'is-invalid': dato.errors.establecimiento_id }">
                                    <option v-for="establecimiento in establecimientos" :key="establecimiento.id" :value="establecimiento.id">
                                        {{ establecimiento.nombre }}
                                    </option>
                                </select>
                            </div>
                            <small class="text-danger" v-for="error in dato.errors.establecimiento_id" :key="error">{{ error
                                }}</small>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <button class="btn btn-warning" @click="cargarMasivo()">Cargar Horarios Administrativo Masivo</button>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12 mb-1">
                        <div class="table-responsive" v-if="personales.total> 0">         
                            <table class="table table-bordered table-hover table-sm table-striped">
                                <thead class="table-dark">
                                    <tr>
                                        <th class="text-center">#</th>
                                        <th>DNI</th>
                                        <th>Nombre</th>
                                        <th>Cargo</th>
                                        <th>Establecimiento</th>
                                        <th>Accion</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="(personal,index) in personales.data" :key="personal.id">
                                        <td class="text-center">{{ index + personales.from }}</td>
                                        <td>{{ personal.numero_dni }}</td>
                                        <td>{{ personal.nombres + ' ' + personal.apellido_paterno + ' ' + personal.apellido_materno }}</td>
                                        <td>{{ personal.cargo?.nombre }}</td>
                                        <td>{{ personal.establecimiento?.nombre }}</td>
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
        <Horario v-if="dato.horario" :horario="horario" :form="form"></Horario>
      </div>
    </div>
    <RoleTurnoForm :form="form" @onVerHorario="verhorario"></RoleTurnoForm>
</template>




