<script >
import { Link } from '@inertiajs/inertia-vue3';
import PendingTransactions from '../Components/PendingTransactions.vue'
import { usePage } from '@inertiajs/inertia-vue3';

export default{
    components:{
        Link,
        PendingTransactions
    },
    mounted () {
       
    },
  
    setup(){
       console.log(`this is user ${usePage().props.value.auth.user.id}`)
       const navs = [
            { name: "Equipment", url: "/municipality/inventory" },
            { name: "Request", url: "/municipality/request" },
            { name: "Forms", url: "/municipality/form" },
            { name: "Transactions", url: "/municipality/transaction" },

        ]
        return{
            navs
        }
    }

}

</script>

<template>
     <div class="flex flex-col bg-orange-100 h-full md:h-screen">
        <nav class="flex flex-row justify-between bg-white  border-b-2 p-5 w-full">
            <span>logo</span>
            <span class="text-orange-600">Name</span>
        </nav>
        <nav class="flex bg-white flex-row justify-end w-full">
            <div class="flex flex-row justify-center text-center  h-14">
                <inertia-link :href="nav.url" active-class=" bg-gray-400 text-white" 
                class=" px-5 border-r-2 last:border-transparent text-center pt-4" v-for="(nav, key) in navs"
                    :key="key">
                    {{ nav.name }}  </inertia-link>

            </div>

        </nav>
        <div class="flex flex-row h-full ">

            <main class=" flex-col w-full space-y-12 overflow-y-auto mt-10 mb-10 ml-10 mr-5 scrollbar">
                <slot />
            </main>
           

            <div class="hidden md:flex box-border bg-orange-300 w-1/4 p-10  mt-10 mb-10 mr-10 ml-2.5">
                <div class="flex flex-col space-y-8 justify-items-center">
                    <!-- <div class="box-border  h-20  p-4  hover:scale-110 content-center rounded-3xl"
                        style="background:#DAD9D8; box-shadow: 9px 10px 5px rgb(0 0 0 / 0.25);">
                        <span class="text-2xl font-extrabold text-blue-500 ">


                        </span>


                    </div> -->
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
                            <!-- <inertia-link class="text-emerald-500 cursor-pointer" :href="route('transactions.index')">See
                            All</inertia-link> -->
                        </div>
                        <!-- <RecievedTransaction :transactions="send" /> -->
                    </div>

                </div>

            </div>
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
