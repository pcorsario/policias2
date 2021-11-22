<template>
    <app-layout>
        <div class="flex">
            <el-card class="lg:w-1/2 md:w-full sm:w-full">
                <div class="flex justify-between items-center">
                    <h2 class="font-bold">Usuarios</h2>
                    <el-button
                        type="primary"
                        @click="modalFormVisible = true"
                        icon="el-icon-circle-plus-outline">Nuevo usuario
                    </el-button>
                </div>
                <el-divider class="my-3"></el-divider>
                <DataTable :value="getAll" class="p-datatable-sm" :paginator="true"
                           :rows="10"
                           v-model:filters="filters"
                           filterDisplay="menu"
                           :globalFilterFields="['name', 'identify', 'type']"
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
                    <Column field="type" header="Tipo de usuario">
                        <template #body="{data}">
                            <span>
                                {{ data == 'a' ? 'Administrador': 'Soporte' }}
                            </span>
                        </template>
                    </Column>
                    <Column field="identify" header="Username"></Column>
                    <Column field="name" header="Nombres">
                    </Column>
                    <Column headerStyle="width:8em" bodyStyle="text-align: center">
                        <template #body="row">
                            <el-button type="text" icon="el-icon-edit" @click="setDataToFormEdit(row.data)">
                                Editar
                            </el-button>
<!--                            <el-dropdown trigger="click">-->
<!--                                  <span class="el-dropdown-link text-blue-400 text-base">-->
<!--                                    <i class="el-icon-arrow-down el-icon&#45;&#45;right"></i>-->
<!--                                  </span>-->
<!--                                <template #dropdown>-->
<!--                                    <el-dropdown-menu>-->
<!--                                        <el-dropdown-item icon="el-icon-key" @click="mostrarModalConfirmacion(row.data)">-->
<!--                                            Restablecer contraseña-->
<!--                                        </el-dropdown-item>-->
<!--                                    </el-dropdown-menu>-->
<!--                                </template>-->
<!--                            </el-dropdown>-->
                        </template>
                    </Column>
                </DataTable>
            </el-card>
        </div>

        <Dialog header="Nuevo usuario" v-model:visible="modalFormVisible" :modal="true" position="top"
                :breakpoints="{'960px': '75vw', '640px': '100vw'}" :style="{width: '30vw'}">
            <form-user
                type-form="new"
                @success="modalFormVisible = false"
                @cancel="modalFormVisible = false"></form-user>
        </Dialog>

        <Dialog header="Actualizar usuario" v-model:visible="modalFormUpdateVisible" :modal="true" position="top"
                :breakpoints="{'960px': '75vw', '640px': '100vw'}" :style="{width: '30vw'}">
            <form-user
                :errors="errors"
                type-form="update"
                :form-data="formEdit"
                @success="modalFormUpdateVisible = false"
                @error="handleUpdateErrors"
                @cancel="modalFormUpdateVisible = false"></form-user>
        </Dialog>
    </app-layout>
</template>

<script>
import AdminLayout from "../../Layouts/AdminLayout";
import FormUser from './Form';

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
        FormUser,
        DataTable, Column, InputText, Dialog
    },
    data() {
        return {
            records: null,
            modalFormVisible: false,
            modalFormUpdateVisible: false,
            formEdit: {},
            filters: {'global': {value: null, matchMode: FilterMatchMode.CONTAINS}},
            selectedRecord: null,
            loading: false
        }
    },
    created() {
        this.loadData()
    },
    methods: {
        ...mapActions('Users', ['loadData']),
        setDataToFormEdit(data) {
            this.formEdit = _.cloneDeep(data);
            this.modalFormUpdateVisible = true;
        },
        getTextStatus(estado) {
            return estado == 'a' ? 'Activo' : 'Inactivo';
        },
        handleUpdateErrors(errors) {

        },
    },
    computed: {
        ...mapGetters('Users', ['getAll']),
    }
}
</script>

<style scoped>

</style>
