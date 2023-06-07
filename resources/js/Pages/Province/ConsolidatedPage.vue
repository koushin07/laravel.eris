<template>

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
                <v-select :options="municipalities" label="municipality" v-model="municipality"></v-select>

            </div>
            <div class=" relative">
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
                                <inertia-link type="button" :href="'/province/consolidatedShow/' + body.id"
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

import { ref, watch } from 'vue';
import { Inertia } from '@inertiajs/inertia';
import ContentBox from '@/Components/ContentBox.vue'
import Table from '@/Components/Table.vue';
import ProvinceLayout from '@/Layouts/Province/ProvinceLayout.vue';
import { usePage } from '@inertiajs/inertia-vue3';
import Pagination from '@/Components/Pagination.vue';
import moment from 'moment';
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
        filters: [Array, Object],
        municipalities: Object
    },
    setup(filters) {
        const current = ref(usePage().url.value)
        const search = ref(filters.search)
        const tableBody = ref({})

        const tableHead = [
            { name: "equipment" },
            { name: "available" },
            { name: "damages" },
            { name: "municipality" },
            { name: "date Recieved" },
            { name: "action" }

        ]

const municipality = ref()

        watch(search, value => {

            Inertia.get(usePage().url.value, { search: value }, {
                preserveState: true
            })

        })
        watch(municipality, value => {

            Inertia.get(usePage().url.value, { municipality: value.municipality }, {
                preserveState: true
            })

        })


        return {
            tableHead,
            search,
            tableBody,
            moment,
            municipality,
        };
    },

}
</script>

<style lang="scss" scoped>

</style>