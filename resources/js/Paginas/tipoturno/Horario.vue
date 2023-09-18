<script setup>
import { toRefs, onMounted, ref } from 'vue';
import useHorarioTurno from '@/Composables/horarioturno.js';
import useHelper from '@/Helpers';  
const { hideModal, Toast } = useHelper();
const props = defineProps({
    form: Object,
    currentPage : Number
});
const { form, currentPage } = toRefs(props)
const {
    errors, respuesta, agregarHorario, actualizarHorario
} = useHorarioTurno();
const  emit  =defineEmits(['onListar'])
const crud = {
    'nuevo': async() => {
        await agregarHorario(form.value)
        form.value.errors = []
        if(errors.value)
        {
            form.value.errors = errors.value
        }
        if(respuesta.value.ok==1){
            form.value.errors = []
            hideModal('#modalhorario')
            Toast.fire({icon:'success', title:respuesta.value.mensaje})
            emit('onListar', currentPage.value)

            
        }
    },
    'editar': async() => {
        await actualizarHorario(form.value)
        form.value.errors = []
        if(errors.value)
        {
            form.value.errors = errors.value
        }
        if(respuesta.value.ok==1){
            form.value.errors = []
            hideModal('#modalhorario')
            Toast.fire({icon:'success', title:respuesta.value.mensaje})
            emit('onListar', currentPage.value)
        }
    }
}

const calcularHoras = ()=>{
    if(form.value.horaentrada!='' && form.value.horasalida!=''){
        const horaInicioArray = form.value.horaentrada.split(':');
        const horaFinArray = form.value.horasalida.split(':');
        
        const inicio = new Date(0, 0, 0, horaInicioArray[0], horaInicioArray[1]);
        const fin = new Date(0, 0, 0, horaFinArray[0], horaFinArray[1]);
        
        const diferencia = new Date(fin - inicio);
        const horas = diferencia.getUTCHours().toString().padStart(2, '0');
        const minutos = diferencia.getUTCMinutes().toString().padStart(2, '0');
        
        let cont = parseInt(form.value.dialunes)+
        parseInt(form.value.diamartes)+
        parseInt(form.value.diamiercoles)+
        parseInt(form.value.diajueves)+
        parseInt(form.value.diaviernes)+
        parseInt(form.value.diasabado)+
        parseInt(form.value.diadomingo);

        const horasMultiplicadas = horas * cont;
        const minutosMultiplicados = minutos * cont;
        
        // Formatear el resultado en el formato deseado
        const horasFormateadas = horasMultiplicadas.toString().padStart(2, '0');
        const minutosFormateados = minutosMultiplicados.toString().padStart(2, '0');
        
        form.value.totalhoras = `${horasMultiplicadas}:${minutosMultiplicados}`;

    }else{
        form.value.totalhoras = '';
    }
}

const guardar = () => {
    crud[form.value.estadoCrud]()
}
</script>
<template>
    <form @submit.prevent="guardar">
    <div class="modal fade" id="modalhorario" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="modalhorarioLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="modalhorarioLabel">Modal title</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <h3>TIPO DE TURNO : {{ form.tipo_turno_nombre }}</h3>
                    <div class="row">
                        <div class="col">
                            <div class="card">
                                <div class="card-body">
                                    <div class="mb-3">
                                        <label for="horaentrada" class="form-label">Hora de Entrada </label>
                                        <input type="time" class="form-control" v-model="form.horaentrada" :class="{ 'is-invalid': form.errors.horaentrada }">
                                        <small class="text-danger" v-for="error in form.errors.horaentrada" :key="error">{{ error
                                                }}</small>
                                    </div>
                                    <div class="mb-3">
                                        <label for="horasalida" class="form-label">Hora de Salida </label>
                                        <input type="time" class="form-control" v-model="form.horasalida" :class="{ 'is-invalid': form.errors.horasalida }">
                                        <small class="text-danger" v-for="error in form.errors.horasalida" :key="error">{{ error
                                                }}</small>
                                    </div>
                                    <div class="mb-3">
                                        <label for="toleranciaantes" class="form-label">Tolerancia Antes </label>
                                        <input type="number" class="form-control" v-model="form.toleranciaantes" :class="{ 'is-invalid': form.errors.toleranciaantes }">
                                        <small class="text-danger" v-for="error in form.errors.toleranciaantes" :key="error">{{ error
                                                }}</small>
                                    </div>
                                    <div class="mb-3">
                                        <label for="toleranciadespues" class="form-label">Tolerancia Despues </label>
                                        <input type="number" class="form-control" v-model="form.toleranciadespues" :class="{ 'is-invalid': form.errors.toleranciadespues }">
                                        <small class="text-danger" v-for="error in form.errors.toleranciadespues" :key="error">{{ error
                                                }}</small>
                                    </div>
                                    <div class="mb-3">
                                        <label for="inicioentrada" class="form-label">Inicio de Entrada </label>
                                        <input type="time" class="form-control" v-model="form.inicioentrada" :class="{ 'is-invalid': form.errors.inicioentrada }">
                                        <small class="text-danger" v-for="error in form.errors.inicioentrada" :key="error">{{ error
                                                }}</small>
                                    </div>                                    
                                    <div class="mb-3">
                                        <label for="iniciosalida" class="form-label">Inicio de Salida </label>
                                        <input type="time" class="form-control" v-model="form.iniciosalida" :class="{ 'is-invalid': form.errors.iniciosalida }">
                                        <small class="text-danger" v-for="error in form.errors.iniciosalida" :key="error">{{ error
                                                }}</small>
                                    </div>  
                                    <div class="mb-3">
                                        <label for="finentrada" class="form-label">Fin de Entrada </label>
                                        <input type="time" class="form-control" v-model="form.finentrada" :class="{ 'is-invalid': form.errors.finentrada }">
                                        <small class="text-danger" v-for="error in form.errors.finentrada" :key="error">{{ error
                                                }}</small>
                                    </div> 
                                    <div class="mb-3">
                                        <label for="finsalida" class="form-label">Fin de Salida </label>
                                        <input type="time" class="form-control" v-model="form.finsalida" :class="{ 'is-invalid': form.errors.finsalida }">
                                        <small class="text-danger" v-for="error in form.errors.finsalida" :key="error">{{ error
                                                }}</small>
                                    </div>  
                                </div>
                            </div>
                        </div>
                        <div class="col">
                            <div class="card">
                                <div class="card-body">
                                    <div class="mb-3">
                                        <label for="dialunes" class="form-label">LUNES </label>
                                        <select v-model="form.dialunes" class="form-control" :class="{ 'is-invalid': form.errors.dialunes }">
                                            <option value="" disabled>--SELECCIONE--</option>
                                            <option value="1">SI</option>
                                            <option value="0">NO</option>
                                        </select>
                                        <small class="text-danger" v-for="error in form.errors.dialunes" :key="error">{{ error
                                                }}</small>
                                    </div>
                                    <div class="mb-3">
                                        <label for="diamartes" class="form-label">MARTES </label>
                                        <select v-model="form.diamartes" class="form-control" :class="{ 'is-invalid': form.errors.diamartes }">
                                            <option value="" disabled>--SELECCIONE--</option>
                                            <option value="1">SI</option>
                                            <option value="0">NO</option>
                                        </select>
                                        <small class="text-danger" v-for="error in form.errors.diamartes" :key="error">{{ error
                                                }}</small>
                                    </div>
                                    <div class="mb-3">
                                        <label for="diamiercoles" class="form-label">MIERCOLES </label>
                                        <select v-model="form.diamiercoles" class="form-control" :class="{ 'is-invalid': form.errors.diamiercoles }">
                                            <option value="" disabled>--SELECCIONE--</option>
                                            <option value="1">SI</option>
                                            <option value="0">NO</option>
                                        </select>
                                        <small class="text-danger" v-for="error in form.errors.diamiercoles" :key="error">{{ error
                                                }}</small>
                                    </div>
                                    <div class="mb-3">
                                        <label for="diajueves" class="form-label">JUEVES </label>
                                        <select v-model="form.diajueves" class="form-control" :class="{ 'is-invalid': form.errors.diajueves }">
                                            <option value="" disabled>--SELECCIONE--</option>
                                            <option value="1">SI</option>
                                            <option value="0">NO</option>
                                        </select>
                                        <small class="text-danger" v-for="error in form.errors.diajueves" :key="error">{{ error
                                                }}</small>
                                    </div>
                                    <div class="mb-3">
                                        <label for="diaviernes" class="form-label">VIERNES </label>
                                        <select v-model="form.diaviernes" class="form-control" :class="{ 'is-invalid': form.errors.diaviernes }">
                                            <option value="" disabled>--SELECCIONE--</option>
                                            <option value="1">SI</option>
                                            <option value="0">NO</option>
                                        </select>
                                        <small class="text-danger" v-for="error in form.errors.diaviernes" :key="error">{{ error
                                                }}</small>
                                    </div>
                                    <div class="mb-3">
                                        <label for="diasabado" class="form-label">SABADO </label>
                                        <select v-model="form.diasabado" class="form-control" :class="{ 'is-invalid': form.errors.diasabado }">
                                            <option value="" disabled>--SELECCIONE--</option>
                                            <option value="1">SI</option>
                                            <option value="0">NO</option>
                                        </select>
                                        <small class="text-danger" v-for="error in form.errors.diasabado" :key="error">{{ error
                                                }}</small>
                                    </div>
                                    <div class="mb-3">
                                        <label for="diadomingo" class="form-label">DOMINGO </label>
                                        <select v-model="form.diadomingo" class="form-control" :class="{ 'is-invalid': form.errors.diadomingo }">
                                            <option value="1">SI</option>
                                            <option value="0">NO</option>
                                        </select>
                                        <small class="text-danger" v-for="error in form.errors.diadomingo" :key="error">{{ error
                                                }}</small>
                                    </div>
                                    <div class="mb-3">
                                        <label for="totalhoras" class="form-label">Total de Horas Semana</label>
                                        <input type="text" class="form-control" v-model="form.totalhoras" :class="{ 'is-invalid': form.errors.totalhoras }" @focus="calcularHoras()">
                                        <small class="text-danger" v-for="error in form.errors.totalhoras" :key="error">{{ error
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