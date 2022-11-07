<template>
    <head title="Recieved Transactions"/>
    <div class="">


        <div class="flex flex-col overflow-x-auto relative shadow-md sm:rounded-lg">
            <div class="flex justify-between items-center py-4 bg-white dark:bg-gray-800">
                
                <div class="relative ml-3">
                    
                    <span class="font-semibold p-3 antialiased">Recieved Transactions</span>
                </div>
                
            </div>
            <hr/>
            <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400 ">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                    <tr>

                        <th scope="col" class="py-3 px-6 text-center" v-for="head in tableHeader">
                            {{head.name}}
                        </th>

                    </tr>
                </thead>
                <tbody>


                    <tr v-for="borrow in borrows"
                        class="overflow-y-auto bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600 text-center">

                        <td scope="row" class="items-center py-4  text-gray-900 whitespace-nowrap dark:text-white">

                            <div class="text-base font-semibold ">{{ borrow.municipality_name }}</div>


                        </td>
                        <td scope="row" class="items-center  text-gray-900 whitespace-nowrap dark:text-white ">

                            <div class="text-base font-semibold">{{ borrow.equipment_name }}</div>

                        </td>


                        <td scope="row" class="items-center  text-gray-900 whitespace-nowrap dark:text-white">

                            <div class="text-base font-semibold ">{{ borrow.returned ? 'Yes' : 'No' }}</div>

                        </td>
                        <td scope="row" class="items-center  text-gray-900 whitespace-nowrap dark:text-white ">

                            <div class="text-base font-semibold">{{ borrow.quantity }}</div>

                        </td>



                    </tr>

                </tbody>
            </table>

            <div class="bg-white ">
               
            </div>

        </div>
    </div>
</template>


<script>
import AuthenticatedLayout from '@/Layouts/MunicipalityLayout.vue'
import { Head } from '@inertiajs/inertia-vue3';
export default {
    layout: AuthenticatedLayout,
    props: {
        borrows: Array,
    },
    setup() {
        const tableHeader = [
            { name: 'Municipality Name' },
            { name: 'Equipment name' },
            { name: 'Returned' },
            { name: 'Quantity' },
        ]

        return {
            tableHeader,
        }
    }
}
</script>

<style lang="scss" scoped>

</style>