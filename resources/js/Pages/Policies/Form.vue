<template>
    <el-form ref="form" label-position="top" :model="form" :rules="rules">
        <el-form-item label="Grado">
            <el-select
                v-model="form.rango_id"
                filterable
                placeholder="Seleccione un grado"
                @change="handleSelectRange"
            >
                <el-option
                    v-for="item in getAllRanges"
                    :key="item.id"
                    :label="item.descripcion"
                    :value="item.id">
                </el-option>
            </el-select>
            <span class="text-red-500" v-if="errors.rango_id">Seleccione un grado</span>
        </el-form-item>

        <el-form-item label="Cedula">
            <el-input v-model="form.cedula" autofocus max="10"></el-input>
            <span class="text-red-500" v-if="errors.cedula">{{ errors.cedula}}</span>
        </el-form-item>

        <el-form-item label="Primer apellido">
            <el-input v-model="form.apellido_paterno"></el-input>
            <span class="text-red-500" v-if="errors.apellido_paterno">{{ errors.apellido_paterno}}</span>
        </el-form-item>

        <el-form-item label="Segundo apellido">
            <el-input v-model="form.apellido_materno"></el-input>
            <span class="text-red-500" v-if="errors.apellido_materno">{{ errors.apellido_materno}}</span>
        </el-form-item>

        <el-form-item label="Nombres">
            <el-input v-model="form.nombres"></el-input>
            <span class="text-red-500" v-if="errors.nombres">{{ errors.nombres}}</span>
        </el-form-item>

        <el-form-item label="Numero celular">
            <el-input v-model="form.celular"></el-input>
            <span class="text-red-500" v-if="errors.celular">{{ errors.celular}}</span>
        </el-form-item>

        <el-form-item label="Numero convencional">
            <el-input v-model="form.convencional"></el-input>
            <span class="text-red-500" v-if="errors.convencional">{{ errors.convencional}}</span>
        </el-form-item>

        <el-form-item label="Correo">
            <el-input v-model="form.correo"></el-input>
            <span class="text-red-500" v-if="errors.correo">{{ errors.correo}}</span>
        </el-form-item>

<!--        <el-form-item label="Direccion domicilio">-->
<!--            <el-input type="textarea" :rows="2" v-model="form.direccion_domicilio"></el-input>-->
<!--            <span class="text-red-500" v-if="errors.direccion_domicilio">{{ errors.direccion_domicilio}}</span>-->
<!--        </el-form-item>-->

        <el-form-item>
            <el-checkbox v-model="form.estado" true-label="a" false-label="i">Activo</el-checkbox>
            <span class="text-red-500" v-if="errors.estado">{{ errors.estado}}</span>
        </el-form-item>

        <div class="text-right">
            <el-button type="default" @click="$emit('cancel')">Cancelar</el-button>
            <el-button type="primary" @click="handleSubmit" :disabled="loading">{{ nameButtonForm }}</el-button>
        </div>
    </el-form>
</template>

<script>
import {mapActions, mapGetters} from 'vuex';

const FORMULARIO_SIN_DATOS = undefined;

export default {
    name: "Form",
    props: {
        typeForm: {
            type: String,
            required: true
        },
        formData: {
            type: Object
        }
    },
    data() {
        return {
            form: {
                cedula: '',
                apellido_paterno: '',
                apellido_materno: '',
                nombres: '',
                celular: '',
                convencional: '',
                // direccion_domicilio: '',
                correo: '',
                rango_id: '',
                rango: {
                    id: '',
                    descripcion: '',
                },
                estado: 'a'
            },
            errors: {},
            loading: false,
        }
    },
    created() {
        if (this.formData !== FORMULARIO_SIN_DATOS) {
            this.form = this.formData;
            this.rango_id = this.form.rango.id;
        }
        this.loadRanges();
    },
    methods: {
        ...mapActions('Policias', ['add', 'update']),
        ...mapActions('Rangos', {
            loadRanges: 'loadData'
        }),
        handleSubmit() {
            if (this.typeForm == 'new')
                this.save();

            if (this.typeForm == 'update')
                this.updateRecord();
        },
        handleSelectRange(value) {
            this.form.rango.descripcion = this.getTextRangeSelected(value);
            this.form.rango.id = this.form.rango_id;
        },
        async save() {

            this.loading = true;

            this.$inertia.post(route('policia.save'), this.form, {
                onSuccess: page => {
                    this.loading = false;
                    this.messageSuccess();
                    this.add(page.props.flash.data);
                    this.emitSuccess(page.props.flash.data);
                },
                onError: errors => {
                    this.loading = false;
                    this.messageError();
                    this.errors = errors;
                    this.$emit('error', errors);
                }
            });
        },

        async updateRecord() {

            this.loading = true;

            this.$inertia.patch(route('policia.update', this.form.id), this.form, {
                onSuccess: page => {
                    this.loading = false;
                    this.messageSuccess();
                    this.update(this.form);
                    this.emitSuccess(this.form);
                },
                onError: errors => {
                    this.loading = false;
                    this.messageError();
                    this.errors = errors;
                    this.$emit('error', errors);
                }
            });
        },
        emitSuccess(data) {
            this.$emit('success', data);
        },
        getTextRangeSelected(idRangeSelected) {
            const textRangeSelected = this.getAllRanges.filter(range => range.id == idRangeSelected)[0].descripcion;
            return textRangeSelected;
        },
        messageSuccess() {
            this.$notify({
                message: 'Se guardaron correctamente los datos.',
                type: 'success'
            });
        },
        messageError() {
            this.$notify({
                message: 'No se pudo guardar la información, revise que todos los datos sean correctos e intente de nuevo',
                type: 'error'
            });
        },

    },
    computed: {
        nameButtonForm() {
            return this.typeForm === 'new' ? 'Guardar' : 'Actualizar';
        },
        ...mapGetters('Rangos', {
            getAllRanges: 'getAll'
        })
    }
}
</script>

<style scoped>

</style>
