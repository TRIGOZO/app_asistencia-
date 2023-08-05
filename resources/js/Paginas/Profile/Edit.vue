<script setup>
import { toRefs, onMounted } from 'vue';
import useProfesion from '@/Composables/profesiones'
import usePersonal from '@/Composables/personal'
import usePerfil from '@/Composables/perfil'
import useHelper from '@/Helpers';
const { Toast, hideModal } = useHelper();
const { profesiones, listaProfesiones } = useProfesion();
const { estadosciviles, listaEstadosCiviles } = usePersonal();
const { errors, respuesta, actualizarPerfil } = usePerfil();
const { form } = toRefs(props)
const  emit  =defineEmits(['cargardatos'])
const props = defineProps({
    form: Object
});
onMounted(() => {
    obtenerlistas()
})

const obtenerlistas = async () => {
    listaEstadosCiviles()
    listaProfesiones()
}
const guardarPerfil = async () => {
    await actualizarPerfil(form.value)
    form.value.errors = []
    if (errors.value) {
        form.value.errors = errors.value
    }
    if (respuesta.value.ok == 1) {
        form.value.errors = []
        Toast.fire({ icon: 'success', title: respuesta.value.mensaje })
        hideModal('#modalusuario')
        emit('cargardatos')
    }
}
const guardarcambios = () => {
    guardarPerfil()
}

</script>
<template>
    <!-- Modal -->
    <div class="modal fade" id="modalusuario" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="modalusuarioLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="modalusuarioLabel">Modal title</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col">
                            <div class="mb-3">
                                <label class="form-label" for="username">Nombre de Usuario</label>
                                <input type="hidden" v-model="form.user_id">
                                <input class="form-control" type="text" placeholder="Name" v-model="form.username"
                                    :class="{ 'is-invalid': form.errors.username }" />
                                <small class="text-danger" v-for="error in form.errors.username" :key="error">{{ error
                                }}</small>
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="nombres">Nombres</label>
                                <input class="form-control" v-model="form.nombres" type="text" placeholder="Nombres"
                                    :class="{ 'is-invalid': form.errors.nombres }" />
                                <small class="text-danger" v-if="form.errors.nombres">{{ form.errors.nombres[0] }}</small>
                            </div>

                            <div class="mb-3">
                                <label class="form-label" for="apellido_paterno">Apellido Paterno</label>
                                <input class="form-control" v-model="form.apellido_paterno" type="text"
                                    placeholder="Paterno" :class="{ 'is-invalid': form.errors.apellido_paterno }" />
                                <small class="text-danger" v-if="form.errors.apellido_paterno">{{
                                    form.errors.apellido_paterno[0] }}</small>
                            </div>

                            <div class="mb-3">
                                <label class="form-label" for="apellido_materno">Apellido Materno</label>
                                <input class="form-control" v-model="form.apellido_materno" type="text"
                                    placeholder="Materno" :class="{ 'is-invalid': form.errors.apellido_materno }" />
                                <small class="text-danger" v-if="form.errors.apellido_materno">{{
                                    form.errors.apellido_materno[0] }}</small>
                            </div>

                            <div class="mb-3">
                                <label class="form-label" for="sexo">Sexo</label>
                                <select v-model="form.sexo" class="form-control"
                                    :class="{ 'is-invalid': form.errors.sexo }">
                                    <option value="M">Masculino</option>
                                    <option value="F">Femenino</option>
                                </select>
                                <small class="text-danger" v-if="form.errors.sexo">{{ form.errors.sexo[0] }}</small>
                            </div>

                            <div class="mb-3">
                                <label class="form-label" for="fecha_nacimiento">Fecha de Nacimiento</label>
                                <input class="form-control" v-model="form.fecha_nacimiento" type="date"
                                    :class="{ 'is-invalid': form.errors.fecha_nacimiento }" />
                                <small class="text-danger" v-if="form.errors.fecha_nacimiento">{{
                                    form.errors.fecha_nacimiento[0] }}</small>
                            </div>
                        </div>
                        <div class="col">
                            <div class="mb-3">
                                <label class="form-label" for="telefono">Teléfono</label>
                                <input class="form-control" v-model="form.telefono" type="tel" placeholder="Teléfono"
                                    :class="{ 'is-invalid': form.errors.telefono }" />
                                <small class="text-danger" v-if="form.errors.telefono">{{ form.errors.telefono[0] }}</small>
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="celular">Celular</label>
                                <input class="form-control" v-model="form.celular" type="tel" placeholder="Celular"
                                    :class="{ 'is-invalid': form.errors.celular }" />
                                <small class="text-danger" v-for="error in form.errors.celular" :key="error">{{ error
                                }}</small>
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="email">Email</label>
                                <input class="form-control" v-model="form.email" type="email" placeholder="Email"
                                    :class="{ 'is-invalid': form.errors.email }" />
                                <small class="text-danger" v-if="form.errors.email">{{ form.errors.email[0] }}</small>
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="tienehijos">¿Tiene hijos?</label>
                                <select v-model="form.tienehijos" class="form-control"
                                    :class="{ 'is-invalid': form.errors.tienehijos }">
                                    <option value="SI">SI</option>
                                    <option value="NO">NO</option>
                                </select>
                                <small class="text-danger" v-if="form.errors.tienehijos">{{ form.errors.tienehijos[0]
                                }}</small>
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="profesion_id">Profesión</label>
                                <select v-model="form.profesion_id" class="form-control"
                                    :class="{ 'is-invalid': form.errors.profesion_id }">
                                    <option v-for="profesion in profesiones" :key="profesion.id" :value="profesion.id"
                                        :title="profesion.nombre">
                                        {{ profesion.nombre }}
                                    </option>
                                </select>
                                <small class="text-danger" v-for="error in form.errors.profesion_id" :key="error">{{ error
                                }}</small>
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="estado_civil_id">Estado Civil</label>
                                <select v-model="form.estado_civil_id" class="form-control">
                                    <option v-for="estado_civil in estadosciviles" :key="estado_civil.id"
                                        :value="estado_civil.id" :title="estado_civil.nombre">
                                        {{ estado_civil.nombre }}
                                    </option>
                            </select>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="direccion">Direccion</label>
                        <input class="form-control" v-model="form.direccion" type="text" placeholder="Direccion" />
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" @click="guardarcambios()">Guardar</button>
            </div>
        </div>
    </div>
</div></template>
