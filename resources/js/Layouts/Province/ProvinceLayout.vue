<script >
import { Link } from '@inertiajs/inertia-vue3';
import PendingTransactions from '@/Components/PendingTransactions.vue'
import { usePage } from '@inertiajs/inertia-vue3';
import Dropdown from '@/Components/Dropdown.vue';
export default {
    components: {
        Link,
        PendingTransactions,
        Dropdown
    },



    setup() {
        console.log(`this is user ${usePage().props.value.auth.user.id}`)
        const navs = [
            {name: "Dashboard", url: "/province/dashboard"},
            { name: "Equipment", url: "/province/consolidated" },
            { name: "Request", url: "/province/request" },
            { name: "Transactions", url: "/province/transaction" },

        ]

      
        window.Echo.private(`borrowing.${usePage().props.value.auth.user.id}`)
            .listen('.borrow.recieved', (e) => {
                console.log('this is e', e)
                alert('someone borrowed', e)
            })
        return {
            navs
        }
    }

}

</script>

<template>
    <div class="flex flex-col h-full md:h-screen">
        <nav class="flex flex-row justify-between bg-white  border-b-2 p-5 w-full">
            <img src="../../../css/eprris.png" class="h-12">
            <div class="grid grid-flow-col gap-2 align-middle">
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
                                <inertia-link :href="route('municipality.office.index')"
                                    class="block py-2 px-4 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white cursor-pointer">
                                    Account</inertia-link>

                                <inertia-link  :href="route('logout')" method="post"
                                    class="block py-2 px-4 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white cursor-pointer">
                                    Logout</inertia-link>
                            </li>
                        </ul>

                    </template>

                </Dropdown>
                
              
            </div>

        </nav>
        <nav class="flex bg-white flex-row justify-end w-full">
            <div class="flex flex-row justify-center text-center  h-14">
                <inertia-link :href="nav.url" :class="{ 'bg-gray-400 text-white': $page.url === nav.url }"
                    class=" px-5 border-r-2 last:border-transparent text-center pt-4" v-for="(nav, key) in navs"
                    :key="key">
                    {{ nav.name }} </inertia-link>

            </div>

        </nav>
        <div class="flex flex-row h-full ">

            <main class=" flex-col w-full  space-y-12 overflow-y-auto mt-10 mb-10 ml-10 mr-5 scrollbar">
                <slot />
            </main>


            <!--             <div class="hidden md:flex box-border bg-orange-300 w-1/4 p-10  mt-10 mb-10 mr-10 ml-2.5">
                <div class="flex flex-col space-y-8 justify-items-center">
                
                    <div class="    flex flex-col space-x-1">
                        <div class="flex justify-between px-4">
                            <span class="text-red-500 font-semibold">Pending</span>
                            <span class="text-red-500 cursor-pointer">See All</span>
                        </div>
                        <Pending-transactions></Pending-transactions>
                    </div>
                    <div class="flex flex-col space-x-1">
                        <div class="flex justify-between px-4">
                            <span class="text-emerald-500">Send</span>
                           
                        </div>
                       
                    </div>

                </div>

            </div> -->
        </div>
    </div>
    <!-- <div class="flex body">
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
                        <inertia-link :href="route('office.index')">
                        <i class="fa-solid fa-map py-4 cursor-pointer hover:text-white"></i>
                        </inertia-link>

                        <inertia-link :href="route('borrowing.create')">
                        <i class="fa-solid fa-tty py-4 cursor-pointer hover:text-white"></i>
                        </inertia-link>

                    </div>


                </div>
            </div>
        </div>
      
        <div class="flex flex-col pl-14 h-screen scrollbar bg-transparent w-screen sm:w-9/12 overflow-y-auto ">

            <div class=" flex-col mx-5 mt-9 max-h-screen content-center">
                <slot />
            </div>


        </div>
      
        <TransactionCard />
    </div>
  -->
</template>
