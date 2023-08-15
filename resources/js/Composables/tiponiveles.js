import axios from 'axios'
import { ref } from 'vue'
import { getConfigHeader, getdataParamsPagination } from '@/Helpers'
export default function useTipoNivel() {
    const tiponiveles = ref([])
    const errors = ref('')
    const tiponivel = ref({})
    const respuesta = ref([])
    
    const obtenerTipoNivel = async(id) => {
        let respuesta = await axios.get('tipo-nivel/mostrar?id='+id,getConfigHeader())
        tiponivel.value = respuesta.data
    }
    const listaTipoNiveles = async()=>{
        let respuesta = await axios.get('tipo-nivel/todos',getConfigHeader())
        tiponiveles.value = respuesta.data        
    }
    const obtenerTipoNiveles = async(data) => {
        let respuesta = await axios.get('tipo-nivel/listar' + getdataParamsPagination(data),getConfigHeader())
        tiponiveles.value =respuesta.data
    }
    const agregarTipoNivel = async(data) => {
        errors.value = ''
        try {
            let respond = await axios.post('tipo-nivel/guardar',data,getConfigHeader())
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
    const actualizarTipoNivel = async(data) => {
        errors.value = ''
        try {
            let respond = await axios.post('tipo-nivel/actualizar',data,getConfigHeader())
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
    const eliminarTipoNivel = async(id) => {
        const respond = await axios.post('tipo-nivel/eliminar', {id:id},getConfigHeader())
        if(respond.data.ok==1)
        {
            respuesta.value = respond.data
        }
    }
    return {
        errors, tiponiveles, listaTipoNiveles, tiponivel, obtenerTipoNivel, obtenerTipoNiveles, 
        agregarTipoNivel, actualizarTipoNivel, eliminarTipoNivel, respuesta
    }
}