import axios from 'axios'
import { ref } from 'vue'
import { getConfigHeader, getdataParamsPagination } from '@/Helpers'
export default function useMicroRed() {
    const microredes = ref([])
    const errors = ref('')
    const microred = ref({})
    const respuesta = ref([])
    
    const obtenerMicroRed = async(id) => {
        let respuesta = await axios.get('micro-red/mostrar?id='+id,getConfigHeader())
        microred.value = respuesta.data
    }
    const listaMicroRedes = async()=>{
        let respuesta = await axios.get('micro-red/todos',getConfigHeader())
        microredes.value = respuesta.data        
    }
    const obtenerMicroRedes = async(data) => {
        let respuesta = await axios.get('micro-red/listar' + getdataParamsPagination(data),getConfigHeader())
        microredes.value =respuesta.data
    }
    const agregarMicroRed = async(data) => {
        errors.value = ''
        try {
            let respond = await axios.post('micro-red/guardar',data,getConfigHeader())
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
    const actualizarMicroRed = async(data) => {
        errors.value = ''
        try {
            let respond = await axios.post('micro-red/actualizar',data,getConfigHeader())
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
    const eliminarMicroRed = async(id) => {
        const respond = await axios.post('micro-red/eliminar', {id:id},getConfigHeader())
        if(respond.data.ok==1)
        {
            respuesta.value = respond.data
        }
    }
    return {
        errors, microredes, listaMicroRedes, microred, obtenerMicroRed, obtenerMicroRedes, 
        agregarMicroRed, actualizarMicroRed, eliminarMicroRed, respuesta
    }
}