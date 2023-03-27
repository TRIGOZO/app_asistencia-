import { defineStore } from "pinia";
import axios from "axios";

export const useUsuarioStore = defineStore("usuario", {

    state: () => ({
        usuario: {},
        menus:[],
        role:{}
    }),
    actions: {
        async cargarDatosSession(id){
            this.usuario = await axios.get('usuario-session-data/',{params:{id:id}}).then((respuesta) => respuesta.data)
            this.role = this.usuario.role
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
            this.menus = [];
            role:{}
        }
    }
})
