<script setup>
  import jwt_decode from 'jwt-decode'
  import { ref, onMounted, inject } from 'vue';
  import { defineTitle } from '@/Helpers';
  import useHelper from '@/Helpers';  
  import useEstablecimiento from '@/Composables/establecimientos.js';  
  import useCondicionLaboral from '@/Composables/condicionlaboral.js';
  import usePersonal from '@/Composables/personal.js';
  import useCargo from '@/Composables/cargos.js';
  import useTipoTrabajador from '@/Composables/tipotrabajador.js';
  import useProfesion from '@/Composables/profesiones.js';
  import ContentHeader from '@/Componentes/ContentHeader.vue';
  import JsonExcel from 'vue-json-excel3';
  const { openModal, Toast, Swal, formatoFecha, meses } = useHelper();
  const {
        errors, personales, personal, 
        obtenerPersonal, obtenerPersonalesReporte, 
        eliminarPersonal, respuesta, obtenerPersonalesReporteExcel,
        personalesReporte
    } = usePersonal();
    const {
        profesiones, listaProfesiones
    } = useProfesion();
    const {
        tipotrabajadores, listaTipoTrabajadores
    } = useTipoTrabajador();  
    const {
    listaCondicionesLaborales, condicioneslaborales
    } = useCondicionLaboral();
    const {
        listaEstablecimientos, establecimientos
    } = useEstablecimiento();
    const {
        listaCargos, cargos
    } = useCargo();    
    const titleHeader = ref({
      titulo: "Reporte - Personal",
      subTitulo: "Reportes",
      icon: "",
      vista: ""
    });
    const cargarPareReporte=()=>{
        obtenerPersonalesReporteExcel(form.value)
    }
    const jsonFields = ref({
        "DNI" : "numero_dni",
        "Apellido Paterno": "apellido_paterno",
        "Nombres": "nombres",


    })

    onMounted(()=>{
        listaCondicionesLaborales()
        listaEstablecimientos()
        listarPersonal()
        listaTipoTrabajadores()
        listaProfesiones()
        listaCargos()
    });
    const listarPersonal = async(page=1) => {
        dato.value.page= page
        await obtenerPersonalesReporte(dato.value, form.value)
    }
    const anhoactual=formatoFecha(null,"YYYY");
    const dato = ref({
        page:'',
        buscar:'',
        paginacion: 10,
    });
    const form = ref({
        establecimiento_id:'',
        tipo_trabajador_id:'',
        profesion_id:'',
        condicion_id:'',
        cargo_id:'',
        errors:[]        
    })
    //paginacion
    const isActived = () => {
        return personales.value.current_page
    }
    const offset = 2;

    const cambiarPaginacion = () => {
        listarPersonal()
    }
    const cambiarPagina =(pagina) => {
        listarPersonal(pagina)
    }
    const pagesNumber = () => {
        if(!personales.value.to){
            return []
        }
        let from = personales.value.current_page - offset
        if(from < 1) from = 1
        let to = from + (offset*2)
        if( to >= personales.value.last_page) to = personales.value.last_page
        let pagesArray = []
        while(from <= to) {
            pagesArray.push(from)
            from ++
        }
        return pagesArray
    }
    const cargar=()=>{
        listarPersonal()
    }
</script>
<template>
<ContentHeader :title-header="titleHeader"></ContentHeader>
    <div class="app-content">
      <div class="container-fluid">
        <div class="card card-primary card-outline mt-2">
            <div class="card-header">
                <h6 class="card-title">
                    Listado de Trabajadores
                </h6>
            </div>
            <div class="card-body">
                <div class="row mb-4">
                    <div class="col-md-2">
                        <label for="name" class="form-label">Establecimiento</label>
                        <select v-model="form.establecimiento_id" class="form-control"
                            :class="{ 'is-invalid': form.errors.establecimiento_id }">
                            <option value="">Todos</option>
                            <option v-for="establecimiento in establecimientos" :key="establecimiento.id" :value="establecimiento.id"
                                :title="establecimiento.nombre">
                                {{ establecimiento.nombre }}
                            </option>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <label for="name" class="form-label">Tipo de Trabajador</label>
                        <select v-model="form.tipo_trabajador_id" class="form-control"
                            :class="{ 'is-invalid': form.errors.tipo_trabajador_id }">
                            <option value="">Todos</option>
                            <option v-for="tipotrabajador in tipotrabajadores" :key="tipotrabajador.id" :value="tipotrabajador.id"
                                :title="tipotrabajador.nombre">
                            {{ tipotrabajador.nombre }}
                            </option>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <label for="name" class="form-label">Profesion</label>
                        <select v-model="form.profesion_id" class="form-control"
                            :class="{ 'is-invalid': form.errors.profesion_id }">
                            <option value="">Todos</option>
                                <option v-for="profesion in profesiones" :key="profesion.id" :value="profesion.id"
                                    :title="profesion.nombre">
                                {{ profesion.nombre }}
                            </option>
                        </select>
                    </div> 
                    <div class="col-md-2">
                        <label for="name" class="form-label">Condicion</label>
                        <select v-model="form.condicion_id" class="form-control"
                            :class="{ 'is-invalid': form.errors.condicion_id }">
                            <option value="">Todos</option>
                                <option v-for="condicion in condicioneslaborales" :key="condicion.id" :value="condicion.id"
                                    :title="condicion.nombre">
                                {{ condicion.nombre }}
                            </option>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <label for="name" class="form-label">Cargo</label>
                        <select v-model="form.cargo_id" class="form-control"
                            :class="{ 'is-invalid': form.errors.cargo_id }">
                            <option value="">Todos</option>
                                <option v-for="cargo in cargos" :key="cargo.id" :value="cargo.id"
                                    :title="cargo.nombre">
                                {{ cargo.nombre }}
                            </option>
                        </select>
                    </div>
                    <div class="col-md-2 mb-1">
                        <br>
                        <button class="btn btn-primary" @click="cargar()">Cargar</button>&nbsp;&nbsp;
                        <JsonExcel class="btn btn-success" :fields="jsonFields" :data="personales.data">
                            <i class="fa-solid fa-file-excel"></i> Descargar
                        </JsonExcel>

                    </div>                                    
                </div>
                <div class="row">
                    <div class="col-md-2 mb-1">
                        <nav>
                            <ul class="pagination">
                                <li v-if="personales.current_page >= 2" class="page-item">
                                    <a href="#" aria-label="Previous" class="page-link"
                                        title="Primera Página"
                                        @click.prevent="cambiarPagina(1)">
                                        <span><i class="fas fa-backward-fast"></i></span>
                                    </a>
                                </li>
                                <li v-if="personales.current_page > 1" class="page-item">
                                    <a href="#" aria-label="Previous" class="page-link"
                                        title="Página Anterior"
                                        @click.prevent="cambiarPagina(personales.current_page - 1)">
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
                                <li v-if="personales.current_page < personales.last_page" class="page-item">
                                    <a href="#" aria-label="Next" class="page-link"
                                        title="Página Siguiente"
                                        @click.prevent="cambiarPagina(personales.current_page + 1)">
                                        <span aria-hidden="true"><i class="fas fa-angle-right"></i></span>
                                    </a>
                                </li>
                                    <li v-if="personales.current_page <= personales.last_page-1" class="page-item">
                                    <a href="#" aria-label="Next" class="page-link"
                                        @click.prevent="cambiarPagina(personales.last_page)"
                                        title="Última Página">
                                        <span aria-hidden="true"><i class="fas fa-forward-fast"></i></span>
                                    </a>
                                </li>
                            </ul>
                        </nav>
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

                </div>
                <div class="row">
                    <div class="col-md-12 mb-1">
                        <div class="table-responsive">         
                            <table class="table table-bordered table-hover table-sm table-striped">
                                <thead class="table-dark">
                                    <tr>
                                        <th class="text-center">#</th>
                                        <th>DNI</th>
                                        <th>Ape. Paterno</th>
                                        <th>Ape. Materno</th>
                                        <th>Nombres</th>
                                        <th>Nivel</th>
                                        <th>Profesion</th>
                                        <th>Cargo</th>
                                        <th>Condicion</th>
                                        <th>Tiene Hijos</th>
                                        <th>Observacion</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-if="personales.total == 0">
                                        <td class="text-danger text-center" colspan="11">
                                            -- Datos No Registrados - Tabla Vacía --
                                        </td>
                                    </tr>
                                    <tr v-else v-for="(personal,index) in personales.data" :key="personal.id">
                                        <td class="text-center">{{ index + personales.from }}</td>
                                        <td>{{ personal.numero_dni }}</td>
                                        <td>{{ personal.apellido_paterno }}</td>
                                        <td>{{ personal.apellido_materno }}</td>
                                        <td>{{ personal.nombres }}</td>
                                        <td>{{ personal.nivel_id }}</td>
                                        <td>{{ personal.profesion?.nombre }}</td>
                                        <td>{{ personal.cargo?.nombre }}</td>
                                        <td>{{ personal.condicion?.nombre }}</td>
                                        <td>{{ personal.tienehijos }}</td>
                                        <td>{{ personal.observacion }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-5 mb-1">
                        Mostrando <b>{{personales.from}}</b> a <b>{{ personales.to }}</b> de <b>{{ personales.total}}</b> Registros
                    </div>
                    <div class="col-md-7 mb-1 text-right">
                        <nav>
                            <ul class="pagination">
                                <li v-if="personales.current_page >= 2" class="page-item">
                                    <a href="#" aria-label="Previous" class="page-link"
                                        title="Primera Página"
                                        @click.prevent="cambiarPagina(1)">

                                        <span><i class="fas fa-backward-fast"></i></span>
                                    </a>
                                </li>
                                <li v-if="personales.current_page > 1" class="page-item">
                                    <a href="#" aria-label="Previous" class="page-link"
                                        title="Página Anterior"
                                        @click.prevent="cambiarPagina(personales.current_page - 1)">

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
                                <li v-if="personales.current_page < personales.last_page" class="page-item">
                                    <a href="#" aria-label="Next" class="page-link"
                                        title="Página Siguiente"
                                        @click.prevent="cambiarPagina(personales.current_page + 1)">
                                        <span aria-hidden="true"><i class="fas fa-angle-right"></i></span>
                                    </a>
                                </li>
                                    <li v-if="personales.current_page <= personales.last_page-1" class="page-item">
                                    <a href="#" aria-label="Next" class="page-link"
                                        @click.prevent="cambiarPagina(personales.last_page)"
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
</template>