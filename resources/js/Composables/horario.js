import axios from 'axios'
import { ref } from 'vue'
import { getConfigHeader, getdataParamsPagination } from '@/Helpers'
export default function useHorario() {
    const errors = ref('')
    const horario = ref({})
    const respuesta = ref([])
    
    const obtenerHorario = async(id) => {
        let respuesta = await axios.get('cargo/mostrar?id='+id,getConfigHeader())
        cargo.value = respuesta.data
    }

    const agregarHorario = async(data) => {
        errors.value = ''
        try {
            let respond = await axios.post('cargo/guardar',data,getConfigHeader())
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

    const eliminarHorario = async(id) => {
        const respond = await axios.post('cargo/eliminar', {id:id},getConfigHeader())
        if(respond.data.ok==1)
        {
            respuesta.value = respond.data
        }
    }
    return {
        errors, horario,obtenerHorario, agregarHorario, eliminarHorario, respuesta
    }
}