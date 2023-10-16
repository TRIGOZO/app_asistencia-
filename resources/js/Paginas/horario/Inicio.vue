<script setup>
  import useHorario from '@/Composables/horario.js';
  import PersonalForm from './Form.vue'
  import useHelper from '@/Helpers'; 
  import ContentHeader from '@/Componentes/ContentHeader.vue';
  import { ref, onMounted } from 'vue';
  import Horario from './Horario.vue'
  const { openModal, Toast, Swal } = useHelper();
  const {
        errors, mostrarHorariosPersonal, horarios, eliminarHorarioPersonal,
        obtenerHorario, horario, respuesta
    } = useHorario();
    const titleHeader = ref({
      titulo: "Horario",
      subTitulo: "Inicio",
      icon: "",
      vista: ""
    });
    const listarHorariosPersonal = async(page=1) => {
        dato.value.page= page
        await mostrarHorariosPersonal(dato.value)
    }
    const eliminar = (id) => {
        Swal.fire({
            title: '¿Estás seguro de Eliminar?',
            text: "Horario",
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
        await eliminarHorarioPersonal(id)
        if(errors.value)
        {
            form.value.errors = errors.value
        }
        if(respuesta.value.ok==1){
            Toast.fire({icon:'success', title:respuesta.value.mensaje})
            listarHorariosPersonal(horarios.value.current_page)
        }
    }
    const verDetalle = async(id) =>{
        await obtenerHorario(id)
        dato.value.horario=id
    }
    //paginacion
    const isActived = () => {
        return horarios.value.current_page
    }
    const offset = 2;
    const dato = ref({
        page:'',
        buscar:'',
        paginacion: 10,
        horario:'',
    });
    const buscar = () => {
        listarHorariosPersonal()
    }
    const cambiarPaginacion = () => {
        listarHorariosPersonal()
    }
    const cambiarPagina =(pagina) => {
        listarHorariosPersonal(pagina)
    }
    const pagesNumber = () => {
        if(!horarios.value.to){
            return []
        }
        let from = horarios.value.current_page - offset
        if(from < 1) from = 1
        let to = from + (offset*2)
        if( to >= horarios.value.last_page) to = horarios.value.last_page
        let pagesArray = []
        while(from <= to) {
            pagesArray.push(from)
            from ++
        }
        return pagesArray
    }
    // CARGA
    onMounted(() => {
        //listarHorariosPersonal()
    })
</script>
<template>
    <ContentHeader :title-header="titleHeader"></ContentHeader>
    <div class="app-content">
      <div class="container-fluid">
        <div class="card card-primary card-outline mt-2">
            <div class="card-header">
                <h6 class="card-title">
                    Listado de Horarios Generados
                </h6>
            </div>
            <div class="card-body">
                <div class="row">
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
                    <div class="col-md-3">
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
                                <li v-if="horarios.current_page >= 2" class="page-item">
                                    <a href="#" aria-label="Previous" class="page-link"
                                        title="Primera Página"
                                        @click.prevent="cambiarPagina(1)">
                                        <span><i class="fas fa-backward-fast"></i></span>
                                    </a>
                                </li>
                                <li v-if="horarios.current_page > 1" class="page-item">
                                    <a href="#" aria-label="Previous" class="page-link"
                                        title="Página Anterior"
                                        @click.prevent="cambiarPagina(horarios.current_page - 1)">
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
                                <li v-if="horarios.current_page < horarios.last_page" class="page-item">
                                    <a href="#" aria-label="Next" class="page-link"
                                        title="Página Siguiente"
                                        @click.prevent="cambiarPagina(horarios.current_page + 1)">
                                        <span aria-hidden="true"><i class="fas fa-angle-right"></i></span>
                                    </a>
                                </li>
                                    <li v-if="horarios.current_page <= horarios.last_page-1" class="page-item">
                                    <a href="#" aria-label="Next" class="page-link"
                                        @click.prevent="cambiarPagina(horarios.last_page)"
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
                                        <th>DNI</th>
                                        <th>Ape. Paterno</th>
                                        <th>Ape. Materno</th>
                                        <th>Nombres</th>
                                        <th>Fecha Desde</th>
                                        <th>Fecha Hasta</th>
                                        <th>Usuario</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-if="horarios.total == 0">
                                        <td class="text-danger text-center" colspan="9">
                                            -- Datos No Registrados - Tabla Vacía --
                                        </td>
                                    </tr>
                                    <tr v-else v-for="(horario,index) in horarios.data" :key="horario.id">
                                        <td class="text-center">{{ index + horarios.from }}</td>
                                        <td>{{ horario.personal.numero_dni }}</td>
                                        <td>{{ horario.personal.apellido_paterno }}</td>
                                        <td>{{ horario.personal.apellido_materno }}</td>
                                        <td>{{ horario.personal.nombres }}</td>
                                        <td>{{ horario.fecha_desde}}</td>
                                        <td>{{ horario.fecha_hasta }}</td>
                                        <td>{{ horario.user.username }}</td>
                                        <td>
                                            <button class="btn btn-danger btn-sm" title="Eliminar Horario" @click.prevent="eliminar(horario.id)">
                                                <i class="fas fa-trash"></i>
                                            </button>&nbsp;
                                            <button class="btn btn-success btn-sm" title="Ver Detalle" @click.prevent="verDetalle(horario.id)">
                                                <i class="fas fa-eye"></i>
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
                        Mostrando <b>{{horarios.from}}</b> a <b>{{ horarios.to }}</b> de <b>{{ horarios.total}}</b> Registros
                    </div>
                    <div class="col-md-7 mb-1 text-right">
                        <nav>
                            <ul class="pagination">
                                <li v-if="horarios.current_page >= 2" class="page-item">
                                    <a href="#" aria-label="Previous" class="page-link"
                                        title="Primera Página"
                                        @click.prevent="cambiarPagina(1)">

                                        <span><i class="fas fa-backward-fast"></i></span>
                                    </a>
                                </li>
                                <li v-if="horarios.current_page > 1" class="page-item">
                                    <a href="#" aria-label="Previous" class="page-link"
                                        title="Página Anterior"
                                        @click.prevent="cambiarPagina(horarios.current_page - 1)">

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
                                <li v-if="horarios.current_page < horarios.last_page" class="page-item">
                                    <a href="#" aria-label="Next" class="page-link"
                                        title="Página Siguiente"
                                        @click.prevent="cambiarPagina(horarios.current_page + 1)">
                                        <span aria-hidden="true"><i class="fas fa-angle-right"></i></span>
                                    </a>
                                </li>
                                    <li v-if="horarios.current_page <= horarios.last_page-1" class="page-item">
                                    <a href="#" aria-label="Next" class="page-link"
                                        @click.prevent="cambiarPagina(horarios.last_page)"
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
      <Horario v-if="dato.horario" :horario="horario" :form="dato" @onListar="verDetalle"></Horario>
    </div>
</template>