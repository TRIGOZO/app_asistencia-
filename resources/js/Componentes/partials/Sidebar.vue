<template>
        <div id="layoutSidenav_nav">
            <nav class="sidenav shadow-right sidenav-light">
                <div class="sidenav-menu">
                    <div class="nav accordion" id="accordionSidenav">
                        <!-- Sidenav Menu Heading (Core)-->
                        <div class="sidenav-menu-heading">Menus</div>
                        <!-- Sidenav Accordion (Dashboard)-->
                        <li v-for="menu in menus" :key="menu.id">
                            <template v-if="menu.menus.length">
                                <a class="nav-link" :class="[ menuactivo  == menu.id ? 'active' : 'collapsed']" href="javascript:void(0);" data-bs-toggle="collapse" :data-bs-target="'#'+menu.slug" aria-expanded="false" :aria-controls="menu.slug">
                                    <div :class="menu.icono"><i data-feather="activity"></i></div>
                                    &nbsp; &nbsp;{{menu.nombre}}
                                    <div class="sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                                </a>
                                <div class="collapse" :class="[menuactivo  == menu.id ? 'show' : '' ]" :id="menu.slug" data-bs-parent="#accordionSidenav">
                                    <nav class="sidenav-menu-nested nav accordion" id="accordionSidenavPages">
                                        <a class="nav-link" :class="[ $route.path == '/'+hijo.slug ? 'active' : '' ]" v-for=" hijo in menu.menus" :key="hijo.id" :href="hijo.slug">
                                            <i :class="hijo.icono"></i>&nbsp;{{ hijo.nombre }}
                                            <span style="display:none">
                                            <template  v-if="$route.path == '/'+hijo.slug && menuactivo == ''">{{ menuactivo = hijo.padre_id }}</template>
                                            </span>
                                        </a>
                                    </nav>
                                </div>
                            </template>
                            <template v-else>
                                <a class="nav-link" :href="menu.slug" :class="{ 'active': $route.path == '/'+menu.slug}">
                                    <div :class="menu.icono"></div>
                                    &nbsp; &nbsp;{{menu.nombre}}
                                </a>
                            </template>
                        </li>
                    </div>
                </div>
                <!-- Sidenav Footer-->
                <div class="sidenav-footer">
                    <div class="sidenav-footer-content">
                        <div class="sidenav-footer-subtitle">Logeado como:</div>
                        <div class="sidenav-footer-title">{{usuario.username}}</div>
                    </div>
                </div>
            </nav>
        </div>
</template>
<script>
    import useDatosSession  from '@/Composables/session';
    import { ref, computed, onMounted } from 'vue'
    import { useRoute } from 'vue-router'
    export default {

        setup() {
            const { usuario, menus } = useDatosSession()
            const ruta = useRoute()
            const menuactivo = ref('')




            console.log(menuactivo)
            return {
                usuario, menus, menuactivo
            }
        },
    }
</script>
