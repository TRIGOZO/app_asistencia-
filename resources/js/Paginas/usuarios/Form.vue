<script setup>
import { toRefs, onMounted } from 'vue';
import useUsuario from '@/Composables/usuario.js';
import useRole from '@/Composables/roles.js';
import useEstablecimiento from '@/Composables/establecimientos.js';
import useHelper from '@/Helpers';  
const { hideModal, Toast } = useHelper();
const { form, currentPage } = toRefs(props)
const props = defineProps({
    form: Object,
    currentPage : Number
});
const {
    errors, respuesta, agregarUsuario, actualizarUsuario
} = useUsuario();

const {
    listaEstablecimientos, establecimientos
} = useEstablecimiento();

const {
    listaRoles, roles
} = useRole();

const  emit  =defineEmits(['onListar'])
const crud = {
    'nuevo': async() => {
        await agregarUsuario(form.value)
        form.value.errors = []
        if(errors.value)
        {
            form.value.errors = errors.value
        }
        if(respuesta.value.ok==1){
            form.value.errors = []
            hideModal('#modalusuario')
            Toast.fire({icon:'success', title:respuesta.value.mensaje})
            emit('onListar', currentPage.value)
        }
    },
    'editar': async() => {
        await actualizarUsuario(form.value)
        form.value.errors = []
        if(errors.value)
        {
            form.value.errors = errors.value
        }
        if(respuesta.value.ok==1){
            form.value.errors = []
            hideModal('#modalusuario')
            Toast.fire({icon:'success', title:respuesta.value.mensaje})
            emit('onListar', currentPage.value)
        }
    }
}
const guardar = () => {
    crud[form.value.estadoCrud]()
}
onMounted(() => {
    listaRoles()
    listaEstablecimientos()
})
</script>
<template>
    <form @submit.prevent="guardar">
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
                            <div class="card">
                                <div class="card-body">
                                    <h6 class="card-subtitle mb-2 text-muted">Datos de Usuario</h6>
                                    <div class="mb-3">
                                        <label for="name" class="form-label">Name</label>
                                        <input type="text" class="form-control" v-model="form.username" :class="{ 'is-invalid': form.errors.username }" placeholder="User Name">
                                        <small class="text-danger" v-for="error in form.errors.username" :key="error">{{ error
                                                }}</small>
                                    </div>
                                    <div class="mb-3">
                                        <label for="name" class="form-label">Rol</label>
                                        <select v-model="form.role_id" class="form-control"
                                            :class="{ 'is-invalid': form.errors.role_id }">
                                            <option value="">--Seleccione--</option>
                                            <option v-for="role in roles" :key="role.id" :value="role.id"
                                                :title="role.nombre">
                                                {{ role.nombre }}
                                            </option>
                                        </select>
                                        <small class="text-danger" v-for="error in form.errors.role_id" :key="error">{{ error
                                                }}</small>
                                    </div>  
                                    <div class="mb-3">
                                        <label for="name" class="form-label">Establecimiento</label>
                                        <select v-model="form.establecimiento_id" class="form-control"
                                            :class="{ 'is-invalid': form.errors.establecimiento_id }">
                                            <option value="">--Seleccione--</option>
                                            <option v-for="establecimiento in establecimientos" :key="establecimiento.id" :value="establecimiento.id"
                                                :title="establecimiento.nombre">
                                                {{ establecimiento.nombre }}
                                            </option>
                                        </select>
                                        <small class="text-danger" v-for="error in form.errors.establecimiento_id" :key="error">{{ error
                                                }}</small>
                                    </div>                            
                   
                                </div>
                            </div>
                        </div>
                        <div class="col">
                            <div class="card">
                                <div class="card-body">
                                    <h6 class="card-subtitle mb-2 text-muted">Datos Personales</h6>
                                    <div class="mb-3">
                                        <label for="nombres" class="form-label">Nombres</label>
                                        <input type="text" class="form-control" v-model="form.nombres" :class="{ 'is-invalid': form.errors.nombres }" placeholder="Nombres">
                                        <small class="text-danger" v-for="error in form.errors.nombres" :key="error">{{ error
                                                }}</small>
                                    </div>
                                    <div class="mb-3">
                                        <label for="apellido_paterno" class="form-label">Apellido Paterno</label>
                                        <input type="text" class="form-control" v-model="form.apellido_paterno" :class="{ 'is-invalid': form.errors.apellido_paterno }" placeholder="Apellido Paterno">
                                        <small class="text-danger" v-for="error in form.errors.apellido_paterno" :key="error">{{ error
                                                }}</small>
                                    </div>                            
                                    <div class="mb-3">
                                        <label for="apellido_materno" class="form-label">Apellido Materno</label>
                                        <input type="text" class="form-control" v-model="form.apellido_materno" :class="{ 'is-invalid': form.errors.apellido_materno }" placeholder="Apellido Materno">
                                        <small class="text-danger" v-for="error in form.errors.apellido_materno" :key="error">{{ error
                                                }}</small>
                                    </div>
                                    <div class="mb-3">
                                        <label for="numero_dni" class="form-label">DNI</label>
                                        <input type="text" class="form-control" v-model="form.numero_dni" :class="{ 'is-invalid': form.errors.numero_dni }" placeholder="dni">
                                        <small class="text-danger" v-for="error in form.errors.numero_dni" :key="error">{{ error
                                                }}</small>
                                    </div>
                                    <div class="mb-3">
                                        <label for="sexo" class="form-label">Sexo</label>
                                        <select v-model="form.sexo" class="form-control" :class="{ 'is-invalid': form.errors.sexo }">
                                            <option value="M">Masculino</option>
                                            <option value="F">Femenino</option>
                                        </select>
                                        <small class="text-danger" v-for="error in form.errors.sexo" :key="error">{{ error
                                                }}</small>
                                    </div>
                                    <div class="mb-3">
                                        <label for="celular" class="form-label">Celular</label>
                                        <input type="text" class="form-control" v-model="form.celular" :class="{ 'is-invalid': form.errors.celular }" placeholder="999999999">
                                        <small class="text-danger" v-for="error in form.errors.celular" :key="error">{{ error
                                                }}</small>
                                    </div>
                                    <div class="mb-3">
                                        <label for="email" class="form-label">Email</label>
                                        <input type="text" class="form-control" v-model="form.email" :class="{ 'is-invalid': form.errors.email }" placeholder="Email">
                                        <small class="text-danger" v-for="error in form.errors.email" :key="error">{{ error
                                                }}</small>
                                    </div> 
                                    <div class="mb-3">
                                        <label for="direccion" class="form-label">Direccion</label>
                                        <input type="text" class="form-control" v-model="form.direccion" :class="{ 'is-invalid': form.errors.direccion }" placeholder="Direccion">
                                        <small class="text-danger" v-for="error in form.errors.direccion" :key="error">{{ error
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