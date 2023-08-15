import axios from 'axios'
import { ref } from 'vue'
import { getConfigHeader, getdataParamsPagination } from '@/Helpers'
export default function useTipoPermiso() {
    const tipopermisos = ref([])
    const errors = ref('')
    const tipopermiso = ref({})
    const respuesta = ref([])
    
    const obtenerTipoPermiso = async(id) => {
        let respuesta = await axios.get('tipo-permiso/mostrar?id='+id,getConfigHeader())
        tipopermiso.value = respuesta.data
    }
    const listaTipoPermisos = async()=>{
        let respuesta = await axios.get('tipo-permiso/todos',getConfigHeader())
        tipopermisos.value = respuesta.data        
    }
    const obtenerTipoPermisos = async(data) => {
        let respuesta = await axios.get('tipo-permiso/listar' + getdataParamsPagination(data),getConfigHeader())
        tipopermisos.value =respuesta.data
    }
    const agregarTipoPermiso = async(data) => {
        errors.value = ''
        try {
            let respond = await axios.post('tipo-permiso/guardar',data,getConfigHeader())
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
    const actualizarTipoPermiso = async(data) => {
        errors.value = ''
        try {
            let respond = await axios.post('tipo-permiso/actualizar',data,getConfigHeader())
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
    const eliminarTipoPermiso = async(id) => {
        const respond = await axios.post('tipo-permiso/eliminar', {id:id},getConfigHeader())
        if(respond.data.ok==1)
        {
            respuesta.value = respond.data
        }
    }
    return {
        errors, tipopermisos, listaTipoPermisos, tipopermiso, obtenerTipoPermiso, obtenerTipoPermisos, 
        agregarTipoPermiso, actualizarTipoPermiso, eliminarTipoPermiso, respuesta
    }
}