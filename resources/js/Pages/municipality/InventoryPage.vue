<template>

    <!-- <Head title="Tansaction" /> -->
    <Content-box class="w-full h-fit">
        <div class="flex flex-col mx-10 mt-4 space-y-30">
            <div class="flex flex-col justify-end h-fit">
                <span class="text-xl font-bold  ">
                    TOTAL EQUIPMENT
                </span>
                <span class="text-5xl " style="font-family: century-gothic, sans-serif;">
                    {{ status.total }}
                </span>
            </div>
            <div class="flex flex-col w-full">
                <div class="flex flex-col-reverse md:flex-row gap-7 justify-end w-full ">
                    <div class="flex flex-row justify-between w-full">
                        <div class="flex flex-col space-y-10 content-box py-6 px-4 rounded-xl border-2 w-[200px] lg:w-[250px] h-fit">
                            <span class="text-slate-600 text-lg font-bold tracking-wider">SERVICEABLE</span>
                            <span
                                class="text-center mt-4 lining-nums text-slate-700 text-3xl font-semibod tracking-wider">
                                {{ status.serviceable }}
                            </span>
                        </div>
                        <div class="flex flex-col space-y-10 content-box py-6 px-4 rounded-xl border-2 w-[200px] lg:w-[250px] h-fit">
                            <span class="text-slate-600 text-lg font-bold tracking-wider">POOR</span>
                            <span
                                class="text-center mt-4 lining-nums text-slate-700 text-3xl font-semibod tracking-wider">
                                {{ status.poor }}
                            </span>
                        </div>
                        <div class="flex flex-col space-y-10 content-box py-6 px-4 rounded-xl border-2 w-[200px] lg:w-[250px] h-fit">
                            <span class="text-slate-600 text-lg font-bold tracking-wider">UNUSABLE</span>
                            <span
                                class="text-center mt-4 lining-nums text-slate-700 text-3xl font-semibod tracking-wider">
                                {{ status.unusable }}
                            </span>
                        </div>
                    </div>

                    <div 
                        class="grid  place-content-center h-[250px] py-2 md:h-[200px] md:w-[300px] content-box px-4  rounded-xl border-2 ">

                        <canvas id="myChart"></canvas>



                    </div>



                </div>

            </div>
        </div>

    </Content-box>
    <ContentBox class="h-fit">
       
      
        <div class="flex flex-col space-y-5">
            <span class=" text-base font-bold col-span-2 md:col-span-3">My Inventory</span>


            <div class="grid md:grid-cols-4 place-content-between">


                <div class="col-span-2 md:col-span-3">
                    <CreateModal />
                </div>


                <div class="relative col-span-2 md:col-span-1   ">
                    <div class="relative w-full max-w-xl mr-6 focus-within:text-purple-500">
                            <div class="absolute inset-y-0 flex items-center pl-2">
                                <svg class="w-4 h-4" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z"
                                        clip-rule="evenodd"></path>
                                </svg>
                            </div>
                            <input v-model="search"
                                class="w-full pl-8 pr-2 text-sm text-gray-700 placeholder-gray-600 bg-gray-100 border-0 rounded-md dark:placeholder-gray-500 dark:focus:shadow-outline-gray dark:focus:placeholder-gray-600 dark:bg-gray-700 dark:text-gray-200 focus:placeholder-gray-500 focus:bg-white focus:border-purple-300 focus:outline-none focus:shadow-outline-purple form-input"
                                type="text" placeholder="Search for projects" aria-label="Search">
                        </div>
                </div>


            </div>
            <div class="relative">
                <Table :tableHeader="tableHead" :tableBody="equipments.data" :links="equipments.links" :editable="true"
                    :filters="filters" />
                <div class="bg-white ">
                    <Pagination :links="equipments.links" />


                </div>
            </div>
        </div>
    </ContentBox>




</template>

<script>

import { ref, watch, onMounted, computed } from 'vue';
import { Inertia } from '@inertiajs/inertia';
import CreateModal from '@/Components/Forms/CreateModal.vue';
import ContentBox from '@/Components/ContentBox.vue'
import Table from '@/Components/Table.vue';
import MunicipalityLayout from '@/Layouts/MunicipalityLayout.vue';
import { usePage, Head } from '@inertiajs/inertia-vue3';
import Pagination from '@/Components/Pagination.vue';
import Chart from 'chart.js/auto'
import ChartDataLabels from 'chartjs-plugin-datalabels';

export default {
    layout: MunicipalityLayout,
    components: {
        CreateModal,
        Pagination,
        Head,
        ContentBox,
        Table
    },
    props: {
        status: Object,
        equipments: Object,
        name: Object,
        filters: [Array, Object]
    },
    setup({ filters, status }) {
        const current = ref(usePage().url.value)
        const search = ref('')
        const tableBody = ref({})

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
        const labels = ref(['serviceable', 'poor', 'unusable'])
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

        watch(search, value => {

            Inertia.get(usePage().url.value, { search: value }, {
               
            })

        })
        onMounted(() => {

            const ctx = document.getElementById('myChart').getContext('2d');

            const mychart = new Chart(ctx, {
                type: 'doughnut',
                data: {
                    labels: labels,
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
                    
                        // legend:{
                        //     display: false
                        // },
                        tooltip: {
                            enabled: false,
                        },
                        datalabels: {
                           
                           align: 'end',
                            formatter: (value, context) => {
                                console.log(value)
                                return `${value}% \n${labels.value[context.dataIndex]} `
                            },
                            labels:{
                                
                                title:{
                                   font:{
                                    size: 10
                                   }
                                }
                            },
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


        return {
            tableHead,
            search,
            tableBody,
        };
    },

}
</script>

<style lang="scss" scoped>

</style>