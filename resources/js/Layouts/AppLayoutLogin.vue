<script setup>
import { cargarClasesLoginLayout } from '@/Helpers';
import { onMounted } from 'vue';

    onMounted(() => {
        cargarClasesLoginLayout();
    })
</script>

<template>
    <div class="login-box">
        <router-view></router-view>
    </div>
</template>
