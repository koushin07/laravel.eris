

<template>

    <Head title="Dashboard" />



    <div class="grid grid-cols-2 sm:grid-cols-4
                    grid-flow-row gap-4">

        <SmallCard v-for="(value, status) in status" :title="status" :quantity="value" />

    </div>

    <div class="grid grid-cols-1 mt-10 mb-2 sm:grid-cols-2
                     gap-2">
        <div class="box-border h-64 p-2 border shadow-lg content-center bg-white rounded-2xl">Chart for
            <canvas id="myChart" width="400" height="200"></canvas>
        </div>
        <div class="box-border h-64 p-2 border shadow-lg content-center bg-white rounded-2xl">Chart for
            Transaction
            <canvas id="myTransactionChart" width="400" height="200"></canvas>

        </div>
    </div>
    <div class="flex h-72 p-4 border my-2 shadow-lg content-center bg-white rounded-2xl">
        <div class="grid grid-cols-2 gap-2">
            <div>

            </div>

        </div>
    </div>




</template>
<script setup>
import { Head } from '@inertiajs/inertia-vue3';
import SmallCard from '@/Components/SmallCard.vue';
import Chart from 'chart.js/auto';
import { onMounted, ref } from 'vue';
import { Inertia } from '@inertiajs/inertia'
import axios from 'axios';


const props = defineProps({
    status: Object
})

const returnedData = ref({})

window.Echo.channel('fires').listen('.equipment.created', () => {
    Inertia.reload({ only: ['status'] })
    axios.get('http://127.0.0.1:8000/returnedChart')
        .then((res) => {
            returnedData.value = res.data
            console.log('first')
            // console.log(returnedData.value.total)

        })
})
// equipmentchart component
onMounted(async () => {

    await axios.get('http://127.0.0.1:8000/returnedChart')
        .then((res) => {
            returnedData.value = res.data
            // console.log(returnedData.value.total)

        })
   

    const ctx = document.getElementById('myChart');
    const trans = document.getElementById('myTransactionChart')
    const myChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: ['Total', 'Pending', 'Returned'],
            datasets: [{
                label: '# Total',
                data: [returnedData.value.total, returnedData.value.totalPending, returnedData.value.totalReturned],
                backgroundColor: [
                    'rgba(255, 99, 132, 0.2)',
                    'rgba(54, 162, 235, 0.2)',
                    'rgba(255, 206, 86, 0.2)',
                    'rgba(75, 192, 192, 0.2)',
                    'rgba(153, 102, 255, 0.2)',

                ],
                borderColor: [
                    'rgba(255, 99, 132, 1)',
                    'rgba(54, 162, 235, 1)',
                    'rgba(255, 206, 86, 1)',
                    'rgba(75, 192, 192, 1)',
                    'rgba(153, 102, 255, 1)',

                ],
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
    const myTransactionChart = new Chart(trans, {
        type: 'line',
        data: {
            labels: ['Total', 'Serviceable', 'Poor', 'Unusable'],
            datasets: [{
                label: '# Total',
                data: [props.status.total, props.status.serviceable, props.status.poor, props.status.unusable],
                backgroundColor: [
                    'rgba(255, 99, 132, 0.2)',
                    'rgba(54, 162, 235, 0.2)',
                    'rgba(255, 206, 86, 0.2)',
                    'rgba(75, 192, 192, 0.2)',
                    'rgba(153, 102, 255, 0.2)',
                    'rgba(255, 159, 64, 0.2)'
                ],
                borderColor: [
                    'rgba(255, 99, 132, 1)',
                    'rgba(54, 162, 235, 1)',
                    'rgba(255, 206, 86, 1)',
                    'rgba(75, 192, 192, 1)',
                    'rgba(153, 102, 255, 1)',
                    'rgba(255, 159, 64, 1)'
                ],
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });


})
</script>
    
<script>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';


export default { layout: AuthenticatedLayout }
</script>
