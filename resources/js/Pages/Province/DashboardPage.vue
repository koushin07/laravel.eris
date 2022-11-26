<template>
    <Content-box class="bg-gray-50">
        <div class="grid grid-cols-8 gap-10 h-full">


            <div class="flex flex-col space-y-3 col-span-3">
                <span class="font-bold text-base text-justify">Local Transactions</span>
                <div class="flex flex-col overflow-hidden h-[480px] cols-span-2">

                    <div
                        class="flex flex-col justify-between overflow-y-auto bg-white shadow-lg rounded-lg space-y-2 scrollbar">
                        <button v-for="(local, key) in locals" :key="key"
                            class="flex justify-between  border-b  p-4 hover:bg-slate-200 border-grey-200 last:border-transparent">

                            <div class="grid grid-cols-1 text-start">
                                <span class="font-bold text-base text-gray-700 uppercase">{{ local.equipment }}</span>
                                <span class="text-xs text-gray-700 uppercase font-semibold">From: {{ local.owner }}</span>
                                <span class="text-xs text-gray-700 uppercase font-semibold">To: {{ local.borrower }}</span>
                            </div>



                        </button>

                    </div>
                </div>
            </div>

            <div class="flex flex-col space-y-3 col-span-3">
                <span class="font-bold text-base text-justify">Cross Transactions</span>
                <div class="flex flex-col overflow-hidden h-[480px] cols-span-2">

                    <div
                        class="flex flex-col justify-between overflow-y-auto bg-white shadow-lg rounded-lg space-y-2 scrollbar">
                        <button v-for="(regional, key) in regionals" :key="key"
                            class="flex justify-between  border-b  p-4 hover:bg-slate-200 border-grey-200 last:border-transparent">

                            <div class="grid grid-cols-1 text-start">
                                <span class="font-bold text-base text-gray-700 uppercase">{{ regional.equipment }}</span>
                                <span class="text-xs text-gray-700 uppercase">{{ regional.owner }}</span>
                                    <span class="text-xs text-gray-700 uppercase">{{ regional.borrower }}</span>
                            </div>
                        </button>

                    </div>
                </div>
            </div>
            <div class="flex flex-col space-y-3 col-span-2">
                <span class="font-bold text-base text-justify">Incident Report</span>
                <div class="flex flex-col overflow-hidden h-[480px] cols-span-2">

                    <div
                        class="flex flex-col justify-between overflow-y-auto bg-white shadow-lg rounded-lg space-y-2 scrollbar">
                        <button v-for="(report, key) in reports" :key="key"
                            class="flex justify-between  border-b  p-4 hover:bg-slate-200 border-grey-200 last:border-transparent">

                            <div class="grid grid-cols-1 text-start">
                                <span class="font-bold text-base text-gray-700 uppercase">{{ report.reciever.name }}</span>
                                <span class="text-xs text-gray-700 uppercase">{{ report.filename }}</span>
                            </div>



                        </button>

                    </div>
                </div>
            </div>


        </div>

    </Content-box>
</template>

<script>
import TransactionChart from '@/Components/Charts/TransactionChart.vue';
import ContentBox from '@/Components/ContentBox.vue';
import ProvinceLayout from '@/Layouts/Province/ProvinceLayout.vue';
import { Inertia } from '@inertiajs/inertia';
import { usePage } from '@inertiajs/inertia-vue3';

export default {
    layout: ProvinceLayout,
    props: {
        locals: Array,
        regionals: Array,
        reports: Array,
    },
    setup() {
        const serviceable = 40

        window.Echo.private(`child.transacton.${usePage().props.value.auth.user.id}`)
            .listen('.child.trans', (e) => {
                Inertia.reload({ only: ['locals'] })
            })

        return {
            serviceable
        };
    },
    components: { ContentBox, TransactionChart }
}
</script>

<style lang="scss" scoped>

</style>