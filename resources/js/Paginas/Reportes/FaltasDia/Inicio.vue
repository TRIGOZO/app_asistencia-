<script setup>
  import jwt_decode from 'jwt-decode'
  import { ref, onMounted, inject } from 'vue';
  import { defineTitle } from '@/Helpers';
  import useHelper from '@/Helpers';  
  import usePermiso from '@/Composables/permiso.js';
  import ContentHeader from '@/Componentes/ContentHeader.vue';
  import JsonExcel from 'vue-json-excel3';
  const { openModal, Toast, Swal, formatoFecha, meses } = useHelper();


    const { obtenerPermisosSinGoce, permisos, errors } = usePermiso();

    const titleHeader = ref({
      titulo: "Reporte - Faltas por Dia",
      subTitulo: "Reportes",
      icon: "",
      vista: ""
    });
    
    const jsonFields = ref({
        "DNI" : "DNI",
        "Apellidos y Nombres": "apenom",
        "establecimiento": "establecimiento",
        "Condicion Laboral": "condicion",
        "Cargo": "cargo",
        "Nivel":"nivel",
        "Sueldo":"sueldo",
        "Fecha Inicio": "fecha_inicio",
        "Fecha Fin": "fecha_final",
        "Minutos Sin Goce": "minutos_sin_goce",
        "Sueldo":"SUELDO",
        "Descuento":"descuentototal"
    })
    onMounted(()=>{

    });
    const buscar=async()=>{
        await obtenerPermisosSinGoce(dato.value)
        dato.value.errors = []
        if(errors.value)
        {
            dato.value.errors = errors.value
        }
    }
    const anhoactual=formatoFecha(null,"YYYY");
    const dato = ref({
        condicion_laboral_id : 0,
        establecimiento_id : '',
        // tipo_permiso_id:'',
        fecha_desde : formatoFecha(null,"YYYY-MM-DD"),
        fecha_hasta : formatoFecha(null,"YYYY-MM-DD"),
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
                    <div class="col-md-2">
                        <div class="input-group mb-1">
                            <span class="input-group-text" id="basic-addon1">FECHA</span>
                            <input type="date" v-model="dato.fecha_desde" class="form-control" :class="{ 'is-invalid': dato.errors.fecha_desde }">
                        </div>
                        <small class="text-danger" v-for="error in dato.errors.fecha_desde" :key="error">{{ error
                                }}<br></small>
                    </div>
                    <div class="col-md-2 mb-4">
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
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="(registro,index) in permisos" :key="registro.id">
                                        <td class="text-center">{{ index+1 }}</td>
                                        <td>{{ registro.DNI }}</td>
                                        <td>{{ registro.apenom }}</td>
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