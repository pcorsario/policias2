<template>
    <div class="float-left" :class="classNames">
        <table>
            <tbody>
            <tr>
                <td></td>
                <silla :data-silla="getDataSillaByIndex(0)" :assigned="marcarSillaSeleccionada(0)"
                       @event-click="data => handleEventClickSillas(data, obtenerDatosSillaSeleccionada(0))"></silla>
                <silla :data-silla="getDataSillaByIndex(1)"
                       :assigned="marcarSillaSeleccionada(1)"
                       @event-click="data => handleEventClickSillas(data, obtenerDatosSillaSeleccionada(1))"></silla>
                <td></td>
            </tr>
            <tr>
                <silla :data-silla="getDataSillaByIndex(2)"

                       @event-click="data => handleEventClickSillas(data, obtenerDatosSillaSeleccionada(2))"
                       :assigned="marcarSillaSeleccionada(2)"></silla>
                <td class="mesa" colspan="2">{{ dataMesa.descripcion }}</td>
                <silla :data-silla="getDataSillaByIndex(3)"
                       @event-click="data => handleEventClickSillas(data, obtenerDatosSillaSeleccionada(3))"
                       :assigned="marcarSillaSeleccionada(3)"></silla>
            </tr>
            <tr>
                <td></td>
                <silla :data-silla="getDataSillaByIndex(4)"
                       @event-click="data => handleEventClickSillas(data, obtenerDatosSillaSeleccionada(4))"
                       :assigned="marcarSillaSeleccionada(4)"></silla>
                <silla :data-silla="getDataSillaByIndex(5)"
                       @event-click="data => handleEventClickSillas(data, obtenerDatosSillaSeleccionada(5))"
                       :assigned="marcarSillaSeleccionada(5)"></silla>
                <td></td>
            </tr>
            </tbody>
        </table>
    </div>
    <slot></slot>
</template>

<script>

import Silla from "@/Pages/Cuadrantes/partial/Silla";
import {mapGetters, mapActions} from 'vuex';

export default {
    name: "Mesa",
    props: {
        'dataMesa': {
            type: Object,
            required: true
        },
        'classNames': {
            type: String
        },
        'selectedChairs': {
            type: Object,
            default: null
        },
    },
    components: {
        Silla
    },
    data() {
        return {
            NO_EXISTE_SILLA_SELECCIONADA: undefined,
            SILLA_SIN_SELECCIONAR: undefined

        }
    },
    created() {
    },
    methods: {
        ...mapActions('DistributionConfiguraions', ['setSelectedChair']),
        handleEventClickSillas(chair, dataAsignacion) {

            if(dataAsignacion === this.SILLA_SIN_SELECCIONAR)
            {
                this.setSelectedChair({silla: chair});
                return;
            }
            this.setSelectedChair({silla: chair, asignacion: dataAsignacion});

        },
        getDataSillaByIndex(index) {
            return this.sillas[index];
        },
        getIdSillaByIndex(index) {
            return this.getDataSillaByIndex(index)?.id;
        },
        obtenerDatosSillaSeleccionada(index) {
            const idSilla = this.getIdSillaByIndex(index);
            return this.selectedChairs?.find(chair => chair.idSilla == idSilla);
        },
        marcarSillaSeleccionada(index) {
            return this.obtenerDatosSillaSeleccionada(index) !== this.NO_EXISTE_SILLA_SELECCIONADA;
        },
        guardarSillaSeleccionada(numeroSilla) {
            this.sillasSeleccionadas.push({
                nombre: numeroSilla
            })
        },
        eliminarSillaSeleccionada(numeroSilla) {
            this.sillasSeleccionadas = this.sillasSeleccionadas.filter(silla => silla.nombre !== numeroSilla);
        },
    },
    computed: {
        sillas() {
            return this.dataMesa.sillas;
        }
    }
}
</script>

<style scoped>
.mesa {
    background-color: #607d8b;
    min-width: 49.51px;
    text-align: center;
    color: white;
    border: 1px solid grey;
    font-size: 11px;
}

</style>
