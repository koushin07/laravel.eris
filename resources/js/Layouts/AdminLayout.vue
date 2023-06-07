<template>
    <div class="bg-white h-full md:h-screen">
        <nav class="flex flex-row justify-between shadow-md p-5 w-full">
            <inertia-link href="/rdrrmc/dashboard">
                <img src="../../css/eris.png" class="h-12">

            </inertia-link>
            <div class="grid grid-flow-col place-content-center gap-2 align-middle">
                <Dropdown>
                    <template #trigger>
                        <button class="inline-flex items-center text-gray-500 bg-white border border-gray-300 focus:outline-none
                     hover:bg-gray-100 focus:ring-4 focus:ring-gray-200 font-medium rounded-lg text-sm px-3 py-1.5
                      dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:bg-gray-700 dark:hover:border-gray-600
                       dark:focus:ring-gray-700" type="button">

                            <div class="text-orange-600">{{ $page.props.auth.user.email }}</div>
                            <svg class="ml-2 w-3 h-3" aria-hidden="true" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 9l-7 7-7-7">
                                </path>
                            </svg>
                        </button>
                    </template>
                    <template #content>
                        <ul class="py-1 text-sm text-gray-700 dark:text-gray-200">
                            <li>
                                <!-- <inertia-link :href="route('municipality.office.index')"
                                    class="block py-2 px-4 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white cursor-pointer">
                                    Account</inertia-link> -->

                                <inertia-link :href="route('logout')" method="post"
                                    class="block py-2 px-4 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white cursor-pointer">
                                    Logout</inertia-link>
                            </li>
                        </ul>

                    </template>

                </Dropdown>


            </div>

        </nav>

        <main class=" h-fit p-10 ">
            <slot />

        </main>
    </div>
</template>

<script>
import Dropdown from '@/Components/Dropdown.vue';
import { usePage } from '@inertiajs/inertia-vue3';
import { useToast } from "vue-toastification";
export default {
    components: {
        Dropdown,

    },

    setup() {
        const toast = useToast();


        window.Echo.private(
            `register.${usePage().props.value.auth.user.id}`
        ).listen(".new.register", (e) => {
           console.log(e);
            toast.info("New Register User", {
                timeout: 5000,
                icon: "fa-regular fa-envelope",
            });

        });



        return {}
    }
}
</script>

<style lang="scss" scoped>

</style>
