import axios from 'axios'
import { ref } from 'vue'
import { getConfigHeader, getdataParamsPagination } from '@/Helpers'
export default function useRed() {
    const redes = ref([])
    const errors = ref('')
    const red = ref({})
    const respuesta = ref([])
    
    const obtenerRed = async(id) => {
        let respuesta = await axios.get('red/mostrar?id='+id,getConfigHeader())
        red.value = respuesta.data
    }
    const listaRedes = async()=>{
        let respuesta = await axios.get('red/todos',getConfigHeader())
        redes.value = respuesta.data        
    }
    const obtenerRedes = async(data) => {
        let respuesta = await axios.get('red/listar' + getdataParamsPagination(data),getConfigHeader())
        redes.value =respuesta.data
    }
    const agregarRed = async(data) => {
        errors.value = ''
        try {
            let respond = await axios.post('red/guardar',data,getConfigHeader())
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
    const actualizarRed = async(data) => {
        errors.value = ''
        try {
            let respond = await axios.post('red/actualizar',data,getConfigHeader())
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
    const eliminarRed = async(id) => {
        const respond = await axios.post('red/eliminar', {id:id},getConfigHeader())
        if(respond.data.ok==1)
        {
            respuesta.value = respond.data
        }
    }
    return {
        errors, redes, listaRedes, red, obtenerRed, obtenerRedes, 
        agregarRed, actualizarRed, eliminarRed, respuesta
    }
}