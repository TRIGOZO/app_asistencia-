<script setup>
import { toRefs, onMounted } from 'vue';
import useCargo from '@/Composables/cargos.js';
import useHelper from '@/Helpers'; 
import useTipoTurno from '@/Composables/tipoturno.js';
const { hideModal, Toast, meses } = useHelper();
const props = defineProps({
    form: Object,
    currentPage : Number
});
const { form, currentPage } = toRefs(props)
const {
    errors, respuesta, agregarCargo, actualizarCargo
} = useCargo();
const {
    listaTipoTurnos, tipoturnos
} = useTipoTurno();
const  emit  =defineEmits(['onListar'])
const crud = {
    'nuevo': async() => {
        await agregarCargo(form.value)
        form.value.errors = []
        if(errors.value)
        {
            form.value.errors = errors.value
        }
        if(respuesta.value.ok==1){
            form.value.errors = []
            hideModal('#modalformlroleturno')
            Toast.fire({icon:'success', title:respuesta.value.mensaje})
            emit('onListar', currentPage.value)

            
        }
    },
    'editar': async() => {
        await actualizarCargo(form.value)
        form.value.errors = []
        if(errors.value)
        {
            form.value.errors = errors.value
        }
        if(respuesta.value.ok==1){
            form.value.errors = []
            hideModal('#modalformlroleturno')
            Toast.fire({icon:'success', title:respuesta.value.mensaje})
            emit('onListar', currentPage.value)
        }
    }
}
const guardar = () => {
    crud[form.value.estadoCrud]()
}

onMounted(() => {
    listaTipoTurnos()
})
</script>
<template>
    <form @submit.prevent="guardar">
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
                        <input type="text" class="form-control" v-model="form.nombre" :class="{ 'is-invalid': form.errors.nombre }">
                        <small class="text-danger" v-for="error in form.errors.nombre" :key="error">{{ error
                                }}</small>
                    </div>
                    <div class="mb-3">
                        <label for="mes" class="form-label">Mes </label>
                        <select class="form-control" v-model="form.mes">
                            <option value="" disabled>Selecciona un mes</option>
                            <option v-for="mes in meses" :key="mes.numero" :value="mes.numero">{{ mes.nombre }} - {{ mes.numero }}</option>
                        </select>
                        <small class="text-danger" v-for="error in form.errors.nombre" :key="error">{{ error
                                }}</small>
                    </div>
                    <div class="mb-3">
                        <label for="mes" class="form-label">Tipo de Turno </label>
                        <select class="form-control" v-model="form.tipo_turno_id">
                            <option value="" disabled>Selecciona</option>
                            <option v-for="tipoturno in tipoturnos" :key="tipoturno.numero" :value="tipoturno.id">{{ tipoturno.nombre }}</option>
                        </select>
                    </div>
                     <div class="mb-3">
                        <label for="mes" class="form-label">Fecha Desde </label>

                    </div>                                 
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">{{ (form.estadoCrud=='nuevo') ? 'Guardar' : 'Actualizar' }}</button>
                </div>
            </div>
        </div>
    </div>
    </form>
</template>