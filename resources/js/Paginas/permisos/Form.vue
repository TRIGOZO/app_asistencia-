<script setup>
import { toRefs, onMounted } from 'vue';
import usePermiso from '@/Composables/permiso.js';
import useTipoPermiso from '@/Composables/tipopermisos.js';
import useEstablecimiento from '@/Composables/establecimientos.js';
import useHelper from '@/Helpers';  
const { hideModal, Toast } = useHelper();
const props = defineProps({
    form: Object,
    usuario: Object,
    currentPage : Number
});
const { form, usuario, currentPage } = toRefs(props)
const {
    errors, respuesta, agregarPermiso, actualizarPermiso
} = usePermiso();
const {
    tipopermisos, listaTipoPermisos
} = useTipoPermiso();
const {
    establecimientos, listaEstablecimientos
} = useEstablecimiento();
const  emit  =defineEmits(['onListar'])
const crud = {
    'nuevo': async() => {
        await agregarPermiso(form.value)
        form.value.errors = []
        if(errors.value)
        {
            form.value.errors = errors.value
        }
        if(respuesta.value.ok==1){
            form.value.errors = []
            hideModal('#modalpermiso')
            Toast.fire({icon:'success', title:respuesta.value.mensaje})
            emit('onListar', currentPage.value)

            
        }
    },
    'editar': async() => {
        await actualizarPermiso(form.value)
        form.value.errors = []
        if(errors.value)
        {
            form.value.errors = errors.value
        }
        if(respuesta.value.ok==1){
            form.value.errors = []
            hideModal('#modalpermiso')
            Toast.fire({icon:'success', title:respuesta.value.mensaje})
            emit('onListar', currentPage.value)
        }
    }
}
onMounted(() => {
    listaTipoPermisos()
    listaEstablecimientos()
})
const guardar = () => {
    crud[form.value.estadoCrud]()
}
</script>
<template>
    <form @submit.prevent="guardar">
    <div class="modal fade" id="modalpermiso" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="modalpermisoLabel" aria-hidden="true">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="modalpermisoLabel">Modal title</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="nombre" class="form-label">Personal </label>
                        <input type="text" class="form-control" v-model="form.nombre" :class="{ 'is-invalid': form.errors.nombre }" readonly>
                        <small class="text-danger" v-for="error in form.errors.nombre" :key="error">{{ error
                                }}</small>
                    </div>
                    <div class="mb-3">
                        <label for="fecha_desde" class="form-label">Fecha Desde</label>
                        <input type="date" class="form-control" v-model="form.fecha_desde" :class="{ 'is-invalid': form.errors.fecha_desde }">
                        <small class="text-danger" v-for="error in form.errors.fecha_desde" :key="error">{{ error
                                }}</small>
                    </div>
                    <div class="mb-3">
                        <label for="hora_inicio" class="form-label">Hora Inicio</label>
                        <input type="time" class="form-control" v-model="form.hora_inicio" :class="{ 'is-invalid': form.errors.hora_inicio }">
                        <small class="text-danger" v-for="error in form.errors.hora_inicio" :key="error">{{ error
                                }}</small>
                    </div>
                    <div class="mb-3">
                        <label for="fecha_hasta" class="form-label">Fecha Hasta</label>
                        <input type="date" class="form-control" v-model="form.fecha_hasta" :class="{ 'is-invalid': form.errors.fecha_hasta }">
                        <small class="text-danger" v-for="error in form.errors.fecha_hasta" :key="error">{{ error
                                }}</small>
                    </div>
                    <div class="mb-3">
                        <label for="hora_hasta" class="form-label">Hora Fin</label>
                        <input type="time" class="form-control" v-model="form.hora_hasta" :class="{ 'is-invalid': form.errors.hora_hasta }">
                        <small class="text-danger" v-for="error in form.errors.hora_hasta" :key="error">{{ error
                                }}</small>
                    </div>
                    <div class="mb-3">
                        <label for="tipo_permiso_id" class="form-label">Tipo Permiso</label>
                        <select v-model="form.tipo_permiso_id" class="form-control" :class="{ 'is-invalid': form.errors.tipo_permiso_id }">
                            <option value="">--Seleccione--</option>
                            <option v-for="tipopermiso in tipopermisos" :key="tipopermiso.id" :value="tipopermiso.id"
                                :title="tipopermiso.nombre">{{ tipopermiso.nombre }}</option>
                        </select>
                        <small class="text-danger" v-for="error in form.errors.tipo_permiso_id" :key="error">{{ error
                                }}</small>
                    </div>
                    <div class="mb-3">
                        <label for="motivo" class="form-label">Motivo</label>
                        <input type="text" class="form-control" v-model="form.motivo" :class="{ 'is-invalid': form.errors.motivo }">
                        <small class="text-danger" v-for="error in form.errors.motivo" :key="error">{{ error
                                }}</small>
                    </div>
                    <div class="mb-3" v-if="usuario.role_id!=2">
                        <label for="establecimiento_id" class="form-label">Establecimiento</label>
                        <select v-model="form.establecimiento_id" class="form-control" :class="{ 'is-invalid': form.errors.establecimiento_id }">
                            <option v-for="establecimiento in establecimientos" :key="establecimiento.id" :value="establecimiento.id"
                                :title="establecimiento.nombre">{{ establecimiento.nombre }}</option>
                        </select>
                        <small class="text-danger" v-for="error in form.errors.establecimiento_id" :key="error">{{ error
                                }}</small>
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