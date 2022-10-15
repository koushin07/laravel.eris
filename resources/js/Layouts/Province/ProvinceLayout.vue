<template>



    <main class="flex">
        <!-- sidebar -->
        <aside
            class="flex flex-col justify-between  pt-6 h-screen w-28 rounded-sm bg-gradient-to-b from-cyan-500 to-sky-400">

            <!-- <div class="text-center">
                <span class=" tracking-wider text-center text-xl font-bold"> {{ $page.props.auth.user.name }}</span>

            </div>

            <div class="flex flex-col space-y-3">
                <div class="flex flex-col space-y-4">
                    <div class="flex flex-row justify-between px-2">
                        <div class="flex-row space-x-2">
                            <i class="fa-solid fa-house"></i>
                            <span class="font-semibold antialiased">Transactions</span>
                        </div>
                        <div>
                            <i class="fa-solid fa-chevron-down pr-2"></i>
                        </div>

                    </div>
                    <div class="box-border bg-blue-300 rounded-xl border-2 mx-5 my-2 p-2">
                        <div class="flex flex-col space-y-2 text-sm p-3">
                            <div class="flex-row space-x-2">
                                <i class="fa-solid fa-house"></i>
                                <span class="font-semibold antialiased">Local Transactions</span>
                            </div>
                            <div class="flex-row space-x-2">
                                <i class="fa-solid fa-house"></i>
                                <span class="font-semibold antialiased">Cross Transactions</span>
                            </div>
                        </div>

                    </div>

                </div>


                <div class="flex-row space-x-2">
                    <i class="fa-solid fa-house"></i>
                    <span class="font-semibold antialiased">Home</span>
                </div>
                <div class="flex-row space-x-2">
                    <i class="fa-solid fa-house"></i>
                    <span class="font-semibold antialiased">Home</span>
                </div>
            </div>
            <div>
                asdad
            </div> -->


        </aside>


        <main class="pt-10 px-10 pb-10">
            <div class="flex flex-row space-x-10">
                <div class="flex flex-col">
                    <div class="flex flex-row space-x-10">
                        <div class="flex-col space-y-10">

                            <div class="flex flex-row gap-4">
                                <div class="grid grid-cols-2 gap-20 place-content-between">
                                    <div class="box-border rounded-2xl text-center border-2 shadow-2xl h-32 w-fit p-3">
                                        <div class="grid grid-cols-1 gap-5">
                                            <span class="font-bold font-sans text-lg">Local Transaction</span>
                                            <span class="font-bold font-sans text-sm">231</span>
                                        </div>
                                    </div>
                                    <div class="box-border rounded-2xl text-center border-2 shadow-2xl h-32 w-fit p-3">
                                        <div class="grid grid-cols-1 gap-5">
                                            <span class="font-bold font-sans text-lg">Cross Transaction</span>
                                            <span class="font-bold font-sans text-sm">231</span>
                                        </div>
                                    </div>
                                </div>


                            </div>
                            <div class="box-border col-span-2 rounded-xl border-2 shadow-2xl p-2">
                                <Transaction-chart />
                            </div>

                        </div>
                        <div class="flex flex-col p-5 rounded-xl border-2 shadow-2xl">
                            <Most-used />
                            <div class=" py-2 text-center">
                                <span class="font-bold text-lg">Equipment</span>
                            </div>

                        </div>

                    </div>
                    <div class="box-border col-span-3 mt-10 rounded-xl border-2 shadow-2xl p-2">
                        <div class="flex flex-row space-x-10">
                            <Status-chart />
                            <div class="flex flex-col justify-evenly py-7">
                                <div class="flex flex-row space-x-3 ">
                                    <div class="box-border rounded-full mt-1 opacity-50 h-3 w-3"
                                        style="background-color:  rgba(255, 99, 132, 1)"></div>
                                    <span class="text-sm">Serviceable</span>
                                </div>
                                <div class="flex flex-row space-x-3">
                                    <div class="box-border rounded-full   mt-1 opacity-50 h-3 w-3"
                                        style="background-color: rgba(255, 206, 86, 1)"></div>
                                    <span class="text-sm">Unusable</span>
                                </div>
                                <div class="flex flex-row space-x-3">
                                    <div class="box-border rounded-full   mt-1 opacity-50 h-3 w-3"
                                        style="background-color: rgba(54, 162, 235, 1)"></div>
                                    <span class="text-sm">Serviceable</span>
                                </div>

                            </div>
                        </div>

                    </div>
                </div>
                <div class="hidden sm:flex  static bg-white flex-col flex-grow h-screen w-max overflow-x-auto box-border 
                     border-2 rounded-2xl shadow-2xl">
                    <div class="flex flex-col m-10">
                        <h1 class="font-bold text-xl">Municipalities</h1>
                        <!-- <div class=" h-fit px-4 py-2 shadow-xl content-center bg-white rounded-2xl ">
                       
                    </div> -->
                    </div>
                </div>
            </div>



        </main>



    </main>


</template>

<script>
import TransactionChart from '../../Components/Charts/TransactionChart.vue'
import MostUsed from '@/Components/Charts/MostUsed.vue';
import StatusChart from '../../Components/Charts/StatusChart.vue';
export default {
    components: {
        TransactionChart,
        MostUsed,
        StatusChart
    },
    setup() {


        return {}
    }
}
</script>

<style lang="scss" scoped>

</style>