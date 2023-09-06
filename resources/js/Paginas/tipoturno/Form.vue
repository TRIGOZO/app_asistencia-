<script setup>
import { toRefs, onMounted } from 'vue';
import useTipoTurno from '@/Composables/tipoturno.js';
import useHelper from '@/Helpers';  
const { hideModal, Toast } = useHelper();
const props = defineProps({
    form: Object,
    currentPage : Number
});
const { form, currentPage } = toRefs(props)
const {
    errors, respuesta, agregarTipoTurno, actualizarTipoTurno
} = useTipoTurno();
const  emit  =defineEmits(['onListar'])
const crud = {
    'nuevo': async() => {
        await agregarTipoTurno(form.value)
        form.value.errors = []
        if(errors.value)
        {
            form.value.errors = errors.value
        }
        if(respuesta.value.ok==1){
            form.value.errors = []
            hideModal('#modaltipoturno')
            Toast.fire({icon:'success', title:respuesta.value.mensaje})
            emit('onListar', currentPage.value)
           
        }
    },
    'editar': async() => {
        await actualizarTipoTurno(form.value)
        form.value.errors = []
        if(errors.value)
        {
            form.value.errors = errors.value
        }
        if(respuesta.value.ok==1){
            form.value.errors = []
            hideModal('#modaltipoturno')
            Toast.fire({icon:'success', title:respuesta.value.mensaje})
            emit('onListar', currentPage.value)
        }
    }
}
const guardar = () => {
    crud[form.value.estadoCrud]()
}
</script>
<template>
    <form @submit.prevent="guardar">
    <div class="modal fade" id="modaltipoturno" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="modaltipoturnoLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="modaltipoturnoLabel">Modal title</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col">
                            <div class="card">
                                <div class="card-body">
                                    <div class="mb-3">
                                        <label for="nombre" class="form-label">Nombre </label>
                                        <input type="text" class="form-control" v-model="form.nombre" :class="{ 'is-invalid': form.errors.nombre }">
                                        <small class="text-danger" v-for="error in form.errors.nombre" :key="error">{{ error
                                                }}</small>
                                    </div>
                                    <div class="mb-3">
                                        <label for="diastolerancia" class="form-label">Dias Tolerancia </label>
                                        <input type="number" min="0" class="form-control" v-model="form.diastolerancia" step="1" :class="{ 'is-invalid': form.errors.diastolerancia }">
                                        <small class="text-danger" v-for="error in form.errors.diastolerancia" :key="error">{{ error
                                                }}</small>
                                    </div>
                                    <div class="mb-3">
                                        <label for="descuento" class="form-label">Descuento </label>
                                        <input type="text" class="form-control" v-model="form.descuento" :class="{ 'is-invalid': form.errors.descuento }" placeholder="0.00">
                                        <small class="text-danger" v-for="error in form.errors.descuento" :key="error">{{ error
                                                }}</small>
                                    </div>
                                    <div class="mb-3">
                                        <label for="guardia" class="form-label">Guardia </label>
                                        <select v-model="form.guardia" class="form-control" :class="{ 'is-invalid': form.errors.permiso }">
                                            <option value="">--SELECCIONE--</option>
                                            <option value="0">SI</option>
                                            <option value="1">NO</option>
                                        </select>
                                        <small class="text-danger" v-for="error in form.errors.guardia" :key="error">{{ error
                                                }}</small>
                                    </div>
                                    <div class="mb-3">
                                        <label for="permiso" class="form-label">Permiso </label>
                                        <select v-model="form.permiso" class="form-control" :class="{ 'is-invalid': form.errors.permiso }">
                                            <option value="">--SELECCIONE--</option>
                                            <option value="0">SI</option>
                                            <option value="1">NO</option>
                                        </select>
                                        <small class="text-danger" v-for="error in form.errors.permiso" :key="error">{{ error
                                                }}</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col">
                            <div class="card">
                                <div class="card-body">

                                    <div class="mb-3">
                                        <label for="horasantesdescansa" class="form-label">Hora antes Descansar </label>
                                        <input type="number" min="0" class="form-control" v-model="form.horasantesdescansa" step="1" :class="{ 'is-invalid': form.errors.horasantesdescansa }">
                                        <small class="text-danger" v-for="error in form.errors.horasantesdescansa" :key="error">{{ error
                                                }}</small>
                                    </div>

                                    <div class="mb-3">
                                        <label for="horasdespuesdescansa" class="form-label">Hora despues de Descansar </label>
                                        <input type="number" min="0" class="form-control" v-model="form.horasdespuesdescansa" step="1" :class="{ 'is-invalid': form.errors.horasdespuesdescansa }">
                                        <small class="text-danger" v-for="error in form.errors.horasdespuesdescansa" :key="error">{{ error
                                                }}</small>
                                    </div>
                                    
                                    <div class="mb-3">
                                        <label for="horaasistencial" class="form-label">Hora Asistencial </label>
                                        <input type="number" min="0" class="form-control" v-model="form.horaasistencial" step="1" :class="{ 'is-invalid': form.errors.horaasistencial }">
                                        <small class="text-danger" v-for="error in form.errors.horaasistencial" :key="error">{{ error
                                                }}</small>
                                    </div>

                                    <div class="mb-3">
                                        <label for="horaadministrativo" class="form-label">Hora Administrativo </label>
                                        <input type="number" min="0" class="form-control" v-model="form.horaadministrativo" step="1" :class="{ 'is-invalid': form.errors.horaadministrativo }">
                                        <small class="text-danger" v-for="error in form.errors.horaadministrativo" :key="error">{{ error
                                                }}</small>
                                    </div>
                                    <div class="mb-3">
                                        <label for="nroturnos" class="form-label">Nro de Turnos </label>
                                        <input type="number" min="0" class="form-control" v-model="form.nroturnos" step="1" :class="{ 'is-invalid': form.errors.nroturnos }">
                                        <small class="text-danger" v-for="error in form.errors.nroturnos" :key="error">{{ error
                                                }}</small>
                                    </div>
                                </div>
                            </div>
                        </div>
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