<template>
    <app-layout>
        <div class="grid sm:grid-cols-1 md:grid-cols-6 ">
            <div class="md:col-start-3 md:col-span-2">
                <qrcode :codigo-invitacion="codigoInvitacion">
                    <template #description>

                    </template>
                    <template #action>

                    </template>
                </qrcode>
            </div>
        </div>
    </app-layout>
</template>

<script>
import QR from "@/Pages/Invitaciones/partial/QR";
import AppLayout from "@/Layouts/AppLayout";

export default {
    name: "Informacion",

    props: {
        codigoInvitacion: {
            type: String,
            required: true
        },
    },

    components: {
        qrcode: QR,
        AppLayout
    }
}
</script>

<style scoped>

</style>
