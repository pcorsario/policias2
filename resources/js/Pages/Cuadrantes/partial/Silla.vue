<template>
    <td class="sillas" @click="handleEventClick" :class="{'assigned': assigned}">
        <span>{{ dataSilla.descripcion }}</span>
    </td>
</template>
<script>

export default {
    name: "Silla",
    props: {
        dataSilla: {
            type: Object,
            required: true
        },
        assigned: {
            type: Boolean,
            default: false,
        },
        dataTooltip: {
            type: String,
            default: ''
        }
    },
    data() {
        return {
            ESTILO_SILLA_SELECCIONADA: 'assigned',
            ESTILO_SILLA_SIN_SELECCIONAR: '',
        }
    },
    methods: {
        obtenerNumeroSilla(numeroMesa, letraSilla) {
            return numeroMesa + letraSilla;
        },
        marcarSillaSeleccionada(numeroMesa, letraSilla) {
            const numeroSilla = this.obtenerNumeroSilla(numeroMesa, letraSilla);
            return this.verificarSiSeleccionoSilla(numeroSilla) ? this.ESTILO_SILLA_SELECCIONADA : this.ESTILO_SILLA_SIN_SELECCIONAR;
        },
        handleEventClick() {
            this.$emit('eventClick', this.dataSilla);
        },
    }
}
</script>

<style scoped>
.sillas {
    border: 1px solid grey;
    font-size: 11px;
}

.sillas {
    min-width: 24.23px;
    text-align: center;
}

.sillas:hover {
    cursor: pointer;
    background-color: gray;
}

.assigned {
    --tw-bg-opacity: 1;
    background-color: rgba(29, 78, 216, var(--tw-bg-opacity));
    color: white;
}
</style>
