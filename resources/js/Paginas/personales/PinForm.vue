<script setup>
    import { ref, onMounted } from 'vue';
    const pin = ref('');
    const addNumber = (number) =>{
        if (pin.value.length < 4) {
            pin.value += number;
        }
    }
    const numbers = [1, 2, 3, 4, 5, 6, 7, 8, 9, '', 0, ''];
</script>
<template>
    <form @submit.prevent="guardar">
    <div class="modal fade" id="modalpin" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="modalpinLabel" aria-hidden="true">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="modalpinLabel">INGRESE PIN</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="card">
                        <div class="card-body">
                            <div>
                                <input
                                    type="password"
                                    v-model="pin"
                                    :maxlength="4"
                                    readonly
                                    class="form-control mb-4"
                                >
                                <div class="row">

                                    <div class="col-md-4" v-for="number in numbers" :key="number">
                                        <button                                            
                                            class="btn btn-lg btn-secondary"
                                            @click="addNumber(number)">
                                            {{ number }}
                                        </button>
                                    </div>                                    
                                </div>

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

</template>