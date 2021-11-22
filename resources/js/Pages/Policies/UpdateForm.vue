<template>

    <el-form ref="form" label-position="top" :model="form" :rules="rules">


        <el-form-item label="Grado">
            <el-input disabled v-model="nombreRango"></el-input>
        </el-form-item>

        <el-form-item label="Cédula">
            <el-input v-model="dataForm.cedula" disabled></el-input>
        </el-form-item>

        <el-form-item label="Primer apellido">
            <el-input v-model="dataForm.apellido_paterno" autofocus></el-input>
        </el-form-item>

        <el-form-item label="Segundo apellido">
            <el-input v-model="dataForm.apellido_materno"></el-input>
        </el-form-item>

        <el-form-item label="Nombres">
            <el-input v-model="dataForm.nombres"></el-input>
        </el-form-item>

        <el-form-item label="Numero celular">
            <el-input v-model="dataForm.celular"></el-input>
        </el-form-item>

        <el-form-item label="Numero convencional">
            <el-input v-model="dataForm.convencional"></el-input>
        </el-form-item>

        <el-form-item label="Correo">
            <el-input v-model="dataForm.correo"></el-input>
        </el-form-item>

<!--        <el-form-item label="Direccion domicilio">-->
<!--            <el-input type="textarea" :rows="2" v-model="dataForm.direccion_domicilio"></el-input>-->
<!--        </el-form-item>-->

        <div class="text-right">
            <el-button type="primary" :disabled="validated" @click="handleSubmit">Actualizar mis datos</el-button>
        </div>
    </el-form>
</template>

<script>

import Photo from './Photo';

const VALIDO = false;

export default {
    name: "UpdateForm",

    components: {
        photoPolice: Photo
    },

    props: {
        dataForm: {
            type: Object,
            required: true
        }
    },

    data() {
        return {}
    },

    methods: {
        handleSubmit() {
            if (this.validated == !VALIDO) return;

            this.actualizar();
        },
        async actualizar() {
            await this.$inertia.patch(route('front.policia.update', {policia: this.dataForm.id}), this.dataForm, {
                onSuccess: () => {
                    this.$notify({
                        message: 'Se actualizó tu información personal sin problemas, gracias.',
                        type: 'success'
                    });
                }
            });

        }
    },
    computed: {
        validated() {
            return VALIDO;
        },
        nombreRango() {
            return this.dataForm.rango?.descripcion;
        }
    }
}
</script>

<style scoped>

</style>
