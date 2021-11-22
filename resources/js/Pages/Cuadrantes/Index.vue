<template>
    <app-layout>
        <div class="flex">
            <el-card class="lg:w-full md:w-full sm:w-full">
                <div class="flex justify-between items-center">
                    <h2 class="font-bold">Distribución de Cuadrantes</h2>
<!--                    <el-button-->
<!--                        type="primary"-->
<!--                        @click="modalFormVisible = true"-->
<!--                        icon="el-icon-circle-plus-outline">...-->
<!--                    </el-button>-->
                </div>
                <el-divider class="my-3"></el-divider>
                <el-container class="overflow-x-auto">
                    <div class="flex flex-wrap" style="min-width: 1140px; max-width: 1140px">
                        <cuadrante v-for="(cuadrante, index) in cuadrantes" :key="index" :datos="cuadrante"
                                   :editable="true"
                                   :loadSelectedChairs="true">

                        </cuadrante>
                    </div>
                </el-container>
            </el-card>
        </div>
        <Dialog header="Asignar silla" v-model:visible="modalAsignarVisible"
                :modal="true" position="top"
                :breakpoints="{'960px': '75vw', '640px': '100vw'}" :style="{width: '30vw'}">
            <form-asignacion :silla="getSelectedChair.silla" :modal-close="modalAsignarVisible"
                             @cancel="modalAsignarVisible = CERRAR_MODAL"
                             @save="modalAsignarVisible = CERRAR_MODAL">
            </form-asignacion>
        </Dialog>
        <Dialog header="Detalles de asignación de silla" v-model:visible="modalVisualizarAsignacionVisible"
                :modal="true" position="top" :breakpoints="{'960px': '75vw', '640px': '100vw'}"
                :style="{width: '30vw'}">
            <form-asignacion-update :data-form="getSelectedChair.asignacion" @deleted="modalVisualizarAsignacionVisible = CERRAR_MODAL">

            </form-asignacion-update>

        </Dialog>
    </app-layout>
</template>

<script>

import AdminLayout from "@/Layouts/AdminLayout";
import Cuadrante from "@/Pages/Cuadrantes/partial/Cuadrante";
import FormAsignacion from '@/Pages/Asignacion/Form';
import FormAsignacionUpdate from '@/Pages/Asignacion/UpdateForm';
import {mapActions, mapGetters} from 'vuex';

import "primevue/resources/themes/saga-blue/theme.css";
import "primevue/resources/primevue.min.css";
import "primeicons/primeicons.css";
import Dialog from "primevue/dialog";

export default {
    name: "Index",
    props: ['cuadrantes'],
    components: {
        appLayout: AdminLayout,
        Cuadrante, Dialog, FormAsignacion, FormAsignacionUpdate
    },
    data() {
        return {
            modalAsignarVisible: false,
            modalVisualizarAsignacionVisible: false,
            SILLA_SIN_ASIGNAR: undefined,
            CERRAR_MODAL: false
        }
    },
    methods: {
        ...mapActions('Policias', ['deletePoliciesByRanges'])
    },
    computed: {
        ...mapGetters('DistributionConfiguraions', ['getSelectedChair']),

    },
    watch: {
        getSelectedChair(chair) {
            if (chair.asignacion === this.SILLA_SIN_ASIGNAR) {
                this.modalAsignarVisible = true;
                return;
            }

            this.modalVisualizarAsignacionVisible = true;
        },
        modalAsignarVisible(visibilidadModal) {

            if (visibilidadModal === this.CERRAR_MODAL) {
                this.deletePoliciesByRanges();
            }
        }
    }
}
</script>

<style >

</style>
