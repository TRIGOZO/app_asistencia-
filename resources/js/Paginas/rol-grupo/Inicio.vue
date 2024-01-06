<script setup>
    import useEstablecimiento from '@/Composables/establecimientos.js';
    import useHelper from '@/Helpers';
    import { ref, onMounted } from 'vue';
    import roles from './roles.vue';
    import usePersonal from '@/Composables/personal.js';
    import ContentHeader from '@/Componentes/ContentHeader.vue';
    import useTipoTurno from '@/Composables/tipoturno.js';
    import useTipoTrabajador from '@/Composables/tipotrabajador.js';
    import useProfesion from '@/Composables/profesiones.js';
    import JsonExcel from 'vue-json-excel3';
    const {
        profesiones, listaProfesiones
    } = useProfesion();
    const {
        tipoturnos, listaTipoTurnos
    } = useTipoTurno();  
    const {
        tipotrabajadores, listaTipoTrabajadores
    } = useTipoTrabajador();        
    const { meses, formatoFecha } = useHelper();
    const {
        establecimientos, listaEstablecimientos
    } = useEstablecimiento();
    const {
        personales, obtenerPersonalesEstablecimiento
    } = usePersonal();
    const titleHeader = ref({
      titulo: "Roles",
      subTitulo: "Turno",
      icon: "",
      vista: ""
    });
    const mostrarRoles = ref(false);
    const jsonFields = ref({
        "DNI" : "numero_dni",
        "Apellidos y Nombres": "apellidos_nombres",
        "1": "d1",
        "2": "d2",
        "3": "d3",
        "4": "d4",
        "5": "d5",
        "6": "d6",
        "7": "d7",
        "8": "d8",
        "9": "d9",
        "10": "d10",
        "11": "d11",
        "12": "d12",
        "13": "d13",
        "14": "d14",
        "15": "d15",
        "16": "d16",
        "17": "d17",
        "18": "d18",
        "19": "d19",
        "20": "d20",
        "21": "d21",
        "22": "d22",
        "23": "d23",
        "24": "d24",
        "25": "d25",
        "26": "d26",
        "27": "d27",
        "28": "d28",
        "29": "d29",
        "30": "d30",
        "31": "d31",
        "Total Horas": "total_horas",
    })

    const generarRoles=async()=>{
        mostrarRoles.value=true
        await listaTipoTurnos()
        await obtenerPersonalesEstablecimiento(form.value);

        

        // personales.value.forEach(persona => {
        // console.log("Persona:", persona);  // Mostrar información sobre la persona

        // let suma = 0;
        // if (persona.d1 !== null) {
        //     var turno = tipoturnos.value.find(t => t.abreviatura == persona.d1);
        //     console.log("Turno encontrado:", turno);  // Mostrar información sobre el turno encontrado

        //     if (turno) {
        //     persona.total_horas += (turno.totalhoras == null) ? 0 : parseInt(turno.totalhoras);
        //     console.log("Persona actualizada con total_horas:", persona.total_horas);
        //     }
        // }
        // });

        personales.value.personales.forEach(persona => {

            persona.total_horas = 0;
            for (let i = 1; i <= 31; i++) {
                const dayKey = `d${i}`;
                if (persona[dayKey] !== null) {
                    const turno = tipoturnos.value.find(t => t.abreviatura === persona[dayKey]);
                    if (turno) {
                        persona.total_horas += (turno.totalhoras == null) ? 0 : parseInt(turno.totalhoras);
                        //console.log(`Persona actualizada con total_horas para ${dayKey}:`, persona.total_horas);
                    }
                }
            }

        });

    }
    const form = ref({
        establecimiento_id:'',
        tipo_trabajador_id:1,
        profesion_id:'',
        mes_numero:parseInt(formatoFecha(null,"MM")),
        anio:parseInt(formatoFecha(null,"YYYY")),
        errors:[]
    });
    const formRolePersonal = ref({
        datosGenerales : form,
        personal : []
    })
    const anios = ref([]);
    const listarAnios=()=>{
        const anioActual=parseInt(formatoFecha(null,"YYYY"))
        for (let index = anioActual; index >= anioActual - 4; index--) {
            anios.value.push(index);
        }
    }
    onMounted(() => {
        listaEstablecimientos()
        listaProfesiones()
        listarAnios()
        listaTipoTrabajadores()
    })    
</script>
<template>
    <ContentHeader :title-header="titleHeader"></ContentHeader>
    <div class="app-content">
      <div class="container-fluid">
        <div class="card card-primary card-outline">
            <div class="card-header">
                <h6 class="card-title">
                    Generacion de Rol de Turnos
                </h6>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-2 mb-1">
                        <label for="name" class="form-label">Establecimiento</label>
                        <select v-model="form.establecimiento_id" class="form-control"
                            :class="{ 'is-invalid': form.errors.establecimiento_id }">
                            <option value="">--Seleccione--</option>
                            <option v-for="establecimiento in establecimientos" :key="establecimiento.id" :value="establecimiento.id"
                                :title="establecimiento.nombre">
                                {{ establecimiento.nombre }}
                            </option>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <label for="name" class="form-label">Mes</label>
                        <select v-model="form.mes_numero" class="form-control"
                            :class="{ 'is-invalid': form.errors.mes_numero }">
                            <option v-for="mes in meses" :key="mes.numero" :value="mes.numero"
                                :title="mes.nombre">
                                {{ mes.nombre }}
                            </option>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <label for="anio" class="form-label">Año</label>
                        <select v-model="form.anio" class="form-control"
                            :class="{ 'is-invalid': form.errors.anio }">
                            <option v-for="anho in anios" :key="anho" :value="anho"
                                :title="anho">
                                {{ anho }}
                            </option>
                        </select>
                    </div>                    
                    <div class="col-md-2">
                        <label for="name" class="form-label">Tipo de Trabajador</label>
                        <select v-model="form.tipo_trabajador_id" class="form-control"
                            :class="{ 'is-invalid': form.errors.tipo_trabajador_id }">
                            <option v-for="tipotrabajador in tipotrabajadores" :key="tipotrabajador.id" :value="tipotrabajador.id"
                                :title="tipotrabajador.nombre">
                            {{ tipotrabajador.nombre }}
                            </option>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <label for="name" class="form-label">Profesion</label>
                        <select v-model="form.profesion_id" class="form-control"
                            :class="{ 'is-invalid': form.errors.profesion_id }">
                            <option value="">Todos</option>
                                <option v-for="profesion in profesiones" :key="profesion.id" :value="profesion.id"
                                    :title="profesion.nombre">
                                {{ profesion.nombre }}
                            </option>
                        </select>
                    </div>                                     
                    <div class="col-md-2 mb-1">
                        <br>
                        <button class="btn btn-primary" @click="generarRoles()">Cargar</button>&nbsp;
                        <JsonExcel class="btn btn-success" :fields="jsonFields" :data="personales.personales">
                            <i class="fa-solid fa-file-excel"></i> Descargar
                        </JsonExcel>
                    </div>
                </div>
                <div class="row" v-if="mostrarRoles">
                    <roles :personales="personales" :tipoturnos="tipoturnos" :form="formRolePersonal"></roles>
                </div>
            </div>
        </div>
      </div>
    </div>
</template>




