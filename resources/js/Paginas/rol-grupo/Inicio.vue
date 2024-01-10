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
    const estado=ref(1);
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
    const verPDF=()=>{
        let canvas = document.getElementById('canvas')
        let ctx = canvas.getContext('2d');
        ctx.imageSmoothingEnabled = true;
        ctx.webkitImageSmoothingEnabled = true;
        ctx.mozImageSmoothingEnabled = true;
        ctx.msImageSmoothingEnabled = true;
        ctx.imageSmoothingQuality = 'high';
        ctx.clearRect(0, 0, canvas.width, canvas.height);
        const iframe = document.getElementById('pdfPreview');
        iframe.src = '';
        openModal('#modalreporterolturno')
        html2canvas(canvas).then((canvas) => {
            let img = '/img/logo.jpg';
            let doc = new jspdf('l');
            const textToCenter = "GOBIERNO REGIONAL HUANUCO";
            let y = 10
            let textWidth = doc.getTextDimensions(textToCenter).w;
            let centerX = (doc.internal.pageSize.getWidth() - textWidth) / 2;
            doc.addImage(img, 'png', 8, 2);
            doc.setFontSize(14);
            doc.text(textToCenter, centerX+15, y);
            let texto = "DIRECCIÓN REGIONAL DE SALUD";
            y+=7
            doc.text(texto, centerX, y);
            texto = "UNIDAD EJECUTORA 404 - RED DE SALUD HUÁNUCO "+personales.value.personales.length+" "+doc.internal.pageSize.getWidth();
            y+=7
            doc.text(texto, centerX, y);
            y+=5
            //tabla
            let x = 5;
            let ycelda = y+8;
            let xcelda = x;
            let espaciodni = 20;
            let espacioapenom = 48;
            let espaciocelda = 7.1;            
            doc.rect(xcelda, ycelda, espaciodni, 9);
            y+=6;
            doc.text('DNI', x+8, y+8);
            x += 30;
            xcelda+=espaciodni;
            if(personales.value.diasDelMes.length<30){
                espacioapenom = 75;
                espaciocelda = 6.5;
            }
            doc.rect(xcelda, ycelda, espacioapenom, 9);
            doc.text('APENOM', x, y+8);
            xcelda+=espacioapenom;
            x = espacioapenom+espaciodni+7;

            for (let dia of personales.value.diasDelMes) {
                doc.rect(xcelda, ycelda-9, espaciocelda, 9);
                doc.rect(xcelda, ycelda, espaciocelda, 9);
                let diaText = dia.nombreDia;
                let diaNum = dia.dia;
                // let diaText = `${dia.dia}\n${dia.nombreDia}`;
                doc.text(diaText, x, y);
                doc.text(diaNum.toString(), x, y+8);
                x+=espaciocelda
                if(diaNum==10){
                    x=x-0.6;
                }
                xcelda+=espaciocelda
            }
            y+=18;
            doc.setFontSize(10);
            ycelda=y-7;
            let contador=1;
            for (let persona of personales.value.personales) {
                x=5;
                xcelda=x;
                doc.rect(xcelda, ycelda, espaciodni, 8);
                doc.text(persona.numero_dni, x+2, y);
                x+=espaciodni;
                xcelda+=espaciodni;
                doc.setFontSize(8);
                const lineas = doc.splitTextToSize(persona.apellidos_nombres, espacioapenom-1);
                lineas.forEach((linea, index) => {
                    const yActual = (y-3) + (index * 3);
                    doc.text(linea, x + 1, yActual, { align: 'justify' });
                });               
                doc.rect(xcelda, ycelda, espacioapenom, 8);
                xcelda=espaciodni+espacioapenom+5;
                x=xcelda;
                doc.setFontSize(10);
                for(let i=1; i<=personales.value.diasDelMes.length; i++){
                    const dayKey = `d${i}`;
                    doc.rect(xcelda, ycelda, espaciocelda, 8);
                    if (persona[dayKey] !== null) {
                        doc.text(persona[dayKey].toString(), x+1, y);
                    }
                    xcelda+=espaciocelda
                    x+=espaciocelda
                }
                y+=8;
                ycelda+=8;
                contador+=1;
                if(contador % 20==0){
                    y=22;
                    ycelda=y-7;
                    doc.addPage();
                }
            }
            let pdfData = doc.output('blob');
            let blob = new Blob([pdfData], { type: 'application/pdf' });
            let url = URL.createObjectURL(blob);
            iframe.src = url;
            iframe.setAttribute('sandbox', 'allow-scripts');
        })
    }
    const generarRoles=async()=>{
        mostrarRoles.value=true
        estado.value=2;
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
            estado.value=1;
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
                        <template v-if="mostrarRoles">
                            <JsonExcel class="btn btn-success" :fields="jsonFields" :data="personales.personales">
                                <i class="fa-solid fa-file-excel"></i>
                            </JsonExcel>&nbsp;
                            <button class="btn btn-danger" @click="verPDF()"><i class="fa-solid fa-file-pdf"></i></button>
                        </template>
                    </div>
                </div>
                <div class="row" v-if="mostrarRoles">
                    <template v-if="estado==2">
                        <div class="sk-chase">
                            <div class="sk-chase-dot"></div>
                            <div class="sk-chase-dot"></div>
                            <div class="sk-chase-dot"></div>
                            <div class="sk-chase-dot"></div>
                            <div class="sk-chase-dot"></div>
                            <div class="sk-chase-dot"></div>
                        </div>
                    </template>
                    <template v-else>
                        <roles :personales="personales" :tipoturnos="tipoturnos" :form="formRolePersonal"></roles>
                    </template>
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
                </div>
            </div>
        </div>
    </div>
</template>




