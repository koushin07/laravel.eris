<template>
    <span class="text-2xl mb-10 font-bold text-black">
        Admin Site
    </span>


    <div class="grid grid-flow-row md:grid-cols-6 gap-2">
        <!-- account  -->
        <div class="flex flex-col w-full gap-10 col-span-4">
            <div class="px-3 gap-2 h-full w-full">
                <div class="flex flex-col  ">
                    <span class="text-xl p-2 text-center  font-semibold bg-orange-200 ">
                        Offices
                    </span>
                    <div class="grid gap-2 border-2 border-orange-200 px-5 ">

                        <div class="flex flex-row justify-between">
                            <inertia-link :href="route('rdrrmc.municipalities')"
                                class="text-lg font-noraml hover:text-orange-300">
                                Municipality
                            </inertia-link>
                            <inertia-link class="text-lg font noraml" :href="route('rdrrmc.register')">
                                <i class="fa-solid fa-plus text-orange-400 hover:text-orange-600"></i>
                            </inertia-link>
                        </div>
                        <hr>
                        <div class="flex flex-row justify-between">
                            <inertia-link :href="route('rdrrmc.provinces')"
                                class="text-lg font-noraml hover:text-orange-300">
                                Province
                            </inertia-link>
                            <inertia-link :href="route('rdrrmc.register_province')" class="text-lg font noraml">
                                <i class="fa-solid fa-plus text-orange-400 hover:text-orange-600"></i>
                            </inertia-link>
                        </div>

                    </div>

                </div>


            </div>
            <div class="px-3 gap-2 h-full w-full">
                <div class="flex flex-col  ">
                    <span class="text-xl p-2 text-center  font-semibold bg-orange-200 ">
                        TBD name
                    </span>
                    <div class="grid gap-2 border-2 border-orange-200 px-5 ">

                        <div class="flex flex-row justify-between">
                            <inertia-link :href="route('rdrrmc.consolidated')" class="text-lg font-noraml hover:text-orange-300">
                                Equipment
                            </inertia-link>
                            
                        </div>
                        <hr>
                        

                    </div>

                </div>

            </div>
            <div class="px-3 gap-2 h-full w-full">
                <div class="flex flex-col  ">
                    <span class="text-xl p-2 text-center  font-semibold bg-orange-200 ">
                        Transactions
                    </span>
                    <div class="grid gap-2 border-2 border-orange-200 px-5 ">

                        <div class="flex flex-row justify-between">
                            <inertia-link :href="route('rdrrmc.transaction')" class="text-lg font-noraml hover:text-orange-300">
                                Equipment Request
                            </inertia-link>
                            <!-- <button class="text-lg font noraml">
                                <i class="fa-solid fa-plus text-orange-400 hover:text-orange-600"></i>
                            </button> -->
                        </div>
                        <hr>
                        <div class="flex flex-row justify-between">
                            <inertia-link :href="route('rdrrmc.report')" class="text-lg font-noraml hover:text-orange-300">
                                Incident Report
                            </inertia-link>
                            
                        </div>

                    </div>

                </div>

            </div>

        </div>
        <!-- end of account -->

        <!-- <div class="flex justify-center col-span-2">
            <div class="box-content bg-slate-100 w-full h-full mx-6 border-2 border-slate-100">
                <div class="flex flex-col justify-center ">
                    <span class="text-xl text-center font-bold text-black border-b-2 p-3">
                        Recent Actions
                    </span>
                    <div class="flex flex-col pt-3 justify-evenly">
                        <span class="tex-lg text-black text-start px-6 ">
                            New Transaction Created
                        </span>
                        <span class="tex-lg text-black text-start p-6">
                            New Equipment Created
                        </span>
                    </div>

                </div>
            </div>
        </div> -->
    </div>



</template>

<script>
import AdminLayout from '@/Layouts/AdminLayout.vue'
import MostUsed from '@/Components/Charts/MostUsed.vue';

export default {
    layout: AdminLayout,
    components: {
        MostUsed
    },
    props: {
        data: Array,
    },
    setup(props) {


        return {}
    }
}
</script>

<style lang="scss" scoped>

</style>