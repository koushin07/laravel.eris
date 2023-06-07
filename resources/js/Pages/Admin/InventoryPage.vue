<template>

    <Head title="Tansaction" />

    <div class="flex flex-col mx-10 mt-4 gap-10">
        <div class="flex flex-col justify-end h-fit ">
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
                    <div
                        class="flex bg-white flex-col space-y-10 content-box py-6 px-4 rounded-xl shadow-5 shadow-sm w-[200px] lg:w-[250px] h-fit">
                        <span class="text-slate-600 text-lg font-bold tracking-wider">SERVICEABLE</span>
                        <span class="text-center mt-4 lining-nums text-slate-700 text-3xl font-semibod tracking-wider">
                            {{ status.serviceable }}
                        </span>
                    </div>
                    <div
                        class="flex bg-white flex-col space-y-10 content-box py-6 px-4 rounded-xl shadow-5 w-[200px] lg:w-[250px] h-fit">
                        <span class="text-slate-600 text-lg font-bold tracking-wider">POOR</span>
                        <span class="text-center mt-4 lining-nums text-slate-700 text-3xl font-semibod tracking-wider">
                            {{ status.poor }}
                        </span>
                    </div>
                    <div
                        class="flex bg-white flex-col space-y-10 content-box py-6 px-4 rounded-xl shadow-5 w-[200px] lg:w-[250px] h-fit">
                        <span class="text-slate-600 text-lg font-bold tracking-wider">UNSERVICEABLE</span>
                        <span class="text-center mt-4 lining-nums text-slate-700 text-3xl font-semibod tracking-wider">
                            {{ status.unserviceable }}
                        </span>
                    </div>
                </div>





            </div>
            <div class="flex flex-row space-x-6 h-[250px]  md:h-[300px]">
                <div class="grid  place-content-center   content-box px-4  rounded-xl bg-white shadow-5 mt-4 ">
                    <div class=" h-[250px]  md:h-[250px]   py-2    md:w-[300px] ">
                        <canvas id="myChart"></canvas>
                    </div>




                </div>
                <div class=" py-2 flex flex-col w-full content-box px-4  rounded-xl bg-white shadow-5 mt-4 ">
                    <span class="font-bold text-lg mb-6 text-red-500">On Critical Condition Equipment</span>
                    <ul class="w-full divide-y divide-gray-200 dark:divide-gray-700">
                        <li class="pb-3 sm:pb-4" v-for="(critacal, key) in criticals">
                            <div class="flex items-center space-x-4" v-if="critacal">

                                <div class="flex-1 min-w-0">
                                    <p class="text-sm font-medium text-gray-500 truncate dark:text-white">
                                        Equipment
                                    </p>
                                    <p class="text-sm text-gray-900 truncate font-semibold dark:text-gray-400">
                                        {{ key }}
                                    </p>
                                </div>
                                <div class="flex flex-col min-w-0 justify-end ">
                                    <p class="text-sm font-medium text-gray-500 truncate dark:text-white">
                                        Remainings
                                    </p>
                                    <p class="text-sm text-gray-900 truncate font-semibold dark:text-gray-400 text-end">
                                        {{ critacal }}
                                    </p>

                                </div>
                            </div>
                        </li>
                    </ul>




                </div>
            </div>

        </div>

    </div>



    <ContentBox class="h-full p-2">

        <div class="flex flex-col space-y-5">



            <div class="flex flex-row justify-between ">
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
                            type="text" placeholder="Search for Equipment" aria-label="Search">
                    </div>
                </div>
                <div class="my-1 w-44">
                    <v-select :options=municipalities v-model="municipality" placeholder="Municipalities" label="municipality"></v-select>
                </div>
            </div>
            <hr>
            <div class="relative">

                <Table>
                    <template #header>
                        <tr>
                            <th scope="col" class="py-3 px-6" v-for="(head, key) in tableHead" :key="key">
                                <div class="flex flex-row justify-center py-1">
                                    <span>
                                        {{ head.name }}
                                    </span>


                                </div>

                            </th>

                        </tr>
                    </template>
                    <template #body>
                        <tr class="max-h-full even:bg-orange-200  bg-white border-b dark:bg-gray-800 dark:border-gray-700"
                            v-for="(body, key) in equipments.data">
                            <td scope="row" class="text-center p-4">
                                {{ body.name }}
                            </td>

                            <td class="text-center">
                                {{ body.available }}
                            </td>
                            <td class="text-center">
                                {{ body.damages }}
                            </td>
                            <td class="text-center">
                                {{ body.municipality }}
                            </td>
                            <td class="text-center">
                                {{ moment(body.recieved_at).format('MMMM DD Y') }}
                            </td>
                            <td class="text-center">
                                <inertia-link type="button" :href="route('rdrrmc.consolidated.show', body.id)"
                                    :data="{ municipality: body.municipality }"
                                    class="font-medium text-orange-600 dark:text-orange-500 hover:underline">
                                    <!-- <EditModal :form="body" /> -->
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                        stroke-width="1.5" stroke="currentColor" class="w-5 h-5 ">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M3.75 3.75v4.5m0-4.5h4.5m-4.5 0L9 9M3.75 20.25v-4.5m0 4.5h4.5m-4.5 0L9 15M20.25 3.75h-4.5m4.5 0v4.5m0-4.5L15 9m5.25 11.25h-4.5m4.5 0v-4.5m0 4.5L15 15" />
                                    </svg>

                                </inertia-link>


                            </td>
                        </tr>
                    </template>

                </Table>
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
import adminLayout from '@/Layouts/AdminLayout.vue'
import { usePage, Head } from '@inertiajs/inertia-vue3';
import Pagination from '@/Components/Pagination.vue';
import Chart from 'chart.js/auto'
import ChartDataLabels from 'chartjs-plugin-datalabels';
import Dropdown from '@/Components/Dropdown.vue'
import InvoiceModal from '@/Components/InvoiceModal.vue'
import moment from 'moment'
import axios from 'axios';


export default {
    layout: adminLayout,
    components: {
        CreateModal,
        Pagination,
        Head,
        ContentBox,
        Table,
        Dropdown,
        InvoiceModal
    },
    props: {
        criticals: Object,
        status: Object,
        equipments: Object,
        name: Object,
        filters: [Array, Object],
        municipalities: Array,
    },
    setup({ filters, status, equipments }) {
        const current = ref(usePage().url.value)
        const search = ref('')
        const tableBody = ref({})
        const municipality = ref()
        const tableHead = [
            { name: "equipment" },
            { name: "available" },
            { name: "damages" },
            { name: "municipality" },
            { name: "date Recieved" },
            { name: "action" }
        ]
        const labels = ref(['serviceable', 'poor', 'unserviceable'])
        const date = ref(new Date());
        const equipmentStatus = ref()
        const category = ref()

        const download = () => {
            axios.get('/api/invoice-data').then((res) => {
                console.log(res);
                alert(' done')
            })
        }
        const percentage = computed(() => {
            const serviceable = Math.floor((status.serviceable / status.total) * 100)
            const unserviceable = Math.floor((status.unserviceable / status.total) * 100)
            const poor = Math.floor((status.poor / status.total) * 100)

            return {
                serviceable,
                unserviceable,
                poor
            }
        })
        watch(municipality, value => {
            Inertia.get(usePage().url.value, { municipality: value },{
                preserveState: true
            })
        })
        watch(search, value => {

            Inertia.get(usePage().url.value, { search: value }, {
                preserveState: true
            })

        })
        watch(equipmentStatus, value => {
            Inertia.get(usePage().url.value, { status: value }, {
                preserveState: true
            })
        })
        watch(category, value => {
            Inertia.get(usePage().url.value, { category: value }, {
                preserveState: true
            })
        })
        watch(date, value => {
            Inertia.get(usePage().url.value, { date: value }, {
                preserveState: true
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
                        data: [percentage.value.serviceable, percentage.value.poor, percentage.value.unserviceable],
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
                            labels: {

                                title: {
                                    font: {
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
            municipality,
            tableHead,
            search,
            download,
            date,
            tableBody,
            equipmentStatus,
            category,
            moment
        };
    },

}
</script>

<style scoped>
.bg-txt {
    color: #4B3F72;

}

.shadow-5 {
    box-shadow: rgba(0, 0, 0, 0.24) 0px 3px 8px;
}
</style>