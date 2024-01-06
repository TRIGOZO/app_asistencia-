<script setup>
    import { toRefs, ref, onMounted, computed } from 'vue';
    import useHorario from '@/Composables/horario.js';
    import useHelper from '@/Helpers';
    const { hideModal, Toast, Swal } = useHelper();
    const props = defineProps({
        personales: Object,
        tipoturnos: Object,
        form: Object
    });

    const {
        errors, respuesta, guardarHorarioAsistencial
    } = useHorario();
    
    const { personales, tipoturnos, form } = toRefs(props)

    const Guardar=async(index)=>{
        form.value.personal = personales.value.personales[index]
        if(personales.value.personales[index].total_horas > 150 && form.value.datosGenerales.tipo_trabajador_id == 1)
        {
            Swal.fire({
                text: 'El total de horas seleccionada supera los 150 para asistencial',
                title: "Turno Roles",
                icon: 'warning',
                confirmButtonColor: '#3085d6',
                confirmButtonText: 'Aceptar'
            })
        }
        else
        {
            await guardarHorarioAsistencial(form.value)
            if(respuesta.value.ok==1){          
                Toast.fire({icon:'success', title:respuesta.value.mensaje})
            }
            personales.value.personales[index].modificado = false;
        }
    }
    const marcarComoModificado=(index)=> {
        personales.value.personales[index].modificado = true;
        let suma = 0;

        personales.value.personales[index].total_horas = 0;

        for (let i = 1; i <= 31; i++) {
            const dayKey = `d${i}`;
            if (personales.value.personales[index][dayKey] !== null) {
                const turno = tipoturnos.value.find(t => t.abreviatura === personales.value.personales[index][dayKey]);
                if (turno) {
                    personales.value.personales[index].total_horas += (turno.totalhoras == null) ? 0 : parseInt(turno.totalhoras);
                }
            }

        }       
    }


</script>
<template>
    <div class="row">
        <div class="col-md-12 mb-1">
            <h2></h2>
            <div class="table-responsive">
                
                <table class="table table-bordered table-hover table-sm table-striped text-sm table-responsive" style="min-width: 1800px;">
                    <thead class="table-dark">
                        <tr>
                            <th class="text-center">#</th>
                            <th>DNI</th>
                            <th>APENOM</th>
                            <th>1</th>
                            <th>2</th>
                            <th>3</th>
                            <th>4</th>
                            <th>5</th>
                            <th>6</th>
                            <th>7</th>
                            <th>8</th>
                            <th>9</th>
                            <th>10</th>
                            <th>11</th>
                            <th>12</th>
                            <th>13</th>
                            <th>14</th>
                            <th>15</th>
                            <th>16</th>
                            <th>17</th>
                            <th>18</th>
                            <th>19</th>
                            <th>20</th>
                            <th>21</th>
                            <th>22</th>
                            <th>23</th>
                            <th>24</th>
                            <th>25</th>
                            <th>26</th>
                            <th>27</th>
                            <th>28</th>
                            <th>29</th>
                            <th>30</th>
                            <th>31</th>
                            <th>Accion</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(personal, pindex) in personales.personales" :key="personal.id">
                            <td class="fs-8">{{ pindex+1 }}</td>
                            <td class="fs-8">{{ personal.numero_dni }}</td>
                            <td class="fs-8">{{ personal.apellidos_nombres }}</td>
                            <td>
                                <select v-model="personal.d1" class="form-control custom-select-sm" :name="'turno['+pindex+'][d1]'"
                                :class="{ 'is-invalid': personal.errors?.d1 }" @change="marcarComoModificado(pindex)">
                                    <option :value="null">--</option>
                                    <option v-for="tt in tipoturnos" :value="tt.abreviatura" :data-totalhoras="tt.totalhoras">{{ tt.abreviatura }}</option>
                                </select>
                            </td>
                            <td>
                                <select v-model="personal.d2" class="form-control custom-select-sm" :name="'turno['+pindex+'][d2]'"
                                :class="{ 'is-invalid': personal.errors?.d2 }" @change="marcarComoModificado(pindex)">
                                    <option :value="null">--</option>
                                    <option v-for="tt in tipoturnos" :value="tt.abreviatura" :data-totalhoras="tt.totalhoras">{{ tt.abreviatura }}</option>
                                </select>
                            </td>
                            <td>
                                <select v-model="personal.d3" class="form-control custom-select-sm" :name="'turno['+pindex+'][d3]'"
                                :class="{ 'is-invalid': personal.errors?.d3 }" @change="marcarComoModificado(pindex)">
                                    <option :value="null">--</option>
                                    <option v-for="tt in tipoturnos" :value="tt.abreviatura" :data-totalhoras="tt.totalhoras">{{ tt.abreviatura }}</option>
                                </select>
                            </td>
                            <td>
                                <select v-model="personal.d4" class="form-control custom-select-sm" :name="'turno['+pindex+'][d4]'"
                                :class="{ 'is-invalid': personal.errors?.d4 }" @change="marcarComoModificado(pindex)">
                                    <option :value="null">--</option>
                                    <option v-for="tt in tipoturnos" :value="tt.abreviatura" :data-totalhoras="tt.totalhoras">{{ tt.abreviatura }}</option>
                                </select>
                            </td>
                            <td>
                                <select v-model="personal.d5" class="form-control custom-select-sm" 
                                :class="{ 'is-invalid': personal.errors?.d5 }" @change="marcarComoModificado(pindex)">
                                    <option :value="null">--</option>
                                    <option v-for="tt in tipoturnos" :value="tt.abreviatura" :data-totalhoras="tt.totalhoras">{{ tt.abreviatura }}</option>
                                </select>
                            </td>
                            <td>
                                <select v-model="personal.d6" class="form-control custom-select-sm" 
                                :class="{ 'is-invalid': personal.errors?.d6 }" @change="marcarComoModificado(pindex)">
                                    <option :value="null">--</option>
                                    <option v-for="tt in tipoturnos" :value="tt.abreviatura" :data-totalhoras="tt.totalhoras">{{ tt.abreviatura }}</option>
                                </select>
                            </td>
                            <td>
                                <select v-model="personal.d7" class="form-control custom-select-sm" 
                                :class="{ 'is-invalid': personal.errors?.d7 }" @change="marcarComoModificado(pindex)">
                                    <option :value="null">--</option>
                                    <option v-for="tt in tipoturnos" :value="tt.abreviatura" :data-totalhoras="tt.totalhoras">{{ tt.abreviatura }}</option>
                                </select>
                            </td>
                            <td>
                                <select v-model="personal.d8" class="form-control custom-select-sm" 
                                :class="{ 'is-invalid': personal.errors?.d8 }" @change="marcarComoModificado(pindex)">
                                    <option :value="null">--</option>
                                    <option v-for="tt in tipoturnos" :value="tt.abreviatura" :data-totalhoras="tt.totalhoras">{{ tt.abreviatura }}</option>
                                </select>
                            </td>
                            <td>
                                <select v-model="personal.d9" class="form-control custom-select-sm" 
                                :class="{ 'is-invalid': personal.errors?.d9 }" @change="marcarComoModificado(pindex)">
                                    <option :value="null">--</option>
                                    <option v-for="tt in tipoturnos" :value="tt.abreviatura" :data-totalhoras="tt.totalhoras">{{ tt.abreviatura }}</option>
                                </select>
                            </td>
                            <td>
                                <select v-model="personal.d10" class="form-control custom-select-sm" 
                                :class="{ 'is-invalid': personal.errors?.d10 }" @change="marcarComoModificado(pindex)">
                                    <option :value="null">--</option>
                                    <option v-for="tt in tipoturnos" :value="tt.abreviatura" :data-totalhoras="tt.totalhoras">{{ tt.abreviatura }}</option>
                                </select>
                            </td>
                            <td>
                                <select v-model="personal.d11" class="form-control custom-select-sm" 
                                :class="{ 'is-invalid': personal.errors?.d11 }" @change="marcarComoModificado(pindex)">
                                    <option :value="null">--</option>
                                    <option v-for="tt in tipoturnos" :value="tt.abreviatura" :data-totalhoras="tt.totalhoras">{{ tt.abreviatura }}</option>
                                </select>
                            </td>
                            <td>
                                <select v-model="personal.d12" class="form-control custom-select-sm" 
                                :class="{ 'is-invalid': personal.errors?.d12 }" @change="marcarComoModificado(pindex)">
                                    <option :value="null">--</option>
                                    <option v-for="tt in tipoturnos" :value="tt.abreviatura" :data-totalhoras="tt.totalhoras">{{ tt.abreviatura }}</option>
                                </select>
                            </td>
                            <td>
                                <select v-model="personal.d13" class="form-control custom-select-sm" 
                                :class="{ 'is-invalid': personal.errors?.d13 }" @change="marcarComoModificado(pindex)">
                                    <option :value="null">--</option>
                                    <option v-for="tt in tipoturnos" :value="tt.abreviatura" :data-totalhoras="tt.totalhoras">{{ tt.abreviatura }}</option>
                                </select>
                            </td>
                            <td>
                                <select v-model="personal.d14" class="form-control custom-select-sm" 
                                :class="{ 'is-invalid': personal.errors?.d14 }" @change="marcarComoModificado(pindex)">
                                    <option :value="null">--</option>
                                    <option v-for="tt in tipoturnos" :value="tt.abreviatura" :data-totalhoras="tt.totalhoras">{{ tt.abreviatura }}</option>
                                </select>
                            </td>
                            <td>
                                <select v-model="personal.d15" class="form-control custom-select-sm" 
                                :class="{ 'is-invalid': personal.errors?.d15 }" @change="marcarComoModificado(pindex)">
                                    <option :value="null">--</option>
                                    <option v-for="tt in tipoturnos" :value="tt.abreviatura" :data-totalhoras="tt.totalhoras">{{ tt.abreviatura }}</option>
                                </select>
                            </td>
                            <td>
                                <select v-model="personal.d16" class="form-control custom-select-sm" 
                                :class="{ 'is-invalid': personal.errors?.d16 }" @change="marcarComoModificado(pindex)">
                                    <option :value="null">--</option>
                                    <option v-for="tt in tipoturnos" :value="tt.abreviatura" :data-totalhoras="tt.totalhoras">{{ tt.abreviatura }}</option>
                                </select>
                            </td>
                            <td>
                                <select v-model="personal.d17" class="form-control custom-select-sm" 
                                :class="{ 'is-invalid': personal.errors?.d17 }" @change="marcarComoModificado(pindex)">
                                    <option :value="null">--</option>
                                    <option v-for="tt in tipoturnos" :value="tt.abreviatura" :data-totalhoras="tt.totalhoras">{{ tt.abreviatura }}</option>
                                </select>
                            </td>
                            <td>
                                <select v-model="personal.d18" class="form-control custom-select-sm" 
                                :class="{ 'is-invalid': personal.errors?.d18 }" @change="marcarComoModificado(pindex)">
                                    <option :value="null">--</option>
                                    <option v-for="tt in tipoturnos" :value="tt.abreviatura" :data-totalhoras="tt.totalhoras">{{ tt.abreviatura }}</option>
                                </select>
                            </td>
                            <td>
                                <select v-model="personal.d19" class="form-control custom-select-sm" 
                                :class="{ 'is-invalid': personal.errors?.d19 }" @change="marcarComoModificado(pindex)">
                                    <option :value="null">--</option>
                                    <option v-for="tt in tipoturnos" :value="tt.abreviatura" :data-totalhoras="tt.totalhoras">{{ tt.abreviatura }}</option>
                                </select>
                            </td>
                            <td>
                                <select v-model="personal.d20" class="form-control custom-select-sm" 
                                :class="{ 'is-invalid': personal.errors?.d20 }" @change="marcarComoModificado(pindex)">
                                    <option :value="null">--</option>
                                    <option v-for="tt in tipoturnos" :value="tt.abreviatura" :data-totalhoras="tt.totalhoras">{{ tt.abreviatura }}</option>
                                </select>
                            </td>
                            <td>
                                <select v-model="personal.d21" class="form-control custom-select-sm" 
                                :class="{ 'is-invalid': personal.errors?.d21 }" @change="marcarComoModificado(pindex)">
                                    <option :value="null">--</option>
                                    <option v-for="tt in tipoturnos" :value="tt.abreviatura" :data-totalhoras="tt.totalhoras">{{ tt.abreviatura }}</option>
                                </select>
                            </td>
                            <td>
                                <select v-model="personal.d22" class="form-control custom-select-sm" 
                                :class="{ 'is-invalid': personal.errors?.d22 }" @change="marcarComoModificado(pindex)">
                                    <option :value="null">--</option>
                                    <option v-for="tt in tipoturnos" :value="tt.abreviatura" :data-totalhoras="tt.totalhoras">{{ tt.abreviatura }}</option>
                                </select>
                            </td>
                            <td>
                                <select v-model="personal.d23" class="form-control custom-select-sm" 
                                :class="{ 'is-invalid': personal.errors?.d23 }" @change="marcarComoModificado(pindex)">
                                    <option :value="null">--</option>
                                    <option v-for="tt in tipoturnos" :value="tt.abreviatura" :data-totalhoras="tt.totalhoras">{{ tt.abreviatura }}</option>
                                </select>
                            </td>
                            <td>
                                <select v-model="personal.d24" class="form-control custom-select-sm" 
                                :class="{ 'is-invalid': personal.errors?.d24 }" @change="marcarComoModificado(pindex)">
                                    <option :value="null">--</option>
                                    <option v-for="tt in tipoturnos" :value="tt.abreviatura" :data-totalhoras="tt.totalhoras">{{ tt.abreviatura }}</option>
                                </select>
                            </td>
                            <td>
                                <select v-model="personal.d25" class="form-control custom-select-sm" 
                                :class="{ 'is-invalid': personal.errors?.d25 }" @change="marcarComoModificado(pindex)">
                                    <option :value="null">--</option>
                                    <option v-for="tt in tipoturnos" :value="tt.abreviatura" :data-totalhoras="tt.totalhoras">{{ tt.abreviatura }}</option>
                                </select>
                            </td>
                            <td>
                                <select v-model="personal.d26" class="form-control custom-select-sm" 
                                :class="{ 'is-invalid': personal.errors?.d26 }" @change="marcarComoModificado(pindex)">
                                    <option :value="null">--</option>
                                    <option v-for="tt in tipoturnos" :value="tt.abreviatura" :data-totalhoras="tt.totalhoras">{{ tt.abreviatura }}</option>
                                </select>
                            </td>
                            <td>
                                <select v-model="personal.d27" class="form-control custom-select-sm" 
                                :class="{ 'is-invalid': personal.errors?.d27 }" @change="marcarComoModificado(pindex)">
                                    <option :value="null">--</option>
                                    <option v-for="tt in tipoturnos" :value="tt.abreviatura" :data-totalhoras="tt.totalhoras">{{ tt.abreviatura }}</option>
                                </select>
                            </td>
                            <td>
                                <select v-model="personal.d28" class="form-control custom-select-sm" 
                                :class="{ 'is-invalid': personal.errors?.d28 }" @change="marcarComoModificado(pindex)">
                                    <option :value="null">--</option>
                                    <option v-for="tt in tipoturnos" :value="tt.abreviatura" :data-totalhoras="tt.totalhoras">{{ tt.abreviatura }}</option>
                                </select>
                            </td>
                            <td>
                                <select v-model="personal.d29" class="form-control custom-select-sm" 
                                :class="{ 'is-invalid': personal.errors?.d29 }" @change="marcarComoModificado(pindex)">
                                    <option :value="null">--</option>
                                    <option v-for="tt in tipoturnos" :value="tt.abreviatura" :data-totalhoras="tt.totalhoras">{{ tt.abreviatura }}</option>
                                </select>
                            </td>
                            <td>
                                <select v-model="personal.d30" class="form-control custom-select-sm" 
                                :class="{ 'is-invalid': personal.errors?.d30 }" @change="marcarComoModificado(pindex)">
                                    <option :value="null">--</option>
                                    <option v-for="tt in tipoturnos" :value="tt.abreviatura" :data-totalhoras="tt.totalhoras">{{ tt.abreviatura }}</option>
                                </select>
                            </td>
                            <td>
                                <select v-model="personal.d31" class="form-control custom-select-sm" 
                                :class="{ 'is-invalid': personal.errors?.d31 }" @change="marcarComoModificado(pindex)">
                                    <option :value="null">--</option>
                                    <option v-for="tt in tipoturnos" :value="tt.abreviatura" :data-totalhoras="tt.totalhoras">{{ tt.abreviatura }}</option>
                                </select>
                            </td>
                            <td>
                                <button title="Guardar" class="btn btn-sm btn-primary" :disabled="!personal.modificado" @click="Guardar(pindex)">
                                    <i class="fa-solid fa-floppy-disk"></i>
                                </button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</template>