<script setup>
import { ref } from 'vue';
import {useAutenticacion} from '@/Composables/autenticacion';
import imgLogo from '../../../../public/img/redhcologo.png';

    const user = ref({
        username:'',
        pasword:'',
        remember:false,
        errors:[]
    });

    const {errors, loginUsuario } = useAutenticacion();

    const autenticar = async() => {
        await loginUsuario(user.value);
    }
</script>

<template>
    <div class="login-logo">
        <img :rc="imgLogo">
        <a href="/"><b>ASISTENCIA </b>APP</a>
    </div>
    <div class="card">
        <div class="card-body login-card-body">
            <p class="login-box-msg">Iniciar Sesi&oacute;n</p>
            <form action="" @submit.prevent="autenticar">
                <div class="form-group row">
                    <div class="col-md-12 mb-2">
                        <div class="input-group ">
                            <input type="text" class="form-control" placeholder="Nombre de Usuario"
                                v-model="user.username"
                                :class="{ 'is-invalid' : errors.username }"/>
                            <div class="input-group-text">
                                <span class="fa-solid fa-user"></span>
                            </div>
                        </div>
                        <small class="text-danger" v-for="error in errors.username"
                            :key="error">{{ error }}</small>
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-md-12 mb-2">
                        <div class="input-group">
                            <input type="password" class="form-control" placeholder="Contraseña"
                                v-model="user.password"
                                :class="{ 'is-invalid' : errors.password }" />

                            <div class="input-group-text">
                                <span class="fas fa-lock"></span>
                            </div>
                        </div>
                        <small class="text-danger" v-for="error in errors.password"
                            :key="error">{{ error }}</small>
                    </div>
                </div>
                <div class="row">
                    <div class="col-8">
                        <div class="icheck-primary">
                        <input type="checkbox" id="remember">
                        <label for="remember">
                            Recordarme
                        </label>
                        </div>
                    </div>
                    <!-- /.col -->
                    <div class="col-4">
                        <button type="submit" class="btn btn-primary btn-block">
                            Acceder
                        </button>
                    </div>
                    <!-- /.col -->
                </div>
            </form>
        </div>
    </div>
</template>
