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
    listaCondicionesLaborales, condicioneslaborales
    } = useCondicionLaboral();
    const {
        listaEstablecimientos, establecimientos
    } = useEstablecimiento();
    const {
        cargarTardanzas, marcacionesHorarios
    } = useMarcacion();
    const { reportePermisos, permisos } = usePermiso();

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
        listaCondicionesLaborales()
        listaEstablecimientos()
    });
    const buscar=async()=>{
        await cargarTardanzas(dato.value)
        let marcaciones = marcacionesHorarios.value
        marcaciones.forEach(item=>{
            item.descuento = (item.constante_descuento*item.minutos).toFixed(2)
            item.total=(item.sueldo-(item.constante_descuento*item.minutos)).toFixed(2)
        });
    }
    const anhoactual=formatoFecha(null,"YYYY");
    const dato = ref({
        condicion_laboral_id : '',
        establecimiento_id : '',
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
                    <div class="col-md-3">
                        <div class="input-group">
                            <div class="input-group mb-1">
                                <span class="input-group-text" id="basic-addon1">Condicion Laboral</span>
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
                                    <option value="">--Seleccione--</option>
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
                                        <th>Tiempo Minutos</th>
                                        <th>Sueldo (S/.)</th>
                                        <th>Constante</th>
                                        <th>Descuento (S/.)</th>
                                        <th>Total(S/.)</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="(registro,index) in marcacionesHorarios" :key="registro.id">
                                        <td class="text-center">{{ index }}</td>
                                        <td>{{ registro.numero_dni }}</td>
                                        <td>{{ registro.apenom }}</td>
                                        <td>{{ registro.condicion }}</td>
                                        <td>{{ registro.cargo }}</td>
                                        <td>{{ registro.nivel }}</td>
                                        <td>{{ registro.minutos }}</td>
                                        <td>{{ registro.sueldo }}</td>
                                        <td>{{ registro.constante_descuento }}</td>
                                        <td>{{ registro.descuento }}</td>
                                        <td>{{ registro.total }}</td>
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