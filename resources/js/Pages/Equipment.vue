<template>
    <h4 class="text-right mb-2 font-bold text-lg">{{ name.municipality_name }}</h4>
    <Table :tableHeader="tableHeader" :tableBody="equipments.data" :links="equipments.links " :filters="filters" />
</template>

<script>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import Table from '@/Components/Table.vue';
export default {
    layout: AuthenticatedLayout,
    components: {
        Table,
    },
    props: {
        equipments: Object,
        name: Object,
        filters: [Array, Object]
    },
    setup() {
        const tableHeader = [
            { name: 'Equipment Name' },
            { name: 'Serviceable' },
            { name: 'Poor' },
            { name: 'Unusable' },
            { name: 'Actions' }
        ]

        return { tableHeader }
    }
}
</script>

<style lang="scss" scoped>

</style>