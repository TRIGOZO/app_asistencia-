import axios from 'axios'
import { ref } from 'vue'
import { getConfigHeader, getdataParamsPagination } from '@/Helpers'
export default function useTipoTurno() {
    const tipoturnos = ref([])
    const errors = ref('')
    const tipoturno = ref({})
    const respuesta = ref([])
    
    const obtenerTipoTurno = async(id) => {
        let respuesta = await axios.get('tipo-turno/mostrar?id='+id,getConfigHeader())
        tipoturno.value = respuesta.data
    }
    const listaTipoTurnos = async()=>{
        let respuesta = await axios.get('tipo-turno/todos',getConfigHeader())
        tipoturnos.value = respuesta.data        
    }
    const obtenerTipoTurnos = async(data) => {
        let respuesta = await axios.get('tipo-turno/listar' + getdataParamsPagination(data),getConfigHeader())
        tipoturnos.value =respuesta.data
    }
    const agregarTipoTurno = async(data) => {
        errors.value = ''
        try {
            let respond = await axios.post('tipo-turno/guardar',data,getConfigHeader())
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
    const actualizarTipoTurno = async(data) => {
        errors.value = ''
        try {
            let respond = await axios.post('tipo-turno/actualizar',data,getConfigHeader())
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
    const eliminartipoturno = async(id) => {
        const respond = await axios.post('tipo-turno/eliminar', {id:id},getConfigHeader())
        if(respond.data.ok==1)
        {
            respuesta.value = respond.data
        }
    }
    return {
        errors, tipoturnos, listaTipoTurnos, tipoturno, obtenerTipoTurno, obtenerTipoTurnos, 
        agregarTipoTurno, actualizarTipoTurno, eliminartipoturno, respuesta
    }
}