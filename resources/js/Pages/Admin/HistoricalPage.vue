<template>

    <Head title="History" />
    <div class="flex flex-col pt-6">
        <div class="my-1 w-44">
            <v-select :options=municipalities v-model="municipality" placeholder="Municipalities" 
                label="municipality"></v-select>
        </div>
        <table
            class="table-auto  w-full text-sm border-x-2 border-b-2 border-orange-200 text-gray-500 dark:text-gray-400">
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
                    v-for="(body, key) in histories.data">
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
                    <td class="text-center" v-if="body.filename">
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
                    <td class="text-center" v-else>
                        Nothing Found

                    </td>

                </tr>

            </tbody>
        </table>
        <div class="bg-white ">
            <Pagination :links="histories.links" />


        </div>
    </div>
</template>

<script>

import Layout from '@/Layouts/AdminLayout.vue'
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
        municipalities: Array,
        filters: [Array, Object]
    },
    setup({ filters, histories }) {
        const municipality = ref()
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
        const localHeader = [
            { name: 'Subject' },
            { name: 'From' },
            { name: 'To' },
            { name: 'Date' },
            { name: 'sit. rep.' },
        ]
        const loadMore = async () => {

            offset.value = offset.value + 10
        }
        watch(municipality, value => {
            Inertia.get(usePage().url.value, { municipality: value },{
                preserveState: true
            })
        })
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
            totalReturned,
            moment,
            search,
            loadMore,
            totalQuantity,
            update,
            localHeader,
            municipality,
        }
    }
}
</script>

<style scoped>
.history {
    box-shadow: rgba(50, 50, 93, 0.25) 0px 6px 12px -2px, rgba(0, 0, 0, 0.3) 0px 3px 7px -3px;
}
</style>