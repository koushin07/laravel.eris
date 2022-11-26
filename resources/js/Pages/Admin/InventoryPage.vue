<template>

    <Head title="Tansaction" />
    <ContentBox>
        <div class="flex flex-col space-y-5">
            <div class="grid grid-cols-4 place-content-between">
                <span class=" text-base font-bold col-span-2 md:col-span-3">Consolidated Inventory</span>

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
            <div class="overflow-auto relative">
                <Table :tableHeader="tableHead" :tableBody="equipments.data" :links="equipments.links"
                    :filters="filters" />
                <div class="bg-white ">
                    <Pagination :links="equipments.links" />


                </div>
            </div>
        </div>
    </ContentBox>
</template>

<script>

import { ref, watch } from 'vue';
import { Inertia } from '@inertiajs/inertia';
import ContentBox from '@/Components/ContentBox.vue'
import Table from '@/Components/Table.vue';
import { usePage, Head } from '@inertiajs/inertia-vue3';
import Pagination from '@/Components/Pagination.vue';
import AdminLayout from '@/Layouts/AdminLayout.vue';
export default {
    layout: AdminLayout,
    components: {
        Pagination,
        Head,
        ContentBox,
        Table
    },
    props: {
        equipments: Object,
        name: Object,
        filters: [Array, Object]
    },
    setup(filters) {
        const current = ref(usePage().url.value)
        const search = ref(filters.search)
        const tableBody = ref({})

        const tableHead = [
            { name: "Equipment" },
            { name: "Category" },
            { name: "Model" },
            { name: "Serial" },
            { name: "Unit" },
            { name: "Code" },
            { name: "Asset ID" },
          
        ]



        watch(search, value => {

            Inertia.get(usePage().url.value, { search: value }, {
                preserveState: true
            })

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