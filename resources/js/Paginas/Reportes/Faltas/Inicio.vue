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
  import DetallesForm from './Detalles.vue'
  const { openModal, Toast, Swal, formatoFecha, meses } = useHelper();

    const {
    listaCondicionesLaborales, condicioneslaborales
    } = useCondicionLaboral();
    const {
        listaEstablecimientos, establecimientos
    } = useEstablecimiento();
    const {
        cargarFaltasEstablecimiento, faltas, cargarFaltas, faltasdetalle
    } = useMarcacion();

    const titleHeader = ref({
      titulo: "Reporte - Faltas",
      subTitulo: "Reportes",
      icon: "",
      vista: ""
    });
    const personal = ref({});
    const datobusquedafaltas = ref({
        dni : '',
        mes : '',
        anho : '',
    });    
    const verDetalles = async(reg) => {
        personal.value=reg
        datobusquedafaltas.value.dni = personal.value.numero_dni
        datobusquedafaltas.value.mes = dato.value.mes
        datobusquedafaltas.value.anho = dato.value.anho
        await cargarFaltas(datobusquedafaltas.value)
        document.getElementById("modaldetallefaltasLabel").innerHTML = 'Ver Detalles de Faltas';
        openModal('#modaldetallefaltas')
    }
    const jsonFields = ref({
        "DNI" : "personal.numero_dni",
        "Apellidos y Nombres": "apenom",
        "Condicion Laboral": "condicion",
        "Cargo": "cargo",
        "Nivel":"nivel",
        "Sueldo":"sueldo",
        "Faltas":"faltas",
        "Sueldo Diario":"sueldo_diario",
        "Descuento":"descuentototal"

    })
    onMounted(()=>{
        listaCondicionesLaborales()
        listaEstablecimientos()
    });

    const buscar=async()=>{
        await cargarFaltasEstablecimiento(dato.value)
    }
    const anhoactual=formatoFecha(null,"YYYY");
    const dato = ref({
        condicion_laboral_id : 0,
        establecimiento_id : '',
        mes : parseInt(formatoFecha(null,"MM")),
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
                                        <th>DNI</th>
                                        <th>Nombre y Apellidos</th>
                                        <th>Condicion Laboral</th>
                                        <th>Cargo</th>
                                        <th>Nivel</th>
                                        <th>Sueldo (S/.)</th>
                                        <th>Faltas</th>
                                        <th>Sueldo Diario</th>
                                        <th>Descuento (S/.)</th>
                                        <th>Accion</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="(registro,index) in faltas" :key="registro.id">
                                        <td class="text-center">{{ index+1 }}</td>
                                        <td>{{ registro.numero_dni }}</td>
                                        <td>{{ registro.apenom }}</td>
                                        <td>{{ registro.condicion }}</td>
                                        <td>{{ registro.cargo }}</td>
                                        <td>{{ registro.nivel }}</td>
                                        <td>{{ registro.sueldo }}</td>
                                        <td>{{ registro.faltas }}</td>
                                        <td>{{ registro.sueldo_diario }}</td>
                                        <td>{{ registro.descuentototal }}</td>
                                        <td><button class="btn btn-info btn-sm" v-if="registro.faltas>0" title="Ver Faltas" @click="verDetalles(registro)"><i class="fa-solid fa-eye"></i></button></td>
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
    <DetallesForm :personal="personal" :faltasdetalle="faltasdetalle"></DetallesForm>
</template>