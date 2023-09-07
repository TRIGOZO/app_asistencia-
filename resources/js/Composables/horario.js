import axios from 'axios'
import { ref } from 'vue'
import { getConfigHeader, getdataParamsPagination } from '@/Helpers'
export default function useHorario() {
    const errors = ref('')
    const horario = ref({})
    const respuesta = ref([])
    

    const generarHorario = async(data) => {
        errors.value = ''
        try {
            let respond = await axios.post('horario/guardar',data,getConfigHeader())
            errors.value =''
            respuesta.value=respond.data
            // if(respond.data.ok==1){
            //     respuesta.value=respond.data
            // }else{
            //     respuesta.value=respond.data
            // }
        } catch (error) {
            errors.value=""
            if(error.response.status === 422) {
                errors.value = error.response.data.errors
            }
        }
    }

    const obtenerHorario = async(id) => {
        let respuesta = await axios.get('horario/mostrar?id='+id,getConfigHeader())
        horario.value = respuesta.data
    }



    const eliminarHorario = async(id) => {
        const respond = await axios.post('horario/eliminar', {id:id},getConfigHeader())
        if(respond.data.ok==1)
        {
            respuesta.value = respond.data
        }
    }
    return {
        errors, horario,obtenerHorario, generarHorario, eliminarHorario, respuesta
    }
}