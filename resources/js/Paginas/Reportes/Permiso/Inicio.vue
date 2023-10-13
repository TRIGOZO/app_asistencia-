<script setup>
  import jwt_decode from 'jwt-decode'
  import { ref, onMounted } from 'vue';
  import { defineTitle } from '@/Helpers';
  import useHelper from '@/Helpers';  
  import useCondicionLaboral from '@/Composables/condicionlaboral.js';
  import ContentHeader from '@/Componentes/ContentHeader.vue';

  const { openModal, Toast, Swal, formatoFecha, meses } = useHelper();
  const {
    listaCondicionesLaborales, condicioneslaborales
    } = useCondicionLaboral();
    const titleHeader = ref({
      titulo: "Permiso",
      subTitulo: "Reportes",
      icon: "",
      vista: ""
    });
onMounted(()=>{
    listaCondicionesLaborales()
});

    const dato = ref({
        condicionLaboral : '',
        mes : '',
        tipoPermiso : '',
        anho : '',
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
                <div class="row">
                    <div class="col-md-3">
                        <div class="input-group">
                            <div class="input-group mb-1">
                                <span class="input-group-text" id="basic-addon1">Condicion Laboral</span>
                                <select v-model="dato.condicionLaboral" class="form-control"
                                                    :class="{ 'is-invalid': dato.errors.condicionLaboral }">
                                    <option value="">--Seleccione--</option>
                                    <option v-for="condicion in condicioneslaborales" :key="condicion.id" :value="condicion.id"
                                        :title="condicion.nombre">
                                        {{ condicion.nombre }}
                                    </option>
                                </select>
                            </div>
                            <small class="text-danger" v-for="error in dato.errors.condicionLaboral" :key="error">{{ error
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
                </div>
                <div class="row">
                    <div class="col-md-12 mb-1">

                    </div>
                </div>
            </div>
        </div>
        <br><br>

      </div>
    </div>
</template>




