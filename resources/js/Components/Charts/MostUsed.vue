<template>
<canvas id="equipment"></canvas>
</template>

<script>
import { onMounted } from 'vue'
import Chart from 'chart.js/auto';
export default {
    setup () {
        onMounted(()=>{
            const ctx = document.getElementById('equipment')
            const equipment = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: ['Total', 'denied', 'confirmed'],
                    datasets: [{
                        label: '# Total',
                        data: [10, 2, 5],
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
        })
        


        return {}
    }
}
</script>

<style lang="scss" scoped>

</style>