<script setup>
import { toRefs, onMounted } from 'vue';
import usePersonal from '@/Composables/personal.js';
import useTipoTrabajador from '@/Composables/tipotrabajador.js';
import useEstablecimiento from '@/Composables/establecimientos.js';
import useProfesion from '@/Composables/profesiones.js';
import useCondicionLaboral from '@/Composables/condicionlaboral.js';
import useCargo from '@/Composables/cargos.js';
import useNivel from '@/Composables/niveles.js';
import useHelper from '@/Helpers';  
const { hideModal, Toast } = useHelper();
const props = defineProps({
    form: Object,
    currentPage : Number
});
const { form, currentPage } = toRefs(props)

const {
    errors, respuesta, agregarPersonal, actualizarPersonal, estadosciviles,
    listaEstadosCiviles
} = usePersonal();

const {
    listaProfesiones, profesiones
} = useProfesion();

const {
    listaNiveles, niveles
} = useNivel();

const {
    listaCargos, cargos
} = useCargo();


const {
    listaCondicionesLaborales, condicioneslaborales
} = useCondicionLaboral();

const {
    listaEstablecimientos, establecimientos
} = useEstablecimiento();

const {
    tipotrabajadores, listaTipoTrabajadores
} = useTipoTrabajador();

const  emit  =defineEmits(['onListar'])
const crud = {
    'nuevo': async() => {
        await agregarPersonal(form.value)
        form.value.errors = []
        if(errors.value)
        {
            form.value.errors = errors.value
        }
        if(respuesta.value.ok==1){
            form.value.errors = []
            hideModal('#modalpersonal')
            Toast.fire({icon:'success', title:respuesta.value.mensaje})
            emit('onListar', currentPage.value)
        }
    },
    'editar': async() => {
        await actualizarPersonal(form.value)
        form.value.errors = []
        if(errors.value)
        {
            form.value.errors = errors.value
        }
        if(respuesta.value.ok==1){
            form.value.errors = []
            hideModal('#modalpersonal')
            Toast.fire({icon:'success', title:respuesta.value.mensaje})
            emit('onListar', currentPage.value)
        }
    }
}
const guardar = () => {
    crud[form.value.estadoCrud]()
}
onMounted(() => {
    listaEstadosCiviles()
    listaEstablecimientos()
    listaTipoTrabajadores()
    listaProfesiones()
    listaCondicionesLaborales()
    listaNiveles()
    listaCargos()
})

</script>
<template>
    <form @submit.prevent="guardar">
    <div class="modal fade" id="modalpersonal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="modalpersonalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="modalpersonalLabel">Modal title</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col">
                            <div class="card">
                                <div class="card-body">
                                    <h6 class="card-subtitle mb-2 text-muted">Datos Personales</h6>
                                    <div class="mb-3">
                                        <label for="numero_dni" class="form-label">Nro Documento</label>
                                        <input type="text" class="form-control" v-model="form.numero_dni" :class="{ 'is-invalid': form.errors.numero_dni }" placeholder="Nro de Documento">
                                        <small class="text-danger" v-for="error in form.errors.numero_dni" :key="error">{{ error
                                                }}</small>
                                    </div>                        
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
                                        <label for="sexo" class="form-label">Sexo</label>
                                        <select v-model="form.sexo" class="form-control" :class="{ 'is-invalid': form.errors.sexo }">
                                            <option value="M">Masculino</option>
                                            <option value="F">Femenino</option>
                                        </select>
                                        <small class="text-danger" v-for="error in form.errors.sexo" :key="error">{{ error
                                                }}</small>
                                    </div>
                                    <div class="mb-3">
                                        <label for="estado_civil_id" class="form-label">Estado Civil</label>
                                        <select v-model="form.estado_civil_id" class="form-control" :class="{ 'is-invalid': form.errors.estado_civil_id }">
                                            <option value="">--Seleccione--</option>
                                            <option v-for="estadocivil in estadosciviles" :key="estadocivil.id" :value="estadocivil.id">
                                                {{ estadocivil.nombre }}
                                            </option>
                                        </select>
                                        <small class="text-danger" v-for="error in form.errors.estado_civil_id" :key="error">{{ error
                                                }}</small>
                                    </div>
                                    <div class="mb-3">
                                        <label for="telefono" class="form-label">Telefono</label>
                                        <input type="text" class="form-control" v-model="form.telefono" :class="{ 'is-invalid': form.errors.telefono }" placeholder="999999999">
                                        <small class="text-danger" v-for="error in form.errors.telefono" :key="error">{{ error
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
                                        <label for="fecha_nacimiento" class="form-label">Fecha Nacimiento</label>
                                        <input type="date" class="form-control" v-model="form.fecha_nacimiento" :class="{ 'is-invalid': form.errors.fecha_nacimiento }">
                                        <small class="text-danger" v-for="error in form.errors.fecha_nacimiento" :key="error">{{ error
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
                        <div class="col">
                            <div class="card">
                                <div class="card-body">
                                    <h6 class="card-subtitle mb-2 text-muted">Datos Empleado</h6>
                                    <div class="mb-3">
                                        <label for="tipo_trabajador_id" class="form-label">Tipo de Trabajador</label>
                                        <select v-model="form.tipo_trabajador_id" class="form-control" :class="{ 'is-invalid': form.errors.tipo_trabajador_id }">
                                            <option value="">--Seleccione--</option>
                                            <option v-for="tipotrabajador in tipotrabajadores" :key="tipotrabajador.id" :value="tipotrabajador.id">
                                                {{ tipotrabajador.nombre }}
                                            </option>
                                        </select>
                                        <small class="text-danger" v-for="error in form.errors.tipo_trabajador_id" :key="error">{{ error
                                                }}</small>
                                    </div>
                                    <div class="mb-3">
                                        <label for="cargo_id" class="form-label">Cargo</label>
                                        <select v-model="form.cargo_id" class="form-control" :class="{ 'is-invalid': form.errors.cargo_id }">
                                            <option value="">--Seleccione--</option>
                                            <option v-for="cargo in cargos" :key="cargo.id" :value="cargo.id">
                                                {{ cargo.nombre }}
                                            </option>
                                        </select>
                                        <small class="text-danger" v-for="error in form.errors.cargo_id" :key="error">{{ error
                                                }}</small>
                                    </div>                                    
                                    <div class="mb-3">
                                        <label for="tienehijos">TIENE HIJOS</label>
                                        <select v-model="form.tienehijos" class="form-control" :class="{ 'is-invalid': form.errors.tienehijos }">
                                            <option value="">--SELECCIONE--</option>
                                            <option value="SI">SI</option>
                                            <option value="NO">NO</option>
                                        </select>
                                        <small class="text-danger" v-for="error in form.errors.tienehijos" :key="error">{{ error
                                                }}</small>
                                    </div>
                                    <div class="mb-3">
                                        <label for="profesion_id" class="form-label">Profesion</label>
                                        <select v-model="form.profesion_id" class="form-control" :class="{ 'is-invalid': form.errors.profesion_id }">
                                            <option value="">--Seleccione--</option>
                                            <option v-for="profesion in profesiones" :key="profesion.id" :value="profesion.id">
                                                {{ profesion.nombre }}
                                            </option>
                                        </select>
                                        <small class="text-danger" v-for="error in form.errors.profesion_id" :key="error">{{ error
                                                }}</small>
                                    </div>                         
                                    <div class="mb-3">
                                        <label for="nivel_id" class="form-label">Nivel</label>
                                        <input type="text" class="form-control" v-model="form.nivel_id" :class="{ 'is-invalid': form.errors.nivel_id }" placeholder="AAA">
                                        <small class="text-danger" v-for="error in form.errors.nivel_id" :key="error">{{ error
                                                }}</small>
                                    </div>
                                    <div class="mb-3">
                                        <label for="sueldo" class="form-label">Sueldo</label>
                                        <input type="text" class="form-control" v-model="form.sueldo" :class="{ 'is-invalid': form.errors.sueldo }" placeholder="999999999">
                                        <small class="text-danger" v-for="error in form.errors.sueldo" :key="error">{{ error
                                                }}</small>
                                    </div>
                                    <div class="mb-3">
                                        <label for="condicion_laboral_id" class="form-label">Condicion Laboral</label>
                                        <select v-model="form.condicion_laboral_id" class="form-control" :class="{ 'is-invalid': form.errors.condicion_laboral_id }">
                                            <option value="">--Seleccione--</option>
                                            <option v-for="condicionlaboral in condicioneslaborales" :key="condicionlaboral.id" :value="condicionlaboral.id">
                                                {{ condicionlaboral.nombre }}
                                            </option>
                                        </select>
                                        <small class="text-danger" v-for="error in form.errors.condicion_laboral_id" :key="error">{{ error
                                                }}</small>
                                    </div>
                                    <div class="mb-3">
                                        <label for="fecha_inicio" class="form-label">Fecha de Inicio</label>
                                        <input type="date" class="form-control" v-model="form.fecha_inicio" :class="{ 'is-invalid': form.errors.fecha_inicio }" placeholder="999999999">
                                        <small class="text-danger" v-for="error in form.errors.fecha_inicio" :key="error">{{ error
                                                }}</small>
                                    </div>
                                    <div class="mb-3">
                                        <label for="fecha_fin" class="form-label">Fecha de Fin</label>
                                        <input type="date" class="form-control" v-model="form.fecha_fin" :class="{ 'is-invalid': form.errors.fecha_fin }" placeholder="999999999">
                                        <small class="text-danger" v-for="error in form.errors.fecha_fin" :key="error">{{ error
                                                }}</small>
                                    </div>
                                    <div class="mb-3">
                                        <label for="establecimiento_id" class="form-label">Establecimiento</label>
                                        <select v-model="form.establecimiento_id" class="form-control" :class="{ 'is-invalid': form.errors.establecimiento_id }">
                                            <option value="">--Seleccione--</option>
                                            <option v-for="establecimiento in establecimientos" :key="establecimiento.id" :value="establecimiento.id">
                                                {{ establecimiento.nombre }}
                                            </option>
                                        </select>
                                        <small class="text-danger" v-for="error in form.errors.establecimiento_id" :key="error">{{ error
                                                }}</small>
                                    </div>
                                    <div class="mb-3">
                                        <label for="observacion" class="form-label">Observacion</label>
                                        <textarea v-model="form.observacion" class="form-control" :class="{ 'is-invalid': form.errors.observacion }"></textarea>
                                        <small class="text-danger" v-for="error in form.errors.observacion" :key="error">{{ error }}</small>
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