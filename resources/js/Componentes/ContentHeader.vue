<script setup>
import { useRoute } from 'vue-router';

const props = defineProps({
    titulo: String,
    subTitulo: String,
    icon: String,
    titleHeader: Object
})

const route = useRoute();
const icono = route.meta.icono;

</script>

<template>
     <div class="app-content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6">
                    <h4 class="m-0">
                        <i :class="titleHeader?.icon ? titleHeader?.icon : icono "></i> {{ titleHeader?.titulo }}
                    </h4>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-end">
                        <li class="breadcrumb-item"><a href="/principal">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">
                            {{ route.name }}
                        </li>
                        <li class="breadcrumb-item active" aria-current="page"
                            v-if="titleHeader?.subTitulo">
                            {{ titleHeader?.subTitulo }}
                        </li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
</template>
