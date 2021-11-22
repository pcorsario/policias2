<template>
    <app-layout>
        <div class="grid grid-cols-1 sm:grid-cols-6 md:grid-cols-7 lg:grid-cols-6">
            <div class="sm:col-start-2 sm:col-span-4 md:col-start-3 md:col-span-3 lg:col-start-3 lg:col-span-2">
                <el-card :body-style="{ padding: '0px' }" class="mt-4">
                    <img src="/images/logo_policia.jpeg"
                         class="image" style="width: 100%">
                    <div style="padding: 14px;">
                        <h2 class="font-bold mb-4 text-lg">Confirmación de asistencia</h2>

                        <div class="bottom">
                            <p class="text-sm mb-2">
                                Hola {{ datosAsignacion.policia }}
                            </p>
                            <p class="text-sm">
                                El Servicio de Cesantias de la Policía Nacional, le hace la coordial invitación
                                al evento XXXXXX, para el cual se le ha asignado un lugar específico
                                para que pueda XXXXX
                            </p>

                            <div class="mt-4">
                                <tabla-asignacion :data="datosAsignacion"></tabla-asignacion>
                            </div>

                            <div class="flex justify-end mt-2">
                                <el-button type="primary" class="button" @click="guardarInvitacion('s')">
                                    <i class="fas fa-check"></i>
                                    Aceptar invitación
                                </el-button>
                                <el-button type="text" class="text-red-500 hover:text-red-700"
                                           @click="guardarInvitacion('i')">
                                    <i class="fas fa-times"></i>
                                    Rechazar invitación
                                </el-button>
                            </div>

                        </div>
                    </div>
                </el-card>
            </div>
        </div>

    </app-layout>
</template>

<script>

import AppLayout from "@/Layouts/AppLayout";
import TablaAsignacion from "@/Pages/Asignacion/TablaAsignacion";

export default {
    name: "Confirmacion",

    components: {
        AppLayout, TablaAsignacion
    },

    props: {
        datosAsignacion: {
            type: Object,
            required: true
        }
    },

    methods: {
        guardarInvitacion(estadoInvitacion) {
            this.$inertia.post(route('front.invitacion.save'), {
                id: this.datosAsignacion.idSP,
                estado: estadoInvitacion
            }, {
                onSuccess(page) {
                }
            })
        }

    }

}
</script>

<style scoped>

</style>
