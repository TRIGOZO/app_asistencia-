import axios from 'axios'
import { ref } from 'vue'
import { getdataParamsPagination, getConfigHeader } from '@/Helpers'
export default function usePerfil() {
    const respuesta = ref([])
    const errors = ref('')
    const actualizarPerfil = async(data) => {
        errors.value = ''
        try {
            let respond = await axios.post('actualizar-perfil',data,getConfigHeader())
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

    const cambiarClave = async(data) => {
        errors.value = ''
        try {
            let respond = await axios.post('cambiar-clave',data,getConfigHeader())
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
        errors, respuesta, actualizarPerfil, cambiarClave
    }
}