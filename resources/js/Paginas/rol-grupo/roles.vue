<script setup>
    import { toRefs, onMounted } from 'vue';

    const props = defineProps({
        personales: Object,
        tipoturnos: Object
    });
    const { personales } = toRefs(props)


</script>

<template>
    <div class="row">
        <div class="col-md-12 mb-1">
            <div class="table-responsive">         
                <table class="table table-bordered table-hover table-sm table-striped">
                    <thead class="table-dark">
                        <tr>
                            <th class="text-center">#</th>
                            <th>DNI</th>
                            <th>APENOM</th>
                            <th v-for="dia in personales.dias">
                                {{ dia.dia }}<br>
                                <small>{{ dia.nombreDia }}</small>
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(personal, index) in personales.personales" :key="personal.id">
                            <td class="fs-8">{{ index+1 }}</td>
                            <td class="fs-8">{{ personal.numero_dni }}</td>
                            <td class="fs-8">{{ personal.apellido_paterno + ' ' + personal.apellido_materno + ' ' + personal.nombres}}</td>
                            <td v-for="dia in personales.dias" :key="dia.dia">
                                <select name="" id="" class="form-control form-select-sm">
                                    <option value="">-</option>
                                    <option v-for="tt in tipoturnos">{{ tt.abreviatura }}</option>
                                </select>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</template>