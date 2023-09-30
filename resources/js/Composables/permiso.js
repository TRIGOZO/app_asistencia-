import axios from 'axios'
import { ref } from 'vue'
import { getConfigHeader, getdataParamsPagination } from '@/Helpers'
export default function usePermiso() {
    const permisos = ref([])
    const errors = ref('')
    const permiso = ref({})
    const respuesta = ref([])
    
    const obtenerPermiso = async(id) => {
        let respuesta = await axios.get('permiso/mostrar?id='+id,getConfigHeader())
        permiso.value = respuesta.data
    }
    const obtenerPermisos = async(data) => {
        let respuesta = await axios.get('permiso/listar' + getdataParamsPagination(data),getConfigHeader())
        permisos.value =respuesta.data
    }
    const listarFecha = async(fecha) => {
        let respuesta = await axios.get('permiso/listar-fecha?fecha=' + fecha,getConfigHeader())
        permisos.value =respuesta.data
    }    
    const agregarPermiso = async(data) => {
        errors.value = ''
        try {
            let respond = await axios.post('permiso/guardar',data,getConfigHeader())
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
    const obtenerPermisosMensual = async(data) =>{
        let respond = await axios.post('permiso/minutos-menual-permiso',data,getConfigHeader())
        permisos.value=respond.data
    }
    const actualizarPermiso = async(data) => {
        errors.value = ''
        try {
            let respond = await axios.post('permiso/actualizar',data,getConfigHeader())
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
    const eliminarPermiso = async(id) => {
        const respond = await axios.post('permiso/eliminar', {id:id},getConfigHeader())
        if(respond.data.ok==1)
        {
            respuesta.value = respond.data
        }
    }
    return {
        errors, permisos, permiso, obtenerPermiso, obtenerPermisos, 
        agregarPermiso, actualizarPermiso, eliminarPermiso, respuesta,
        listarFecha, obtenerPermisosMensual
    }
}