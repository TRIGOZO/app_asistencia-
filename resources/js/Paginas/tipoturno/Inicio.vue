<script setup>
  import jwt_decode from 'jwt-decode'
  import { ref, onMounted } from 'vue';
  import { defineTitle } from '@/Helpers';
  import useHelper from '@/Helpers';  
  import useTipoTurno from '@/Composables/tipoturno.js';
  import useHorarioTurno from '@/Composables/horarioturno.js';  
  import ContentHeader from '@/Componentes/ContentHeader.vue';
  import TipoTurnoForm from './Form.vue'
  import HorarioForm from './Horario.vue'
  const { openModal, Toast, Swal } = useHelper();
  const {
        tipoturnos, errors, tipoturno, respuesta,
        obtenerTipoTurnos, obtenerTipoTurno, eliminarTipoTurno
    } = useTipoTurno();

  const {
        obtenerHorario, horario
    } = useHorarioTurno();
    
    const titleHeader = ref({
      titulo: "Tipo Turno",
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
        diastolerancia:'',
        descuento:'',
        guardia:'',
        permiso:'',
        horasantesdescansa:'',
        horasdespuesdescansa:'',
        horaasistencial:'',
        horaadministrativo:'',
        nroturnos:'',
        estadoCrud:'',
        errors:[]
    });
    const formhorario = ref({
        id:'',
        tipo_turno_nombre:'',
        tipo_turno_id:'',
        horaentrada:'',
        horasalida:'',
        toleranciaantes:'',
        toleranciadespues:'',
        inicioentrada:'',
        finentrada:'',
        iniciosalida:'',
        finsalida:'',
        dialunes:'',
        diamartes:'',
        diamiercoles:'',
        diajueves:'',
        diaviernes:'',
        diasabado:'',
        diadomingo:'0',
        totalhoras:'',
        totalhorassemanal:'',
        estadoCrud:'',
        errors:[]
    });    
    const limpiar = ()=> {
        form.value.id =""
        form.value.nombre=''
        form.value.diastolerancia=''
        form.value.descuento=''
        form.value.guardia=''
        form.value.permiso=''
        form.value.horasantesdescansa=''
        form.value.horasdespuesdescansa=''
        form.value.horaasistencial=''
        form.value.horaadministrativo=''
        form.value.nroturnos=''
        form.value.errors = []
        errors.value = []
    }
    const limpiarFormHorario = ()=> {
        formhorario.value.id ='';
        formhorario.value.tipo_turno_nombre='';
        formhorario.value.tipo_turno_id='';
        formhorario.value.horaentrada='';
        formhorario.value.horasalida='';
        formhorario.value.toleranciaantes='';
        formhorario.value.toleranciadespues='';
        formhorario.value.inicioentrada='';
        formhorario.value.finentrada='';
        formhorario.value.iniciosalida='';
        formhorario.value.finsalida='';
        formhorario.value.dialunes=1;
        formhorario.value.diamartes=1;
        formhorario.value.diamiercoles=1;
        formhorario.value.diajueves=1;
        formhorario.value.diaviernes=1;
        formhorario.value.diasabado=1;
        formhorario.value.diadomingo=0;
        formhorario.value.totalhoras='';
        formhorario.value.totalhorassemanal='';
        formhorario.value.errors = []
        errors.value = []
    }
    
    const obtenerDatos = async(id) => {
        await obtenerTipoTurno(id);
        if(tipoturno.value)
        {
            formhorario.value.tipo_turno_nombre=tipoturno.value.nombre;
            formhorario.value.tipo_turno_id=tipoturno.value.id;
            form.value.id=tipoturno.value.id
            form.value.nombre=tipoturno.value.nombre
            form.value.diastolerancia=tipoturno.value.diastolerancia
            form.value.descuento=tipoturno.value.descuento
            form.value.guardia=tipoturno.value.guardia
            form.value.permiso=tipoturno.value.permiso
            form.value.horasantesdescansa=tipoturno.value.horasantesdescansa
            form.value.horasdespuesdescansa=tipoturno.value.horasdespuesdescansa
            form.value.horaasistencial=tipoturno.value.horaasistencial
            form.value.horaadministrativo=tipoturno.value.horaadministrativo
            form.value.nroturnos=tipoturno.value.nroturnos
        }
    }
    const obtenerDatosHorario = async(id) => {
        await obtenerHorario(id);
        if(tipoturno.value)
        {
            formhorario.value.id =horario.value.id;
            formhorario.value.tipo_turno_nombre=horario.value.tipo_turno.nombre;
            formhorario.value.tipo_turno_id=horario.value.tipo_turno_id;
            formhorario.value.horaentrada=horario.value.horaentrada;
            formhorario.value.horasalida=horario.value.horasalida;
            formhorario.value.toleranciaantes=horario.value.toleranciaantes;
            formhorario.value.toleranciadespues=horario.value.toleranciadespues;
            formhorario.value.inicioentrada=horario.value.inicioentrada;
            formhorario.value.finentrada=horario.value.finentrada;
            formhorario.value.iniciosalida=horario.value.iniciosalida;
            formhorario.value.finsalida=horario.value.finsalida;
            formhorario.value.dialunes=horario.value.dialunes;
            formhorario.value.diamartes=horario.value.diamartes;
            formhorario.value.diamiercoles=horario.value.diamiercoles;
            formhorario.value.diajueves=horario.value.diajueves;
            formhorario.value.diaviernes=horario.value.diaviernes;
            formhorario.value.diasabado=horario.value.diasabado;
            formhorario.value.diadomingo=horario.value.diadomingo;
            formhorario.value.totalhoras=horario.value.totalhoras;
        }
    }
    const editar = (id) => {
        limpiar();
        obtenerDatos(id)
        form.value.estadoCrud = 'editar'
        document.getElementById("modaltipoturnoLabel").innerHTML = 'Editar Tipo Turno';
        openModal('#modaltipoturno')
    }
    const EditarHorario = (id) => {
        limpiarFormHorario();
        obtenerDatosHorario(id)
        formhorario.value.estadoCrud = 'editar'
        document.getElementById("modalhorarioLabel").innerHTML = 'Editar Horario';
        openModal('#modalhorario')
    }
    const nuevoHorario = (id) => {
        limpiarFormHorario()
        obtenerDatos(id)
        formhorario.value.estadoCrud = 'nuevo'
        openModal('#modalhorario')
        document.getElementById("modalhorarioLabel").innerHTML = 'Nuevo Horario';
    }
    const nuevo = () => {
        limpiar()
        form.value.estadoCrud = 'nuevo'
        openModal('#modaltipoturno')
        document.getElementById("modaltipoturnoLabel").innerHTML = 'Nuevo Tipo Turno';
        //titulo.textContent = 'Editar Datos Personales';
    }
    const listarTipoTurnos = async(page=1) => {
        dato.value.page= page
        await obtenerTipoTurnos(dato.value)
    }
    const eliminar = (id) => {
        Swal.fire({
            title: '¿Estás seguro de Eliminar?',
            text: "Tipo Turno",
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
        await eliminarTipoTurno(id)
        form.value.errors = []
        if(errors.value)
        {
            form.value.errors = errors.value
        }
        if(respuesta.value.ok==1){
            form.value.errors = []
            Toast.fire({icon:'success', title:respuesta.value.mensaje})
            listarTipoTurnos(tipoturnos.value.current_page)
        }
    }
    // PAGINACION
    const isActived = () => {
        return tipoturnos.value.current_page
    }
    const offset = 2;

    const buscar = () => {
        listarTipoTurnos()
    }
    const cambiarPaginacion = () => {
        listarTipoTurnos()
    }
    const cambiarPagina =(pagina) => {
        listarTipoTurnos(pagina)
    }
    const pagesNumber = () => {
        if(!tipoturnos.value.to){
            return []
        }
        let from = tipoturnos.value.current_page - offset
        if(from < 1) from = 1
        let to = from + (offset*2)
        if( to >= tipoturnos.value.last_page) to = tipoturnos.value.last_page
        let pagesArray = []
        while(from <= to) {
            pagesArray.push(from)
            from ++
        }
        return pagesArray
    }
    // CARGA
    onMounted(() => {
        defineTitle(titleHeader.value.titulo)
        listarTipoTurnos()
    })
</script>
<template>
    <ContentHeader :title-header="titleHeader"></ContentHeader>
    <div class="app-content">
      <div class="container-fluid">
        <div class="card card-primary card-outline">
            <div class="card-header">
                <h6 class="card-title">
                    Listado de Tipo Turnos
                </h6>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-1 mb-1">
                        <button  type="button" class="btn btn-danger" @click.prevent="nuevo">
                            <i class="fas fa-plus"></i> Nuevo
                        </button>                        
                    </div>
                    <div class="col-md-2 mb-1">
                        <div class="input-group mb-1">
                            <span class="input-group-text" id="basic-addon1">Mostrar</span>
                            <select class="form-select"  v-model="dato.paginacion" @change="cambiarPaginacion">
                                <option value="5">5</option>
                                <option value="10">10</option>
                                <option value="20">20</option>
                                <option value="25">25</option>
                                <option value="50">50</option>
                                <option value="100">100</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-5">
                        <div class="input-group mb-1">
                            <span class="input-group-text" id="basic-addon1">Buscar</span>
                            <input class="form-control" placeholder="Ingrese nombre, código ciiu" type="text" v-model="dato.buscar"
                                @change="buscar" />
                        </div>
                    </div>
                    <div class="col-md-4 mb-1">
                        <nav>
                            <ul class="pagination">
                                <li v-if="tipoturnos.current_page >= 2" class="page-item">
                                    <a href="#" aria-label="Previous" class="page-link"
                                        title="Primera Página"
                                        @click.prevent="cambiarPagina(1)">
                                        <span><i class="fas fa-backward-fast"></i></span>
                                    </a>
                                </li>
                                <li v-if="tipoturnos.current_page > 1" class="page-item">
                                    <a href="#" aria-label="Previous" class="page-link"
                                        title="Página Anterior"
                                        @click.prevent="cambiarPagina(tipoturnos.current_page - 1)">
                                        <span><i class="fas fa-angle-left"></i></span>
                                    </a>
                                </li>
                                <li v-for="page in pagesNumber()" class="page-item"
                                    :key="page"
                                    :class="[ page == isActived() ? 'active' : '']"
                                    :title="'Página '+ page">
                                    <a href="#" class="page-link"
                                        @click.prevent="cambiarPagina(page)">{{ page }}</a>
                                </li>
                                <li v-if="tipoturnos.current_page < tipoturnos.last_page" class="page-item">
                                    <a href="#" aria-label="Next" class="page-link"
                                        title="Página Siguiente"
                                        @click.prevent="cambiarPagina(tipoturnos.current_page + 1)">
                                        <span aria-hidden="true"><i class="fas fa-angle-right"></i></span>
                                    </a>
                                </li>
                                    <li v-if="tipoturnos.current_page <= tipoturnos.last_page-1" class="page-item">
                                    <a href="#" aria-label="Next" class="page-link"
                                        @click.prevent="cambiarPagina(tipoturnos.last_page)"
                                        title="Última Página">
                                        <span aria-hidden="true"><i class="fas fa-forward-fast"></i></span>
                                    </a>
                                </li>
                            </ul>
                        </nav>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12 mb-1">
                        <div class="table-responsive">         
                            <table class="table table-bordered table-hover table-sm table-striped">
                                <thead class="table-dark">
                                    <tr>
                                        <th class="text-center">#</th>
                                        <th>Abreviatura</th>
                                        <th>Nombre</th>
                                        <th>Dias Tolerancia</th>
                                        <th>Descuento</th>
                                        <th>Guardia</th>
                                        <th>Permiso</th>
                                        <th>Horas antes de Descansar</th>
                                        <th>Horas despues de Descansar</th>
                                        <th>Hora Asistencial</th>
                                        <th>Hora Administrativo</th>
                                        <th>Nro Turnos</th>
                                        <th>count</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-if="tipoturnos.total == 0">
                                        <td class="text-danger text-center" colspan="7">
                                            -- Datos No Registrados - Tabla Vacía --
                                        </td>
                                    </tr>
                                    <tr v-else v-for="(tipoturno,index) in tipoturnos.data" :key="tipoturno.id">
                                        <td class="text-center">{{ index + tipoturnos.from }}</td>
                                        <td>{{ tipoturno.abreviatura }}</td>
                                        <td>{{ tipoturno.nombre }}</td>
                                        <td>{{ tipoturno.diastolerancia }}</td>
                                        <td>{{ tipoturno.descuento }}</td>
                                        <td>{{ tipoturno.guardia==1 ? 'SI' : 'NO' }}</td>
                                        <td>{{ tipoturno.permiso==1 ? 'SI' : 'NO' }}</td>
                                        <td>{{ tipoturno.horasantesdescansa }}</td>
                                        <td>{{ tipoturno.horasdespuesdescansa }}</td>
                                        <td>{{ tipoturno.horaasistencial }}</td>
                                        <td>{{ tipoturno.horaadministrativo }}</td>
                                        <td>{{ tipoturno.nroturnos }}</td>
                                        <td>{{ tipoturno.horario_count }}</td>
                                        <td>
                                            <button class="btn btn-warning btn-sm" title="Editar Tipo Turno" @click.prevent="editar(tipoturno.id)">
                                                <i class="fas fa-edit"></i>
                                            </button>&nbsp;
                                            <button class="btn btn-danger btn-sm" title="Eliminar Tipo Turno" @click.prevent="eliminar(tipoturno.id)">
                                                <i class="fas fa-trash"></i>
                                            </button>&nbsp;
                                            <button class="btn btn-info btn-sm" :title="tipoturno.horario_count > 0 ? 'Editar Horario' : 'Nuevo Horario'" @click.prevent="tipoturno.horario_count > 0 ? EditarHorario(tipoturno.id) : nuevoHorario(tipoturno.id)">
                                                <i class="fas fa-clock"></i>
                                            </button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-5 mb-1">
                        Mostrando <b>{{tipoturnos.from}}</b> a <b>{{ tipoturnos.to }}</b> de <b>{{ tipoturnos.total}}</b> Registros
                    </div>
                    <div class="col-md-7 mb-1 text-right">
                        <nav>
                            <ul class="pagination">
                                <li v-if="tipoturnos.current_page >= 2" class="page-item">
                                    <a href="#" aria-label="Previous" class="page-link"
                                        title="Primera Página"
                                        @click.prevent="cambiarPagina(1)">

                                        <span><i class="fas fa-backward-fast"></i></span>
                                    </a>
                                </li>
                                <li v-if="tipoturnos.current_page > 1" class="page-item">
                                    <a href="#" aria-label="Previous" class="page-link"
                                        title="Página Anterior"
                                        @click.prevent="cambiarPagina(tipoturnos.current_page - 1)">

                                        <span><i class="fas fa-angle-left"></i></span>
                                    </a>
                                </li>
                                <li v-for="page in pagesNumber()" class="page-item"
                                    :key="page"
                                    :class="[ page == isActived() ? 'active' : '']"
                                    :title="'Página '+ page">
                                    <a href="#" class="page-link"
                                        @click.prevent="cambiarPagina(page)">{{ page }}</a>
                                </li>
                                <li v-if="tipoturnos.current_page < tipoturnos.last_page" class="page-item">
                                    <a href="#" aria-label="Next" class="page-link"
                                        title="Página Siguiente"
                                        @click.prevent="cambiarPagina(tipoturnos.current_page + 1)">
                                        <span aria-hidden="true"><i class="fas fa-angle-right"></i></span>
                                    </a>
                                </li>
                                    <li v-if="tipoturnos.current_page <= tipoturnos.last_page-1" class="page-item">
                                    <a href="#" aria-label="Next" class="page-link"
                                        @click.prevent="cambiarPagina(tipoturnos.last_page)"
                                        title="Última Página">
                                        <span aria-hidden="true"><i class="fas fa-forward-fast"></i></span>
                                    </a>
                                </li>
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
      </div>
    </div>
    <TipoTurnoForm :form="form" @onListar="listarTipoTurnos" :currentPage="tipoturnos.current_page"></TipoTurnoForm>
    <HorarioForm :form="formhorario" @onListar="listarTipoTurnos" :currentPage="tipoturnos.current_page"></HorarioForm >
</template>




