<template>
    <Content-box>
        <Incident-report :reports="reports"/>
    </Content-box>
</template>

<script>
import { Head } from '@inertiajs/inertia-vue3';
import ContentBox from '@/Components/ContentBox.vue';
import MunicipalityLayout from '@/Layouts/MunicipalityLayout.vue'
import IncidentReport from '@/Components/Transactions/IncidentReport.vue';
export default {
    layout: MunicipalityLayout,
    components:{
        Head,
        ContentBox,
        IncidentReport
    },
    props:{
        reports: Object,
    },
    setup () {
        

        return {}
    }
}
</script>

<style lang="scss" scoped>

</style>