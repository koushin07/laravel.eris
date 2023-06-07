<template>


    <div class="flex flex-col pt-6">
        <span class="text-xl font-bold p-2">Transactions</span>
        <div class="flex gap-2 justify-between mb-2">
            <Datepicker v-model="date" class="w-1/8 h-8 rounded" placeholder="Input Date Here" />

            <div class="w-2/4">
                <div class="flex ">
                    <label for="location-search"
                        class="mb-2 text-sm font-medium text-gray-900 sr-only dark:text-white">Your
                        Email</label>
                    <button @click="(drop = !drop)"
                        class="flex-shrink-0 z-10 inline-flex items-center py-2.5 px-4 text-sm font-medium text-center text-gray-500 bg-gray-100 border border-gray-300 rounded-l-lg hover:bg-gray-200 focus:ring-4 focus:outline-none focus:ring-gray-100 dark:bg-gray-700 dark:hover:bg-gray-600 dark:focus:ring-gray-700 dark:text-white dark:border-gray-600"
                        type="button">

                        {{ filter }} <svg aria-hidden="true" class="w-4 h-4 ml-1" fill="currentColor"
                            viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd"
                                d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                clip-rule="evenodd"></path>
                        </svg></button>
                    <transition enter-active-class="transition ease-out duration-200"
                        enter-from-class="transform opacity-0 scale-95" enter-to-class="transform opacity-100 scale-100"
                        leave-active-class="transition ease-in duration-75"
                        leave-from-class="transform opacity-100 scale-100"
                        leave-to-class="transform opacity-0 scale-95">
                        <div v-show="drop" class="absolute z-40 mt-10 rounded-md shadow-lg" style="display: none;"
                            @click="drop = false">
                            <div
                                class=" ring-1 ring-black ring-opacity-5 z-10  bg-white divide-y divide-gray-100 rounded shadow w-44 dark:bg-gray-700">
                                <ul class="py-1 text-sm text-gray-700 dark:text-gray-200"
                                    aria-labelledby="dropdown-button-2">
                                    <li>
                                        <button type="button" @click="filter = 'name'"
                                            class="inline-flex w-full px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:text-gray-400 dark:hover:bg-gray-600 dark:hover:text-white"
                                            role="menuitem">
                                            <div class="inline-flex items-center">

                                                Incident Name
                                            </div>
                                        </button>
                                    </li>
                                    <li>
                                        <button type="button" @click="filter = 'ID'"
                                            class="inline-flex w-full px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:text-gray-400 dark:hover:bg-gray-600 dark:hover:text-white"
                                            role="menuitem">
                                            <div class="inline-flex items-center">

                                                Incident ID
                                            </div>
                                        </button>
                                    </li>


                                </ul>
                            </div>
                        </div>
                    </transition>
                    <div class="relative w-full">
                        <input type="search" v-model="searchInput"
                            class="block p-2.5 w-full z-20 text-sm text-gray-900 bg-gray-50 rounded-r-lg border-l-gray-50 border-l-2 border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-l-gray-700  dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:border-blue-500"
                            placeholder="Search...." required>
                        <button @click="search"
                            class="absolute top-0 right-0 p-2.5 text-sm font-medium text-white bg-blue-700 rounded-r-lg border border-blue-700 hover:bg-blue-800  focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                            <svg aria-hidden="true" class="w-5 h-5" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                            <span class="sr-only">Search</span>
                        </button>
                    </div>
                </div>
            </div>

        </div>
        <table
            class="table-auto  w-full text-sm border-x-2 border-b-2 border-orange-200 text-gray-500 dark:text-gray-400">
            <thead
                class="text-xs text-stone-900 text-center uppercase bg-orange-300 dark:bg-gray-700  dark:text-gray-400">
                <tr>
                    <th scope="col" class="py-3 px-6" v-for="(head, key) in localHeader" :key="key">
                        <div class="flex flex-row justify-center py-1">
                            <span>
                                {{ head.name }}
                            </span>


                        </div>

                    </th>

                </tr>
            </thead>
            <tbody>
                <tr class="max-h-full even:bg-orange-200  bg-white border-b dark:bg-gray-800 dark:border-gray-700"
                    v-for="(body, key) in locals.data">
                    <td scope="row" class="text-center p-4">
                        {{ body.incident_id }}
                    </td>
                    <td scope="row" class="text-center p-4">
                        {{ body.incident }}
                    </td>


                    <td class="text-center">
                        {{ body.borrower }}
                    </td>
                    <td class="text-center">
                        {{ body.owner }}
                    </td>
                    <td class="text-center">
                        {{ body.name }}
                    </td>

                    <td class="text-center">
                        {{ moment(body.created_at).format('MMMM DD Y') }}
                    </td>
                    <td class="text-center">
                        <a :href="('/report/' + body.id)" type="button" target="_blank"
                            class="mr-4 font-medium text-green-600 dark:text-orange-500 hover:underline">
                            <!-- <EditModal :form="body" /> -->
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                stroke="currentColor" class="w-5 h-5">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" />
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                        </a>
                    </td>

                </tr>

            </tbody>
        </table>
        <div class="bg-white ">
            <Pagination :links="locals.links" />


        </div>
    </div>




    <!-- <div class="flex flex-col pt-6">
        <span class="text-xl font-bold p-2 ">Cross Transactions</span>
   


        <table
            class="table-auto  w-full text-sm border-x-2 border-b-2 border-orange-200 text-gray-500 dark:text-gray-400 ">
            <thead
                class="text-xs text-stone-900 text-center uppercase bg-orange-400 dark:bg-gray-700  dark:text-gray-400">
                <tr>
                    <th scope="col" class="py-3 px-6" v-for="(head, key) in localHeader" :key="key">
                        <div class="flex flex-row justify-center py-1">
                            <span>
                                {{ head.name }}
                            </span>


                        </div>

                    </th>

                </tr>
            </thead>
            <tbody>
                <tr class="max-h-full even:bg-orange-200  bg-white border-b dark:bg-gray-800 dark:border-gray-700"
                    v-for="(body, key) in regionals.data">
                    <td scope="row" class="text-center p-4">
                        {{ body.incident }}
                    </td>


                    <td class="text-center">
                        {{ body.borrower }}
                    </td>
                    <td class="text-center">
                        {{ body.owner }}
                    </td>

                    <td class="text-center">
                        {{ moment(body.created_at).format('MMMM DD Y') }}
                    </td>
                    <td class="text-center">
                        {{ body.filename }}
                    </td>

                </tr>

            </tbody>
        </table>
        <div class="bg-white ">
            <Pagination :links="regionals.links" />


        </div>
    </div> -->


</template>

<script>
import { ref, computed } from 'vue';
import TransactionChart from '@/Components/Charts/TransactionChart.vue';
import ContentBox from '@/Components/ContentBox.vue';
import ProvinceLayout from '@/Layouts/Province/ProvinceLayout.vue';
import { Inertia } from '@inertiajs/inertia';
import { usePage } from '@inertiajs/inertia-vue3';
import moment from 'moment'
import Pagination from '@/Components/Pagination.vue';
export default {
    layout: ProvinceLayout,
    components: { ContentBox, TransactionChart, Pagination },
    props: {
        locals: Object,
        regionals: Object,
        reports: Object,
    },
    setup({ locals }) {
        let query = ref('')

        const filter = ref('Filter')
        const drop = ref(false)
        const searchInput = ref()
        const date = ref()

        const search = () => {
            if (date) {
                Inertia.get(usePage().url.value, { date: date.value }, {
                    preserveState: true
                })
            }
            if (filter.value === 'name') {
                // console.log(searchInput.value);
                if (usePage().url.value.includes('id')) {
                    Inertia.get('/province/dashboard', { name: searchInput.value }, {
                        preserveState: true
                    })
                } else {
                    Inertia.get(usePage().url.value, { name: searchInput.value }, {
                        preserveState: true
                    })

                }
            }
            if (filter.value === 'ID') {
                // console.log(searchInput.value);
                if (usePage().url.value.includes('name')) {
                    Inertia.get('/province/dashboard', { id: searchInput.value, date: date.value }, {
                        preserveState: true
                    })
                } else {
                    Inertia.get(usePage().url.value, { id: searchInput.value, date: date.value }, {
                        preserveState: true
                    })
                }
            }
        }

        const localHeader = [
            { name: 'Subject ID' },
            { name: 'Subject' },
            { name: 'From' },
            { name: 'To' },
            { name: 'Equipment' },
            { name: 'Date' },
            { name: 'sit. rep.' },
        ]
        let filteredLocal = computed(() =>
            query.value === ''
                ? locals.data
                : locals.data.sort((a, b) =>

                    equipment.name
                        .toLowerCase()
                        .replace(/\s+/g, '')
                        .includes(query.value.toLowerCase().replace(/\s+/g, ''))
                ),

        )
        window.Echo.private(`child.transacton.${usePage().props.value.auth.user.id}`)
            .listen('.child.trans', (e) => {
                Inertia.reload({ only: ['locals'] })
            })

        return {
            searchInput,
            moment,
            date,
            localHeader,
            filter,
            query,
            filteredLocal,
            drop,
            search
        };
    },

}
</script>

<style lang="scss" scoped>

</style>