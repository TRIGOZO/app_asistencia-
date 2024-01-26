<script setup>
  import usePersonal from '@/Composables/personal.js';
  import PersonalForm from './Form.vue'
  import PinForm from './PinForm.vue'
  import useHelper from '@/Helpers';  
  import ContentHeader from '@/Componentes/ContentHeader.vue';
  import { ref, onMounted } from 'vue';
  const { openModal, Toast, Swal } = useHelper();
  const {
        errors, personales, personal, 
        obtenerPersonal, obtenerPersonales, 
        eliminarPersonal, respuesta
    } = usePersonal();
    const titleHeader = ref({
      titulo: "Personal",
      subTitulo: "Inicio",
      icon: "",
      vista: ""
    });
    const form = ref({
        id:'',
        numero_dni: '',
        nombres: '',
        apellido_paterno: '',
        apellido_materno: '',
        sexo: 'M',
        fecha_nacimiento: '',
        estado_civil_id: '',
        direccion: '',
        telefono: '',
        celular: '',
        email: '',
        tipo_trabajador_id: '',
        tienehijos: '',
        profesion_id: '',
        nivel_id: '',
        sueldo: '',
        condicion_laboral_id: '',
        fecha_inicio: '',
        fecha_fin: '',
        establecimiento_id: '',
        cargo_id: '', 
        observacion: '',
        estadoCrud:'',
        errors:[]

    });
    const limpiar = ()=> {
        form.value.id='',
        form.value.numero_dni = ''
        form.value.nombres = '',
        form.value.apellido_paterno = '',
        form.value.apellido_materno = '',
        form.value.sexo = 'M',
        form.value.fecha_nacimiento = '',
        form.value.estado_civil_id = '',
        form.value.direccion = '',
        form.value.telefono = '',
        form.value.celular = '',
        form.value.email = '',
        form.value.tipo_trabajador_id = '',
        form.value.tienehijos = '',
        form.value.profesion_id = '',
        form.value.nivel_id = '',
        form.value.sueldo = '',
        form.value.condicion_laboral_id = '',
        form.value.fecha_inicio = '',
        form.value.fecha_fin = '',
        form.value.establecimiento_id = '',
        form.value.cargo_id = '', 
        form.value.observacion = '',
        form.value.errors = []
        errors.value = []
    }
    const obtenerDatos = async(id) => {
        await obtenerPersonal(id);
        if(personal.value)
        {
            form.value.id=personal.value.id;
            form.value.numero_dni = personal.value.numero_dni;
            form.value.nombres = personal.value.nombres;
            form.value.apellido_paterno = personal.value.apellido_paterno;
            form.value.apellido_materno = personal.value.apellido_materno;
            form.value.sexo = personal.value.sexo;
            form.value.fecha_nacimiento = personal.value.fecha_nacimiento;
            form.value.estado_civil_id = personal.value.estado_civil_id;
            form.value.direccion = personal.value.direccion;
            form.value.telefono = personal.value.telefono;
            form.value.celular = personal.value.celular;
            form.value.email = personal.value.email;
            form.value.tipo_trabajador_id = personal.value.tipo_trabajador_id;
            form.value.tienehijos = personal.value.tienehijos;
            form.value.profesion_id = personal.value.profesion_id;
            form.value.nivel_id = personal.value.nivel_id;
            form.value.sueldo = personal.value.sueldo;
            form.value.condicion_laboral_id = personal.value.condicion_laboral_id;
            form.value.fecha_inicio = personal.value.fecha_inicio;
            form.value.fecha_fin = personal.value.fecha_fin;
            form.value.establecimiento_id = personal.value.establecimiento_id;
            form.value.cargo_id = personal.value.cargo_id;
            form.value.observacion = personal.value.observacion;
        }
    }
    const editar = (id) => {
        limpiar();
        obtenerDatos(id)
        form.value.estadoCrud = 'editar'
        document.getElementById("modalpersonalLabel").innerHTML = 'Editar Personal';
        openModal('#modalpersonal')
    }
    const nuevo = () => {
        limpiar()
        form.value.estadoCrud = 'nuevo'
        openModal('#modalpersonal')
        document.getElementById("modalpersonalLabel").innerHTML = 'Nuevo Personal';
        //titulo.textContent = 'Editar Datos Personales';
    }
    const listarPersonal = async(page=1) => {
        dato.value.page= page
        await obtenerPersonales(dato.value)
    }
    const eliminar = (id) => {
        Swal.fire({
            title: '¿Estás seguro de Eliminar?',
            text: "Personal",
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
    const establecerpin=(id)=>{
        openModal('#modalpin')
    }
    const elimina = async(id) => {
        await eliminarPersonal(id)
        form.value.errors = []
        if(errors.value)
        {
            form.value.errors = errors.value
        }
        if(respuesta.value.ok==1){
            form.value.errors = []
            Toast.fire({icon:'success', title:respuesta.value.mensaje})
            listarPersonal(personales.value.current_page)
        }
    }

    //paginacion
    const isActived = () => {
        return personales.value.current_page
    }
    const offset = 2;
    const dato = ref({
        page:'',
        buscar:'',
        paginacion: 10
    });
    const buscar = () => {
        listarPersonal()
    }
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
    // CARGA
    onMounted(() => {
        listarPersonal()
    })
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
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-if="personales.total == 0">
                                        <td class="text-danger text-center" colspan="12">
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
                                        <td>
                                            <button class="btn btn-warning btn-sm" title="Editar Personal" @click.prevent="editar(personal.id)">
                                                <i class="fas fa-edit"></i>
                                            </button>&nbsp;
                                            <button class="btn btn-danger btn-sm" title="Eliminar Personal" @click.prevent="eliminar(personal.id)">
                                                <i class="fas fa-trash"></i>
                                            </button>&nbsp;
                                            <button class="btn btn-success btn-sm" title="Establecer Pin" @click.prevent="establecerpin(personal.id)">
                                                <i class="fas fa-key"></i>
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
    <PinForm></PinForm>
    <PersonalForm :form="form" @onListar="listarPersonal" :currentPage="listarPersonal.current_page"></PersonalForm>
</template>