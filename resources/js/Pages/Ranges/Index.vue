<template>
    <app-layout>
        <div class="flex">
            <el-card class="lg:w-1/2 md:w-full sm:w-full">
                <div class="flex justify-between items-center">
                    <h2 class="font-bold">Grados para policias</h2>
                    <el-button
                        type="primary"
                        @click="modalFormVisible = true"
                        icon="el-icon-circle-plus-outline">Nuevo grado
                    </el-button>
                </div>
                <el-divider class="my-3"></el-divider>
                <DataTable :value="getAll" class="p-datatable-sm" :paginator="true"
                           :rows="10"
                           v-model:filters="filters"
                           filterDisplay="menu"
                           :globalFilterFields="['descripcion', 'estado']"
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
                    <Column field="descripcion" header="Descripcion"></Column>
                    <Column field="estado" header="Estado">
                        <template #body="row">
                            <el-tag :type="row.data.estado == 'a' ? 'success': 'warning'">{{ getTextStatus(row.data.estado) }}</el-tag>
                        </template>
                    </Column>
                    <Column>
                        <template #body="row">
                            <el-button type="text" icon="el-icon-edit" @click="setDataToFormEdit(row.data)">
                                Editar
                            </el-button>
                        </template>
                    </Column>
                </DataTable>
            </el-card>
        </div>

        <Dialog header="Nuevo Grado" v-model:visible="modalFormVisible" :modal="true" position="top">
            <form-rango
                type-form="new"
                @success="modalFormVisible = false"
                @cancel="modalFormVisible = false"></form-rango>
        </Dialog>

        <Dialog header="Actualizar Grado" v-model:visible="modalFormUpdateVisible" :modal="true" position="top">
            <form-rango
                type-form="update"
                :form-data="formEdit"
                @success="modalFormUpdateVisible = false"
                @error="handleUpdateErrors"
                @cancel="modalFormUpdateVisible = false"></form-rango>
        </Dialog>

    </app-layout>
</template>

<script>
import AdminLayout from "../../Layouts/AdminLayout";
import FormRango from './Form';

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
    components: {
        appLayout: AdminLayout,
        FormRango,
        DataTable, Column, InputText, Dialog
    },
    data() {
        return {
            records: null,
            modalFormVisible: false,
            modalFormUpdateVisible: false,
            formEdit: {},
            filters: {'global': {value: null, matchMode: FilterMatchMode.CONTAINS}}
        }
    },
    created() {
        this.loadData()
    },
    methods: {
        ...mapActions('Rangos', ['loadData']),
        setDataToFormEdit(data) {
            this.formEdit = {id: data.id, descripcion: data.descripcion, estado: data.estado};
            this.modalFormUpdateVisible = true;
        },
        getTextStatus(estado){
          return estado == 'a' ? 'Activo' : 'Inactivo';
        },
        handleUpdateErrors(errors) {
        }
    },
    computed: {
        ...mapGetters('Rangos', ['getAll']),
    }
}
</script>

<style scoped>

</style>
