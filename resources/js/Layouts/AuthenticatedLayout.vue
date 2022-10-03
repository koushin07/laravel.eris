<script >
import { Link } from '@inertiajs/inertia-vue3';
import TransactionCard from './Partials/TransactionCard.vue';

export default{
    components:{
        Link,
        TransactionCard
    },
   created(){
    window.Echo.private(`requestSend.${this.$page.props.auth.user.municipality_id}`)
    .listen('.Mtransaction.created', (e)=>{
        console.log('yeys')
            console.log(e)
        })
   },
    setup(){
        return{

        }
    }

}

</script>

<template>
    <div class="flex">
        <!--Sidebar-->
        <div class="flex flex-row z-50">
            <div
                class="flex absolute flex-col hover:z-50 bg-gradient-to-t from-cyan-500 to-blue-500 h-screen w-14 transition-all duration-500  hover:left-0 hover:w-36 rounded-r-2xl">
                <div class=" flex flex-col justify-between items-center ">
                    <div class="flex flex-col items-center pt-48">

                        <inertia-link href="/dashboard">
                        <i class="fa-solid fa-house py-4 cursor-pointer hover:text-white"></i>
                        </inertia-link>
                        <inertia-link :href="route('equipment.index')">
                        <i class="fa-solid fa-table-list py-4 cursor-pointer hover:text-white"></i>
                        </inertia-link>
                        <!-- :href="route('logout')" method="post" -->
                        <inertia-link :href="route('province.index')">
                        <i class="fa-solid fa-map py-4 cursor-pointer hover:text-white"></i>
                        </inertia-link>

                        <inertia-link :href="route('transactions.create')">
                        <i class="fa-solid fa-tty py-4 cursor-pointer hover:text-white"></i>
                        </inertia-link>

                    </div>


                </div>
            </div>
        </div>
        <!--End of Sidebar-->
        <!--   Main/2nd column     -->
        <div class="flex flex-col pl-14 h-screen scrollbar bg-transparent w-screen sm:w-9/12 overflow-y-auto ">

            <div class=" flex-col mx-5 mt-9 max-h-screen content-center">
                <div class="flex m-4">
                    EPRRIS
                </div>
                <slot />
            </div>


        </div>
        <!--   End of Main/2nd column   -->
        <!--   last column     -->
        <TransactionCard />
    </div>
    <!--    <div>
        <div class="min-h-screen bg-gray-100">
            <nav class="bg-white border-b border-gray-100">
                &lt;!&ndash; Primary Navigation Menu &ndash;&gt;
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="flex justify-between h-16">
                        <div class="flex">
                            &lt;!&ndash; Logo &ndash;&gt;
                            <div class="shrink-0 flex items-center">
                                <Link :href="route('dashboard')">
                                    <ApplicationLogo class="block h-9 w-auto" />
                                </Link>
                            </div>

                            &lt;!&ndash; Navigation Links &ndash;&gt;
                            <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
                                <NavLink :href="route('dashboard')" :active="route().current('dashboard')">
                                    Dashboard
                                </NavLink>
                            </div>
                        </div>

                        <div class="hidden sm:flex sm:items-center sm:ml-6">
                            &lt;!&ndash; Settings Dropdown &ndash;&gt;
                            <div class="ml-3 relative">
                                <Dropdown align="right" width="48">
                                    <template #trigger>
                                        <span class="inline-flex rounded-md">
                                            <button type="button" class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition ease-in-out duration-150">
                                                {{ $page.props.auth.user.name }}

                                                <svg class="ml-2 -mr-0.5 h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                                </svg>
                                            </button>
                                        </span>
                                    </template>

                                    <template #content>
                                        <DropdownLink :href="route('logout')" method="post" as="button">
                                            Log Out
                                        </DropdownLink>
                                    </template>
                                </Dropdown>
                            </div>
                        </div>

                        &lt;!&ndash; Hamburger &ndash;&gt;
                        <div class="-mr-2 flex items-center sm:hidden">
                            <button @click="showingNavigationDropdown = ! showingNavigationDropdown" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out">
                                <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                                    <path :class="{'hidden': showingNavigationDropdown, 'inline-flex': ! showingNavigationDropdown }" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                                    <path :class="{'hidden': ! showingNavigationDropdown, 'inline-flex': showingNavigationDropdown }" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>

                &lt;!&ndash; Responsive Navigation Menu &ndash;&gt;
                <div :class="{'block': showingNavigationDropdown, 'hidden': ! showingNavigationDropdown}" class="sm:hidden">
                    <div class="pt-2 pb-3 space-y-1">
                        <ResponsiveNavLink :href="route('dashboard')" :active="route().current('dashboard')">
                            Dashboard
                        </ResponsiveNavLink>
                    </div>

                    &lt;!&ndash; Responsive Settings Options &ndash;&gt;
                    <div class="pt-4 pb-1 border-t border-gray-200">
                        <div class="px-4">
                            <div class="font-medium text-base text-gray-800">{{ $page.props.auth.user.name }}</div>
                            <div class="font-medium text-sm text-gray-500">{{ $page.props.auth.user.email }}</div>
                        </div>

                        <div class="mt-3 space-y-1">
                            <ResponsiveNavLink :href="route('logout')" method="post" as="button">
                                Log Out
                            </ResponsiveNavLink>
                        </div>
                    </div>
                </div>
            </nav>

            &lt;!&ndash; Page Heading &ndash;&gt;
            <header class="bg-white shadow" v-if="$slots.header">
                <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                    <slot name="header" />
                </div>
            </header>

            &lt;!&ndash; Page Content &ndash;&gt;
            <main>
                <slot />
            </main>
        </div>
    </div>-->
</template>
