<script setup>
import { toRefs, onMounted } from 'vue';
    const props = defineProps({
        horario: Object,
        form: Object
    });
    const { horario, form } = toRefs(props)
</script>
<template>
    <br>
        <div class="card card-primary card-outline">
            <div class="card-header">
                <h6 class="card-title">
                    HORARIO GENERADO : {{ form.nombres + ' ' +form.apellidos }}
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
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="(registro, index) in horario" :key="registro.id">
                                        <td class="text-center">{{ index+1 }}</td>
                                        <td>{{ registro.nombredia }}</td>
                                        <td>{{ registro.fecha }}</td>
                                        <td>{{ registro.hora_entrada }}</td>
                                        <td>{{ registro.hora_salida }}</td>
                                        <td>{{ registro.total_horas }}</td>
                                        <td>{{ registro.turno_horario.tipo_turno.abreviatura }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>


            </div>
        </div>
</template>