<script setup>
import { toRefs, onMounted } from 'vue';
import usePerfil from '@/Composables/perfil'
import useHelper from '@/Helpers';
const { form } = toRefs(props)
const  emit  =defineEmits(['cargardatos'])
const {cambiarClave, errors, respuesta} = usePerfil()
const {Toast, hideModal} = useHelper()
const props = defineProps({
    form: Object
});
onMounted(() => {
    //obtenerlistas()
})

const guardarClave = async () => {
    await cambiarClave(form.value)
    form.value.errors = []
    if (errors.value) {
        form.value.errors = errors.value
    }
    if (respuesta.value.ok == 1) {
        form.value.errors = []
        Toast.fire({ icon: 'success', title: respuesta.value.mensaje })
        hideModal('#modalupdatepassword')
    }



}
const guardar = () => {
    guardarClave()
}

</script>
<template>
    <div class="modal fade" id="modalupdatepassword" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="modalupdatepasswordLabel" aria-hidden="true">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="modalupdatepasswordLabel">Modal title</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label" for="current_password">Contraseña actual</label>
                        <input class="form-control" v-model="form.current_password" type="password" placeholder="Contraseña actual"
                                :class="{ 'is-invalid': form.errors.current_password }" />
                        <small class="text-danger" v-if="form.errors.current_password">{{ form.errors.current_password[0] }}</small>
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="password">Nueva Contraseña</label>
                        <input class="form-control" v-model="form.password" type="password" placeholder="Nueva Contraseña"
                                :class="{ 'is-invalid': form.errors.password }" />
                        <small class="text-danger" v-if="form.errors.password">{{ form.errors.password[0] }}</small>
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="confirmar_clave">Confirmar Contraseña</label>
                        <input class="form-control" v-model="form.password_confirmation" type="password" placeholder="Confirmar Contraseña"
                                :class="{ 'is-invalid': form.errors.password_confirmation }" />
                        <small class="text-danger" v-if="form.errors.password_confirmation">{{ form.errors.password_confirmation[0] }}</small>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" @click="guardar()">Guardar</button>
                </div>
            </div>
        </div>
    </div>
</template>
