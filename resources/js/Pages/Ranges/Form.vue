<template>
    <el-form ref="form" :model="form">
        <el-form-item label="Descripcion">
            <el-input v-model="form.descripcion" autofocus></el-input>
            <span class="text-red-500" v-if="errors.descripcion">{{ errors.descripcion}}</span>
        </el-form-item>

        <el-form-item>
            <el-checkbox v-model="form.estado" true-label="a" false-label="i">Activo</el-checkbox>
        </el-form-item>

        <div class="text-right">
            <el-button type="default" @click="$emit('cancel')">Cancelar</el-button>
            <el-button type="primary" @click="handleSubmit" :disabled="loading">{{ nameButtonForm }}</el-button>
        </div>
    </el-form>
</template>

<script>
import {mapActions} from 'vuex';

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
                descripcion: null,
                estado: 'a'
            },
            loading: false,
            errors: {},
        }
    },
    created() {
        if (this.formData !== undefined) {
            this.form = this.formData;
        }
    },
    methods: {
        ...mapActions('Rangos', ['add', 'update']),
        handleSubmit() {
            if (this.typeForm == 'new')
                this.save();

            if (this.typeForm == 'update')
                this.updateRecord();
        },
        async save() {

            this.loading = true;

            this.$inertia.post(route('rango.save'), this.form, {
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
        error() {
            this.$emit('error');
        },
        async updateRecord() {

            this.loading = true;

            this.$inertia.patch(route('rango.update', this.form.id), this.form, {
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
        emitSuccess(data){
            this.$emit('success')
            // Si la petición se realizó correctamente entonces se emite un evento success
            this.$emit('success', {
                id: data.id,
                descripcion: data.descripcion,
                estado: data.estado
            });
        },
        messageSuccess() {
            this.$notify({
                message: 'Se guardaron correctamente los datos.',
                type: 'success'
            })
        },
        messageError() {
            this.$notify({
                message: 'No se pudo guardar la información, revise que todos los datos sean correctos e intente de nuevo',
                type: 'error'
            })
        },
    },
    computed: {
        nameButtonForm() {
            return this.typeForm === 'new' ? 'Guardar' : 'Actualizar';
        }
    }
}
</script>

<style scoped>

</style>
