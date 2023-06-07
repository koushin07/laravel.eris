<script >
import { Link } from '@inertiajs/inertia-vue3';
import PendingTransactions from '../Components/PendingTransactions.vue'
import { usePage } from '@inertiajs/inertia-vue3';
import Dropdown from '@/Components/Dropdown.vue';
import Notification from '@/Components/Notification.vue'
import { onMounted, ref, watch } from 'vue'
import useChannel from '@/Composables/useChannel';
import { Head } from '@inertiajs/inertia-vue3'
import useNotification from '@/Composables/useNotification';
import { useToast } from "vue-toastification";
import { emitter } from '@/Composables/useEventBus'
import ResponsiveNavLink from '@/Components/ResponsiveNavLink.vue';

export default {
    components: {
        Head,
        Notification,
        Link,
        PendingTransactions,
        Dropdown,
        ResponsiveNavLink,
    },


    setup() {

        // const { reconfirmed } = useChannel()
        const show = ref(false);
        const showTransaction = ref()

        const toast = useToast();

        console.log(`this is user ${usePage().props.value.auth.user.id}`)
        const navs = [
            { name: "Equipment", url: "/municipality/inventory" },
            { name: "incidents", url: "/municipality/request" },
            { name: "Forms", url: "/municipality/inventory/create" },
            { name: "Transactions", url: "/municipality/transaction" },

        ]

        const equipmentManagement = [
            { name: "Inventory", url: "/municipality/inventory" },
            // { name: "Report", url: "/municipality/incident" }
        ]

        const transactions = [
            { name: "My Requests", url: "/municipality/request", hasNotif: false },
            { name: "In-Bound Requests", url: "/municipality/partials", hasNotif: false },
            // { name: "Approvals", url: "/municipality/approval", hasNotif: false },

            // { name: "History", url: "/municipality/history", hasNotif: false },

        ]


       const { fetchPendingNotification, fetchReconfirmationotification,    notification } = useNotification()
        emitter.on('*', () => {
            console.log('this is emmitter');
            fetchPendingNotification()
        })



        onMounted(() => {
            window.Echo.private(`reconfirm.${usePage().props.value.auth.user.id}`).listen('.reconfirm', (e)=>{
            // alert(e)
            // console.log(e);
            // alert('notifyadmin')
            toast.info("Transaction Completed", {
                timeout: 10000,
                icon: "fa-regular fa-envelope",
            });
        })
            fetchPendingNotification()
            fetchReconfirmationotification()
            window.Echo.private(
                `borrowing.${usePage().props.value.auth.user.id}`
            ).listen(".borrow.recieved", (e) => {
                emitter.emit('refresh-approvals')
                fetchPendingNotification()

                toast.info("Equipment Request Recieved", {
                    timeout: 5000,
                    icon: "fa-regular fa-envelope",
                });

            });



        })

        return {
            navs,
            equipmentManagement,
            transactions,
            notification,
            show,
            showTransaction,
        }
    }

}

</script>

<template>
    <div class="flex h-screen bg-gray-50 dark:bg-gray-900 ">
        <!-- Desktop sidebar -->
        <aside class="z-20 hidden w-64 overflow-y-auto bg-white dark:bg-gray-800 md:block flex-shrink-0">
            <div class=" py-4 text-gray-500 dark:text-gray-400">
                <div class="mx-auto  w-30 h-10">
                    <inertia-link href="/municipality/request">
                        <img src="../../css/eris.png " class="mx-auto">
                    </inertia-link>

                </div>

                <ul class="mt-20 flex flex-col space-y-2">
                    <!-- <ResponsiveNavLink href="/archive">

                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                            stroke="currentColor" class="w-5 h-5">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M20.25 7.5l-.625 10.632a2.25 2.25 0 01-2.247 2.118H6.622a2.25 2.25 0 01-2.247-2.118L3.75 7.5M10 11.25h4M3.375 7.5h17.25c.621 0 1.125-.504 1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125H3.375c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125z" />
                        </svg>

                        <span class="ml-4">Archive</span>

                    </ResponsiveNavLink> -->
                    <li class="relative px-6 py-3">
                        <button
                            class="dropdown-label inline-flex items-center justify-between w-full text-sm font-semibold transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200"
                            @click="showTransaction = !showTransaction">
                            <span class="inline-flex items-center">
                                <svg class="w-5 h-5 " fill="none" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="2" viewBox="0 0 24 24" stroke="currentColor">
                                    <path
                                        d="M4 5a1 1 0 011-1h14a1 1 0 011 1v2a1 1 0 01-1 1H5a1 1 0 01-1-1V5zM4 13a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H5a1 1 0 01-1-1v-6zM16 13a1 1 0 011-1h2a1 1 0 011 1v6a1 1 0 01-1 1h-2a1 1 0 01-1-1v-6z">
                                    </path>
                                </svg>
                                <span class="ml-1">Transactions</span>
                            </span>
                            <svg class="w-4 h-4" :class="showTransaction ? 'rotate-180' : ''" aria-hidden="true"
                                fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                    clip-rule="evenodd"></path>
                            </svg>
                        </button>


                        <ul v-if="showTransaction"
                            class="dropdown-content p-2 mt-2 space-y-2 overflow-hidden text-sm font-medium text-gray-500 rounded-md shadow-inner bg-gray-50 dark:text-gray-400 dark:bg-gray-900"
                            aria-label="submenu">
                            <li v-for="trans in transactions"
                                class="px-2 py-1 transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200">
                                <inertia-link class="w-full" :href="trans.url">{{ trans.name }}</inertia-link>
                            </li>

                        </ul>
                    </li>
                    <li class="relative px-6 py-3">
                        <button
                            class="dropdown-label inline-flex items-center justify-between w-full text-sm font-semibold transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200"
                            @click="show = !show">
                            <span class="inline-flex items-center">
                                <svg class="w-5 h-5 " fill="none" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="2" viewBox="0 0 24 24" stroke="currentColor">
                                    <path
                                        d="M4 5a1 1 0 011-1h14a1 1 0 011 1v2a1 1 0 01-1 1H5a1 1 0 01-1-1V5zM4 13a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H5a1 1 0 01-1-1v-6zM16 13a1 1 0 011-1h2a1 1 0 011 1v6a1 1 0 01-1 1h-2a1 1 0 01-1-1v-6z">
                                    </path>
                                </svg>
                                <span class="ml-1">Equipment Management</span>
                            </span>
                            <svg class="w-4 h-4" :class="show ? 'rotate-180' : ''" aria-hidden="true"
                                fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                    clip-rule="evenodd"></path>
                            </svg>
                        </button>


                        <ul v-if="show"
                            class="dropdown-content p-2 mt-2 space-y-2 overflow-hidden text-sm font-medium text-gray-500 rounded-md shadow-inner bg-gray-50 dark:text-gray-400 dark:bg-gray-900"
                            aria-label="submenu">
                            <li v-for="Em in equipmentManagement"
                                class="px-2 py-1 transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200">
                                <inertia-link class="w-full" :href="Em.url">{{ Em.name }}</inertia-link>
                            </li>

                        </ul>
                    </li>

                </ul>

            </div>
        </aside>
        <!-- Mobile sidebar -->
        <!-- Backdrop -->


        <div class="flex flex-col flex-1 w-full ">
            <header class="z-10 py-4 bg-white shadow-md dark:bg-gray-800">
                <div
                    class="container flex items-center justify-end h-full px-6 mx-auto text-purple-600 dark:text-purple-300">
                    <!-- Mobile hamburger -->



                    <ul class="flex items-center flex-shrink-0 space-x-6 ">


                        <!-- Notifications menu -->
                      <Notification :reconfirm="notification.reconfirm"  :request="notification.request"/>
                        <!-- Profile menu -->
                        <Dropdown>
                            <template #trigger>
                                <button class="inline-flex items-center text-gray-500 bg-white border border-gray-300 focus:outline-none
                     hover:bg-gray-100 focus:ring-4 focus:ring-gray-200 font-medium rounded-lg text-sm px-3 py-1.5
                      dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:bg-gray-700 dark:hover:border-gray-600
                       dark:focus:ring-gray-700" type="button">

                                    <span class="text-orange-600"> {{ $page.props.auth.user.assign_office.municipality
                                    }}</span>
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


                                        <Link :href="route('logout')" method="post" as="Link"
                                            class="block py-2 px-4 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white cursor-pointer">
                                        Logout</Link>

                                    </li>
                                </ul>

                            </template>

                        </Dropdown>
                    </ul>
                </div>
            </header>
            <main class="h-full bg-gray-50 overflow-y-auto">
                <slot />
            </main>
        </div>
    </div>

    <!-- <div class="flex flex-col h-full md:h-screen">


        <nav class="flex flex-row justify-between bg-white  border-b-2 p-5 w-full">
            <img src="../../css/eprris.png " class="h-12">
            <div class="grid grid-flow-col gap-2 align-middle">
                <Dropdown>
                    <template #trigger>
                        <button class="inline-flex items-center text-gray-500 bg-white border border-gray-300 focus:outline-none
                     hover:bg-gray-100 focus:ring-4 focus:ring-gray-200 font-medium rounded-lg text-sm px-3 py-1.5
                      dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:bg-gray-700 dark:hover:border-gray-600
                       dark:focus:ring-gray-700" type="button">

                            <span class="text-orange-600"> {{ $page.props.auth.user.assign_office.municipality }}</span>
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


                                <Link :href="route('logout')" method="post" as="Link"
                                    class="block py-2 px-4 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white cursor-pointer">
                                Logout</Link>
                            </li>
                        </ul>

                    </template>

                </Dropdown>


            </div>

        </nav>
        <nav class="flex bg-white flex-row  w-full z-10">
            <div class="flex flex-row justify-center text-center  h-14">

                <Dropdown align="left" class=" px-5  text-center pt-4">
                    <template #trigger>
                        <button>
                            <p class="break-words">
                                Equipment Management
                            </p>
                        </button>
                    </template>
                    <template #content class="mt-16">
                        <ul class="py-1 text-sm text-start text-gray-700 dark:text-gray-200">
                            <li>
                                <inertia-link :href="management.url" v-for="management in equipmentManagement"
                                    class="block py-2 px-4 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white cursor-pointer">
                                    {{ management.name }}</inertia-link>


                            </li>
                        </ul>
                    </template>
                </Dropdown>

                <Dropdown align="left" class=" px-5 border-x-2 z-0  text-center pt-4">
                    <template #trigger>
                        <button>
                            Transactions
                        </button>

                    </template>
                    <template #content class="mt-16">
                        <ul class="py-1 text-sm text-start text-gray-700 dark:text-gray-200">
                            <li>
                                <inertia-link :href="transaction.url" v-for="transaction in transactions"
                                    class="block py-2 px-4 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white cursor-pointer">
                                    {{ transaction.name }}
                                    <span v-if="transaction.hasNotif && count > 0"
                                        class="inline-flex items-center justify-center px-2 py-1 mr-2 text-xs font-bold leading-none text-red-100 bg-red-600 rounded-full ml-10">{{
        count
                                        }}</span>
                                </inertia-link>



                            </li>
                        </ul>
                    </template>
                </Dropdown>

                <inertia-link href="/archive" class=" px-5 border-r-2 z-0  text-center pt-4 pb-4">
                    Archive
                </inertia-link>
            </div>

        </nav>
        <div class="flex flex-row h-full bg-orange-100">

            <main class=" flex-col w-full  space-y-12 overflow-y-auto m-4 scrollbar ">

                <slot />
            </main>


        </div>
    </div> -->
</template>
<style scoped>
.shadow {
    box-shadow: rgba(0, 0, 0, 0.35) 0px 5px 15px;
}
</style>
