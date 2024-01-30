import axios from 'axios'
import { ref } from 'vue'
import { getConfigHeader, getdataParamsPagination } from '@/Helpers'
export default function useMarcacion() {
    const marcaciones = ref([])
    const marcacionesHorarios = ref([])
    const errors = ref('')
    const marcacion = ref({})
    const respuesta = ref([])
    const faltas = ref([])
    const faltasdetalle = ref([])
    const registrosHorariosExtras =  ref([])
    const obtenerMarcacion = async(id) => {
        let respuesta = await axios.get('marcacion/mostrar?id='+id,getConfigHeader())
        marcacion.value = respuesta.data
    }

    const obtenerMarcaciones = async(data) => {
        let respuesta = await axios.get('marcacion/listar' + getdataParamsPagination(data),getConfigHeader())
        marcaciones.value =respuesta.data
    }
    const obtenerMarcacionesHoy = async(data) => {
        let respuesta = await axios.get('marcacion/marcaciones-hoy' + getdataParamsPagination(data),getConfigHeader())
        marcaciones.value =respuesta.data
    }    
    const agregarMarcacion = async(data) => {
        errors.value = ''
        try {
            let respond = await axios.post('marcacion/guardar',data,getConfigHeader())
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
    const importarMarcaciones = async(data) => {
        errors.value = ''
        try {
            let respond = await axios.post('marcacion/importacion',data,getConfigHeader())
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
    const actualizarMarcacion = async(data) => {
        errors.value = ''
        try {
            let respond = await axios.post('marcacion/actualizar',data,getConfigHeader())
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
    const eliminarMarcacion = async(id) => {
        const respond = await axios.post('marcacion/eliminar', {id:id},getConfigHeader())
        if(respond.data.ok==1)
        {
            respuesta.value = respond.data
        }
    }
    const cargarMarcacionHorario = async(data) => {
        try {
            let respond = await axios.post('marcacion/marcaciones-horario', data,getConfigHeader())
            marcacionesHorarios.value =respond.data
        } catch (error) {
            if(error.response.status === 422) {
                errors.value = error.response.data.errors
            }
        }
    }
    const cargarTardanzas = async(data) =>{
        try {
            let respond = await axios.post('marcacion/reporte-tardanzas', data,getConfigHeader())
            marcacionesHorarios.value =respond.data
        } catch (error) {
            if(error.response.status === 422) {
                errors.value = error.response.data.errors
            }
        }
    }
    const cargarFaltasEstablecimiento = async(data) =>{
        try {
            let respond = await axios.post('marcacion/reporte-faltas', data,getConfigHeader())
            faltas.value =respond.data
        } catch (error) {
            if(error.response.status === 422) {
                errors.value = error.response.data.errors
            }
        }
    }    
    const cargarFaltas = async(data) =>{
        try {
            let respond = await axios.post('marcacion/faltas', data,getConfigHeader())
            faltasdetalle.value =respond.data
        } catch (error) {
            if(error.response.status === 422) {
                errors.value = error.response.data.errors
            }
        }
    }
    const cargarFaltasxFecha = async(data) =>{
        try {
            let respond = await axios.post('marcacion/reporte-faltas-fecha', data,getConfigHeader())
            faltas.value =respond.data
        } catch (error) {
            if(error.response.status === 422) {
                errors.value = error.response.data.errors
            }
        }
    }
    const  cargarReporteHorasExtras = async(data)=>{
        try {
            let respond = await axios.post('marcacion/reporte-horas-extras', data,getConfigHeader())
            registrosHorariosExtras.value =respond.data
        } catch (error) {
            if(error.response.status === 422) {
                errors.value = error.response.data.errors
            }
        }        
    }
    return {
        errors, marcaciones, marcacion, obtenerMarcacion, obtenerMarcaciones, 
        agregarMarcacion, actualizarMarcacion, eliminarMarcacion, respuesta, obtenerMarcacionesHoy,
        cargarMarcacionHorario, marcacionesHorarios, cargarTardanzas, cargarFaltas, faltas, cargarFaltasEstablecimiento,
        faltasdetalle, cargarFaltasxFecha, importarMarcaciones, cargarReporteHorasExtras, registrosHorariosExtras
    }
}