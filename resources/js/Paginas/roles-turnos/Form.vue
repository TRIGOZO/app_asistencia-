<script setup>
import { toRefs, onMounted } from 'vue';
import useHelper from '@/Helpers'; 
import useTipoTurno from '@/Composables/tipoturno.js';
import useHorario from '@/Composables/horario.js';
const { hideModal, Toast, meses } = useHelper();
const props = defineProps({
    form: Object,
    currentPage : Number
});
const { form, currentPage } = toRefs(props)
const {
    errors, respuesta, generarHorario
} = useHorario();
const {
    listaTipoTurnos, tipoturnos
} = useTipoTurno();
const  emit  =defineEmits(['onVerHorario'])

const generar = async() => {
    await generarHorario(form.value)
    form.value.errors = []
    if(errors.value)
    {
        form.value.errors = errors.value
    }
    
    if(respuesta.value.ok==1){
        form.value.errors = []
        hideModal('#modalformlroleturno')
        Toast.fire({icon:'success', title:respuesta.value.mensaje})
        emit('onVerHorario', 1)
    }else{
        console.log(respuesta.value.mensaje)
        Toast.fire({icon:'error', title:respuesta.value.mensaje})
    }

}

onMounted(() => {
    listaTipoTurnos()
})
</script>
<template>
    <form @submit.prevent="generar">
    <div class="modal fade" id="modalformlroleturno" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="modalformlroleturnoLabel" aria-hidden="true">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="modalformlroleturnoLabel">Modal title</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="nombre" class="form-label">Nombre </label>
                        <h4>{{ form.nombres }}</h4>
                    </div>
                    <div class="mb-3">
                        <label for="nombre" class="form-label">Apellidos </label>
                        <h4>{{ form.apellidos }}</h4>
                    </div>
                    <div class="mb-3">
                        <label for="mes" class="form-label">Tipo de Turno </label>
                        <select class="form-control" v-model="form.tipo_turno_id" :class="{ 'is-invalid': form.errors.tipo_turno_id }">
                            <option value="" disabled>Selecciona</option>
                            <option v-for="tipoturno in tipoturnos" :key="tipoturno.id" :value="tipoturno.id">{{ tipoturno.nombre }}</option>
                        </select>
                        <small class="text-danger" v-for="error in form.errors.tipo_turno_id" :key="error">{{ error
                                }}</small>
                    </div>
                     <div class="mb-3">
                        <label for="mes" class="form-label">Fecha Desde </label>
                        <input type="text" class="form-control" v-model="form.fecha_desde" :class="{ 'is-invalid': form.errors.fecha_desde }">
                        <small class="text-danger" v-for="error in form.errors.fecha_desde" :key="error">{{ error
                                }}</small>
                    </div> 
                     <div class="mb-3">
                        <label for="mes" class="form-label">Fecha Hasta </label>
                        <input type="text" class="form-control" v-model="form.fecha_hasta" :class="{ 'is-invalid': form.errors.fecha_hasta }">
                        <small class="text-danger" v-for="error in form.errors.fecha_hasta" :key="error">{{ error
                                }}</small>
                    </div>
                     <div class="mb-3">
                        <label for="mes" class="form-label">Es Lactancia </label>
                        <div class="form-check">
                          <input class="form-check-input" type="checkbox" v-model="form.es_lactancia" id="es_lactancia">
                          <label class="form-check-label" for="es_lactancia">SI</label>
                        </div>
                        <small class="text-danger" v-for="error in form.errors.fecha_hasta" :key="error">{{ error
                                }}</small>
                    </div>                                                                    
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Generar <i class="fa-solid fa-arrow-down"></i></button>
                </div>
            </div>
        </div>
    </div>
    </form>
</template>