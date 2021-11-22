<template>
    <app-layout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Inicio
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                    <el-card class="lg:w-full md:w-full sm:w-full">
                        <div class="flex justify-between items-center">
                            <h2 class="font-bold">Actualización de mis datos personales</h2>
                        </div>
                        <el-divider class="my-3"></el-divider>
                        <photo-police></photo-police>
                        <FormPolicias :data-form="policia" />
                    </el-card>

                </div>
            </div>
        </div>
    </app-layout>
</template>

<script>
import AppLayout from '@/Layouts/AppLayout'
import FormPolicias from '@/Pages/Policies/UpdateForm';
import Photo from "@/Pages/Policies/Photo";

export default {
    components: {
        AppLayout,
        FormPolicias,
        photoPolice: Photo
    },
    data(){
        return {
            policia: {}
        }
    },
    created() {
        this.getDataPolicia();
    },
    methods: {
        async getDataPolicia(){
            const response = await axios.get(route('front.policia.logged.get'));
            this.policia = response.data;
        }
    }
}
</script>
