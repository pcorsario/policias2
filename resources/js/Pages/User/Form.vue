<template>
    <el-form ref="form" label-position="top" :model="form" :rules="rules">
        <el-form-item label="Tipo de usuario">
            <el-select
                v-model="form.type"
                filterable
                placeholder="Seleccione un tipo de usuario"
            >
                <el-option
                    v-for="item in tipoUsuarios"
                    :key="item.id"
                    :label="item.descripcion"
                    :value="item.id">
                </el-option>
            </el-select>
            <span class="text-red-500" v-if="errors.type">{{ errors.type }}</span>
        </el-form-item>

        <el-form-item label="Nombre">
            <el-input v-model="form.name" placeholder="Nombre de la persona que va a usar el usuario"></el-input>
            <span class="text-red-500" v-if="errors.name">{{ errors.name }}</span>
        </el-form-item>

        <el-form-item label="Username">
            <el-input v-model="form.identify" placeholder="Nick de usuario sin espacios"></el-input>
            <span class="text-red-500" v-if="errors.identify">{{ errors.identify }}</span>
        </el-form-item>

        <el-form-item label="Correo">
            <el-input type="email" v-model="form.email" placeholder="Correo de la persona que va a utilizar el usuario"></el-input>
            <span class="text-red-500" v-if="errors.email">{{ errors.email }}</span>
        </el-form-item>

        <el-form-item label="Contraseña">
            <el-input type="password" v-model="form.password" placeholder="Ingresa una contraseña segura"></el-input>
            <span class="text-red-500" v-if="errors.password">{{ errors.password }}</span>
        </el-form-item>

        <el-form-item label="Confirmar contraseña">
            <el-input type="password" v-model="form.password_confirmation" placeholder="Confirma la contraseña"></el-input>
            <span class="text-red-500" v-if="errors.password_confirmation">{{ errors.password_confirmation }}</span>
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
                name: null,
                identify: null,
                email: null,
                type: null,
                password: '',
                password_confirmation: '',
            },
            tipoUsuarios: [
                {id: 'a', descripcion: 'Administrador'},
                {id: 'e', descripcion: 'Soporte'}
            ],
            loading: false,
            errors: {}
        }
    },
    created() {
        if (this.formData !== FORMULARIO_SIN_DATOS) {
            this.form = this.formData;
        }
    },
    methods: {
        ...mapActions('Users', ['add', 'update']),
        handleSubmit() {
            if (this.typeForm == 'new')
                this.save();

            if (this.typeForm == 'update')
                this.updateRecord();
        },
        async save() {
            this.loading = true;

            this.$inertia.post(route('user.save'), this.form, {
                onSuccess: page => {
                    this.loading = false;
                    this.add(page.props.flash.data);
                    this.emitSuccess(page.props.flash.data);
                },
                onError: errors => {
                    this.loading = false;
                    this.errors = errors;
                    this.$emit('error', errors);
                }
            });

        },
        updateRecord(){
            this.loading = true;

            this.$inertia.patch(route('user.update', this.form.id), this.form, {
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
