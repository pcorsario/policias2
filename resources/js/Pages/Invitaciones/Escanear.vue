<template>
    <app-layout>
        <div class="grid sm:grid-cols-1 md:grid-cols-6">
            <div class="md:col-span-6 lg:col-start-3 lg:col-span-2">
                <el-card :body-style="{ padding: '0px' }" class="mt-4">
                    <div style="padding: 14px;">
                        <h1 class="font-bold mb-4 text-lg">Escaner de invitaciones</h1>
                        <el-divider></el-divider>
                        <div class="bottom" >
                            <div id="lector-qr" style="min-height: 500px" class="w-full mb-4"></div>
                            <div class="text-right">
                                <el-button type="primary" @click="iniciarEscaneo" size="large">
                                    <i class="fas fa-qrcode"></i>
                                    Escanear nuevamente
                                </el-button>
                            </div>
                        </div>

                    </div>

                </el-card>

            </div>
        </div>

        <Dialog header="Datos de invitación" v-model:visible="modalFormVisible" :modal="true" position="top"
                :breakpoints="{'960px': '75vw', '640px': '100vw'}" :style="{width: '30vw'}">
            <tabla-asignacion v-if="datosInvitacion !== null"></tabla-asignacion>
            <tabla-asignacion v-if="datosInvitacion !== null" :data="datosInvitacion"></tabla-asignacion>

            <div class="mt-2 text-right" v-if="asistenciaRegistrada">
                <el-alert
                    title="Esta invitación ya ha sido registrada anteriormente, no se puede volver a registrar"
                    type="warning"
                    class="mb-2"
                >
                </el-alert>
                <el-button @click="cerrarModal">Cerrar</el-button>
            </div>


            <div v-else class="mt-4 text-right">
                <el-button @click="cerrarModal">Cerrar</el-button>
                <el-button @click="confirmarAsistencia" type="primary">Confirmar asistencia</el-button>
            </div>

        </Dialog>
    </app-layout>

</template>

<script>

import "primevue/resources/themes/saga-blue/theme.css";
import "primevue/resources/primevue.min.css";
import Dialog from 'primevue/dialog';
import AppLayout from '@/Layouts/AdminLayout';
import TablaAsignacion from "@/Pages/Asignacion/TablaAsignacion";

export default {
    name: "Escanear",

    components: {
        Dialog, AppLayout, TablaAsignacion
    },

    data() {
        return {
            modalFormVisible: false,
            datosInvitacion: null,
            loading: false,
        }
    },

    mounted() {
        this.iniciarEscaneo()
    },

    methods: {
        obtenerInformacion(codigoInvitacion) {
            const response = axios.get(route('invitacion.comprobar', codigoInvitacion))
                .then(response => {
                    this.datosInvitacion = response.data;
                    this.modalFormVisible = true;
                })
                .catch(error => {
                    this.$notify({
                        message: 'Codigo de invitación erroreo',
                        type: 'error'
                    });
                    this.iniciarEscaneo();
                });

        },

        confirmarAsistencia() {

            const response = axios.post(
                route('invitacion.asistencia.confirmar'), {id: this.datosInvitacion.idSP})
                .then(response => {
                    if (response.data.status == 'success') {
                        this.$notify({
                            message: 'Se registró correctamente la asistencia.',
                            type: 'success'
                        });
                        this.cerrarModal();
                    }
                }).catch(function (error) {
                    alert(error.response);
                });


        },

        async iniciarEscaneo() {
            const lectorQr = new Html5Qrcode('lector-qr');

            const qrSuccessCallback = (decodedText, decodedResult) => {
                lectorQr.stop();
                this.obtenerInformacion(decodedText);
            };

            const config = {fps: 10, qrbox: 250};

            lectorQr.start(
                { facingMode: "environment" },
                config,
                qrSuccessCallback
            );
        },

        cerrarModal() {
            this.modalFormVisible = false;
            this.datosInvitacion = null;
            this.iniciarEscaneo();
        },

    },

    computed: {
        asistenciaRegistrada() {
            const ASISTIO = 's';
            return this.datosInvitacion.asistencia === ASISTIO;
        }
    }
}
</script>

<style scoped>

</style>
