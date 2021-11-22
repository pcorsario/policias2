<template>
    <photo-police :data="{csrf: csrf}"></photo-police>
<!--    <form @submit.prevent="submit">-->
<!--        <input type="text" v-model="form.name" />-->
<!--        <input type="file" @input="form.avatar = $event.target.files[0]" />-->
<!--        <progress v-if="form.progress" :value="form.progress.percentage" max="100">-->
<!--            {{ form.progress.percentage }}%-->
<!--        </progress>-->
<!--        <button type="submit">Submit</button>-->
<!--    </form>-->
</template>

<script>

import Photo from "@/Pages/Policies/Photo";

export default {
    name: "FormPhoto",

    props: {
      csrf: String
    },

    data(){
        return {
            form: this.$inertia.form({
                name: null,
                avatar: null,
            }),
        }
    },

    components: {
        photoPolice: Photo
    },

    methods: {
        submit() {
            this.form.post(route('front.policia.update.photo'))
        },
    }
}
</script>

<style scoped>

</style>
