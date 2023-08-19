import axios from 'axios'
import { ref } from 'vue'
import { getConfigHeader, getdataParamsPagination } from '@/Helpers'
export default function useCondicionLaboral() {
    const condicioneslaborales = ref([])
    const errors = ref('')
    const condicionlaboral = ref({})
    const respuesta = ref([])
    
    const obtenerCondicionLaboral = async(id) => {
        let respuesta = await axios.get('condicion-laboral/mostrar?id='+id,getConfigHeader())
        condicionlaboral.value = respuesta.data
    }
    const listaCondicionesLaborales = async()=>{
        let respuesta = await axios.get('condicion-laboral/todos',getConfigHeader())
        condicioneslaborales.value = respuesta.data        
    }
    const obtenerCondicionesLaborales = async(data) => {
        let respuesta = await axios.get('condicion-laboral/listar' + getdataParamsPagination(data),getConfigHeader())
        condicioneslaborales.value =respuesta.data
    }
    const agregarCondicionLaboral = async(data) => {
        errors.value = ''
        try {
            let respond = await axios.post('condicion-laboral/guardar',data,getConfigHeader())
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
    const actualizarCondicionLaboral = async(data) => {
        errors.value = ''
        try {
            let respond = await axios.post('condicion-laboral/actualizar',data,getConfigHeader())
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
    const eliminarCondicionLaboral = async(id) => {
        const respond = await axios.post('condicion-laboral/eliminar', {id:id},getConfigHeader())
        if(respond.data.ok==1)
        {
            respuesta.value = respond.data
        }
    }
    return {
        errors, condicioneslaborales, listaCondicionesLaborales, condicionlaboral, obtenerCondicionLaboral, obtenerCondicionesLaborales, 
        agregarCondicionLaboral, actualizarCondicionLaboral, eliminarCondicionLaboral, respuesta
    }
}