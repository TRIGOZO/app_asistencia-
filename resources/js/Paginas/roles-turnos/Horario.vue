<script setup>
import { toRefs, onMounted } from 'vue';
    const props = defineProps({
        horario: Object,
    });
    const { horario } = toRefs(props)
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
                                        <th>Fecha</th>
                                        <th>Hora de Entrada</th>
                                        <th>Hora de Salida</th>
                                        <th>total_horas</th>
                                        <th>Accion</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="registro in horario" :key="registro.id">
                                        <td class="text-center">{{ registro.nro }}</td>
                                        <td>{{ registro.fecha }}</td>
                                        <td>{{ registro.hora_entrada }}</td>
                                        <td>{{ registro.hora_salida }}</td>
                                        <td>{{ registro.total_horas }}</td>
                                        <td>

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