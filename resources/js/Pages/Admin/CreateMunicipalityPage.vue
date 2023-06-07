<template>
    <form @submit.prevent="submit" autocomplete="off">

        <div>
            <InputLabel for="name" value="Province" />
            <v-select :options="convertedProvince" v-model="form.province"/>
            <InputError class="mt-2" :message="form.errors.province" />
        </div>

        <div class="mt-4">
            <InputLabel for="municipality" value="municipality" />
            <TextInput id="municipality" type="text" class="mt-1 block w-full" v-model="form.name" required
                autocomplete="municipality" />
            <InputError class="mt-2" :message="form.errors.name" />
        </div>
        <div class="mt-4">
            <InputLabel for="email" value="Email" />
            <TextInput id="email" type="email" class="mt-1 block w-full" v-model="form.email" required
                autocomplete="email" />
            <InputError class="mt-2" :message="form.errors.email" />
        </div>
        <div class="mt-4 w-ful">
          
            <div class="grid lg:grid-flow-col gap-10">
                <div>
                    <InputLabel for="latitude" value="latitude" />
                    <TextInput id="latitude" type="text" class="mt-1 w-full block" v-model="form.lat" required
                        autocomplete="latitude" />
                    <InputError class="mt-2" :message="form.errors.lat" />
                </div>
                <div>
                    <InputLabel for="longitute" value="longitute" />
                    <TextInput id="longitute" type="text" class="mt-1 w-full block" v-model="form.long" required
                        autocomplete="longitute" />
                    <InputError class="mt-2" :message="form.errors.long" />
                </div>
               
            </div>
            <span class="text-sm text-slate-300">Get Coordintes <a href="https://www.gps-coordinates.net/" target="_blank" class="text-blue-500 underline">Here</a> </span>
        </div>

        <div class="mt-4">
            <InputLabel for="password" value="Password" />
            <TextInput id="password" type="password" class="mt-1 block w-full" v-model="form.password" required
                autocomplete="new-password" />
            <InputError class="mt-2" :message="form.errors.password" />
        </div>

        <div class="mt-4">
            <InputLabel for="password_confirmation" value="Confirm Password" />
            <TextInput id="password_confirmation" type="password" class="mt-1 block w-full"
                v-model="form.password_confirmation" required autocomplete="new-password" />
            <InputError class="mt-2" :message="form.errors.password_confirmation" />
        </div>

        <div class="flex items-center justify-end mt-4">

            <PrimaryButton class="ml-4" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                Register New Municipality
            </PrimaryButton>
        </div>
    </form>
</template>

<script >
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { useForm } from '@inertiajs/inertia-vue3';
import MunicipalityList from '@/Components/Lists/MunicipalityList.vue';
import ProvinceList from '@/Components/Lists/ProvinceList.vue';
import AdminLayout from '@/Layouts/AdminLayout.vue'

export default {
    layout: AdminLayout,
    components: {
        InputError,
        InputLabel,
        PrimaryButton,
        TextInput,
        MunicipalityList,
        ProvinceList,


    },
    props: {
        provinces: Array,
    },
    setup({provinces}) {
console.log(provinces);
        let form = useForm({
            name: '',
            email: '',
            password: '',
            password_confirmation: '',
            lat: '',
            long: '',
            province: '',
            terms: false,
        });

        const submit = () => {
            //    console.log(props.municipalities)
            form.post(route('municipalityRegistration'), {
                onSuccess: () => { form.reset('password', 'password_confirmation') },


            });
        }
        const convertedProvince = provinces ? Object.values(provinces).map((c) => c.province) : []
        function getProvince(province) {
            form.province = province.province

        }

        return {
            convertedProvince,
            form,
            submit,
            getProvince
        }
    }
}

</script>

<style lang="scss" scoped>

</style>