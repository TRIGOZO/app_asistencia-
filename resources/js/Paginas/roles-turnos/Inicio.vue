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
        obtenerPersonalesReporte,obtenerPersonal, personal
    } = usePersonal();
    const {
        listaEstablecimientos, establecimientos
    } = useEstablecimiento();
    const {
        guardarHorarioMasivo, errors, respuesta
    } = useHorario();  
    const { usuario2, obtenerUsuario2 } = useUsuario();
    
    const titleHeader = ref({
      titulo: "Generacion de Horarios (Administrativo)",
      subTitulo: "Inicio",
      icon: "",
      vista: ""
    });
    const dato = ref({
        page:'',
        buscar:'',
        paginacion: 10,
        horario:'',
        mes : parseInt(formatoFecha(null,"MM")),
        anio : parseInt(formatoFecha(null,"YYYY")),
        establecimiento_id: usuario2.value.establecimiento_id,
        errors:[],
    });
    const formEnvio = ref({
        establecimiento_id: usuario2.value.establecimiento_id,
    });
    const limpiarDato = ()=> {
        dato.value.establecimiento_id =usuario2.value.establecimiento_id
    }
    const anios = ref([]);
    const listarAnios=()=>{
        const anioActual=parseInt(formatoFecha(null,"YYYY"))
        for (let index = anioActual; index >= anioActual - 4; index--) {
            anios.value.push(index);
        }
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
        formEnvio.value.establecimiento_id = dato.value.establecimiento_id,
        await obtenerPersonalesReporte(dato.value, formEnvio.value)
    }
    const estado=ref(1);

    const cargarMasivo = async()=>{
        estado.value=2;
        
        await guardarHorarioMasivo(dato.value)
        dato.value.errors = []
        if(errors.value)
        {
            dato.value.errors = errors.value
        }else{
            if(respuesta.value.ok==1){
                estado.value=1;
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
        listarAnios()
    })

</script>
<template>
    <ContentHeader :title-header="titleHeader"></ContentHeader>
    <div class="app-content">
      <div class="container-fluid">
        <div class="row">
            <div class="col-md-7">
                <div class="card card-primary card-outline">
                    <div class="card-header">
                        <h6 class="card-title">
                            Busqueda de Personal
                        </h6>
                    </div>
                    <div class="card-body">
                        <div class="row mb-4">
                            <div class="col-md-8">
                                <label for="establecimiento_id" class="mb-2">Apellidos y Nombres</label>
                                <input class="form-control" placeholder="Ingrese nombre, código ciiu" type="text" v-model="dato.buscar"
                                    @change="buscar" />
                            </div>
                            <div class="col-md-4" v-if="usuario.role_id!=2">
                                <label for="establecimiento_id" class="mb-2">Establecimiento</label>
                                <select class="form-control" v-model="dato.establecimiento_id">
                                    <option v-for="establecimiento in establecimientos" :key="establecimiento.id" :value="establecimiento.id"
                                        :title="establecimiento.nombre">
                                        {{ establecimiento.nombre }}
                                    </option>
                                </select>
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
            </div>
            <div class="col-md-5">
                <div class="card card-info card-outline">
                    <div class="card-header">
                        <h6 class="card-title">
                            CARGA MASIVA DE HORARIOS POR MES
                        </h6>
                    </div>
                    <div class="card-body">
                        <div class="row mb-4">
                            <div class="col-md-4">
                                <label for="mes" class="mb-2">Mes</label>
                                <select v-model="dato.mes" class="form-control" :class="{ 'is-invalid': dato.errors.mes }">
                                    <option v-for="mes in meses" :key="mes.numero" :value="mes.numero">
                                        {{ mes.nombre }}
                                    </option>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label for="anio" class="form-label">Año</label>
                                <select v-model="dato.anio" class="form-control"
                                    :class="{ 'is-invalid': dato.errors.anio }">
                                    <option v-for="anho in anios" :key="anho" :value="anho"
                                        :title="anho">
                                        {{ anho }}
                                    </option>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <template v-if="estado==1">
                                    <br>
                                    <button class="btn btn-warning" @click="cargarMasivo()">Generar</button>
                                </template>
                                <template v-else>
                                    <div class="sk-chase">
                                        <div class="sk-chase-dot"></div>
                                        <div class="sk-chase-dot"></div>
                                        <div class="sk-chase-dot"></div>
                                        <div class="sk-chase-dot"></div>
                                        <div class="sk-chase-dot"></div>
                                        <div class="sk-chase-dot"></div>
                                    </div>
                                </template>
                            </div>
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




