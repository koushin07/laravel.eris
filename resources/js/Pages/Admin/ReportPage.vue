<template>
    <Content-box class="h-fit p-7 flex flex-col space-y-3">
        <div class="flex flex-row pt-2 space-x-10 justify-between pb-10">
            <div class="flex flex-row w-full space-x-10 ">
                <v-select v-model="province" class="w-1/5" :options="provinces" label="province" placeholder="Provinces" />
            <v-select v-model="municipality" class="w-1/5" :options="municipalities" label="municipality"
                placeholder="Municipality" />
            <Datepicker v-model="date" show-now-button class="w-1/5" :enable-time-picker="false"
                aria-placeholder="Date" />

            </div>
            
            <button class="bg-button px-2 text-white rounded justify-end" @click="search">
                Search
            </button>
        </div>

        <table
            class="table-auto  w-full text-sm border-x-2 border-b-2 border-orange-200 text-gray-500 dark:text-gray-400">
            <thead
                class="text-xs text-stone-900 text-center uppercase bg-orange-300 dark:bg-gray-700  dark:text-gray-400">
                <tr>
                    <th scope="col" class="py-2 px-6" v-for="(head, key) in tableHeader" :key="key">
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
                    v-for="(body, key) in incidents.data">
                    <td scope="row" class="text-center p-4">
                        {{ body.incident }}
                    </td>
                    <td scope="row" class="text-center p-4">
                        {{ body.filename }}
                    </td>
                    <td scope="row" class="text-center p-4">
                        {{ body.municipality }}
                    </td>

                    <td class="text-center">
                        {{ moment(body.submitted_at).format('MMMM DD Y') }}
                    </td>

                    <td class="text-center gap-">
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
                        <inertia-link method="delete" type="button" v-if="$page.props.auth.user.assign_office.municipality"
                            class=" font-medium text-red-600  dark:text-orange-500 hover:underline"
                            :href="('/province/incident/' + body.id)">
                            <!-- <EditModal :form="body" /> -->
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                stroke="currentColor" class="w-5 h-5">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
                            </svg>


                        </inertia-link>
                        <!-- <a  type="button" class="ml-4 font-medium text-red-600  dark:text-orange-500 hover:underline">
                          
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                stroke="currentColor" class="w-5 h-5">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
                            </svg>


                        </a> -->


                    </td>
                </tr>

            </tbody>
        </table>
    </Content-box>
</template>

<script>
import AdminLayout from '@/Layouts/AdminLayout.vue';
import ContentBox from '@/Components/ContentBox.vue';
import { usePage, Head } from '@inertiajs/inertia-vue3';
import { Inertia } from '@inertiajs/inertia';
import moment from 'moment';
import { ref, watch } from 'vue';
export default {
    layout: AdminLayout,
    components: {
        ContentBox
    },
    props: {
        incidents: Object,
        provinces: Object
    },
    setup() {

        const province = ref()
        const municipality = ref()
        const municipalities = ref()
        const date = ref()
        const search = () => {
            Inertia.get(usePage().url.value, { date: date.value, municipality: municipality.value['id']}, {
                preserveState: true
            })
        }

        watch(province, value => {
            axios.get('/api/municipalities/' + value.province).then((res) => municipalities.value = res.data)
        })

        const tableHeader = [
            { name: 'Incident' },
            { name: 'File Name' },
            { name: 'From' },
            { name: 'Date' },
            { name: 'Action' },
        ]


        return {
            search,
            province,
            municipality,
            date,
            municipalities,
            tableHeader,
            moment
        }
    }
}
</script>

<style lang="scss" scoped>

</style>