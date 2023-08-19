import axios from 'axios'
import { ref } from 'vue'
import { getdataParamsPagination, getConfigHeader } from '@/Helpers'
export default function usePersonal() {
    const personal = ref({})
    const estadosciviles = ref([])
    const personales = ref([])    
    const errors = ref('')
    const respuesta = ref([])
    const obtenerPersonaldetalle = async(id) => {
        let respuesta = await axios.get('personal/obtener-detalle?id='+id,getConfigHeader())
        personal.value = respuesta.data
    }
    const obtenerPersonal = async(id) => {
        let respuesta = await axios.get('personal/obtener?id='+id,getConfigHeader())
        personal.value = respuesta.data
    }
    const listaEstadosCiviles = async()=>{
        let respuesta = await axios.get('personal/estados-civiles',getConfigHeader())
        estadosciviles.value = respuesta.data        
    }
    const obtenerPersonales = async(data) => {
        let respuesta = await axios.get('personal/listar' + getdataParamsPagination(data),getConfigHeader())
        personales.value =respuesta.data
    }
    const agregarPersonal = async(data) => {
        errors.value = ''
        try {
            let respond = await axios.post('personal/guardar',data,getConfigHeader())
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
    const actualizarPersonal = async(data) => {
        errors.value = ''
        try {
            let respond = await axios.post('personal/actualizar',data,getConfigHeader())
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
    const eliminarPersonal = async(id) => {
        const respond = await axios.post('personal/eliminar', {id:id},getConfigHeader())
        if(respond.data.ok==1)
        {
            respuesta.value = respond.data
        }
    }
    return {
        errors, personal, obtenerPersonal, obtenerPersonaldetalle, estadosciviles, listaEstadosCiviles,
        obtenerPersonales, agregarPersonal, actualizarPersonal, eliminarPersonal, personales
    }
}