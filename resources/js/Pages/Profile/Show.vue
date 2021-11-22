<template>
    <app-layout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Perfil de usuario
            </h2>
        </template>

        <div>
            <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
                <jet-form-section>
                    <template #title>
                        Actualizar información personal
                    </template>

                    <template #description>
                        Actualiza todos tus datos personales
                    </template>
                    <template #form>
                        <update-personal-information class="col-span-9" :data-form="policia">
                        </update-personal-information>
                    </template>

                </jet-form-section>

                <jet-section-border/>


                <div v-if="$page.props.jetstream.canUpdateProfileInformation">
                    <update-profile-information-form :user="$page.props.user"/>

                    <jet-section-border/>
                </div>

                <div v-if="$page.props.jetstream.canUpdatePassword">
                    <update-password-form class="mt-10 sm:mt-0"/>

                    <jet-section-border/>
                </div>

                <div v-if="$page.props.jetstream.canManageTwoFactorAuthentication">
                    <two-factor-authentication-form class="mt-10 sm:mt-0"/>

                    <jet-section-border/>
                </div>

                <template v-if="$page.props.jetstream.hasAccountDeletionFeatures">
                    <jet-section-border/>

                    <delete-user-form class="mt-10 sm:mt-0"/>
                </template>
            </div>
        </div>
    </app-layout>
</template>

<script>
import AppLayout from '@/Layouts/AppLayout'
import DeleteUserForm from './DeleteUserForm'
import JetSectionBorder from '@/Jetstream/SectionBorder'
import TwoFactorAuthenticationForm from './TwoFactorAuthenticationForm'
import UpdatePasswordForm from './UpdatePasswordForm'
import UpdateProfileInformationForm from './UpdateProfileInformationForm'
import UpdatePersonalInformation from '@/Pages/Policies/UpdateForm';
import JetFormSection from '@/Jetstream/FormSection';

export default {
    props: ['sessions'],

    components: {
        AppLayout,
        DeleteUserForm,
        JetFormSection,
        JetSectionBorder,
        TwoFactorAuthenticationForm,
        UpdatePasswordForm,
        UpdateProfileInformationForm,
        UpdatePersonalInformation
    },
    data() {
        return {
            policia: {}
        }
    },

    created() {
        this.getDataPolicia();
    },

    methods: {
        async getDataPolicia() {
            const response = await axios.get(route('front.policia.logged.get'));
            this.policia = response.data;
        }
    }
}
</script>
