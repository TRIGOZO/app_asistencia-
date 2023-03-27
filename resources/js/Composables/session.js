import { onMounted, provide, ref } from 'vue';
import { storeToRefs } from 'pinia';
import { useUsuarioStore } from '@/Store';
import jwt_decode from 'jwt-decode';
export default function useDatosSession() {

    const user_id = localStorage.getItem('userSession') ? JSON.parse( JSON.stringify(jwt_decode(localStorage.getItem('userSession')).user)) : null
    ;

    const usuarioStore = useUsuarioStore();
    const  menuactivo = ref();
    const { usuario, menus, role } = storeToRefs(usuarioStore)

    const { cargarDatosSession, cargarMenus, modificarFoto} = usuarioStore

    const obtenerUsuarioSesion = async() => {
        if(user_id != null)
        {
            await cargarDatosSession(user_id);
            cargarMenus();
        }
    }

    onMounted(() => {
        obtenerUsuarioSesion()
    })

    const cambiarFoto = async(foto) => {
        modificarFoto(foto);
    }
    const obtenerMenupadreActivo = async(slug) => {
        let respuesta = await axios.get('obtener-menu-slug',{params:{slug:slug}})
        menuactivo.value = respuesta.data
    }
    return {
        usuario, menus, cambiarFoto, role, obtenerMenupadreActivo, menuactivo
    }
}
