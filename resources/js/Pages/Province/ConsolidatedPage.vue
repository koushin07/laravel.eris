<template>

    <ContentBox>
        <div class="flex flex-col space-y-5">
            <div class="grid grid-cols-4 place-content-between">



                <span class=" text-base font-bold col-span-2 md:col-span-3">My Inventory</span>

                <div class="relative col-span-2 md:col-span-1   ">
                    <input type="search" id="search-dropdown" class="block h-8 w-full z-20 text-sm border-2 bg-transparent rounded-lg focus:outline-none focus:ring-0  py-2 px-1
                                " required vModel="search" placeholder="search...">
                    <button type="submit"
                        class="absolute flex text-center h-8 top-0 right-0 p-2 text-sm font-medium text-white bg-blue-700 
                                rounded-r-lg border-2 border-blue-700 hover:bg-blue-800 focus:ring-2 focus:outline-none
                                 focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800"><svg
                            aria-hidden="true" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                            xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg></button>
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
import ProvinceLayout from '@/Layouts/Province/ProvinceLayout.vue';
import { usePage } from '@inertiajs/inertia-vue3';
import Pagination from '@/Components/Pagination.vue';

export default {
    layout: ProvinceLayout,
    components: {
        Pagination,
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
            { name: "More" }
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