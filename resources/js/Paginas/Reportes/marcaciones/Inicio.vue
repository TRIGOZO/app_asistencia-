<script setup>
  import { ref, onMounted } from 'vue';
  import { defineTitle } from '@/Helpers';
  import useHelper from '@/Helpers'; 
  import useMarcacion from '@/Composables/marcacion.js';
  import usePersonal from '@/Composables/personal.js';
  import usePermiso from '@/Composables/permiso.js';
  import ContentHeader from '@/Componentes/ContentHeader.vue';
  import JsonExcel from 'vue-json-excel3';
  const { openModal, Toast, Swal, formatoFecha, meses } = useHelper();
  const {errors, marcacionesHorarios, cargarMarcacionReales } = useMarcacion();
  const {personal, obtenerPersonal} =usePersonal();
  const titleHeader = ref({
      titulo: "Marcaciones Real",
      subTitulo: "Inicio",
      icon: "",
      vista: ""
    });
    const total=ref(0);
    const anios = ref([]);
    const listarAnios=()=>{
        const anioActual=parseInt(formatoFecha(null,"YYYY"))
        for (let index = anioActual; index >= anioActual - 4; index--) {
            anios.value.push(index);
        }
    }
    const dato = ref({
        dni:'',
        anho:formatoFecha(null,'YYYY'),
        mes:parseInt(formatoFecha(null,'MM')),
        errors:[]
    });
    const cargar=async()=>{
        dato.value.errors = []
        await cargarMarcacionReales(dato.value)
        if(marcacionesHorarios.value){
            total.value = 0
            marcacionesHorarios.value.forEach(m => {
                total.value += (m.diferencia_entrada ?? 0)
            });
        }
        if(errors.value)
        {
            dato.value.errors = errors.value
        }
    }
    const jsonFields = ref({
        "Fecha": "fecha",
        "DNI" : "numero_dni",
        "Apellidos y Nombres": "apenom",
        "Turno": "turno",
        "Hora Entrada": "hora_entrada",
        "Hora Marcada Entrada": "fecha_hora_entrada_marcada",
        "Hora Entrada":"hora_entrada",
        "Diferencia Hora Entrada":"diferencia_entrada",
        "Hora Salida":"hora_salida",
        "Hora Marcada Salida":"fecha_hora_salida_marcada",
        "Diferencia Hora Salida":"diferencia_salida",
    })
    onMounted(() => {
        listarAnios()
    })   
</script>
<template>
    <ContentHeader :title-header="titleHeader"></ContentHeader>
    <div class="app-content">
      <div class="container-fluid">
        <div class="card card-primary card-outline">
            <div class="card-header">
                <h6 class="card-title" @click="listarEstablecimientos">
                    BUSQUEDA
                </h6>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-5">
                        <div class="input-group mb-1">
                            <span class="input-group-text" id="basic-addon1">DNI</span>
                            <input class="form-control" placeholder="Ingrese DNI" type="text" v-model="dato.dni"
                                @change="buscar" :class="{ 'is-invalid': dato.errors.dni }" />
                        </div>
                        <small class="text-danger" v-for="error in dato.errors.dni" :key="error">{{ error }}<br></small>
                    </div>
                    <div class="col-md-2 mb-1">
                        <div class="input-group mb-1">
                            <span class="input-group-text" id="basic-addon1">Mes</span>
                            <select v-model="dato.mes" class="form-control" :class="{ 'is-invalid': dato.errors.mes }">
                                <option v-for="mes in meses" :key="mes.numero" :value="mes.numero">
                                    {{ mes.nombre }}
                                </option>
                            </select>
                        </div>
                        <small class="text-danger" v-for="error in dato.errors.mes" :key="error">{{ error
                                }}<br></small>
                    </div>
                    <div class="col-md-2 mb-1">
                        <div class="input-group mb-1">
                            <span class="input-group-text" id="basic-addon1">Año</span>
                            <select v-model="dato.anho" class="form-control"
                            :class="{ 'is-invalid': dato.errors.anho }">
                                <option v-for="anho in anios" :key="anho" :value="anho"
                                    :title="anho">
                                    {{ anho }}
                                </option>
                            </select>
                        </div>
                        <small class="text-danger" v-for="error in dato.errors.mes" :key="error">{{ error
                                }}<br></small>
                    </div>     
                    <div class="col-md-2 mb-1">
                        <button class="btn btn-primary" @click="cargar()">
                            Cargar
                        </button>&nbsp;
                        <JsonExcel class="btn btn-success" :fields="jsonFields" :data="marcacionesHorarios">
                            <i class="fa-solid fa-file-excel"></i> Descargar
                        </JsonExcel>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="table-responsive">         
                            <table class="table table-bordered table-hover table-sm table-striped">
                                <thead class="table-dark">
                                    <tr>
                                        <th>#</th>
                                        <th>DNI</th>
                                        <th>Apenom</th>
                                        <th>Hora Marcada</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="(marcacion, index) in marcacionesHorarios" :key="marcacion.id">
                                        <td>{{ index+1 }}</td>
                                        <td>{{ marcacion.numero_dni }}</td>
                                        <td>{{ marcacion.apenom }}</td>
                                        <td>{{ marcacion.fecha_hora_marcada }}</td>
                                    </tr>
                                </tbody>
                                <tfoot class="table-dark">
                                    <tr>
                                        <th>#</th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
      </div>
    </div>
</template>




