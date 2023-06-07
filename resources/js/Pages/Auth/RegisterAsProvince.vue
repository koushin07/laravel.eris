<template>
    <form @submit.prevent="submit" autocomplete="off">

        <div>
            <InputLabel for="name" value="Province" />
            <v-select :options="provinces" label="province" :reduce="provinces => provinces.id"
                v-model="form.province" />

        </div>
        <div class="mt-4">
            <InputLabel for="email" value="Email" />
            <TextInput id="email" type="email" class="mt-1 block w-full" v-model="form.email" required
                autocomplete="email" />
            <InputError class="mt-2" :message="form.errors.email" />
        </div>

        <div class="grid grid-cols-2 gap-2 w-fit border rounded mt-4 p-2">
            <span class="mt-4 col-span-2">Personnel In-charge</span>
            <div class="">
                <InputLabel for="firstname" value="First Name" />
                <TextInput id="firstname" type="text" class="mt-1 block w-full" v-model="form.firstname"
                    autocomplete="firstname" />
                <InputError class="mt-2" :message="form.errors.firstname" />
            </div>
            <div class="">
                <InputLabel for="lastname" value="Last Name" />
                <TextInput id="lastname" type="text" class="mt-1 block w-full" v-model="form.lastname"
                    autocomplete="lastname" />
                <InputError class="mt-2" :message="form.errors.lastname" />
            </div>
            <div class="mt-4">
                <InputLabel for="middlename" value="middle Name" />
                <TextInput id="middlename" type="text" class="mt-1 block w-full" v-model="form.middlename"
                    autocomplete="middlename" />
                <InputError class="mt-2" :message="form.errors.middlename" />
            </div>
            <div class="mt-4">
                <InputLabel for="suffix" value="Suffix" />
                <TextInput id="suffix" type="text" class="mt-1 block w-full" v-model="form.suffix"
                    autocomplete="suffix" />
                <InputError class="mt-2" :message="form.errors.suffix" />
            </div>
        </div>
        <div class="mt-4">
            <InputLabel for="contact" value="Contact" />
            <TextInput id="contact" type="number" class="mt-1 block w-full" v-model="form.contact" required
                autocomplete="contact" />
            <InputError class="mt-2" :message="form.errors.contact" />
        </div>
        <div class="mt-4">
            <InputLabel for="address" value="Address" />
            <TextInput id="address" type="text" class="mt-1 block w-full" v-model="form.address" required
                autocomplete="address" />
            <InputError class="mt-2" :message="form.errors.address" />
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

<script setup>
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { Link, useForm } from '@inertiajs/inertia-vue3';
import ProvinceList from '@/Components/Lists/ProvinceList.vue';

const props = defineProps({
    provinces: Array,
})

let form = useForm({
    firstname: '',
    lastname: '',
    middlename: '',
    address: '',
    contact: '',
    suffix: '',
    email: '',
    password: '',
    password_confirmation: '',
    // lat: '',
    // long: '',
    province: '',
    terms: false,
});
const convertedProvince = props.provinces ? Object.values(props.provinces).map((c) => [c.province, c.id]) : []
const submit = () => {
    console.log('sbumit as prov')
    form.post(route('register'), {

        onSuccess: () => form.reset('password', 'password_confirmation'),


    });
}

</script>

<style lang="scss" scoped>

</style>