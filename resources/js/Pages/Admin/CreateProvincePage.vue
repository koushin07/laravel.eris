<template>
    <form @submit.prevent="submit">
        <div>
            <InputLabel for="name" value="Province Name" />
            <!-- <ProvinceList @submit="getProvince" :contents="provinces" /> -->
            <TextInput id="email" type="text" class="mt-1 block w-full" v-model="form.name" required
                autocomplete="username" />

            <InputError class="mt-2" :message="form.errors.name" />
        </div>

        <div class="mt-4">
            <InputLabel for="email" value="Email" />
            <TextInput id="email" type="email" class="mt-1 block w-full" v-model="form.email" required
                autocomplete="username" />
            <InputError class="mt-2" :message="form.errors.email" />
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
                Register New Province
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
import ProvinceList from '@/Components/Lists/ProvinceList.vue';
import AdminLayout from '@/Layouts/AdminLayout.vue';
export default {
    layout: AdminLayout,
    components:{
        InputError,
        InputLabel,
        PrimaryButton,
        TextInput,
        ProvinceList,
    },
    setup() {

        let form = useForm({
            
            name: '',
            email: '',
            password: '',
            password_confirmation: '',
            terms: false,
        });

        const submit = () => {
            console.log('sbumit as prov')
            form.post(route('register'), {
                
                onSuccess: () => form.reset('password', 'password_confirmation'),
                

            });
        }

       
        return {
            form,
            submit,
        }
    }
}

</script>

<style lang="scss" scoped>

</style>