<script setup>
  import jwt_decode from 'jwt-decode'
  import { ref, onMounted, inject } from 'vue';
  import { defineTitle } from '@/Helpers';
  import useHelper from '@/Helpers';  
  import useCondicionLaboral from '@/Composables/condicionlaboral.js';
  import useTipoPermiso from '@/Composables/tipopermisos.js';
  import usePermiso from '@/Composables/permiso.js';
  import ContentHeader from '@/Componentes/ContentHeader.vue';
  import JsonExcel from 'vue-json-excel3';
  const { openModal, Toast, Swal, formatoFecha, meses } = useHelper();


  const {
    listaCondicionesLaborales, condicioneslaborales
    } = useCondicionLaboral();
    const {
        listaTipoPermisos, tipopermisos
    } = useTipoPermiso();
    const { reportePermisos, permisos } = usePermiso();

    const titleHeader = ref({
      titulo: "Reporte - Permiso",
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
        "Desde":"desde",
        "Hasta":"hasta",
        "Motivo":"motivo",
    })
    onMounted(()=>{
        listaCondicionesLaborales()
        listaTipoPermisos()
    });
    const buscar=async()=>{
        reportePermisos(dato.value)
    }
    const anhoactual=formatoFecha(null,"YYYY");
    const dato = ref({
        numero_dni : '',
        condicion_laboral_id : 0,
        mes : parseInt(formatoFecha(null,"MM")),
        tipo_permiso_id : 0,
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
                    <div class="col-md-4 col-xs-4">
                        <div class="input-group">
                            <div class="input-group mb-1">
                                <span class="input-group-text" id="basic-addon1">DNI</span>
                                <input type="text" v-model="dato.numero_dni" class="form-control" :class="{ 'is-invalid': dato.errors.numero_dni }">
                            </div>
                            <small class="text-danger" v-for="error in dato.errors.numero_dni" :key="error">{{ error
                                }}<br></small>                            
                        </div>
                    </div>
                    <div class="col-md-4 col-xs-4">
                        <div class="input-group">
                            <div class="input-group mb-1">
                                <span class="input-group-text" id="basic-addon1">Condicion Laboral</span>
                                <select v-model="dato.condicion_laboral_id" class="form-control"
                                                    :class="{ 'is-invalid': dato.errors.condicion_laboral_id }">
                                    <option value="0">Todos</option>
                                    <option v-for="condicion in condicioneslaborales" :key="condicion.id" :value="condicion.id"
                                        :title="condicion.nombre">
                                        {{ condicion.nombre }}
                                    </option>
                                </select>
                            </div>
                            <small class="text-danger" v-for="error in dato.errors.condicion_laboral_id" :key="error">{{ error
                                }}<br></small>                            
                        </div>
                    </div>
                    <div class="col-md-4 col-xs-4">
                        <div class="input-group">
                            <div class="input-group mb-1">
                                <span class="input-group-text" id="basic-addon1">Tipo de Permiso</span>
                                <select v-model="dato.tipo_permiso_id" class="form-control"
                                                    :class="{ 'is-invalid': dato.errors.tipo_permiso_id }">
                                    <option value="0">Todos</option>
                                    <option v-for="tipopermiso in tipopermisos" :key="tipopermiso.id" :value="tipopermiso.id"
                                        :title="tipopermiso.nombre">
                                        {{ tipopermiso.nombre }}
                                    </option>
                                </select>
                            </div>
                            <small class="text-danger" v-for="error in dato.errors.tipo_permiso_id" :key="error">{{ error
                                }}<br></small>                            
                        </div>
                    </div>
                </div>
                <div class="row mb-4">
                    <div class="col-md-4">
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
                    <div class="col-md-4">
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
                    <div class="col-md-4">
                        <button class="btn btn-primary" @click="buscar()">Cargar</button>&nbsp;
                        <JsonExcel class="btn btn-success" :fields="jsonFields" :data="permisos">
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
                                        <th>DNI</th>
                                        <th>Nombre y Apellidos</th>
                                        <th>Condicion Laboral</th>
                                        <th>Cargo</th>
                                        <th>Nivel</th>
                                        <th>Fecha Hora Desde</th>
                                        <th>Fecha Hora Hasta</th>
                                        <th>Motivo</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="(permiso,index) in permisos" :key="permiso.id">
                                        <td class="text-center">{{ index+1 }}</td>
                                        <td>{{ permiso.personal.numero_dni }}</td>
                                        <td>{{ permiso.apenom }}</td>
                                        <td>{{ permiso.personal.condicion.nombre }}</td>
                                        <td>{{ permiso.personal.cargo.nombre }}</td>
                                        <td>{{ permiso.personal.nivel_id }}</td>
                                        <td>{{ permiso.desde }}</td>
                                        <td>{{ permiso.hasta }}</td>
                                        <td>{{ permiso.motivo }}</td>
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