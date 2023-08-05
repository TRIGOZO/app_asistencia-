import axios from 'axios'
import { ref } from 'vue'
import { getdataParamsPagination, getConfigHeader } from '@/Helpers'
export default function usePersonal() {
    const personal = ref({})
    const estadosciviles = ref([])
    const errors = ref('')

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
    
    return {
        errors, personal, obtenerPersonal, obtenerPersonaldetalle, estadosciviles, listaEstadosCiviles
    }
}