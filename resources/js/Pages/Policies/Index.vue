<template>
    <app-layout>
        <div class="flex">
            <el-card class="lg:w-full md:w-full sm:w-full">
                <div class="flex justify-between items-center">
                    <h2 class="font-bold">Delegados</h2>
                    <div>
                        <el-dropdown trigger="click">
                              <span class="el-dropdown-link">
                                    Exportar
                                    <i class="el-icon-arrow-down el-icon--right"></i>
                              </span>
                            <template #dropdown>
                                <el-dropdown-menu>
                                    <el-dropdown-item>
                                        <el-link type="danger" :href="route('policia.pdf.exportar')">
                                            <i class="far fa-file-pdf"></i>
                                            PDF
                                        </el-link>
                                    </el-dropdown-item>
                                    <el-dropdown-item>
                                        <el-link type="success" :href="route('policia.exportar')">
                                            <i class="far fa-file-excel"></i>
                                            Excel
                                        </el-link>
                                    </el-dropdown-item>
                                </el-dropdown-menu>
                            </template>
                        </el-dropdown>

                        <el-button
                            type="primary"
                            class="ml-2"
                            @click="modalFormVisible = true"
                            icon="el-icon-circle-plus-outline">Nuevo delegado
                        </el-button>
                    </div>
                </div>
                <el-divider class="my-3"></el-divider>
                <DataTable :value="getAll" class="p-datatable-sm" :paginator="true"
                           :rows="10"
                           v-model:filters="filters"
                           filterDisplay="menu"
                           :globalFilterFields="['cedula', 'apellido_paterno', 'apellido_materno', 'nombres', 'celular', 'rango.descripcion']"
                           stripedRows
                           rowHover
                           :rowsPerPageOptions="[10,20,50]"
                           paginatorTemplate="CurrentPageReport FirstPageLink PrevPageLink PageLinks NextPageLink LastPageLink RowsPerPageDropdown"
                           currentPageReportTemplate="Showing {first} to {last} of {totalRecords}"
                           responsiveLayout="scroll">
                    <template #header>
                        <div class="flex justify-end">
                            <div>
                                <el-input v-model="filters['global'].value" placeholder="Buscar..."/>
                            </div>
                        </div>
                    </template>
                    <Column field="rango.descripcion" header="Grado"></Column>
                    <Column field="cedula" header="Cedula"></Column>
                    <Column field="nombres" header="Nombres">
                        <template #body="row">
                            <span>
                                {{
                                    `${row.data.apellido_paterno} ${row.data.apellido_materno || ''} ${row.data.nombres}`
                                }}
                            </span>
                        </template>
                    </Column>
                    <Column field="celular" header="Celular"></Column>
                    <Column headerStyle="width:8em" bodyStyle="text-align: center">
                        <template #body="row">
                            <el-button type="text" icon="el-icon-edit" @click="setDataToFormEdit(row.data)">
                                Editar
                            </el-button>
                            <el-dropdown trigger="click">
                                  <span class="el-dropdown-link text-blue-400 text-base">
                                    <i class="el-icon-arrow-down el-icon--right"></i>
                                  </span>
                                <template #dropdown>
                                    <el-dropdown-menu>
                                        <el-dropdown-item>
                                            <el-link type="danger" :href="route('policia.pdf.exportar.individual', row.data)">
                                                <i class="far fa-file-pdf"></i>
                                                Exportar a PDF
                                            </el-link>
                                        </el-dropdown-item>
                                        <el-dropdown-item icon="el-icon-key"
                                                          @click="mostrarModalConfirmacion(row.data)">
                                            Restablecer contraseña
                                        </el-dropdown-item>
                                    </el-dropdown-menu>
                                </template>
                            </el-dropdown>
                        </template>
                    </Column>
                </DataTable>
            </el-card>
        </div>

        <Dialog header="Nuevo policia" v-model:visible="modalFormVisible" :modal="true" position="top"
                :breakpoints="{'960px': '75vw', '640px': '100vw'}" :style="{width: '30vw'}">
            <form-policia
                type-form="new"
                @success="modalFormVisible = false"
                @cancel="modalFormVisible = false"></form-policia>
        </Dialog>

        <Dialog header="Actualizar policia" v-model:visible="modalFormUpdateVisible" :modal="true" position="top"
                :breakpoints="{'960px': '75vw', '640px': '100vw'}" :style="{width: '30vw'}">
            <form-policia
                :errors="errors"
                type-form="update"
                :form-data="formEdit"
                @success="modalFormUpdateVisible = false"
                @error="handleUpdateErrors"
                @cancel="modalFormUpdateVisible = false"></form-policia>
        </Dialog>
        <el-dialog
            title="Restablecimiento de contraseña"
            v-model="confirmDialogVisible"
            width="30%"
        >
            <span>¿Estas seguro que deseas reestablecer la contraseña de este delegado?</span>
            <template #footer>
                <span class="dialog-footer">
                  <el-button @click="confirmDialogVisible = false">No</el-button>
                  <el-button type="primary" @click="confirmarRestablecimiento" :disabled="loading">Si</el-button>
                </span>
            </template>
        </el-dialog>

    </app-layout>
</template>

<script>
import AdminLayout from "../../Layouts/AdminLayout";
import FormPolicia from './Form';

import {mapActions, mapGetters} from 'vuex';

import "primevue/resources/themes/saga-blue/theme.css";
import "primevue/resources/primevue.min.css";
import "primeicons/primeicons.css";
import InputText from 'primevue/inputtext';
import Column from 'primevue/column';
import DataTable from 'primevue/datatable';
import Dialog from 'primevue/dialog';
import {FilterMatchMode} from 'primevue/api';

export default {
    name: "Index",
    props: {
        errors: Object
    },
    components: {
        appLayout: AdminLayout,
        FormPolicia,
        DataTable, Column, InputText, Dialog
    },
    data() {
        return {
            records: null,
            modalFormVisible: false,
            modalFormUpdateVisible: false,
            formEdit: {},
            filters: {'global': {value: null, matchMode: FilterMatchMode.CONTAINS}},
            confirmDialogVisible: false,
            selectedRecord: null,
            loading: false
        }
    },
    created() {
        this.loadData()
    },
    methods: {
        ...mapActions('Policias', ['loadData']),
        setDataToFormEdit(data) {
            this.formEdit = _.cloneDeep(data);
            this.modalFormUpdateVisible = true;
        },
        getTextStatus(estado) {
            return estado == 'a' ? 'Activo' : 'Inactivo';
        },
        handleUpdateErrors(errors) {
        },
        mostrarModalConfirmacion(data) {
            this.confirmDialogVisible = true;
            this.selectedRecord = data;

        },
        confirmarRestablecimiento() {
            this.loading = true;
            this.$inertia.patch(route('policia.restablecer.clave', this.selectedRecord), {}, {
                onSuccess: (page) => {
                    this.confirmDialogVisible = this.loading = false;
                    this.$notify({
                        message: 'Clave restablecida: El usuario y clave del delegado son el número de cédula del delegado',
                        type: 'success'
                    });
                }
            });
        }
    },
    computed: {
        ...mapGetters('Policias', ['getAll']),
    }
}
</script>

<style scoped>

</style>
