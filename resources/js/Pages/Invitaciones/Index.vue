<template>
    <app-layout>

        <div class="flex">
            <el-card class="lg:w-full md:w-full sm:w-full">
                <div class="flex justify-between items-center">
                    <h2 class="font-bold">Invitaciones de delegados</h2>
                </div>
                <el-divider class="my-3"></el-divider>
                <DataTable :value="asignacionesADelegados" class="p-datatable-sm" :paginator="true"
                           dataKey="idSP"
                           :rows="20"
                           v-model:filters="filters"
                           filterDisplay="menu"
                           :globalFilterFields="['cedula', 'policia', 'ubicacion']"
                           stripedRows
                           rowHover
                           :rowsPerPageOptions="[20,50]"
                           paginatorTemplate="CurrentPageReport FirstPageLink PrevPageLink PageLinks NextPageLink LastPageLink RowsPerPageDropdown"
                           currentPageReportTemplate="Showing {first} to {last} of {totalRecords}"
                           responsiveLayout="scroll">
                    <template #header>
                        <div class="flex justify-between">
                            <div>
                                <el-button type="primary" @click="enviarInvitaciones" icon="el-icon-message"
                                           :disabled="loading">
                                    Enviar invitaciones
                                </el-button>

                                <el-button @click="reenviarInvitaciones" :disabled="loading" class="mr-4">
                                    <i class="pi pi-refresh"></i>
                                    Reenviar invitaciones sin confirmar
                                </el-button>

                                <el-dropdown trigger="click">
                                      <span class="el-dropdown-link">
                                            Mas opciones
                                            <i class="el-icon-arrow-down el-icon--right"></i>
                                      </span>
                                    <template #dropdown>
                                        <el-dropdown-menu>
                                            <el-dropdown-item>
                                                <el-link type="danger" :href="route('invitacion.pdf.exportar')">
                                                    <i class="far fa-file-pdf"></i>
                                                    Exportar a PDF
                                                </el-link>
                                            </el-dropdown-item>
                                            <el-dropdown-item>
                                                <el-link type="success" :href="route('invitacion.exportar')">
                                                    <i class="far fa-file-excel"></i>
                                                    Exportar a excel
                                                </el-link>
                                            </el-dropdown-item>
                                            <el-dropdown-item>
                                                <el-link type="primary" :href="route('policia.reporte.listado')">
                                                    <i class="fas fa-download"></i>
                                                    Descargar listado de control de asistencia
                                                </el-link>
                                            </el-dropdown-item>
                                        </el-dropdown-menu>
                                    </template>
                                </el-dropdown>
                            </div>
                            <div>
                                <el-input v-model="filters['global'].value" placeholder="Buscar..."/>
                            </div>
                        </div>
                    </template>
                    <Column field="ubicacion" header="Ubicación asignada">
                    </Column>
                    <Column field="cedula" header="Cedula"></Column>
                    <Column field="policia" header="Delegado"></Column>
                    <Column field="textoConfirmacion" header="Confirmacion de asistencia">

                        <template #body="{data}">
                            <el-tag :type="data.estiloConfirmacion">
                                {{ data.textoConfirmacion }}
                            </el-tag>
                        </template>
                    </Column>

                    <Column field="textoAsistencia" header="Asistencia al evento">

                        <template #body="{data}">
                            <el-tag :type="data.estiloAsistencia">
                                {{ data.textoAsistencia }}
                            </el-tag>
                        </template>
                    </Column>

                    <Column field="invitacion" header="Invitación">
                        <template #body="{data}">
                            <el-tag type="danger" v-if="poseeCodigoInvitacion(data.invitacion)">
                                No enviada
                            </el-tag>
                            <el-tag v-else type="success">
                                Enviada
                            </el-tag>

                        </template>
                    </Column>
                </DataTable>
            </el-card>
        </div>


    </app-layout>
</template>

<script>

import AdminLayout from "../../Layouts/AdminLayout";

import "primevue/resources/themes/saga-blue/theme.css";
import "primevue/resources/primevue.min.css";
import "primeicons/primeicons.css";
import InputText from 'primevue/inputtext';
import Column from 'primevue/column';
import DataTable from 'primevue/datatable';
import Dialog from 'primevue/dialog';
import Checkbox from 'primevue/checkbox';
import {FilterMatchMode} from 'primevue/api';

const ESTADO_CONFIRMACION = {
    CONFIRMADO: 's',
    NO_CONFIRMADO: 'n',
    NO_ASISTIRA: 'i'
};

const ESTADO_ASISTENCIA = {
    ASITIO: 's',
};

export default {
    name: "IndexInvitaciones",

    components: {
        appLayout: AdminLayout,
        InputText, Column, DataTable, Dialog, Checkbox
    },

    props: {
        asignaciones: {
            type: Object,
            required: true
        }
    },

    data() {
        return {
            records: null,
            formEdit: {},
            filters: {'global': {value: null, matchMode: FilterMatchMode.CONTAINS}},
            loading: false,
        }
    },

    methods: {
        enviarInvitaciones() {
            this.loading = true;
            this.$inertia.post(route('invitacion.enviar.todas'), {}, {
                onSuccess: page => {
                    this.loading = false;
                    this.$notify({
                        message: 'Se enviaron todas las invitaciones a los delegados que no han recibido invitaciones',
                        type: 'success'
                    })
                },
                onError: errors => {
                    this.loading = false;
                    this.$notify({
                        message: 'No se lograron enviar las invitaciones, intente nuevamente',
                        type: 'error'
                    });
                }
            });
        },

        reenviarInvitaciones() {
            this.loading = true;
            this.$inertia.post(route('invitacion.reenviar'), {}, {
                onSuccess: page => {
                    this.loading = false;
                    this.$notify({
                        message: 'Se reenviaron todas las invitaciones nuevamente a los delegados que no han confirmado la asistencia',
                        type: 'success'
                    })
                },
                onError: errors => {
                    this.loading = false;
                    this.$notify({
                        message: 'No se lograron reenviar las invitaciones, intente de nuevo',
                        type: 'error'
                    });
                }
            });
        },

        poseeCodigoInvitacion(codigoInvitacion) {
            return codigoInvitacion == null || codigoInvitacion == '';
        },

        haConfirmadoAsistencia(estadoAsistencia) {
            return estadoAsistencia === ESTADO_CONFIRMACION.NO_CONFIRMADO;
        },

        formatoUbicacion(cuadrante, mesa, silla) {
            return `${cuadrante} - ${mesa} - Silla ${silla}`;
        },

        tipoConfirmacion(estadoInvitacion) {

            if (estadoInvitacion === ESTADO_CONFIRMACION.CONFIRMADO)
                return {
                    text: 'Asistirá',
                    estilo: 'success'
                };

            if (estadoInvitacion === ESTADO_CONFIRMACION.NO_CONFIRMADO)
                return {
                    text: 'Sin confirmar',
                    estilo: 'warning'
                };

            if (estadoInvitacion === ESTADO_CONFIRMACION.NO_ASISTIRA)
                return {
                    text: 'Asistirá',
                    estilo: 'danger'
                };
        },

        estadoAsistencia(estadoAsistencia) {

            if (estadoAsistencia === ESTADO_ASISTENCIA.ASITIO) {
                return {
                    text: 'Asitió',
                    estilo: 'success'
                };
            }

            return {
                text: 'No asistió',
                estilo: 'danger'
            };
        },

    },

    computed: {
        asignacionesADelegados() {
            return this.asignaciones.map(delegado => {
                const confirmacion = this.tipoConfirmacion(delegado.confirmacion);
                const asistencia = this.estadoAsistencia(delegado.asistencia);
                delegado.ubicacion = this.formatoUbicacion(delegado.cuadrante, delegado.mesa, delegado.silla);
                delegado.textoConfirmacion = confirmacion.text;
                delegado.estiloConfirmacion = confirmacion.estilo;
                delegado.textoAsistencia = asistencia.text;
                delegado.estiloAsistencia = asistencia.estilo;
                return delegado;
            });
        }
    },
}
</script>

<style scoped>

</style>
