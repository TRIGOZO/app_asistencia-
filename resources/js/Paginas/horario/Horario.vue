<script setup>
import { toRefs, onMounted } from 'vue';
import useHelper from '@/Helpers';
import useHorario from '@/Composables/horario.js';
    const props = defineProps({
        horario: Object,
        form: Object
    });

    const { horario, form } = toRefs(props)

    const { openModal, Toast, Swal } = useHelper();
    const {
        errors, respuesta, eliminarDetHorario
    } = useHorario();

    const eliminar = (id) => {
        Swal.fire({
            title: '¿Estás seguro de Eliminar?',
            text: "Detalle de Horario",
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Si, Eliminalo!'
        }).then((result) => {
            if (result.isConfirmed) {
                elimina(id)
            }
        })
    }
    const  emit  =defineEmits(['onListar'])
    const elimina = async(id) => {
        await eliminarDetHorario(id)
        if(respuesta.value.ok==1){
            Toast.fire({icon:'success', title:respuesta.value.mensaje})
            emit('onListar', form.value.horario)
        }
    }

</script>
<template>
    <br>
        <div class="card card-primary card-outline">
            <div class="card-header">
                <h6 class="card-title">
                    HORARIO
                </h6>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12 mb-1">
                        <div class="table-responsive">         
                            <table class="table table-bordered table-hover table-sm table-striped">
                                <thead class="table-dark">
                                    <tr>
                                        <th class="text-center">#</th>
                                        <th>Dia</th>
                                        <th>Fecha</th>
                                        <th>Hora de Entrada</th>
                                        <th>Hora de Salida</th>
                                        <th>total_horas</th>
                                        <th>Turno</th>
                                        <th>Accion</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="(registro,index) in horario" :key="registro.id">
                                        <td class="text-center">{{ index+1 }}</td>
                                        <td>{{ registro.nombredia }}</td>
                                        <td>{{ registro.fecha }}</td>
                                        <td>{{ registro.hora_entrada }}</td>
                                        <td>{{ registro.hora_salida }}</td>
                                        <td>{{ registro.total_horas }}</td>
                                        <td>{{ registro.turno_horario.tipo_turno.abreviatura }}</td>
                                        <td>
                                            <button class="btn btn-danger btn-sm" title="Eliminar Registro" @click.prevent="eliminar(registro.id)">
                                                <i class="fas fa-trash"></i>
                                            </button>&nbsp;
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>


            </div>
        </div>
</template>