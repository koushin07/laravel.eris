<template>

    <Head title="History" />
    <div class=" box-border bg-white h-full p-4 md:col-span-3 overflow-y-auto scrollbar ">
        <div class="flex flex-col space-y-20 p-7 h-fit ">


            <div class="grid lg:grid-cols-3 sm:gap-10">
                <span class="text-3xl text-center font-bold">TRANSACTION HISTORY</span>
                <label for="default-search"
                    class="mb-2 text-sm font-medium text-gray-900 sr-only dark:text-white">Search</label>
                <div class="relative col-span-2">
                    <button class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none ">
                        <svg aria-hidden="true" class="w-5 h-5 text-gray-500 dark:text-gray-400" fill="none"
                            stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                    </button>
                    <input type="search" v-model="search"
                        class="block w-full p-2 pl-10 text-sm text-gray-900 border border-gray-300 rounded-full bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                        placeholder="Search Mockups, Logos..." required>

                    <!-- <button type="submit"
                class="text-white absolute right-2.5 bottom-2.5 bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-4 py-2 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Search</button> -->
                </div>
            </div>

            <!-- <div class="flex flex-col sm:flex-row ">
                <span class="text-4xl font-bold  sm:border-r-4  border-black py-2 pr-2">TOTAL

                </span>
                <div class="flex flex-col pl-2 justify-between">
                    <span class="text-xl font-semibold">Borrowed: {{ totalQuantity }}</span>
                    <span class="text-xl font-semibold">Returned: {{ totalReturned }}</span>
                </div>

            </div> -->
            <div class="flex flex-col cols-span-3 w-fit sm:w-full rounded pb-7 history"
                v-for="(data, date) in histories" :key="date">
                <div class="box-content  p-6 bg-slate-300"> <span class="text-lg font-semibold">{{ date }}</span>
                </div>
                <table class="table-auto">
                    <thead>
                        <tr>
                            <th scope="col" class="py-3 px-6 text-gray-500 uppercase text-md"
                                v-for="(header, key) in tableHeader" :key="key">
                                {{ header.name }}
                            </th>
                            <!-- <th scope="col" class="py-3 px-6 text-gray-500">
                                Equipment
                            </th>
                            <th scope="col" class="py-3 px-6 text-gray-500">
                                Quantity
                            </th>
                            <th scope="col" class="py-3 px-6 text-gray-500">
                                Returned
                            </th>
                            <th scope="col" class="py-3 px-6 text-gray-500">
                                Time
                            </th>
                            <th scope="col" class="py-3 px-6 text-gray-500">

                            </th> -->
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(datum, key) in data"
                            class="max-h-full text-sm  dark:bg-gray-800 dark:border-gray-700 border-b-2 last:border-b-transparent">
                            <td class="text-center py-2 font-bold">
                                {{ datum.incident }}
                            </td>
                            <td class="text-center py-2 text-gray-800">
                                {{ datum.borrower }}
                            </td>
                            <td class="text-center py-2 text-gray-800">
                                {{ datum.owner }}
                            </td>
                            <td class="text-center py-2 text-gray-800">
                                {{ datum.equipment }}
                            </td>
                            <td class="text-center py-2 text-gray-800">
                                <!-- {{ datum.quantity ? datum.quantity : 0 }} -->
                                {{ datum.quantity }}
                            </td>
                            <td class="text-center py-2 text-gray-800">
                                {{ datum.returned ? datum.returned : 0 }}
                            </td>
                            <td class="text-center py-2 text-gray-800">
                                <!-- {{ datum.quantity ? datum.quantity : 0 }} -->
                                {{ datum.damage ? datum.damage : 0 }}
                            </td>
                            <td class="text-center py-2 text-gray-800">
                                <!-- {{ moment(datum.created_at).format('hh:mm A') }} -->
                                <div class="flex justify-center">
                                    <button>
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                            stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z" />
                                        </svg>
                                    </button>


                                </div>


                            </td>
                            <td class="text-center py-2 text-gray-800">
                                <button>

                                    <Modal>
                                        <template #body>
                                            <button @click="update = !update"
                                                class="inline-flex justify-center rounded-md border border-transparent bg-blue-100 px-4 py-2 text-sm font-medium text-blue-900 hover:bg-blue-200 focus:outline-none focus-visible:ring-2 focus-visible:ring-blue-500 focus-visible:ring-offset-2">
                                                <div v-if="!update">
                                                    <i class="fa-solid fa-left-long"></i>
                                                </div>

                                                <span v-else>update</span>
                                            </button>
                                            <div class="flex flex-col space-y-7 py-5" v-if="update">
                                                <!-- titles -->
                                                <div class="grid grid-cols-2 place-content-center">
                                                    <span class="text-2xl font-bold text-center">Attribute</span>
                                                    <span class="text-2xl font-bold text-center">Status</span>
                                                </div>
                                                <!-- end of titles -->
                                                <div class="grid grid-cols-2 place-content-center gap-1">
                                                    <div class="grid grid-flow-row  gap-6">
                                                        <span class="text-sm ">
                                                            <span class="font-bold">
                                                                Asset ID:
                                                            </span>
                                                            {{ datum.asset_id ? datum.asset_id : 'NaN' }}
                                                        </span>
                                                        <span class="text-sm font-normal">
                                                            <span class="font-bold">
                                                                Model Number:
                                                            </span> {{ datum.model_number ? datum.model_number : 'NaN'
                                                            }}
                                                        </span>
                                                        <span class="text-sm font-normal">
                                                            <span class="font-bold">
                                                                Serial Number:
                                                            </span> {{ datum.serial_number ? datum.serial_number : 'NaN'
                                                            }}
                                                        </span>
                                                        <span class="text-sm font-normal">
                                                            <span class="font-bold">
                                                                Category:
                                                            </span> {{ datum.category ? datum.category : 'NaN' }}
                                                        </span>
                                                        <span class="text-sm font-normal">
                                                            <span class="font-bold">
                                                                Code:
                                                            </span>:{{ datum.code ? datum.code : 'NaN' }}
                                                        </span>
                                                        <span class="text-sm font-normal">
                                                            <span class="font-bold">
                                                                Unit:
                                                            </span> {{ datum.unit ? datum.unit : 'NaN' }}
                                                        </span>
                                                    </div>

                                                    <div class="flex flex-col space-y-6 ">
                                                        <span class="text-sm font-normal text-center">
                                                            <span class="font-bold">
                                                                Serviceable:
                                                            </span> {{ datum.serviceable ? datum.serviceable : '0' }}
                                                        </span>
                                                        <span class="text-sm font-normal text-center">
                                                            <span class="font-bold">
                                                                Unusable:
                                                            </span> {{ datum.unserviceable ? datum.unserviceable : '0' }}
                                                        </span>
                                                        <span class="text-sm font-normal text-center">
                                                            <span class="font-bold">
                                                                Poor:
                                                            </span> {{ datum.poor ? datum.poor : '0' }}
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                            <Edit-history :form="datum" v-else />
                                        </template>
                                        <template #footer>
                                            <!-- <button @click="update = !update" 
                                                class="inline-flex justify-center rounded-md border border-transparent bg-blue-100 px-4 py-2 text-sm font-medium text-blue-900 hover:bg-blue-200 focus:outline-none focus-visible:ring-2 focus-visible:ring-blue-500 focus-visible:ring-offset-2">
                                               {{ update ? '':'update'}}
                                            </button> -->
                                        </template>

                                    </Modal>
                                </button>


                            </td>
                        </tr>


                    </tbody>
                </table>
            </div>
            <div class="grid grid-rows-1 place-content-center" v-if="histories.length !== 0">
                <button @click="loadMore" class="bg-orange-300 px-4 py-2 text-black rounded-2xl">
                    Load More
                </button>
            </div>

        </div>
    </div>
</template>

<script>

import Layout from '@/Layouts/MunicipalityLayout.vue'
import ContentBox from '@/Components/ContentBox.vue'
import Modal from '@/Components/Modal.vue';
import moment from 'moment'
import { ref, watch, computed } from 'vue';
import { Inertia } from '@inertiajs/inertia';
import { usePage, Head } from '@inertiajs/inertia-vue3';
import EditHistory from '@/Components/EditHistory.vue';

export default {
    layout: Layout,
    components: {
        Head,
        ContentBox,
        moment,
        Modal,
        EditHistory
    },
    props: {
        histories: Object,

        filters: [Array, Object]
    },
    setup({ filters, histories }) {

        const tableHeader = [
            { name: 'incident' },
            { name: 'borrower' },
            { name: 'borrowee' },
            { name: 'equipment' },
            { name: 'quantity' },
            { name: 'returned' },
            { name: 'damage' },
            { name: 'set. rep' },

        ]

        const update = ref(true)
        const totalReturned = computed(() => {
            let total = Object.values(histories).map((date) => {
                return date.reduce((prev, current) => prev + current.returned, 0)

            })
            return total.reduce((prev, current) => prev + current, 0)
        })
        const totalQuantity = computed(() => {
            let total = Object.values(histories).map((date) => {
                return date.reduce((prev, current) => prev + current.quantity, 0)

            })
            return total.reduce((prev, current) => prev + current, 0)
        })
        const search = ref(filters.search)
        const offset = ref(0);

        const loadMore = async () => {

            offset.value = offset.value + 10
        }
        watch(offset, value => {
            Inertia.get(usePage().url.value, { load: value }, {
                preserveState: true
            })

        })
        watch(search, value => {

            Inertia.get(usePage().url.value, { search: value }, {
                preserveState: true
            })

        })

        return {
            tableHeader,
            totalReturned,
            moment,
            search,
            loadMore,
            totalQuantity,
            update,
        }
    }
}
</script>

<style scoped>
.history {
    box-shadow: rgba(50, 50, 93, 0.25) 0px 6px 12px -2px, rgba(0, 0, 0, 0.3) 0px 3px 7px -3px;
}
</style>