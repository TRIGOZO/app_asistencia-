<script setup>
    import { toRefs, ref, onMounted } from 'vue';
    import useHorario from '@/Composables/horario.js';
    const { hideModal, Toast } = useHelper();
    import useHelper from '@/Helpers';
    const props = defineProps({
        personales: Object,
        tipoturnos: Object
    });
    const {
        errors, respuesta, guardarHorarioAsistencial
    } = useHorario();
    const { personales } = toRefs(props)
    const Guardar=async(index)=>{
        await guardarHorarioAsistencial(personales.value.personales[index])
 
        if(respuesta.value.ok==1){
            //form.value.errors = []
            Toast.fire({icon:'success', title:respuesta.value.mensaje})
        }


        // const seleccion = horariopersonal.value.registros[index];
        // console.log(`Selección para la fila ${index}: ${seleccion}`);


        //Toast.fire({icon:'success', title:'Guardado'})
    }
    const guardarmasivo=()=>{

    }
</script>
<template>
    <div class="row">
        <div class="col-md-12 mb-1">
            <div class="table-responsive">         
                <table class="table table-bordered table-hover table-sm table-striped text-sm table-responsive" style="min-width: 1800px;">
                    <thead class="table-dark">
                        <tr>
                            <th class="text-center">#</th>
                            <th>DNI</th>
                            <th>APENOM</th>
                            <th v-for="dia in personales.dias">
                                {{ dia.dia }}<br>
                                <small>{{ dia.nombreDia }}</small>
                            </th>
                            <th>Accion</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(personal, pindex) in personales.personales" :key="personal.id">
                            <td class="fs-8">{{ pindex+1 }}</td>
                            <td class="fs-8">{{ personal.numero_dni }}</td>
                            <td class="fs-8">{{ personal.apellido_paterno + ' ' + personal.apellido_materno + ' ' + personal.nombres}}</td>
                            <td v-for="(dia, dindex) in personal.regdias" :key="dia.dia">
                                <select :id="'dia_'+pindex+'_'+dindex" v-model="dia.rol" class="form-control form-select-sm" 
                                :class="{ 'is-invalid': errors['regdias.'+dindex+'.rol'] }">
                                    <option value="">--</option>
                                    <option v-for="tt in tipoturnos">{{ tt.abreviatura }}</option>
                                </select>
                            </td>
                            <td>
                                <button title="Guardar" class="btn btn-sm btn-primary" @click="Guardar(pindex)">
                                    <i class="fa-solid fa-floppy-disk"></i>
                                </button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</template>