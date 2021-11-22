<template>
    <el-form ref="form" :model="form" label-position="top">
        <!--            <div class="tag-group__title"></div>-->
        <el-tag class="text-sm flex items-center">
            <span>
                <span class="fas fa-chair"></span> Silla
                <span>
                    {{ silla.descripcion }}
                </span>
            </span>
        </el-tag>

        <br>
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
        </el-form-item>

        <el-form-item label="Policia">
            <el-select
                :disabled="form.rango_id == null"
                v-model="form.policia_id"
                filterable
                :loading="loading"
                loading-text="Cargando policias"
                placeholder="Seleccione un policia"
                no-data-text="Todos los policías de este grado ya han sido asignados a sillas"
            >
                <el-option
                    v-for="item in policiasSinAsignarASillas"
                    :key="item.id"
                    :label="item.nombre_completo"
                    :value="item.id">
                </el-option>
            </el-select>
        </el-form-item>

        <div class="text-right">
            <el-button type="default" @click="$emit('cancel')">Cancelar</el-button>
            <el-button type="primary" @click="handleSubmit" :disabled="estadoBotonGuardar">Asignar silla</el-button>
        </div>
    </el-form>
</template>

<script>

const VACIO = undefined;
const DESHABILITAR = true;
const CARGANDO = true;

import {mapActions, mapGetters} from 'vuex';

export default {
    name: "Form",
    props: {
        'silla': {
            type: Object,
            required: true
        },
    },
    data() {
        return {
            form: {
                rango_id: null,
                policia_id: null,
            },
            policias: null,
            loading: false,
            loadingTextSelect: 'Cargando...',
        }
    },
    created() {
        this.form.silla_id = this.silla.id;
        this.cargarRangosPolicias();
    },
    methods: {
        ...mapActions('Rangos', {
            'cargarRangosPolicias': 'loadData',
        }),
        ...mapActions('Policias', {
            'cargarPoliciasPorRangos': 'loadPoliciesByRanges',
        }),
        ...mapActions('AsignacionSillas', {
            'asignarSillaAPolicia': 'asignarSillaAPolicia'
        }),
        async handleSelectRange() {
            this.loading = true;
            this.form.policia_id = null;
            await this.cargarPoliciasPorRangos(this.form.rango_id);
            this.loading = false;

        },
        async handleSubmit(){
            const data = await this.save();

            this.$notify({
                message: 'Se asignó el asiento correctamente',
                type: 'success'
            });

            this.asignarSillaAPolicia(data);
            this.$emit('save');
        },
        async save(){
             const response = await axios.post(route('asignacion.save'), this.form);
             return response.data;
        },
    },
    computed: {
        ...mapGetters('Rangos', {
            'getAllRanges': 'getAll'
        }),
        ...mapGetters('Policias', {
            'getPoliciesByRange': 'getPoliciesByRange'
        }),
        ...mapGetters('AsignacionSillas', {
            'getSillasAsignadas' :'getAll'
        }),
        policiasSinAsignarASillas(){
            if(this.getPoliciesByRange === VACIO) return;

            return this.getPoliciesByRange.filter(police => {
                return this.getSillasAsignadas.find(asignacion => asignacion.idPolicia == police.id) == VACIO;
            });
        },
        estadoBotonGuardar(){
            const VACIO = 0;
            if(this.loading)
                return DESHABILITAR;

            if(VACIO == this.policiasSinAsignarASillas?.length)
                return DESHABILITAR;
        }
    },
}
</script>

<style scoped>

</style>
