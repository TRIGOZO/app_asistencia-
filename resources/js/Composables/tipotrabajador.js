import axios from 'axios'
import { ref } from 'vue'
import { getConfigHeader, getdataParamsPagination } from '@/Helpers'
export default function useTipoTrabajador() {
    const tipotrabajadores = ref([])
    const errors = ref('')
    const tipotrabajador = ref({})
    const respuesta = ref([])
    
    const obtenerTipoTrabajador = async(id) => {
        let respuesta = await axios.get('tipo-trabajador/mostrar?id='+id,getConfigHeader())
        tipotrabajador.value = respuesta.data
    }
    const listaTipoTrabajadores = async()=>{
        let respuesta = await axios.get('tipo-trabajador/todos',getConfigHeader())
        tipotrabajadores.value = respuesta.data        
    }
    const obtenerTipoTrabajadores = async(data) => {
        let respuesta = await axios.get('tipo-trabajador/listar' + getdataParamsPagination(data),getConfigHeader())
        tipotrabajadores.value =respuesta.data
    }
    const agregarTipoTrabajador = async(data) => {
        errors.value = ''
        try {
            let respond = await axios.post('tipo-trabajador/guardar',data,getConfigHeader())
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
    const actualizarTipoTrabajador = async(data) => {
        errors.value = ''
        try {
            let respond = await axios.post('tipo-trabajador/actualizar',data,getConfigHeader())
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
    const eliminarTipoTrabajador = async(id) => {
        const respond = await axios.post('tipo-trabajador/eliminar', {id:id},getConfigHeader())
        if(respond.data.ok==1)
        {
            respuesta.value = respond.data
        }
    }
    return {
        errors, tipotrabajadores, listaTipoTrabajadores, tipotrabajador, obtenerTipoTrabajador, obtenerTipoTrabajadores, 
        agregarTipoTrabajador, actualizarTipoTrabajador, eliminarTipoTrabajador, respuesta
    }
}