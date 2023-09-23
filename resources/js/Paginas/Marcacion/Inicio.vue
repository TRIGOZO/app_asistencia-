<script setup>
  import jwt_decode from 'jwt-decode'
  import { ref, onMounted } from 'vue';
  import { defineTitle } from '@/Helpers';
  import useHelper from '@/Helpers'; 
  import useMarcacion from '@/Composables/marcacion.js';
  import useEstablecimiento from '@/Composables/establecimientos.js';
  import ContentHeader from '@/Componentes/ContentHeader.vue';
  const { openModal, Toast, Swal, formatoFecha } = useHelper();
  const {
        errors,
        respuesta,
        agregarMarcacion,
        obtenerMarcacionesHoy,
        marcaciones
    } = useMarcacion();

  const {
        listaEstablecimientos,
        establecimientos
    } = useEstablecimiento();
    
    const titleHeader = ref({
      titulo: "Realizar Marcacion de Asistencia Manual",
      subTitulo: "Inicio",
      icon: "",
      vista: ""
    });
    const limpiar = () => {
        form.value.numero_dni='',
        form.value.establecimiento_id='',
        form.value.fecha_hora=formatoFecha(null,"YYYY-MM-DD HH:mm"),
        form.value.tipo='',
        form.value.serial='',
        form.value.ip='',
        form.value.estadoCrud='',
        form.value.errors = []
        errors.value = []
    }
    const crud = {
        'nuevo': async() => {
            await agregarMarcacion(form.value)
            form.value.errors = []
            if(errors.value)
            {
                form.value.errors = errors.value
            }
            if(respuesta.value.ok==1){
                form.value.errors = []
                Toast.fire({icon:'success', title:respuesta.value.mensaje})
                limpiar()
                listarMarcaciones()
            }
        },
        'editar': async() => {
            // await actualizarPersonal(form.value)
            // form.value.errors = []
            // if(errors.value)
            // {
            //     form.value.errors = errors.value
            // }
            // if(respuesta.value.ok==1){
            //     form.value.errors = []
            //     hideModal('#modalpersonal')
            //     Toast.fire({icon:'success', title:respuesta.value.mensaje})
            //     emit('onListar', currentPage.value)
            // }
        }
    }
    const guardar = () => {
        crud[form.value.estadoCrud]()
    }
    const dato = ref({
        page:'',
        buscar:'',
        paginacion: 10,
        fecha: formatoFecha(null,"YYYY-MM-DD"),
    });
    const form = ref({
        numero_dni:'',
        establecimiento_id:'',
        fecha_hora:formatoFecha(null,"YYYY-MM-DD HH:mm"),
        tipo:'',
        serial:'',
        ip:'',
        estadoCrud:'nuevo',
        errors:[]
    });

    const buscar = () => {
        listarPersonales()
    }
    const listarMarcaciones = async(page=1) => {
        await obtenerMarcacionesHoy(dato.value)
    }
    const listarEstablecimientos = async() => {
        await listaEstablecimientos()
    }
    // CARGA
    onMounted(() => {
        defineTitle(titleHeader.value.titulo)
        listarMarcaciones()
        listarEstablecimientos()
    })
</script>
<template>
    <ContentHeader :title-header="titleHeader"></ContentHeader>
    <div class="app-content">
      <div class="container-fluid">
        <div class="row">
            <div class="col-md-4">
                <div class="card card-primary card-outline">
                    <div class="card-header">
                        <h6 class="card-title" @click="listarEstablecimientos">
                            MARCACION
                        </h6>
                    </div>
                    <div class="card-body">
                        <form @submit.prevent="guardar">
                            <div class="mb-3">
                                <label for="numero_dni">DNI</label>
                                <input type="text" class="form-control" v-model="form.numero_dni" placeholder="DNI" :class="{ 'is-invalid': form.errors.numero_dni }">
                                <small class="text-danger" v-for="error in form.errors.numero_dni"
                                :key="error">{{error }}<br></small>
                            </div>
                            <div class="mb-3">
                                <label for="establecimiento_id">Establecimiento</label>
                                <select class="form-control" v-model="form.establecimiento_id" :class="{ 'is-invalid': form.errors.establecimiento_id }">
                                    <option value="" disabled>Seleccione</option>
                                    <option v-for="establecimiento in establecimientos" :key="establecimiento.id" :value="establecimiento.id"
                                        :title="establecimiento.nombre">
                                        {{ establecimiento.nombre }}
                                    </option>
                                </select>
                                <small class="text-danger" v-for="error in form.errors.establecimiento_id" :key="error">{{ error
                                }}</small>
                            </div>
                            <div class="mb-3">
                                <label for="fecha_hora">Fecha y Hora</label>
                                <input type="datetime-local" class="form-control" id="fecha_hora" v-model="form.fecha_hora" :class="{ 'is-invalid': form.errors.fecha_hora }">
                                <small class="text-danger" v-for="error in form.errors.fecha_hora" :key="error">{{ error
                                }}</small>
                            </div>
                            <div class="mb-3">
                                <label for="tipo">Tipo</label>
                                <select class="form-control" v-model="form.tipo" :class="{ 'is-invalid': form.errors.tipo }">
                                    <option value="" disabled>Seleccione</option>
                                    <option value="entrada">Entrada</option>
                                    <option value="salida">Salida</option>
                                </select>
                                <small class="text-danger" v-for="error in form.errors.tipo" :key="error">{{ error
                                }}</small>
                            </div>
                            <div class="mb-3">
                                <label for="serial">Serial</label>
                                <input type="text" class="form-control" v-model="form.serial" :class="{ 'is-invalid': form.errors.serial }" placeholder="Serial">
                                <small class="text-danger" v-for="error in form.errors.serial" :key="error">{{ error
                                }}</small>
                            </div>
                            <div class="mb-3">
                                <label for="ip">IP</label>
                                <input type="text" class="form-control" v-model="form.ip" :class="{ 'is-invalid': form.errors.ip }" placeholder="IP">
                                <small class="text-danger" v-for="error in form.errors.ip" :key="error">{{ error
                                }}</small>
                            </div>
                            <button type="submit" class="btn btn-primary">Enviar</button>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-md-8">
                <div class="card card-primary card-outline">
                    <div class="card-header">
                        <h6 class="card-title">
                            REGISTROS HOY
                        </h6>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">         
                            <table class="table table-bordered table-hover table-sm table-striped">
                                <thead class="table-dark">
                                    <tr>
                                        <th colspan="6" class="text-center">Marcaciones</th>
                                    </tr>
                                    <tr>
                                        <th>#</th>
                                        <th>DNI</th>
                                        <th>Apenom</th>
                                        <th>Tipo</th>
                                        <th>Hora</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-if="marcaciones.total == 0">
                                        <td class="text-danger text-center" colspan="7">
                                            -- Datos No Registrados - Tabla Vacía --
                                        </td>
                                    </tr>
                                    <tr v-else v-for="(marcacion,index) in marcaciones.data" :key="marcacion.id">
                                        <td>{{ index + marcaciones.from }}</td>
                                        <td>{{ marcacion.personal?.numero_dni }}</td>
                                        <td>{{ marcacion.personal?.apellido_paterno + ' ' + marcacion.personal?.apellido_materno + ' ' + marcacion.personal?.nombres }}</td>
                                        <td>{{ marcacion.tipo }}</td>
                                        <td>{{ marcacion.fecha_hora }}</td>
                                        <td>
                                            <template v-if="marcacion.deleted_at == null">
                                                <button class="btn btn-warning btn-sm" title="Editar" @click.prevent="editar(marcacion.id)">
                                                    <i class="fas fa-edit"></i>
                                                </button>&nbsp;
                                                <button class="btn btn-danger btn-sm" title="Enviar a Papelera" @click.prevent="eliminar(marcacion.id, 'Temporal')">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </template>
                                            <template v-else>
                                                <button class="btn btn-info btn-sm" title="Restaurar" @click.prevent="restaurar(marcacion.id)">
                                                    <i class="fas fa-trash-restore-alt"></i>
                                                </button>&nbsp;
                                                <button class="btn btn-danger btn-sm" title="Eliminar Permanente" @click.prevent="eliminar(marcacion.id, 'Permanente')">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </template>
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
</template>




