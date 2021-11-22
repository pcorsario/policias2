<template>
    <tabla-asignacion :data="dataForm"></tabla-asignacion>
<!--    <table class="text-left w-full border-collapse"> &lt;!&ndash;Border collapse doesn't work on this site yet but it's available in newer tailwind versions &ndash;&gt;-->
<!--        <tbody>-->
<!--        <tr class="hover:bg-grey-lighter">-->
<!--            <td class="py-2 px-6 border-b border-grey-light font-semibold">Cuadrante</td>-->
<!--            <td class="py-2 px-6 border-b border-grey-light">{{ dataForm.cuadrante }}</td>-->
<!--        </tr>-->
<!--        <tr class="hover:bg-grey-lighter">-->
<!--            <td class="py-2 px-6 border-b border-grey-light font-semibold">Mesa</td>-->
<!--            <td class="py-2 px-6 border-b border-grey-light">{{ dataForm.mesa }}</td>-->
<!--        </tr>-->
<!--        <tr class="hover:bg-grey-lighter">-->
<!--            <td class="py-2 px-6 border-b border-grey-light font-semibold">Silla</td>-->
<!--            <td class="py-2 px-6 border-b border-grey-light">{{ dataForm.silla }}</td>-->
<!--        </tr>-->
<!--        <tr class="hover:bg-grey-lighter">-->
<!--            <td class="py-2 px-6 border-b border-grey-light font-semibold">Policia</td>-->
<!--            <td class="py-2 px-6 border-b border-grey-light">{{ dataForm.policia }}</td>-->
<!--        </tr>-->
<!--        </tbody>-->
<!--    </table>-->
    <div class="grid grid-cols-2 mt-2">
        <el-popconfirm
            title="¿Seguro que dese eliminar este registro?"
            @confirm="eliminarPuesto"
        >
            <template #reference>
                <el-button type="danger" class="col-start-2" icon="el-icon-delete" :disabled="loading">Eliminar asiento asignado</el-button>
            </template>
        </el-popconfirm>

    </div>
</template>

<script>

import {mapGetters, mapActions} from 'vuex';
import TablaAsignacion from "@/Pages/Asignacion/TablaAsignacion";

export default {
    name: "UpdateForm",

    props: {
        'dataForm': {
            type: Object,
            required: true
        }
    },

    components: {
        TablaAsignacion
    },

    data(){
        return {
            loading: false
        }
    },

    methods: {
        ...mapActions('AsignacionSillas', {
            'eliminarAsignacion': 'delete'
        }),
        async eliminarPuesto(){
            this.loading = true;
            const idPolicia = this.dataForm.idPolicia;
            const idSilla = this.dataForm.idSilla;
            const response = await axios.delete(route(`asignacion.delete`, {silla: idSilla, policia: idPolicia}));

            if(response.data.deleted)
            {
                this.eliminarAsignacion(this.dataForm.idSP);
                this.$notify({
                    message: 'Se eliminó la asignación del puesto correctamente',
                    type: 'success'
                });
                this.loading = false;
            }

            this.$emit('deleted');
        }
    },
    computed: {
        ...mapGetters('AsignacionSillas', {
            'todasSillasAsignadas': 'getAll'
        }),
    }
}
</script>

<style scoped>

</style>
