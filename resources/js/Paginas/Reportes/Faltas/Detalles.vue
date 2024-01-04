<script setup>
import { toRefs, onMounted } from 'vue';
import useHelper from '@/Helpers';  
import jspdf from 'jspdf'
import html2canvas from 'html2canvas'
const { hideModal, Toast, formatoFecha } = useHelper();
const props = defineProps({
    personal: Object,
    faltasdetalle: Array
});
const { personal, faltasdetalle } = toRefs(props)

const downloadPDF=(apenom, fecha)=>{
    let canvas = document.getElementById('canvas')
    html2canvas(canvas).then((canvas) => {
        let img = '/img/logo.jpg';
        let doc = new jspdf();

        const textToCenter = "GOBIERNO REGIONAL HUANUCO";
        let posy = 20
        let textWidth = doc.getTextDimensions(textToCenter).w;
        let centerX = (doc.internal.pageSize.getWidth() - textWidth) / 2;

        doc.addImage(img, 'png', 8, 2);

        doc.setFontSize(14);
        doc.setFont("Arial", "italic", "bold");
        doc.text(textToCenter, centerX+15, posy);
        let texto = "DIRECCIÓN REGIONAL DE SALUD";
        posy+=10
        doc.text(texto, centerX, posy);
        posy+=10
        texto = "UNIDAD EJECUTORA 404 - RED DE SALUD HUÁNUCO";
        textWidth = doc.getTextDimensions(texto).w;
        centerX = (doc.internal.pageSize.getWidth() - textWidth) / 2;
        doc.text(texto, centerX, posy);
        posy+=10
        texto = "Año de la Unidad, la Paz y el Desarrollo";
        doc.text(texto, centerX, posy);
        posy+=20
        doc.setFontSize(12);
        doc.text("FORMATO DE FALTAS INJUSTIFICADAS", 10,posy);
        // Texto justificado
        doc.setFontSize(12);
        doc.setFont("Arial", "italic", "normal");
        let posY = 80; // Posición inicial
        const parrafo = "Comunico a Usted que el servidor (a) público "+
        apenom+" el día "+
        formatoFecha(fecha, 'D [de] MMMM [del] YYYY')+
        ", no se hizo presente a Laborar, por lo que de acuerdo a la R.M. Nª 0734-2017-SA/P Art. 31 Incs_B; se ha procedido a Considerar INASISTENCIA INJUSTIFICADA.";

        // Divide el párrafo en líneas
        const lines = doc.splitTextToSize(parrafo, doc.internal.pageSize.getWidth() - 20);

        // Agrega cada línea al PDF
        for (let i = 0; i < lines.length; i++) {
            doc.text(10, posY, lines[i]);
            posY += 10; // Espacio entre líneas
        }
        doc.text("OBSERVACIONES : _________________________________________________________", 10,posY);
        posY += 20
        doc.text("_____________________", 10,posY);
        doc.text("_____________________", 60,posY);
        doc.text("_____________________", 110,posY);
        doc.text("_______________", 170,posY);
        posY += 10
        doc.text("JEFE DE SERVICIO", 10,posY);
        doc.text("UNIDAD RR.HH.", 60,posY);
        doc.text("CONTROL DE ASISTENCIA", 110,posY);
        doc.text("DIRECTOR", 170,posY);        
        posY += 20
        doc.text("RESOLUCION MINISTERIAL Nª 734-2017-MINSA", 10,posY);
        
        doc.save("output.pdf");
    })
}
</script>
<template>
    <form @submit.prevent="guardar">
    <div class="modal fade" id="modaldetallefaltas" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="modaldetallefaltasLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="modaldetallefaltasLabel">Modal title</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <h4>PERSONAL : {{ personal.apenom }}</h4>
                    <div class="row mt-4">
                    <div class="col-md-12 mb-1">
                        <div class="table-responsive">         
                            <table class="table table-bordered table-hover table-sm table-striped">
                                <thead class="table-dark">
                                    <tr>
                                        <th class="text-center">#</th>
                                        <th>NOMBRE DIA</th>
                                        <th>FECHA</th>
                                        <th>Accion</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="(registro,index) in faltasdetalle" :key="registro.id">
                                        <td class="text-center">{{ index+1 }}</td>
                                        <td>{{ registro.nombredia }}</td>
                                        <td>{{ registro.fecha }}</td>
                                        <td><button class="btn btn-sm btn-warning" @click="downloadPDF(personal.apenom, registro.fecha )"><i class="fa-solid fa-file"></i></button></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Guardar</button>
                </div>
            </div>
        </div>
    </div>
    </form>
    <canvas id="canvas" width="200" height="500">
    </canvas>
</template>