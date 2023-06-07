<template>
    <div class="flex items-center min-h-screen p-6 shadow dark:bg-gray-900">
        <div class="flex-1 h-full max-w-4xl mx-auto overflow-hidden bg-white rounded-lg shadow dark:bg-gray-800">
            <div class="flex flex-col overflow-y-auto md:flex-row">
                <div class="h-32 md:h-auto md:w-1/2">
                    <img aria-hidden="true" class="object-cover w-full h-full dark:hidden"
                        src="landingpage/loginbackground.png" alt="Office">
                    <!-- <img aria-hidden="true" class="hidden object-cover w-full h-full dark:block" src="../assets/img/login-office-dark.jpeg" alt="Office"> -->
                </div>
                <div class="flex items-center  justify-center p-6 sm:p-12 md:w-1/2">
                    <form @submit.prevent="submit" class="w-full">
                        <h1 class="mb-4 text-xl font-semibold text-gray-700 dark:text-gray-200">
                            Setup Your Account
                        </h1>

                        <label class="block text-sm">
                            <span class="text-gray-700 dark:text-gray-400">Email</span>
                            <input v-model="form.email" required type="email"
                                class="block rounded-lg w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input">
                            <InputError class="mt-2" :message="form.errors.email" />
                        </label>
                        <span class="text-gray-700 dark:text-gray-400">Person In-Charge</span>
                        <div class="flex flex-row space-x-3">

                            <label class="block text-sm">

                                <input v-model="form.firstname" required type="text" placeholder="First name"
                                    class="block rounded-lg w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input">
                                <InputError class="mt-2" :message="form.errors.firstname" />
                            </label>
                            <label class="block text-sm">

                                <input v-model="form.lastname" required type="text" placeholder="Last name"
                                    class="block rounded-lg w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input">
                                <InputError class="mt-2" :message="form.errors.lastname" />
                            </label>
                        </div>
                        <div class="flex flex-row space-x-3">

                            <label class="block text-sm">

                                <input v-model="form.middlename"  type="text" placeholder="middle name"
                                    class="block rounded-lg w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input">
                                <InputError class="mt-2" :message="form.errors.middlename" />
                            </label>
                            <label class="block text-sm">

                                <input v-model="form.suffix"  type="text" placeholder="Suffix"
                                    class="block rounded-lg w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input">
                                <InputError class="mt-2" :message="form.errors.suffix" />
                            </label>
                        </div>


                        <label class="block text-sm">
                            <span class="text-gray-700 dark:text-gray-400">Address</span>
                            <input v-model="form.address" required type="text"
                                class="block rounded-lg w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input">
                            <InputError class="mt-2" :message="form.errors.address" />
                        </label>
                        <label class="block text-sm">
                            <span class="text-gray-700 dark:text-gray-400">Contact</span>
                            <input v-model="form.contact" required type="tel"
                                class="block rounded-lg w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input">
                            <InputError class="mt-2" :message="form.errors.contact" />
                        </label>
                        <label class="block mt-4 text-sm">
                            <div class="flex flex-row justify-between">
                                <span class="text-gray-700 dark:text-gray-400">Password</span>
                                <div @click="show = !show"
                                    class="text-gray-700 hover:cursor-pointer  dark:text-gray-400">Show</div>
                            </div>

                            <input v-model="form.password"
                                class="block rounded-lg  w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input"
                                placeholder="***************" :type="show ? 'text' : 'password'" required>
                            <InputError class="mt-2" :message="form.errors.password" />
                        </label>
                        <label class="block mt-4 text-sm">
                            <span class="text-gray-700 dark:text-gray-400">Confirm Password</span>
                            <input v-model="form.password_confirmation"
                                class="block rounded-lg w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input"
                                placeholder="***************" :type="show ? 'text' : 'password'" required>
                            <InputError class="mt-2" :message="form.errors.password_confirmation" />
                        </label>

                        <!-- You should use a button here, as the anchor is only used for the example  -->
                        <button type="submit"
                            class="block px-4 w-full py-2 mt-4 text-sm font-medium leading-5 text-center text-white transition-colors duration-150 bg-orange-600 border border-transparent rounded-lg active:bg-purple-600 hover:bg-orange-700 focus:outline-none focus:shadow-outline-orange">

                            Set Up
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import { useForm } from '@inertiajs/inertia-vue3'
import InputError from '@/Components/InputError.vue';
import { ref } from 'vue';
const form = useForm({
    address: '',
    contact: '',
    firstname: '',
    lastname: '',
    middlename: '',
    suffix: '',
    email: '',
    password: '',
    password_confirmation: '',
});
const show = ref(false)
const submit = () => {
    form.post(route('setup'), {
        onSuccess: () => form.reset('password', 'password_confirmation'),
    });
};
</script>

<style scoped>

</style>