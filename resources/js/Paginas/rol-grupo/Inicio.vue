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
    import html2canvas from 'html2canvas'
    import jspdf from 'jspdf'
    const {
        profesiones, listaProfesiones
    } = useProfesion();
    const {
        tipoturnos, listaTipoTurnos
    } = useTipoTurno();  
    const {
        tipotrabajadores, listaTipoTrabajadores
    } = useTipoTrabajador();        
    const { meses, formatoFecha, openModal } = useHelper();
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
        "DIA 1": "d1",
        "DIA 2": "d2",
        "DIA 3": "d3",
        "DIA 4": "d4",
        "DIA 5": "d5",
        "DIA 6": "d6",
        "DIA 7": "d7",
        "DIA 8": "d8",
        "DIA 9": "d9",
        "DIA 10": "d10",
        "DIA 11": "d11",
        "DIA 12": "d12",
        "DIA 13": "d13",
        "DIA 14": "d14",
        "DIA 15": "d15",
        "DIA 16": "d16",
        "DIA 17": "d17",
        "DIA 18": "d18",
        "DIA 19": "d19",
        "DIA 20": "d20",
        "DIA 21": "d21",
        "DIA 22": "d22",
        "DIA 23": "d23",
        "DIA 24": "d24",
        "DIA 25": "d25",
        "DIA 26": "d26",
        "DIA 27": "d27",
        "DIA 28": "d28",
        "DIA 29": "d29",
        "DIA 30": "d30",
        "DIA 31": "d31",
        "DIA Total Horas": "total_horas",
    })
    const downloadPDF=()=>{
        let canvas = document.getElementById('canvas')
        openModal('#modalreporterolturno')
        html2canvas(canvas).then((canvas) => {
            let img = '/img/logo.jpg';
            let doc = new jspdf();

            const textToCenter = "GOBIERNO REGIONAL HUANUCO";
            let posy = 20
            let textWidth = doc.getTextDimensions(textToCenter).w;
            let centerX = (doc.internal.pageSize.getWidth() - textWidth) / 2;

            doc.addImage(img, 'png', 8, 2);

            doc.setFontSize(14);
            //doc.setFont("Arial", "italic", "bold");
            doc.text(textToCenter, centerX+15, posy);
            let texto = "DIRECCIÓN REGIONAL DE SALUD";
            posy+=10
            doc.text(texto, centerX, posy);
            posy+=10
            texto = "UNIDAD EJECUTORA 404 - RED DE SALUD HUÁNUCO";

           
            //doc.save("output.pdf");
            let pdfData = doc.output('blob');

            // Crea un objeto Blob con los datos del PDF
            let blob = new Blob([pdfData], { type: 'application/pdf' });

            // Crea una URL para el Blob
            let url = URL.createObjectURL(blob);


            // let link = document.createElement('a');
            // link.href = url;
            // link.target = '_blank';
            // link.textContent = 'Abrir PDF';
          
            // document.body.appendChild(link);


            const iframe = document.getElementById('pdfPreview');
            iframe.src = url;
            iframe.setAttribute('sandbox', 'allow-same-origin allow-scripts');



        })
    }
    const generarRoles=async()=>{
        mostrarRoles.value=true
        await listaTipoTurnos()
        await obtenerPersonalesEstablecimiento(form.value);

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
                        <button class="btn btn-primary" @click="generarRoles()"><i class="fa-solid fa-download"></i>&nbsp;Generar</button>&nbsp;
                        <JsonExcel class="btn btn-success" :fields="jsonFields" :data="personales.personales">
                            <i class="fa-solid fa-file-excel"></i>
                        </JsonExcel>&nbsp;
                        <button class="btn btn-danger" @click="downloadPDF()"><i class="fa-solid fa-file-pdf"></i></button>
                    </div>
                </div>
                <div class="row" v-if="mostrarRoles">
                    <roles :personales="personales" :tipoturnos="tipoturnos" :form="formRolePersonal"></roles>
                </div>
            </div>
        </div>
      </div>
        <div class="modal fade" id="modalreporterolturno" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="modalreporterolturnoLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="modalreporterolturnoLabel">PDF</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col">
                                <iframe id="pdfPreview" width="100%" height="500"></iframe>
                            </div>                            
                        </div>
                        <div class="row d-none">
                            <div class="col">
                                <canvas id="canvas"></canvas>
                            </div>

                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">{{ (form.estadoCrud=='nuevo') ? 'Guardar' : 'Actualizar' }}</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>




