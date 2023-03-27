<template>





    <router-view></router-view>
</template>

<script>
import { onMounted } from 'vue';
import { cargarClasesLoginLayout } from '@/Helpers';
export default {
    setup() {
        onMounted(() => {
            cargarClasesLoginLayout()
        })
    },
}
</script>
