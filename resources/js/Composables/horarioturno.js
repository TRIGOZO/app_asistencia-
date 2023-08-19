import axios from 'axios'
import { ref } from 'vue'
import { getConfigHeader, getdataParamsPagination } from '@/Helpers'
export default function useHorarioTurno() {
    const errors = ref('')
    const horario = ref({})
    const respuesta = ref([])
    
    const obtenerHorario = async(turno_id) => {
        let respuesta = await axios.get('horario-turno/mostrar?id='+turno_id,getConfigHeader())
        horario.value = respuesta.data
    }
     const agregarHorario = async(data) => {
        errors.value = ''
        try {
            let respond = await axios.post('horario-turno/guardar',data,getConfigHeader())
            errors.value =''
            if(respond.data.ok==1){
                respuesta.value=respond.data
            }
        } catch (error) {
            errors.value=""
            if(error.response.status === 422) {
                errors.value = error.response.data.errors
            }
        }
    }
    const actualizarHorario = async(data) => {
        errors.value = ''
        try {
            let respond = await axios.post('horario-turno/actualizar',data,getConfigHeader())
            errors.value =''
            if(respond.data.ok==1){
                respuesta.value=respond.data
            }

        } catch (error) {
            errors.value=""
            if(error.response.status === 422) {
                errors.value = error.response.data.errors
            }
        }
    }
    return {
        errors, horario, obtenerHorario, 
        agregarHorario, actualizarHorario, respuesta
    }
}