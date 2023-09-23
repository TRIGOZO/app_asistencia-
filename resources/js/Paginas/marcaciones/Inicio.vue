<script setup>

  import { ref, onMounted } from 'vue';
  import { defineTitle } from '@/Helpers';
  import useHelper from '@/Helpers'; 
  import useMarcacion from '@/Composables/marcacion.js';
  import useEstablecimiento from '@/Composables/establecimientos.js';
  import ContentHeader from '@/Componentes/ContentHeader.vue';
  const { openModal, Toast, Swal, formatoFecha, meses } = useHelper();
  const {
        errors,
        cargarMarcacionHorario, marcacionesHorarios,
        respuesta
    } = useMarcacion();

    const titleHeader = ref({
      titulo: "Marcaciones",
      subTitulo: "Inicio",
      icon: "",
      vista: ""
    });

    const cargar = async() => {
        await cargarMarcacionHorario(dato.value)
        dato.value.errors = []
        if(errors.value)
        {
            dato.value.errors = errors.value
        }
    }
    
    const dato = ref({
        dni:'',
        mes: parseInt(formatoFecha(null,"MM")),
        errors:[]
    });
    const descuentoMinutos = (tiempo)=>{

    const [horas, minutos, segundos] = tiempo.split(":");

    const totalSegundos = Math.abs((parseInt(horas)*3600)) + (parseInt(minutos) * 60) + parseInt(segundos);

    const valor = totalSegundos;
    const minutosAbsolutos = Math.floor(valor / 60);

    return minutosAbsolutos;

    }

    const buscar = () => {
        //listarPersonales()
    }
    onMounted(() => {
        defineTitle(titleHeader.value.titulo)
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
                        <button class="btn btn-primary" @click="cargar">
                            Cargar
                        </button>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="table-responsive">         
                            <table class="table table-bordered table-hover table-sm table-striped">
                                <thead class="table-dark">
                                    <tr>
                                        <th colspan="6" class="text-center">Marcaciones</th>
                                        <th colspan="3" class="text-center">Horario</th>
                                    </tr>
                                    <tr>
                                        <th>#</th>
                                        <th>FECHA</th>
                                        <th>DNI</th>
                                        <th>Apenom</th>
                                        <th>Tipo</th>
                                        <th>Hora Marcada</th>
                                        <th>Hora</th>
                                        <th>Diferencia</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="(marcacion, index) in marcacionesHorarios" :key="marcacion.id">
                                        <td>{{ index+1 }}</td>
                                        <td>{{ marcacion.fecha }}</td>
                                        <td>{{ marcacion.numero_dni }}</td>
                                        <td>{{ marcacion.apellido_paterno + ' ' + marcacion.apellido_materno + ' ' + marcacion.nombres }}</td>
                                        <td>{{ marcacion.tipo }}</td>
                                        <td>{{ marcacion.hora_marcada }}</td>
                                        <td>{{ (marcacion.tipo=='Entrada') ? marcacion.hora_entrada : marcacion.hora_salida }}</td>
                                        <td>{{ descuentoMinutos(marcacion.diferencia) + ((marcacion.diferencia<'00:00:00') ? ' Minutos Antes' : ' Minutos Despues') }}</td>
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




