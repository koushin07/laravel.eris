<template>

    <Head title="Equipments" />
    <div class="flex justify-between">
        <button @click="ownEquipment($page.props.auth.user.id )"
            class=" px-4 bg-white border-transparent mb-2 border-4 rounded-lg content-end">My Inventory</button>
        <button type="button" class="font-medium mb-2 px-4 py-2 border-2 border-transparent bg-white rounded-lg">
            <CreateModal />
        </button>

    </div>

    <Table :tableHeader="tableHeader" :tableBody="equipments.data" :links="equipments.links " :filters="filters" />
</template>

<script>
import AuthenticatedLayout from '@/Layouts/MunicipalityLayout.vue';
import Table from '@/Components/Table.vue';
import { Head } from '@inertiajs/inertia-vue3';
import { usePage } from '@inertiajs/inertia-vue3';
import { Inertia } from '@inertiajs/inertia';
import CreateModal from '../Components/Forms/CreateModal.vue';


export default {
    layout: AuthenticatedLayout,
    components: {
        Head,
        Table,
        CreateModal
    },
    props: {
        equipments: Object,
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

        const ownEquipment = (id) => {
            Inertia.get(usePage().url.value, { owner: id }, {

                preserveState: true
            })
            console.log(id)
        }

        return {
            tableHeader,
            ownEquipment
        }
    }
}
</script>

<style lang="scss" scoped>

</style>