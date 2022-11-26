<template>

    <Head title="Account" />
    <Content-box class="w-full">
        <div class="flex flex-col mx-10 mt-4 space-y-44">
            <div class="flex flex-col justify-end h-fit">
                <span class="text-xl font-bold  ">
                    TOTAL EQUIPMENT
                </span>
                <span class="text-5xl " style="font-family: century-gothic, sans-serif;">
                    {{ status.total }}
                </span>
            </div>
            <div class="flex flex-col w-full">
                <div class="flex flex-col-reverse md:flex-row gap-7 justify-end ">
                    <div class="flex flex-col space-y-10 content-box py-6 px-4 rounded-xl border-2 w-full h-fit">
                        <span class="text-slate-600 text-3xl font-bold tracking-wider">SERVICEABLE</span>
                        <span class="text-center mt-4 lining-nums text-slate-700 text-2xl font-semibod tracking-wider">
                            {{ status.serviceable }}
                        </span>
                    </div>
                    <div class="flex flex-col space-y-10 content-box py-6 px-4 rounded-xl border-2 w-full h-fit">
                        <span class="text-slate-600 text-3xl font-bold tracking-wider">POOR</span>
                        <span class="text-center mt-4 lining-nums text-slate-700 text-2xl font-semibod tracking-wider">
                            {{ status.poor }}
                        </span>
                    </div>
                    <div class="flex flex-col space-y-10 content-box py-6 px-4 rounded-xl border-2 w-full h-fit">
                        <span class="text-slate-600 text-3xl font-bold tracking-wider">UNUSABLE</span>
                        <span class="text-center mt-4 lining-nums text-slate-700 text-2xl font-semibod tracking-wider">
                            {{ status.unusable }}
                        </span>
                    </div>
                    <div
                        class="grid place-content-center h-[250px] py-2 md:h-[300px] md:w-[400px] content-box px-4  rounded-xl border-2 ">

                        <canvas id="myChart"></canvas>



                    </div>



                </div>

            </div>
        </div>

    </Content-box>
    <Content-box>
        <div class="flex flex-col space-y-5">
        
                <CreateModal />
         
            <div class="grid md:grid-cols-4 place-content-between">



                <span class=" text-base font-bold col-span-2 md:col-span-3">My Inventory</span>

                <div class="relative col-span-2 md:col-span-1   ">
                    <input type="search" id="search-dropdown" class="block h-8 w-full z-20 text-sm border-2 bg-transparent rounded-lg focus:outline-none focus:ring-0  py-2 px-1
                                " required v-model="search" placeholder="search...">
                    <button type="submit"
                        class=" absolute grid place-content-center h-8 top-0 right-0 p-2 text-sm font-medium text-white bg-blue-700 
                                rounded-r-lg border-2 border-blue-700 hover:bg-blue-800 focus:ring-2 focus:outline-none
                                 focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800"><svg
                            aria-hidden="true" class="w-5 h-5 animate-wiggle" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg></button>
                </div>


            </div>
            <div class="overflow-auto relative">
                <Table :tableHeader="tableHead" :tableBody="equipments.data" :links="equipments.links"
                    :filters="filters" />
                <div class="bg-white ">
                    <Pagination :links="equipments.links" />


                </div>
            </div>
        </div>
    </Content-box>
</template>

<script>
import Layout from '@/Layouts/MunicipalityLayout.vue'
import ContentBox from '@/Components/ContentBox.vue'
import { computed, onMounted, watch, ref } from 'vue'
import Chart from 'chart.js/auto'
import { Head, usePage } from '@inertiajs/inertia-vue3'
import ChartDataLabels from 'chartjs-plugin-datalabels';
import InventoryPage from './municipality/InventoryPage.vue'
import CreateModal from '@/Components/Forms/CreateModal.vue';
import Table from '@/Components/Table.vue';
import Pagination from '@/Components/Pagination.vue';
import { Inertia } from '@inertiajs/inertia';

export default {
    layout: Layout,
    components: {
        ContentBox,
        Head,
        InventoryPage,
        CreateModal,
        Table,
        Pagination,
    },
    props: {
        status: Object,
        equipments: Object,
        filters: [Array, Object]
    },
    setup({ status, filters }) {
        const current = ref(usePage().url.value)
        const search = ref(filters.search)
        const tableBody = ref({})
        const percentage = computed(() => {
            const serviceable = Math.floor((status.serviceable / status.total) * 100)
            const unusable = Math.floor((status.unusable / status.total) * 100)
            const poor = Math.floor((status.poor / status.total) * 100)

            return {
                serviceable,
                unusable,
                poor
            }
        })
        const tableHead = [
            { name: "Equipment" },
            { name: "Category" },
            { name: "Model" },
            { name: "Serial" },
            { name: "Unit" },
            { name: "Code" },
            { name: "Asset ID" },
            { name: "More" }
        ]
        onMounted(() => {

            const ctx = document.getElementById('myChart').getContext('2d');

            const mychart = new Chart(ctx, {
                type: 'doughnut',
                data: {
                    labels: ['serviceable', 'poor', 'unusable'],
                    datasets: [{

                        label: 'Status',
                        data: [percentage.value.serviceable, percentage.value.poor, percentage.value.unusable],
                        borderWidth: 1,
                        backgroundColor: [
                            '#FFA34E',
                            '#BA882F',
                            '#7E6B19',
                        ],
                        borderColor: [
                            '#FFA34E',
                            '#BA882F',
                            '#7E6B19',
                        ],
                    }]
                },
                options: {
                    plugins: {

                        tooltip: {
                            enabled: false,
                        },
                        datalabels: {

                            formatter: (value, context) => {
                                return `${value}%`
                            }
                        }
                    },
                    maintainAspectRatio: false,
                    legend: {
                        display: false,
                        title: {
                            display: false
                        }
                    },

                },
                plugins: [ChartDataLabels]

            });

            // mychart.canvas.parentNode.style.height = '250px';
            // mychart.canvas.parentNode.style.width = '400px';
        })
        watch(search, value => {

            Inertia.get(usePage().url.value, { search: value }, {
                preserveState: true
            })

        })

        return {
            percentage,
            tableHead,
            search,
            current,
            tableBody
        }
    }
}
</script>

<style lang="scss" scoped>

</style>