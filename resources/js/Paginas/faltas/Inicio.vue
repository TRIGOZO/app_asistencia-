<script setup>
  import jwt_decode from 'jwt-decode'
  import { ref, onMounted, inject } from 'vue';
  import { defineTitle } from '@/Helpers';
  import useHelper from '@/Helpers';  
  import useEstablecimiento from '@/Composables/establecimientos.js';  
  import useCondicionLaboral from '@/Composables/condicionlaboral.js';
  import useMarcacion from '@/Composables/marcacion.js';  
  import usePermiso from '@/Composables/permiso.js';
  import ContentHeader from '@/Componentes/ContentHeader.vue';
  import JsonExcel from 'vue-json-excel3';
  const { openModal, Toast, Swal, formatoFecha, meses } = useHelper();


    const {
        cargarFaltas, faltas
    } = useMarcacion();


    const titleHeader = ref({
      titulo: "Reporte - Faltas",
      subTitulo: "Reportes",
      icon: "",
      vista: ""
    });
    
    const jsonFields = ref({
        "DNI" : "personal.numero_dni",
        "Apellidos y Nombres": "apenom",
        "Condicion Laboral": "personal.condicion.nombre",
        "Cargo": "personal.cargo.nombre",
        "Nivel":"personal.nivel_id",
        "Motivo":"motivo",
        "Sueldo":"personal.sueldo",
        "Descuento":"descuento",
        "Total":"total"

    })
    onMounted(()=>{

    });
    const buscar=async()=>{
        await cargarFaltas(dato.value)

    }
    const anhoactual=formatoFecha(null,"YYYY");
    const dato = ref({
        dni : '',
        mes : formatoFecha(null,"MM"),
        anho : anhoactual,
        errors:[]
    });

</script>
<template>
    <ContentHeader :title-header="titleHeader"></ContentHeader>
    <div class="app-content">
      <div class="container-fluid">
        <div class="card card-primary card-outline">
            <div class="card-header">
                <h6 class="card-title">
                    Busqueda
                </h6>
            </div>
            <div class="card-body">
                <div class="row mb-4">
                    <div class="col-md-5">
                        <div class="input-group mb-1">
                            <span class="input-group-text" id="basic-addon1">DNI</span>
                            <input class="form-control" placeholder="Ingrese DNI" type="text" v-model="dato.dni"
                                @change="buscar" :class="{ 'is-invalid': dato.errors.dni }" />
                        </div>
                        <small class="text-danger" v-for="error in dato.errors.dni" :key="error">{{ error }}<br></small>
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
                    <div class="col-md-2">
                        <div class="input-group mb-1">
                            <span class="input-group-text" id="basic-addon1">Año</span>
                            <select v-model="dato.anho" class="form-control" :class="{ 'is-invalid': dato.errors.mes }">
                                <option v-for="(i, n) in 5" :key="i" :value="anhoactual - n">
                                    {{ anhoactual - n }}
                                </option>
                            </select>
                        </div>
                        <small class="text-danger" v-for="error in dato.errors.mes" :key="error">{{ error
                                }}<br></small>
                    </div>
                    <div class="col-md-2">
                        <button class="btn btn-primary" @click="buscar()">Cargar</button>&nbsp;
                        <JsonExcel class="btn btn-success" :fields="jsonFields" :data="faltas">
                            <i class="fa-solid fa-file-excel"></i> Descargar
                        </JsonExcel>
                    </div>          
                </div>
                <div class="row">
                    <div class="col-md-12 mb-1">
                        <div class="table-responsive">         
                            <table class="table table-bordered table-hover table-sm table-striped">
                                <thead class="table-dark">
                                    <tr>
                                        <th class="text-center">#</th>
                                        <th>NOMBRE DIA</th>
                                        <th>FECHA</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="(registro,index) in faltas" :key="registro.id">
                                        <td class="text-center">{{ index+1 }}</td>
                                        <td>{{ registro.nombredia }}</td>
                                        <td>{{ registro.fecha }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <br><br>
      </div>
    </div>
</template>