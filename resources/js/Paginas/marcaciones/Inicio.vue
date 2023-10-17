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
  const {errors, marcacionesHorarios, cargarMarcacionHorario } = useMarcacion();
  const {personal, obtenerPersonal} =usePersonal();
  const titleHeader = ref({
      titulo: "Marcaciones",
      subTitulo: "Inicio",
      icon: "",
      vista: ""
    });
    const dato = ref({
        dni:'',
        anho:formatoFecha(null,'YYYY'),
        mes:formatoFecha(null,'MM'),
        errors:[]
    });
    const cargar=async()=>{
        dato.value.errors = []
        await cargarMarcacionHorario(dato.value)
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
        "Diferencia":"diferencia",
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
                                        <th>FECHA</th>
                                        <th>DNI</th>
                                        <th>Apenom</th>
                                        <th>Turno</th>
                                        <th>Hora Entrada</th>
                                        <th>Hora Entrada Marcada</th>
                                        <th>Hora Salida</th>
                                        <th>Hora Salida Marcada</th>
                                        <th>Diferencia</th>
                                        <th>Redondeado</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="(marcacion, index) in marcacionesHorarios" :key="marcacion.id">
                                        <td>{{ index+1 }}</td>
                                        <td>{{ marcacion.fecha }}</td>
                                        <td>{{ marcacion.numero_dni }}</td>
                                        <td>{{ marcacion.apenom }}</td>
                                        <td>{{ marcacion.turno }}</td>
                                        <td>{{ marcacion.hora_entrada }}</td>
                                        <td>{{ marcacion.fecha_hora_entrada_marcada }}</td>
                                        <td>{{ marcacion.hora_salida }}</td>
                                        <td>{{ marcacion.fecha_hora_salida_marcada }}</td>
                                        <td>{{ marcacion.diferencia }}</td>
                                        <td></td>
                                    </tr>
                                </tbody>
                                <thead class="table-dark">

                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
      </div>
    </div>
</template>




