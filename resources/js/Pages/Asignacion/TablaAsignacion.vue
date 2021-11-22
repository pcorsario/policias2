<template>
    <table class="text-left w-full border-collapse">
        <!--Border collapse doesn't work on this site yet but it's available in newer tailwind versions -->
        <tbody>

        <tr class="hover:bg-grey-lighter">
            <td class="py-2 px-6 border-b border-grey-light font-semibold">Grado</td>
            <td class="py-2 px-6 border-b border-grey-light"> {{
                    data.rango
                }}
            </td>
        </tr>

        <tr class="hover:bg-grey-lighter">
            <td class="py-2 px-6 border-b border-grey-light font-semibold">Cedula</td>
            <td class="py-2 px-6 border-b border-grey-light"> {{
                    data.cedula
                }}
            </td>
        </tr>

        <tr class="hover:bg-grey-lighter">
            <td class="py-2 px-6 border-b border-grey-light font-semibold">Delegado</td>
            <td class="py-2 px-6 border-b border-grey-light"> {{
                    data.policia
                }}
            </td>
        </tr>

        <tr class="hover:bg-grey-lighter">
            <td class="py-2 px-6 border-b border-grey-light font-semibold">Cuadrante</td>
            <td class="py-2 px-6 border-b border-grey-light"> {{
                    data.cuadrante
                }}
            </td>
        </tr>
        <tr class="hover:bg-grey-lighter">
            <td class="py-2 px-6 border-b border-grey-light font-semibold">Mesa</td>
            <td class="py-2 px-6 border-b border-grey-light">{{ data.mesa }}</td>
        </tr>
        <tr class="hover:bg-grey-lighter">
            <td class="py-2 px-6 border-b border-grey-light font-semibold">Silla</td>
            <td class="py-2 px-6 border-b border-grey-light">
                {{ data.silla }}
            </td>
        </tr>
        </tbody>
    </table>
</template>

<script>
export default {
    props: {
        data: {
            type: Object,
            required: true
        }
    },

    name: "TablaAsignacion"
}
</script>

<style scoped>

</style>
