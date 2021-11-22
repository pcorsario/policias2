<template>
    <el-card :body-style="{ padding: '0px' }" class="mt-4">
        <img src="/images/logo_policia.jpeg"
             class="image" style="width: 100%">
        <div style="padding: 14px;">
            <h2 class="font-bold mb-4 text-lg">Codigo QR de invitación</h2>

            <div class="bottom">
                <slot name="description">
                    <p class="text-sm">
                        Gracias por confirmar tu asistencia, ahora solo debe actualizar tu información
                        personal dando click al boton que se encuentra abajo.
                    </p>

                    <p class="text-sm mt-1">
                        Revisa tu correo que te enviaremos un archivo con el codigo QR
                        para que puedas asistir al evento
                    </p>
                </slot>

                <div class="mt-4 flex justify-center">
                    <canvas id="canvas"></canvas>
                </div>

                <slot name="action">
                    <div class="flex justify-end mt-2">
                        <inertia-link :href="route('front.policia.index')">
                            <el-button type="primary" class="button">
                                <i class="fas fa-check"></i>
                                Actualizar mis datos personales
                            </el-button>
                        </inertia-link>
                    </div>
                </slot>

            </div>
        </div>
    </el-card>
</template>

<script>

import AppLayout from "@/Layouts/AppLayout";
import QRCode from 'qrcode';

export default {
    name: "QR",

    props: {
        codigoInvitacion: {
            type: String,
            required: true
        }
    },
    mounted() {
        QRCode.toCanvas(document.getElementById('canvas'), this.codigoInvitacion);
    },

    components: {
        AppLayout
    },
}
</script>

<style scoped>

</style>
