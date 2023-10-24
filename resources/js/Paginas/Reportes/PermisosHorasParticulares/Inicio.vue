<script setup>
  import jwt_decode from 'jwt-decode'
  import { ref, onMounted, inject } from 'vue';
  import { defineTitle } from '@/Helpers';
  import useHelper from '@/Helpers';  
  import useEstablecimiento from '@/Composables/establecimientos.js';  
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
        listaEstablecimientos, establecimientos
    } = useEstablecimiento();
    const {
        tipopermisos, listaTipoPermisos
    } = useTipoPermiso();

    const { obtenerPermisosHorasParticulares, permisos, errors } = usePermiso();

    const titleHeader = ref({
      titulo: "Reporte - Permisos Horas Particulares",
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
        "Minutos Permiso": "minutos_permiso",
        "Sueldo":"SUELDO",
        "Descuento":"descuentototal"
    })
    onMounted(()=>{
        listaCondicionesLaborales()
        listaEstablecimientos()
        listaTipoPermisos()
    });
    const buscar=async()=>{
        await obtenerPermisosHorasParticulares(dato.value)
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
                    <div class="col-md-3">
                        <div class="input-group">
                            <div class="input-group mb-1">
                                <span class="input-group-text" id="basic-addon1">Establecimiento</span>
                                <select v-model="dato.establecimiento_id" class="form-control" :class="{ 'is-invalid': dato.errors.establecimiento_id }">
                                    <option value="">--Seleccione--</option>
                                    <option v-for="establecimiento in establecimientos" :key="establecimiento.id" :value="establecimiento.id">
                                        {{ establecimiento.nombre }}
                                    </option>
                                </select>
                            </div>
                            <small class="text-danger" v-for="error in dato.errors.establecimiento_id" :key="error">{{ error
                                }}</small>
                        </div>
                    </div>                    
                    <div class="col-md-3">
                        <div class="input-group">
                            <div class="input-group mb-1">
                                <span class="input-group-text" id="basic-addon1">Condicion Laboral</span>
                                <select v-model="dato.condicion_laboral_id" class="form-control"
                                                    :class="{ 'is-invalid': dato.errors.condicion_laboral_id }">
                                    <option value="0">TODOS</option>
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
                    <div class="col-md-2">
                        <div class="input-group mb-1">
                            <span class="input-group-text" id="basic-addon1">DESDE</span>
                            <input type="date" v-model="dato.fecha_desde" class="form-control" :class="{ 'is-invalid': dato.errors.fecha_desde }">
                        </div>
                        <small class="text-danger" v-for="error in dato.errors.fecha_desde" :key="error">{{ error
                                }}<br></small>
                    </div>
                    <div class="col-md-2">
                        <div class="input-group mb-1">
                            <span class="input-group-text" id="basic-addon1">HASTA</span>
                            <input type="date" v-model="dato.fecha_hasta" class="form-control" :class="{ 'is-invalid': dato.errors.fecha_hasta }">
                        </div>
                        <small class="text-danger" v-for="error in dato.errors.fecha_hasta" :key="error">{{ error
                                }}<br></small>
                    </div>
        
                </div>
                <div class="row">
                    <!-- <div class="col-md-3 mb-2">
                        <div class="input-group mb-1">
                            <span class="input-group-text" id="basic-addon1">TIPO PERMISO</span>
                            <select v-model="dato.tipo_permiso_id" class="form-control" :class="{ 'is-invalid': dato.errors.tipo_permiso_id }">
                                <option value="">--Seleccione--</option>
                                <option v-for="tipopermiso in tipopermisos" :key="tipopermiso.id" :value="tipopermiso.id"
                                    :title="tipopermiso.nombre">{{ tipopermiso.nombre }}</option>
                            </select>
                        </div>
                        <small class="text-danger" v-for="error in dato.errors.tipo_permiso_id" :key="error">{{ error
                                }}</small>
                    </div> -->
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
                                        <th>Establecimiento</th>
                                        <th>Condicion</th>
                                        <th>Cargo</th>
                                        <th>Nivel</th>
                                        <th>Fecha Hora Inicio</th>
                                        <th>Fecha Hora Fin</th>
                                        <th>Minutos Permiso</th>
                                        <th>Sueldo</th>
                                        <th>Descuento (S/.)</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="(registro,index) in permisos" :key="registro.id">
                                        <td class="text-center">{{ index+1 }}</td>
                                        <td>{{ registro.DNI }}</td>
                                        <td>{{ registro.apenom }}</td>
                                        <td>{{ registro.establecimiento }}</td>
                                        <td>{{ registro.condicion }}</td>
                                        <td>{{ registro.cargo }}</td>
                                        <td>{{ registro.nivel }}</td>
                                        <td>{{ registro.fecha_inicio }}</td>
                                        <td>{{ registro.fecha_final }}</td>
                                        <td>{{ registro.minutos_permiso }}</td>
                                        <td>{{ registro.SUELDO }}</td>
                                        <td>{{ registro.descuento }}</td>
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