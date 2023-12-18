<script setup>
  import jwt_decode from 'jwt-decode'
  import { ref, onMounted } from 'vue';
  import { defineTitle } from '@/Helpers';
  import useHelper from '@/Helpers';  
  import ContentHeader from '@/Componentes/ContentHeader.vue';
  import useEstablecimiento from '@/Composables/establecimientos.js';
  import useMarcacion from '@/Composables/marcacion.js';  
    const {
        obtenerEstablecimientosLista, establecimientos
    } = useEstablecimiento();

    const {
        errors, importarMarcaciones, respuesta
    } = useMarcacion();

  const { openModal, Toast, Swal } = useHelper();
    const titleHeader = ref({
      titulo: "Importar Marcaciones",
      subTitulo: "Inicio",
      icon: "",
      vista: ""
    });
    const datos=ref({
        contador : 0
    })
    const form = ref({
        archivo:'',
        establecimiento_id:'',
        errors:[]
    });
    let intervalId;
    const estado=ref(1);
    const procesarImportacion = async() => {
        let formData = new FormData();
        estado.value = 2
        formData.append('archivo', file.value);
        formData.append('establecimiento_id', form.value.establecimiento_id ?? '');
        await importarMarcaciones(formData)
        form.value.errors = []
        if(errors.value){
            form.value.errors = errors.value

        }
        if(respuesta.value.ok==1){
            form.value.errors = []
            Toast.fire({icon:'success', title:respuesta.value.mensaje})
            
        }
        estado.value=1
        // datos.value.contador += 10;
        // if (datos.value.contador >= 100) {
        //     clearInterval(intervalId);
        // }
    }
    const file = ref(null);
    const cambiarArchivo = (e)=>{
        file.value = e.target.files[0]
    }
    onMounted(()=>{
        //intervalId = setInterval(procesarImportacion(), 1000);
        // intervalId = setInterval(()=>{
        //     procesarImportacion()
        // }, 1000);
        obtenerEstablecimientosLista()
    })
</script>
<template>
    <ContentHeader :title-header="titleHeader"></ContentHeader>
    <div class="app-content">
      <div class="container-fluid">
        <div class="card card-primary card-outline">
            <div class="card-header">
                <h6 class="card-title">
                    IMPORTAR
                </h6>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="archivo" class="form-label">Archivo </label>
                            <div class="input-group">
                                <input type="file" class="form-control" aria-describedby="importarBtn" aria-label="Upload" accept=".dat" :class="{ 'is-invalid': form.errors.archivo }" @change="cambiarArchivo">
                                <button class="btn btn-outline-secondary" type="button" id="importarBtn" @click="procesarImportacion()">Importar</button><br>
                                
                            </div>
                            <small class="text-danger" v-for="error in form.errors.archivo" :key="error">{{ error }}</small>
                        </div>                
                    </div>
                    <div class="col">
                        <div class="mb-3">
                        <label for="establecimiento_id" class="form-label">Establecimiento </label>
                        <select class="form-control" v-model="form.establecimiento_id" :class="{ 'is-invalid': form.errors.establecimiento_id }">
                            <option value="">--Seleccione--</option>
                            <option v-for="establecimiento in establecimientos" :key="establecimiento.id" :value="establecimiento.id"
                                :title="establecimiento.nombre">
                                {{ establecimiento.nombre }}
                            </option>
                        </select>
                        <small class="text-danger" v-for="error in form.errors.establecimiento_id" :key="error">{{ error }}</small>
                    </div>
                    </div>
                    <div class="col">
                        <div class="mb-3">
                            <br>
                            <template v-if="estado!=1">
                                <div class="sk-chase">
                                    <div class="sk-chase-dot"></div>
                                    <div class="sk-chase-dot"></div>
                                    <div class="sk-chase-dot"></div>
                                    <div class="sk-chase-dot"></div>
                                    <div class="sk-chase-dot"></div>
                                    <div class="sk-chase-dot"></div>
                                </div>

                            </template>
                        </div>
                    </div>
                </div>
            </div>
        </div>
      </div>
    </div>

</template>
