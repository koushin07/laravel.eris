<template>
    <table class="table-auto  w-full text-sm  text-gray-500 dark:text-gray-400 border-2 border-orange-200">
        <thead class="text-xs text-gray-700 text-center uppercase bg-orange-200 dark:bg-gray-700 dark:text-gray-400">
            <tr>
                <th scope="col" class="py-3 px-6" v-for="(head, key) in tableHeader" :key="key">
                    {{ head.name }}
                </th>

            </tr>
        </thead>
        <tbody >
            <tr class="max-h-full  bg-white border-b dark:bg-gray-800 dark:border-gray-700" v-for="(body, key) in tableBody">
                <td scope="row" class="py-4 px-6 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                    {{ body.equipment_name }}
                </td>
                <td class="text-center">
                    {{ body.unit }}
                </td>
                <td class="text-center">
                    {{ body.model_number }}
                </td>
                <td class="text-center">
                    {{ body.serial_number }}
                </td>
                <td class="text-center">
                    {{ body.unit }}
                </td>
                <td class="text-center">
                    {{ body.code }}
                </td>
                <td class="text-center">
                    {{ body.asset_id }}
                </td>
                <td class="text-center">
                    <button href="javascript:void(0)" type="button"
                        class="font-medium text-blue-600 dark:text-blue-500 hover:underline">
                        <EditModal :form="body" />

                    </button>
                    /
                    <a type="button"
                        class="cursor-pointer font-medium text-blue-600 dark:text-blue-500 hover:underline">delete</a>

                </td>
            </tr>
            
        </tbody>
    </table>
    <!-- <div class="bg-white text-center">
        <Pagination :links="links" />


    </div> -->
</template>

<script setup>
import Dropdown from '@/Components/Dropdown.vue';
import { Inertia } from '@inertiajs/inertia';
import { usePage } from '@inertiajs/inertia-vue3';

import { ref, watch } from 'vue';

import Pagination from './Pagination.vue';
import EditModal from './Forms/EditModal.vue';


const props = defineProps({
    links: Array,
    tableHeader: Array,
    tableBody: Array,
    filters: Object
})



const sortBy = [
    { name: 'Serviceable' },
    { name: 'Poor' },
    { name: 'Unusable' }
]



const setStatus = (url, status) => {
    current.value = url
    Inertia.get(url, { status }, {
        preserveScroll: true
    })



}


</script>

<style lang="scss" scoped>

</style>
<!-- <div class="flex flex-col overflow-x-auto relative shadow-md sm:rounded-lg z-0">
    <div class="flex justify-between items-center py-4 bg-white dark:bg-gray-800">
        <label for="table-search" class="sr-only">Search</label>
        <div class="relative ml-3">
            <div class="flex absolute inset-y-0 left-0 items-center pl-3 pointer-events-none">
                <svg class="w-5 h-5 text-gray-500 dark:text-gray-400" aria-hidden="true" fill="currentColor"
                    viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd"
                        d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z"
                        clip-rule="evenodd"></path>
                </svg>
            </div>
            <input type="text" id="table-search-equipments" class=" block p-2 pl-10 w-80 text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 
             focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600
              dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                v-model="search" placeholder="Search for Equipment">
        </div>
        <div class="mr-3">

      
            <Dropdown>
                <template #trigger>
                    <button class="inline-flex items-center text-gray-500 bg-white border border-gray-300 focus:outline-none
                     hover:bg-gray-100 focus:ring-4 focus:ring-gray-200 font-medium rounded-lg text-sm px-3 py-1.5
                      dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:bg-gray-700 dark:hover:border-gray-600
                       dark:focus:ring-gray-700" type="button">

                        Sort By
                        <svg class="ml-2 w-3 h-3" aria-hidden="true" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M19 9l-7 7-7-7">
                            </path>
                        </svg>
                    </button>
                </template>
                <template #content>
                    <ul class="py-1 text-sm text-gray-700 dark:text-gray-200" v-for="status in sortBy">
                        <li>
                            <a @click="setStatus($page.url, status.name)"
                                class="block py-2 px-4 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white cursor-pointer">
                                {{ status.name }}</a>
                        </li>
                    </ul>

                </template>

            </Dropdown>



        </div>

    </div>
    <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400 ">
        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
            <tr>

                <th scope="col" class="py-3 px-6 text-center" v-for="head in tableHeader">
                    {{head.name}}
                </th>

            </tr>
        </thead>
        <tbody>


            <tr v-for="body in tableBody" v-if="tableBody.length>0"
                class="overflow-y-auto bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600 text-center">

                <td scope="row" class="items-center py-4  text-gray-900 whitespace-nowrap dark:text-white">

                    <div class="text-base font-semibold ">{{ body.equipment_name }}</div>

                </td>


                <td scope="row" class="items-center  text-gray-900 whitespace-nowrap dark:text-white">

                    <div class="text-base font-semibold ">{{ body.serviceable }}</div>

                </td>
                <td scope="row" class="items-center  text-gray-900 whitespace-nowrap dark:text-white">

                    <div class="text-base font-semibold ">{{ body.poor }}</div>

                </td>
                <td scope="row" class="items-center  text-gray-900 whitespace-nowrap dark:text-white">

                    <div class="text-base font-semibold ">{{ body.unusable }}</div>

                </td>
               
                <td class="py-4 px-6">
                    <button href="javascript:void(0)" type="button"
                        class="font-medium text-blue-600 dark:text-blue-500 hover:underline">
                        <EditModal :form="body" />

                    </button>
                    /
                    <a type="button"
                        class="cursor-pointer font-medium text-blue-600 dark:text-blue-500 hover:underline">delete</a>

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

    <div class="bg-white ">
        <Pagination :links="links" />
      

    </div>

</div> -->