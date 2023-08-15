import axios from 'axios'
import { ref } from 'vue'
import { getConfigHeader, getdataParamsPagination } from '@/Helpers'
export default function useTipoGuardia() {
    const tipoguardias = ref([])
    const errors = ref('')
    const tipoguardia = ref({})
    const respuesta = ref([])
    
    const obtenerTipoGuardia = async(id) => {
        let respuesta = await axios.get('tipo-guardia/mostrar?id='+id,getConfigHeader())
        tipoguardia.value = respuesta.data
    }
    const listaTipoGuardias = async()=>{
        let respuesta = await axios.get('tipo-guardia/todos',getConfigHeader())
        tipoguardias.value = respuesta.data        
    }
    const obtenerTipoGuardias = async(data) => {
        let respuesta = await axios.get('tipo-guardia/listar' + getdataParamsPagination(data),getConfigHeader())
        tipoguardias.value =respuesta.data
    }
    const agregarTipoGuardia = async(data) => {
        errors.value = ''
        try {
            let respond = await axios.post('tipo-guardia/guardar',data,getConfigHeader())
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
    const actualizarTipoGuardia = async(data) => {
        errors.value = ''
        try {
            let respond = await axios.post('tipo-guardia/actualizar',data,getConfigHeader())
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
    const eliminarTipoGuardia = async(id) => {
        const respond = await axios.post('tipo-guardia/eliminar', {id:id},getConfigHeader())
        if(respond.data.ok==1)
        {
            respuesta.value = respond.data
        }
    }
    return {
        errors, tipoguardias, listaTipoGuardias, tipoguardia, obtenerTipoGuardia, obtenerTipoGuardias, 
        agregarTipoGuardia, actualizarTipoGuardia, eliminarTipoGuardia, respuesta
    }
}