import { defineStore } from "pinia";
import axios from "axios";
import jwt_decode from 'jwt-decode';

export const useUsuarioStore = defineStore("usuario", {

    state: () => ({
        usuario: {},
        menus:[],
        role:{},
    }),
    actions: {
        async cargarDatosSession(){
            const user_id = localStorage.getItem('userSession') ? 
                JSON.parse( JSON.stringify(jwt_decode(localStorage.getItem('userSession')).user)) 
                : null;
            this.usuario = await axios.get('usuario-session-data/',{params:{id:user_id}}).then((respuesta) => respuesta.data)
            if(this.usuario)
            {
                this.role = this.usuario.role
            }
        },
        modificarFoto(foto) {
            this.usuario.foto = foto
        },
        cargarMenus() {
            if(this.usuario.menus)
            {
                this.menus = this.usuario.menus ?? []
            }
        },
        limpiarEstados() {
            this.usuario = {};
            this.menus = [this.menus];
            role:{};
        }
    }
})
