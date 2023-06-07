<template>

    <!-- <ContentBox>
        <Local-transactions :equipments="equipments" :provinces="provinces" />
    </ContentBox> -->
    <Head title="My Request"/>

    <content-box>
        <div class="flex flex-col space-y-8 bg-white p-2 ">
            <div class="flex flex-row justify-between">
                <new-incident :equipments="equipments" :provinces="provinces">
                    <template #trigger>
                        <button class="text-lg text-white font-semibold bg-orange-300 rounded w-fit px-4 py-1">
                            <span class="mr-2">New</span>
                            <i class="fa-solid fa-plus"></i>
                        </button>

                    </template>
                </new-incident>

                <div class="grid grid-cols-3 w-2/3 gap-2">
                    <Datepicker v-model="date" class="w-full h-8 rounded" placeholder="Input Date Here" />

                    <div class="col-span-2">
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
                                enter-from-class="transform opacity-0 scale-95"
                                enter-to-class="transform opacity-100 scale-100"
                                leave-active-class="transition ease-in duration-75"
                                leave-from-class="transform opacity-100 scale-100"
                                leave-to-class="transform opacity-0 scale-95">
                                <div v-show="drop" class="absolute z-40 mt-10 rounded-md shadow-lg"
                                    style="display: none;" @click="drop = false">
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
                                    placeholder="Search..." required>
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

            </div>
            <!-- <v-select id="mySelect" :options="convertedIncident" v-model="filter" class=" w-2/6 h-8 border-hidden cursor-pointer" placeholder="Incident" /> -->
            <div class="flex flex-row justify-end">
                <inertia-link href="/municipality/request" class="border-2 border-gray-400 px-2 rounded">Reset
                    Filters</inertia-link>
                <!-- <InvoiceModal /> -->
            </div>
            <table class="table-auto  w-full text-sm border-x border-b border-orange-200
              text-gray-500 dark:text-orange-400">
                <thead
                    class="text-xs text-gray-700 text-center uppercase bg-orange-300 dark:bg-gray-700 dark:text-gray-400">
                    <tr>
                        <th scope="col" class="py-3 px-6" v-for="(head, key) in tableHeader" :key="key">
                            {{ head.name }}
                        </th>

                    </tr>
                </thead>
                <tbody>
                    <tr v-if="histories"
                        class="max-h-full even:bg-orange-200 text-orange-600 even:text-slate-600 bg-white border-b dark:bg-gray-800 dark:border-gray-700"
                        v-for="(body, key) in histories.data" :key="key">
                        <td scope="row" class="p-4 text-center">
                            {{ body.incident_id }}
                        </td>
                        <td scope="row" class="p-4 text-center">
                            {{ body.incident }}
                        </td>
                        <td scope="row" class="text-center">
                            {{ body.acquired }}
                        </td>
                        <td class="text-center">
                            {{ body.authorize_quantity }}
                        </td>
                        <td class="text-center">
                            {{ moment(body.created_at).format('llll') }}
                        </td>
                        <td class="text-center " v-if="body.file_path">
                            <a :href="('/report/' + body.id)" type="button" target="_blank"
                                class="mr-4 font-medium text-green-600 dark:text-orange-500 hover:underline">
                                <!-- <EditModal :form="body" /> -->
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" />
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>




                            </a>
                            <inertia-link :href="('/report/' + body.id)" method="delete"  type="button" class=" font-medium text-red-600  dark:text-orange-500 hover:underline">
                                <!-- <EditModal :form="body" /> -->
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
                                </svg>


                            </inertia-link>



                        </td>
                        <td class="text-center " v-else>
                            <div class="flex justify-center ">
                                <File-upload-modal :detail_id="body.id"/>
                            </div>
                        
                        </td>
                        <td class="text-center">

                            <div class="flex justify-center">
                                <inertia-link :class="body.acquired ? 'text-green-400' : 'text-blue-400'"
                                    class="  underline" :href="('/municipality/request/' + body.id)"
                                    :data="{ incident: body.incident, summary: body.incident_summary }" method="get">
                                    <i class="fa-regular fa-folder-open w-5 h-5"></i>

                                </inertia-link>
                            </div>


                            <!-- <DetailModal :incident="body.incident" :detail="body.id" :equipments="equipments" name="New" :provinces="provinces" /> -->
                        </td>


                    </tr>

                </tbody>
            </table>
            <div class="bg-white ">
                <Pagination :links="histories.links" />


            </div>
        </div>
    </content-box>

</template>

<script>
import { ref, onMounted } from 'vue';
import ContentBox from '../../Components/ContentBox.vue'
import MunicipalityLayout from '@/Layouts/MunicipalityLayout.vue';
import EquipmentList from '../../Components/Lists/EquipmentList.vue';
import { Inertia, Head } from '@inertiajs/inertia'
import { usePage } from '@inertiajs/inertia-vue3';
import LocalTransactions from '@/Components/LocalTransactions.vue';
import newIncident from '@/Components/newIncident.vue'
import TransactionModal from '@/Components/TransactionModal.vue';
import useChannel from '@/Composables/useChannel';
import StatusCard from '@/Components/Transactions/StatusCard.vue';
import DetailModal from '@/Components/DetailModal.vue';
import Pagination from '@/Components/Pagination.vue'
import moment from 'moment';
import InvoiceModal from '@/Components/InvoiceModal.vue';
import FileUploadModal from '@/Components/FileUploadModal.vue'

export default {
    props: {
        histories: Object,
        equipments: Object,
        provinces: Object,
        queryString: [Array, Object]
    },
    components: {
        ContentBox,
        Head,
        EquipmentList,
        LocalTransactions,
        newIncident,
        TransactionModal,
        StatusCard,
        DetailModal,
        moment,
        Pagination,
        InvoiceModal,
        FileUploadModal,

    },
    layout: MunicipalityLayout,
    setup({ histories, queryString }) {


        const isEditable = ref(false)
        const date = ref()
        const filter = ref('Filter')
        const incidents = ref('')
        const { pendings, confirmed, denied } = useChannel()
        const incident = ref('')
        const drop = ref(false)
        const searchInput = ref()
        if (queryString?.name) {
            filter.value = 'name'
            searchInput.value = queryString.name
        }
        if (queryString?.id) {
            filter.value = 'id'
            searchInput.value = queryString.id
        }
        const tableHeader = [
            { name: "SUBJECT ID" },
            { name: "SUBJECT" },
            { name: "ACQUIRED" },
            { name: "REQUEST" },
            { name: "DATE" },
            { name: "SIT. REP." },
            { name: "ACTION" },


        ]
        const tabs = [
            { name: 'Incidents', nagivated: false },
            { name: 'Cart', nagivated: false },
            { name: 'Approved', nagivated: false },

        ]
        const getIncident = (incident) => {
            incidents.value = incident
        }
        // const getHistories = () => {
        //     if (histories) {
        //         //  for(const history in histories){
        //         //     console.log(history);
        //         //  }
        //         Object.keys(histories).forEach((history, key) => {
        //             incidents.value.push({
        //                 incident: history
        //             })
        //         })
        //         console.log(incidents.value);
        //     }
        // }

        const getStatuses = (incident, status) => {
            console.log(incident);
            incident.value = incident
            pendings.value = status

        }

        // watch(date, value => {
        //     Inertia.get(usePage().url.value, { date: value }, {
        //         preserveState: true
        //     })
        // })
        // watch(filter, value => {
        //     Inertia.get(usePage().url.value, { filter: value }, {
        //         preserveState: true
        //     })
        // })


        const handleSubmit = async (form) => {
            form.incidents = incident
            console.log(form.incidents);
            form.post('/api/request', {
                // preserveState: true,
                preserveScroll: true,
                onFinish: () => {
                    incidents.value = ''
                    incident.value = ''
                    // Inertia.reload() 
                    // getHistories()
                },

            })
        }
        const convertedIncident = Object.values(histories.data).map((c) => c.incident)


        const newIncident = () => {
            incidents.value.push({
                incident: ''
            })

        }
        const search = () => {
            if (date) {
                Inertia.get(usePage().url.value, { date: date.value }, {
                    preserveState: true
                })
            }
            if (filter.value === 'name') {
                // console.log(searchInput.value);
                if (usePage().url.value.includes('id')) {
                    Inertia.get('/municipality/request', { name: searchInput.value, date: date.value  }, {
                        preserveState: true
                    })
                }else{
                    Inertia.get('/municipality/request', { name: searchInput.value, date: date.value  }, {
                    preserveState: true
                })
                }
               
            }
            if (filter.value === 'ID' && date) {
                // console.log(searchInput.value);
                if (usePage().url.value.includes('name')) {
                    Inertia.get('/municipality/request', { id: searchInput.value, date: date.value }, {
                        preserveState: true
                    })
                }else{
                    Inertia.get('/municipality/request', { id: searchInput.value, date: date.value }, {
                    preserveState: true
                })
                }
                
            }
        }
        onMounted(() => {
            confirmed()
            denied()

        })
        return {
            searchInput,
            convertedIncident,
            tabs,
            search,
            tableHeader,
            incident,
            isEditable,
            handleSubmit,
            incidents,
            newIncident,
            getIncident,
            getStatuses,
            pendings,
            moment,
            date, drop,
            filter,
        }
    },

}
</script>

<style  scoped>
#mySelect .v-select .dropdown-toggle {
    border: none;
}
</style>