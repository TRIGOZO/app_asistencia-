<template>
        <div id="layoutAuthentication">
            <div id="layoutAuthentication_content">
                <main>
                    <div class="container-xl px-4">
                        <div class="row justify-content-center">
                            <div class="col-lg-5">
                                <!-- Basic login form-->
                                <div class="card shadow-lg border-0 rounded-lg mt-5">
                                    <div class="card-header justify-content-center"><h3 class="fw-light my-4">Login</h3></div>
                                    <div class="card-body">
                                        <!-- Login form-->
                                        <form action="" @submit.prevent="autenticar">
                                            <!-- Form Group (email address)-->
                                            <div class="mb-3">
                                                <label class="small mb-1" for="inputEmailAddress">Nombre Usuario</label>
                                                <input class="form-control" v-model="user.username" type="text" placeholder="Ingrese Nombre de Usuario">
                                                <small class="text-danger" v-for="error in errors.username" :key="error">{{ error }}</small>
                                            </div>
                                            <!-- Form Group (password)-->
                                            <div class="mb-3">
                                                <label class="small mb-1" for="inputPassword">Clave</label>
                                                <input class="form-control" v-model="user.password" type="password" placeholder="Ingrese Clave">
                                                <small class="text-danger" v-for="error in errors.password" :key="error">{{ error }}</small>
                                            </div>
                                            <!-- Form Group (remember password checkbox)-->
                                            <div class="mb-3">
                                                <div class="form-check">
                                                    <input class="form-check-input" id="rememberPasswordCheck" type="checkbox" value="">
                                                    <label class="form-check-label" for="rememberPasswordCheck">Remember password</label>
                                                </div>
                                            </div>
                                            <!-- Form Group (login box)-->
                                            <div class="d-flex align-items-center justify-content-between mt-4 mb-0">
                                                <a class="small" href="auth-password-basic.html">Olvidaste la Clave?</a>
                                                <button class="btn btn-primary" type="submit">Ingresar</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </main>
            </div>
            <div id="layoutAuthentication_footer">
                <footer class="footer-admin mt-auto footer-dark">
                    <div class="container-xl px-4">
                        <div class="row">
                            <div class="col-md-6 small">Copyright © Cristian Wilmer Figueroa Ferrer 2023</div>
                            <div class="col-md-6 text-md-end small">
                                <a href="#!">Privacy Policy</a>
                                ·
                                <a href="#!">Terms &amp; Conditions</a>
                            </div>
                        </div>
                    </div>
                </footer>
            </div>
        </div>
</template>

<script>
import { ref, provide } from 'vue';
import useAutenticacion from  '@/Composables/autenticacion'

export default {
    setup() {
        const { errors, loginUsuario } = useAutenticacion()

        const user = ref({
            username:'',
            password:'',
            rememberme:false
        });

        const autenticar = async() => {
            await loginUsuario(user.value)
        }

        return {
            errors, user,
            autenticar
        }
    },
}
</script>
