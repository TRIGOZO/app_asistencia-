import axios from 'axios'
import { ref } from 'vue'
import { getConfigHeader } from '@/Helpers'
export default function useMenuRole() {
    const roleMenus = ref([])
    const errors = ref('')
    const role = ref({})
    const mrRespuesta = ref('')
    const menus = ref({})
    const listarRoleMenus = async(data) => {//de acuerdo a rol
        errors.value = ''
        roleMenus.value = ''
        role.value = ''
        try {
            let respuesta = await axios.get('menu-role/menu-roles/',{params : data},getConfigHeader())
            roleMenus.value =respuesta.data.role.menus
            role.value = respuesta.data.role
        } catch (error) {
            if(error.response.status === 422) {
                errors.value = error.response.data.errors
            }
        }
    }
    const agregarMenuRole= async(data)=> {
        errors.value = ''
        try {
            let respuesta = await axios.post('menu-role/menu-role-guardar',data,getConfigHeader())
            errors.value =''
            if(respuesta.data.ok==1){
                mrRespuesta.value=respuesta.data

            }
        } catch (error) {
            errors.value=""
            if(error.response.status === 422) {
                errors.value = error.response.data.errors
            }
        }

    }
    const listarMenus = async() => {
        errors.value = ''
        try {
            let respuesta = await axios.get('menu-role/mostrar-menus/',getConfigHeader)
            menus.value =respuesta.data
        } catch (error) {
            if(error.response.status === 422) {
                errors.value = error.response.data.errors
            }
        }
    }
    return {
        errors, roleMenus, role, agregarMenuRole, listarRoleMenus, listarMenus, menus,
        mrRespuesta
    }
}