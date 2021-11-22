<template>
    <div class="flex-none p-2 pl-4 border border-blue-900">
        <div class="grid flex justify-center">

            <div v-if="editing" class="mb-4">
                <el-input v-model="datos.descripcion" size="small">
                    <template #append>
                        <el-button
                            @click="cambiarNombreCuadrante"
                            :disabled="loading"
                            class="border border-r border-gray-500">
                            <i class="el-icon-check font-bold text-green-500 hover:text-green-700"></i>
                        </el-button>
                        <el-button
                            :disabled="loading"
                            @click="editing=false">
                            <i class="el-icon-close text-red-500 hover:text-red-700"></i>
                        </el-button>
                    </template>
                </el-input>
                <span class="text-red-500" v-if="errors.descripcion">{{ errors.descripcion}}</span>
            </div>

            <h1 v-else style="margin: 1rem auto" class="text-center font-bold">
                {{ datos.descripcion }}
                <i class="far fa-edit text-gray-400 cursor-pointer" @click="editing=true"></i>
            </h1>
        </div>
        <div style="min-width: 540px; max-width: 540px">
            <mesa
                v-for="(mesa, index) in mesas"
                :data-mesa="mesa"
                :selected-chairs="loadSelectedChairs ? getSillasAsignadasPorMesa(mesa.id) : null"
                class-names="mb-2 mr-2"
            >
                <div class="clearfix" v-if="finFila(index)"></div>
            </mesa>
        </div>
    </div>
</template>

<script>
import Mesa from './Mesa';
import {mapActions, mapGetters} from 'vuex';

export default {
    name: "Cuadrante",
    props: {
        'datos': {
            type: Array,
        },
        'loadSelectedChairs': {
            type: Boolean,
            default: false
        },
        'editable': {
            type: Boolean,
            default: false
        }
    },
    data() {
        return {
            NUMERO_MAXIMO_MESAS_POR_FILA: 5,
            editing: false,
            loading: false,
            errors: {}
        }
    },
    async created() {
        if (this.loadSelectedChairs) {
            await this.loadAllSelectedChairs();
        }
        this.nombreCuadrante = this.datos.cuadrante.descripcion;

    },
    components: {
        Mesa
    },
    methods: {
        ...mapActions('AsignacionSillas', {
            'loadAllSelectedChairs': 'loadAll',

        }),
        finFila(numeroMesa) {
            return (numeroMesa + 1) % this.NUMERO_MAXIMO_MESAS_POR_FILA === 0;
        },
        cambiarNombreCuadrante(){
            this.loading = true;

            this.$inertia.patch(route('cuadrante.update', this.datos.id), {descripcion: this.datos.descripcion}, {
                onSuccess: page => {
                    this.editing = false;
                    this.loading = false;
                    this.messageSuccess();
                },
                onError: errors => {
                    this.loading = false;
                    this.messageError();
                    this.errors = errors;
                }
            });
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
        ...mapGetters('AsignacionSillas', {
            'getAllAsignations': 'getAll',
            'getSillasAsignadasPorMesa': 'getByMesa'
        }),
        mesas() {
            return this.datos.mesas.sort((a, b) => {
                return a.posicion - b.posicion;
            })
        }
    }
}
</script>

<style scoped>

</style>
