

<template>

    <Head title="Dashboard" />



    <div class="grid grid-cols-2 sm:grid-cols-4
                    grid-flow-row gap-4">
        <!-- <SmallCard title="tatol" :quantity=""/> -->
        <SmallCard v-for="(value, status) in status" :title="status" :quantity="value" />

    </div>
    <!-- 
    <div class="grid grid-cols-1 mt-10 mb-2 sm:grid-cols-2
                     gap-2">
        <div class="box-border h-64 p-2 border shadow-lg content-center bg-white rounded-2xl">Chart for
            <canvas id="myChart" width="400" height="200"></canvas>
        </div>
        <div class="box-border h-64 p-2 border shadow-lg content-center bg-white rounded-2xl">Chart for
            Transaction


        </div>
    </div> -->
    <div class="flex flex-col h-72 p-4 border my-2 shadow-lg content-center bg-white rounded-2xl">

        <span class="text-bold text-justify p-2 text-lg antialiased">My Transactions </span>
        <!-- <div v-for="data in returnedData">
        {{ data }}
    </div> -->
        <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400 ">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                <tr>

                    <th scope="col" class="py-3 px-6 text-center">
                        quantity
                    </th>
                    <th scope="col" class="py-3 px-6 text-center">
                        equipment
                    </th>
                    <th scope="col" class="py-3 px-6 text-center">
                        owner
                    </th>
                    <th scope="col" class="py-3 px-6 text-center">
                        date
                    </th>

                </tr>
            </thead>
            <tbody>


                <tr v-for="data in returnedData" v-if="returnedData.length>0"
                    class="overflow-y-auto bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600 text-center">

                    <td scope="row" class="items-center py-4  text-gray-900 whitespace-nowrap dark:text-white">

                        <div class="text-base font-semibold ">{{ data.quantity }}</div>

                    </td>


                    <td scope="row" class="items-center  text-gray-900 whitespace-nowrap dark:text-white">

                        <div class="text-base font-semibold ">{{ data.equipment_name }}</div>

                    </td>
                    <td scope="row" class="items-center  text-gray-900 whitespace-nowrap dark:text-white ">

                        <div class="text-base font-semibold">{{ data.owner }}</div>
                    </td>
                    <td scope="row" class="items-center  text-gray-900 whitespace-nowrap dark:text-white ">

                        <div class="text-base font-semibold">{{ data.created_at }}</div>
                    </td>





                </tr>
                <tr v-else
                    class="overflow-y-auto bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600 ">

                    <td scope="row" class="items-center py-4  text-gray-900 whitespace-nowrap dark:text-white">
                        <div class="pl-3">
                            <div class="text-base font-semibold ">No Record</div>

                        </div>
                    </td>


                    <td scope="row" class="items-center  text-gray-900 whitespace-nowrap dark:text-white">
                        <div class="pl-3">
                            <div class="text-base font-semibold ml-2"></div>

                        </div>
                    </td>
                    <td scope="row" class="items-center  text-gray-900 whitespace-nowrap dark:text-white ">
                        <div class="pl-3">
                            <div class="text-base font-semibold ml-8"></div>

                        </div>
                    </td>
                    <td class="py-4 px-6">
                        <a href="javascript:void(0)" type="button"
                            class="font-medium text-blue-600 dark:text-blue-500 hover:underline"></a>

                    </td>


                </tr>

            </tbody>
        </table>


    </div>




</template>
<script setup>
import { Head } from '@inertiajs/inertia-vue3';
import SmallCard from '@/Components/SmallCard.vue';
import Chart from 'chart.js/auto';
import { onMounted, ref } from 'vue';
import { Inertia } from '@inertiajs/inertia'
import axios from 'axios';
import { usePage } from '@inertiajs/inertia-vue3';

const props = defineProps({
    status: Object
})

const returnedData = ref({})
const ownTrans = ref([])

    window.Echo.channel('fires').listen('.equipment.created', () => {
        Inertia.reload({ only: ['status'] })
        axios.get('http://127.0.0.1:8000/api/returnedChart')
            .then((res) => {
                returnedData.value = res.data
                console.log('first')
                console.log(returnedData.value.total)

            })
    })
// equipmentchart component
onMounted(async () => {

    await axios.get('http://127.0.0.1:8000/api/returnedChart')
        .then((res) => {
            returnedData.value = res.data
          

        })



    const ctx = document.getElementById('myChart');
    const trans = document.getElementById('myTransactionChart')
    // const myChart = new Chart(ctx, {
    //     type: 'bar',
    //     data: {
    //         labels: ['Total', 'denied', 'confirmed'],
    //         datasets: [{
    //             label: '# Total',
    //             data: [returnedData.value.total, returnedData.value.not_confirmed, returnedData.value.confirmed],
    //             backgroundColor: [
    //                 'rgba(255, 99, 132, 0.2)',
    //                 'rgba(54, 162, 235, 0.2)',
    //                 'rgba(255, 206, 86, 0.2)',
    //                 'rgba(75, 192, 192, 0.2)',
    //                 'rgba(153, 102, 255, 0.2)',

    //             ],
    //             borderColor: [
    //                 'rgba(255, 99, 132, 1)',
    //                 'rgba(54, 162, 235, 1)',
    //                 'rgba(255, 206, 86, 1)',
    //                 'rgba(75, 192, 192, 1)',
    //                 'rgba(153, 102, 255, 1)',

    //             ],
    //             borderWidth: 1
    //         }]
    //     },
    //     options: {
    //         scales: {
    //             y: {
    //                 beginAtZero: true
    //             }
    //         }
    //     }
    // });
    // const returned = new Chart(trans, {
    //     type: 'line',
    //     data: {
    //         labels: ['Total', 'Serviceable', 'Poor', 'Unusable'],
    //         datasets: [{
    //             label: '# Total',
    //             data: [props.status.total, props.status.serviceable, props.status.poor, props.status.unusable],
    //             backgroundColor: [
    //                 'rgba(255, 99, 132, 0.2)',
    //                 'rgba(54, 162, 235, 0.2)',
    //                 'rgba(255, 206, 86, 0.2)',
    //                 'rgba(75, 192, 192, 0.2)',
    //                 'rgba(153, 102, 255, 0.2)',
    //                 'rgba(255, 159, 64, 0.2)'
    //             ],
    //             borderColor: [
    //                 'rgba(255, 99, 132, 1)',
    //                 'rgba(54, 162, 235, 1)',
    //                 'rgba(255, 206, 86, 1)',
    //                 'rgba(75, 192, 192, 1)',
    //                 'rgba(153, 102, 255, 1)',
    //                 'rgba(255, 159, 64, 1)'
    //             ],
    //             borderWidth: 1
    //         }]
    //     },
    //     options: {
    //         scales: {
    //             y: {
    //                 beginAtZero: true
    //             }
    //         }
    //     }
    // });


})
</script>
    
<script>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';


export default { layout: AuthenticatedLayout }
</script>
