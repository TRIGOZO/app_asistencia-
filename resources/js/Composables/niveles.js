import axios from 'axios'
import { ref } from 'vue'
import { getConfigHeader, getdataParamsPagination } from '@/Helpers'
export default function useNivel() {
    const niveles = ref([])
    const errors = ref('')
    const nivel = ref({})
    const respuesta = ref([])
    
    const obtenerNivel = async(id) => {
        let respuesta = await axios.get('nivel/mostrar?id='+id,getConfigHeader())
        nivel.value = respuesta.data
    }
    const listaNiveles = async()=>{
        let respuesta = await axios.get('nivel/todos',getConfigHeader())
        niveles.value = respuesta.data        
    }
    const obtenerNiveles = async(data) => {
        let respuesta = await axios.get('nivel/listar' + getdataParamsPagination(data),getConfigHeader())
        niveles.value =respuesta.data
    }
    const agregarNivel = async(data) => {
        errors.value = ''
        try {
            let respond = await axios.post('nivel/guardar',data,getConfigHeader())
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
    const actualizarNivel = async(data) => {
        errors.value = ''
        try {
            let respond = await axios.post('nivel/actualizar',data,getConfigHeader())
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
    const eliminarNivel = async(id) => {
        const respond = await axios.post('nivel/eliminar', {id:id},getConfigHeader())
        if(respond.data.ok==1)
        {
            respuesta.value = respond.data
        }
    }
    return {
        errors, niveles, listaNiveles, nivel, obtenerNivel, obtenerNiveles, 
        agregarNivel, actualizarNivel, eliminarNivel, respuesta
    }
}