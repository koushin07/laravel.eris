<template>
    <div>

    </div>
</template>

<script>
import Chart from 'chart.js/auto';
export default {
    
    setup () {
        const myChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: ['Total', 'Serviceable', 'Poor', 'Unusable'],
            datasets: [{
                label: '# Total',
                data: [props.status.total, props.status.serviceable, props.status.poor, props.status.unserviceable],
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

        return {}
    }
}
</script>

<style lang="scss" scoped>

</style>