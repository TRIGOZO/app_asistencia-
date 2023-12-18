import { createRouter, createWebHistory } from "vue-router";
import jwt_decode from 'jwt-decode';

//PLANTILLAS
import LayoutLogin from '@/Layouts/AppLayoutLogin.vue'
import LayoutDefault from '@/Layouts/AppLayoutDefault.vue'
// import { useUsuarioStore } from "../Store/UsuarioStore";
// import { storeToRefs } from 'pinia';
//vistas
import Principal from '@/Paginas/Principal.vue'
import Usuario from '@/Paginas/usuarios/Inicio.vue'
import Login from '@/Paginas/Auth/Login.vue'
import Profile from '@/Paginas/Profile/Inicio.vue'
import Profesion from '@/Paginas/profesiones/Inicio.vue'
import Cargo from '@/Paginas/cargos/Inicio.vue'
import TipoTurno from '@/Paginas/tipoturno/Inicio.vue'
import TipoGuardia from '@/Paginas/tipoguardia/Inicio.vue'
import Role from '@/Paginas/roles/Inicio.vue'
import Menu from '@/Paginas/menus/Inicio.vue'
import MenuRole from '@/Paginas/menu-role/Inicio.vue'
import Red from '@/Paginas/redes/Inicio.vue'
import MicroRed from '@/Paginas/microredes/Inicio.vue'
import TipoTrabajador from '@/Paginas/tipotrabajador/Inicio.vue'
import TipoPermiso from '@/Paginas/tipopermisos/Inicio.vue'
import Feriado from '@/Paginas/feriados/Inicio.vue'
import TipoNivel from '@/Paginas/tiponiveles/Inicio.vue'
import Establecimiento from '@/Paginas/establecimientos/Inicio.vue'
import Nivel from '@/Paginas/niveles/Inicio.vue'
import Personal from '@/Paginas/personales/Inicio.vue'
import CondicionLaboral from '@/Paginas/condicionlaboral/Inicio.vue'
import Permiso from '@/Paginas/permisos/Inicio.vue'
import RoleTurno from '@/Paginas/roles-turnos/Inicio.vue'
import CambioTurno from '@/Paginas/cambio-turno/Inicio.vue'
import Marcacion from '@/Paginas/Marcacion/Inicio.vue'
import Marcaciones from '@/Paginas/marcaciones/Inicio.vue'
import faltas from '@/Paginas/faltas/Inicio.vue'
import Horario from '@/Paginas/horario/Inicio.vue'
import RolGroup from '@/Paginas/rol-grupo/Inicio.vue'
import ReportePermiso from '@/Paginas/Reportes/Permiso/Inicio.vue'
import ReporteTardanza from '@/Paginas/Reportes/Tardanza/Inicio.vue'
import ReporteFaltas from '@/Paginas/Reportes/Faltas/Inicio.vue'
import ReportePermisosSinGoce from '@/Paginas/Reportes/PermisosSinGoce/Inicio.vue'
import ReportePermisosHoras from '@/Paginas/Reportes/PermisosHorasParticulares/Inicio.vue'
import ReporteVacaciones from '@/Paginas/Reportes/vacaciones/Inicio.vue'
import faltasDia from '@/Paginas/Reportes/FaltasDia/Inicio.vue'
import Importacion from '@/Paginas/importaciones/Inicio.vue'
const routes = [
    {
        path: '/',name: 'Login', component: Login,
        meta: {layout: LayoutLogin}
    },
    {
        path: '/principal', name:'Principal', component: Principal ,
        meta:{layout: LayoutDefault}
    },
    {
        path: '/usuarios', name:'Usuario', component: Usuario ,
        meta:{layout: LayoutDefault}
    },
    {
        path: '/perfil', name:'Perfil', component: Profile ,
        meta:{layout: LayoutDefault}
    }, 
    {
        path: '/cargo', name:'Cargo', component: Cargo ,
        meta:{layout: LayoutDefault}
    },
    {
        path: '/profesion', name:'Profesion', component: Profesion ,
        meta:{layout: LayoutDefault}
    },   
    {
        path: '/tipo-turno', name:'Tipo Turno', component: TipoTurno ,
        meta:{layout: LayoutDefault}
    },  
    {
        path: '/tipo-guardia', name:'Tipo Guardia', component: TipoGuardia ,
        meta:{layout: LayoutDefault}
    },      
    {
        path: '/role', name:'Role', component: Role ,
        meta:{layout: LayoutDefault}
    },  
    {
        path: '/menus', name:'Menu', component: Menu ,
        meta:{layout: LayoutDefault}
    },
    {
        path: '/menus-roles', name:'MenuRole', component: MenuRole ,
        meta:{layout: LayoutDefault}
    },  
    {
        path: '/red', name:'Red', component: Red ,
        meta:{layout: LayoutDefault}
    },
    {
        path: '/microred', name:'Micro Red', component: MicroRed ,
        meta:{layout: LayoutDefault}
    },
    {
        path: '/tipo-trabajador', name:'Tipo Trabajador', component: TipoTrabajador ,
        meta:{layout: LayoutDefault}
    },
    {
        path: '/tipo-permiso', name:'Tipo Permiso', component: TipoPermiso ,
        meta:{layout: LayoutDefault}
    },
    {
        path: '/feriado', name:'Feriado', component: Feriado ,
        meta:{layout: LayoutDefault}
    },    
    {
        path: '/tipo-nivel', name:'Tipo Nivel', component: TipoNivel ,
        meta:{layout: LayoutDefault}
    },   
    {
        path: '/Establecimiento', name:'Establecimiento', component: Establecimiento ,
        meta:{layout: LayoutDefault}
    },   
    {
        path: '/nivel', name:'Nivel', component: Nivel ,
        meta:{layout: LayoutDefault}
    },  
    {
        path: '/personales', name:'Personal', component: Personal ,
        meta:{layout: LayoutDefault}
    },
    {
        path: '/condicion-laboral', name:'Condicion Laboral', component: CondicionLaboral ,
        meta:{layout: LayoutDefault}
    },     
    {
        path: '/permisos', name:'Permiso', component: Permiso ,
        meta:{layout: LayoutDefault}
    },
    {
        path: '/rol', name:'RolTurno', component: RoleTurno ,
        meta:{layout: LayoutDefault}
    },
    {
        path: '/cambio-turno', name:'CambioTurno', component: CambioTurno ,
        meta:{layout: LayoutDefault}
    },
    {
        path: '/marcacion', name:'Marcacion', component: Marcacion ,
        meta:{layout: LayoutDefault}
    },
    {
        path: '/marcaciones', name:'Marcaciones', component: Marcaciones ,
        meta:{layout: LayoutDefault}
    },
    {
        path: '/horarios', name:'Horario', component: Horario ,
        meta:{layout: LayoutDefault}
    },
    {
        path: '/rol-grupo', name:'Rol Grupo', component: RolGroup ,
        meta:{layout: LayoutDefault}
    },
    {
        path: '/reporte-permiso', name:'Reporte Permiso', component: ReportePermiso ,
        meta:{layout: LayoutDefault}
    },
    {
        path: '/reporte-tardanza', name:'Reporte Tardanza', component: ReporteTardanza ,
        meta:{layout: LayoutDefault}
    },
    {
        path: '/reporte-faltas', name:'Reporte Faltas', component: ReporteFaltas ,
        meta:{layout: LayoutDefault}
    },
    {
        path: '/reporte-permisos-sin-goce', name:'Reporte Permisos', component: ReportePermisosSinGoce ,
        meta:{layout: LayoutDefault}
    },    
    {
        path: '/reporte-permisos-horas-particulares', name:'Horas Particulares', component: ReportePermisosHoras ,
        meta:{layout: LayoutDefault}
    },
    {
        path: '/reporte-vacaciones', name:'Reporte Horas Particulares', component: ReporteVacaciones ,
        meta:{layout: LayoutDefault}
    },      
    {
        path: '/faltas', name:'Faltas', component: faltas ,
        meta:{layout: LayoutDefault}
    },
    {
        path: '/falta-dia', name:'FaltasDia', component: faltasDia ,
        meta:{layout: LayoutDefault}
    },
    {
        path: '/importar-marcaciones', name:'Importar Marcaciones', component: Importacion ,
        meta:{layout: LayoutDefault}
    },    

]

export default createRouter({
    history: createWebHistory(),
    routes
})
