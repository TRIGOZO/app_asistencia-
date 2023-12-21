<script setup>
    import useEstablecimiento from '@/Composables/establecimientos.js';
    import useHelper from '@/Helpers';
    import { ref, onMounted } from 'vue';
    import roles from './roles.vue';
    import usePersonal from '@/Composables/personal.js';
    import ContentHeader from '@/Componentes/ContentHeader.vue';
    import useTipoTurno from '@/Composables/tipoturno.js';
    import useCargo from '@/Composables/cargos.js';
    const {
        cargos, listaCargos
    } = useCargo();
    const {
        tipoturnos, listaTipoTurnos
    } = useTipoTurno();    
    const { meses, formatoFecha } = useHelper();
    const {
        establecimientos, listaEstablecimientos
    } = useEstablecimiento();
    const {
        personales, obtenerPersonalesEstablecimiento
    } = usePersonal();    
    onMounted(() => {
        listaEstablecimientos()
        listaCargos()
    })
    const titleHeader = ref({
      titulo: "Roles",
      subTitulo: "Turno",
      icon: "",
      vista: ""
    });
    const mostrarRoles = ref(false);

    const generarRoles=async()=>{
        mostrarRoles.value=true
        await listaTipoTurnos()
        await obtenerPersonalesEstablecimiento(form.value);
        let registros = personales.value
        registros.personales.forEach(item => {
            item.regdias = registros.dias.map(dia => ({ dia: dia.dia, rol: '' }));
            item.mes = form.value.mes_numero
        });
    }
    const form = ref({
        establecimiento_id:'',
        cargo_id:'',
        mes_numero:parseInt(formatoFecha(null,"MM")),
        errors:[]
    });
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
                    <div class="col-md-4 mb-1">
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
                        <label for="name" class="form-label">Cargo</label>
                        <select v-model="form.cargo_id" class="form-control"
                            :class="{ 'is-invalid': form.errors.cargo_id }">
                            <option value="">Todos</option>
                                <option v-for="cargo in cargos" :key="cargo.id" :value="cargo.id"
                                    :title="cargo.nombre">
                                {{ cargo.nombre }}
                            </option>
                        </select>
                    </div>                    
                    <div class="col-md-4 mb-1">
                        <br>
                        <button class="btn btn-primary" @click="generarRoles()">Cargar</button>
                    </div>
                </div>

                <div class="row" v-if="mostrarRoles">
                    <roles :personales="personales" :tipoturnos="tipoturnos"></roles>
                </div>
            </div>
        </div>
      </div>
    </div>
</template>




