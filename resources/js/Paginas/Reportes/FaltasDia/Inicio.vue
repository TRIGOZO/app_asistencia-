<script setup>
  import jwt_decode from 'jwt-decode'
  import { ref, onMounted, inject } from 'vue';
  import { defineTitle } from '@/Helpers';
  import useHelper from '@/Helpers';  
  import useMarcacion from '@/Composables/marcacion.js';
  import ContentHeader from '@/Componentes/ContentHeader.vue';
  import JsonExcel from 'vue-json-excel3';
  import useUsuario from '@/Composables/usuario.js'
  import html2canvas from 'html2canvas'
  import jspdf from 'jspdf'
  const { openModal, Toast, Swal, formatoFecha, meses } = useHelper();

  const { obtenerUsuario2, usuario2 } = useUsuario();
    const { cargarFaltasxFecha, faltas, errors } = useMarcacion();

    const titleHeader = ref({
      titulo: "Reporte - Faltas por Dia",
      subTitulo: "Reportes",
      icon: "",
      vista: ""
    });
    
    const jsonFields = ref({
        "DNI" : "DNI",
        "Apellidos y Nombres": "apenom",
        "Cargo": "cargo",
        "Nivel": "nivel",
        "Cargo": "cargo",
        "Nivel":"nivel",
    })
    const user_id = localStorage.getItem('userSession') ? JSON.parse( JSON.stringify(jwt_decode(localStorage.getItem('userSession')).user)) : null;
    onMounted(()=>{
        buscar()
    });
    const buscar=async()=>{
        await obtenerUsuario2(user_id)
        await cargarFaltasxFecha(dato.value)
        dato.value.establecimiento_id = usuario2.value.establecimiento_id,
        dato.value.errors = []
        if(errors.value)
        {
            dato.value.errors = errors.value
        }
    }
    const dato = ref({
        fecha : formatoFecha(null, 'YYYY-MM-DD'),
        establecimiento_id : '',
        errors:[]
    });
    const downloadPDF=(registro)=>{
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
        registro.apenom+" el día "+
        formatoFecha(registro.fecha, 'D [de] MMMM [del] YYYY')+
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
    <ContentHeader :title-header="titleHeader"></ContentHeader>
    <div class="app-content">
      <div class="container-fluid">
        <div class="card card-primary card-outline">
            <div class="card-header">
                <h6 class="card-title">
                    Busqueda
                </h6>
            </div>
            <div class="card-body">
                <div class="row mb-4">
                    <div class="col-md-2">
                        <div class="input-group mb-1">
                            <span class="input-group-text" id="basic-addon1">FECHA</span>
                            <input type="date" v-model="dato.fecha" class="form-control" :class="{ 'is-invalid': dato.errors.fecha }" @change="buscar">
                        </div>
                        <small class="text-danger" v-for="error in dato.errors.fecha" :key="error">{{ error
                                }}<br></small>
                    </div>
                    <div class="col-md-2 mb-4">
                        <button class="btn btn-primary" @click="buscar()">Cargar</button>&nbsp;
                        <JsonExcel class="btn btn-success" :fields="jsonFields" :data="faltas">
                            <i class="fa-solid fa-file-excel"></i> Descargar
                        </JsonExcel>
                    </div> 
                </div>
                <div class="row">
                    <div class="col-md-12 mb-1">
                        <div class="table-responsive">         
                            <table class="table table-bordered table-hover table-sm table-striped">
                                <thead class="table-dark">
                                    <tr>
                                        <th class="text-center">#</th>
                                        <th>DNI</th>
                                        <th>Nombre y Apellidos</th>
                                        <th>Cargo</th>
                                        <th>Nivel</th>
                                        <th>Accion</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="(registro,index) in faltas" :key="registro.id">
                                        <td class="text-center">{{ index+1 }}</td>
                                        <td>{{ registro.numero_dni }}</td>
                                        <td>{{ registro.apenom }}</td>
                                        <td>{{ registro.cargo }}</td>
                                        <td>{{ registro.nivel }}</td>
                                        <td><td><button class="btn btn-sm btn-warning" title="Formato" @click="downloadPDF(registro)"><i class="fa-solid fa-file"></i></button></td></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <br><br>
      </div>
    </div>
    <canvas id="canvas" width="200" height="500">
    </canvas>
</template>