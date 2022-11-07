<template>
    <Content-box>
        <div class="grid grid-flow-row md:grid-cols-4  gap-5 h-full w-full ">
            <!-- first box -->
          <Account-card/>
            <div class="box-content border-2 col-span-3 h-full w-full ">

                <div class="grid grid-cols-3 gap-6 h-full ">
                    <!-- status -->
                    <div class="grid grid-cols-2 gap-7 w-full p-3">

                        <div class="flex flex-col justify-evenly text-center box-content border-2 p-2 rounded-2xl">
                            <div class="text-center">
                                <span class="text-center font-bold text-lg">Total</span>

                            </div>
                            <span class="text-center font-bold text-xl">{{ status.total }}</span>

                        </div>

                        <div class="flex flex-col justify-evenly text-center box-content border-2 p-2 rounded-2xl">
                            <div class="text-center">
                                <span class="text-center font-bold text-lg">Serviceable</span>

                            </div>
                            <span class="text-center font-bold text-xl">{{ status.serviceable }}</span>

                        </div>
                        <div class="flex flex-col justify-evenly text-center box-content border-2 p-2 rounded-2xl">
                            <div class="text-center">
                                <span class="text-center font-bold text-lg">Poor</span>

                            </div>
                            <span class="text-center font-bold text-xl">{{ status.poor }}</span>

                        </div>
                        <div class="flex flex-col justify-evenly text-center box-content border-2 p-2 rounded-2xl">
                            <div class="text-center">
                                <span class="text-center font-bold text-lg">Unusable</span>

                            </div>
                            <span class="text-center font-bold text-xl">{{ status.unusable }}</span>

                        </div>
                    </div>
                    <!-- end of status -->
                    <div class="grid grid-cols-5 gap-8 col-span-2">
                      
                        <div
                            class="grid place-content-center  col-span-3 box-border w-full">
                            <div class="flex flex-col space-y-8 justify-items-center">

                                <Status-chart/>

                            </div>

                        </div>
                        <div class="flex flex-col col-span-2 justify-evenly box-content border-l-2 my-3 p-4">
                            <span class="text-lg font-bold">Pendings</span>
                            <button type="button"
                                class="inline-flex items-center px-5 text-sm font-medium text-center hover:bg-orange-300  border-2  rounded-lg  ">
                                Equipment Request
                                <span
                                    class="inline-flex justify-center items-center ml-2 w-4 h-4 text-xs font-semibold text-blue-800 bg-blue-200 rounded-full">
                                    {{ notification }}
                                </span>
                            </button>

                            <button type="button"
                                class="inline-flex items-center px-5 py-2.5 text-sm font-medium text-center  hover:bg-orange-300  border-2 rounded-lg   ">
                                Equipment Type
                                <span
                                    class=" inline-flex justify-center items-center ml-2 w-4 h-4 text-xs font-semibold text-blue-800 bg-blue-200 rounded-full">
                                    {{ unfinish }}
                                </span>
                            </button>

                            <button type="button"
                                class="inline-flex items-center px-5 py-2.5 text-sm font-medium text-center  hover:bg-orange-300  border-2 rounded-lg   ">
                                Incident Report
                                <span
                                    class=" inline-flex justify-center items-center ml-2 w-4 h-4 text-xs font-semibold text-blue-800 bg-blue-200 rounded-full">
                                    {{ reports }}
                                </span>
                            </button>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </Content-box>
</template>

<script>
import AccountCard from '@/Components/AccountCard.vue';
import ContentBox from '@/Components/ContentBox.vue';
import MunicipalityLayout from '@/Layouts/MunicipalityLayout.vue'
import PendingTransactions from '../Components/PendingTransactions.vue'
import StatusChart from '@/Components/Charts/StatusChart.vue';
export default {
    layout: MunicipalityLayout,
    props: {
        reports: Object,
        status: Object,
        notification: Number,
        unfinish: Number
    },
    setup() {

        return {};
    },
    components: {
    ContentBox,
    PendingTransactions,
    AccountCard,
    StatusChart,

}
}
</script>

<style lang="scss" scoped>

</style>