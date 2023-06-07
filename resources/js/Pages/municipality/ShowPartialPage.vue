<template>
    <Content-box>
        <div class="flex flex-row w-fit text-xl px-2 rounded border-2 border-gray-400">

            <div @click="back" class="flex flex-row">
                <button>
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="w-6 h-6 text-gray-700 ">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M19.5 12h-15m0 0l6.75 6.75M4.5 12l6.75-6.75" />
                    </svg>


                </button>
                <span class="cursor-pointer text-gray-700 ">back</span>
            </div>
        </div>

        <div class="flex flex-row justify-between  m-4 z-10">
            <span class="text-lg font-bold">

                {{ incident }}
            </span>


        </div>

        <table class="table-auto pt-2 w-full text-sm border-x border-orange-200 text-gray-500 dark:text-gray-400 z-0">
            <thead
                class="text-xs text-gray-700 text-center uppercase bg-orange-300 dark:bg-gray-700 dark:text-gray-400">
                <tr>
                    <th scope="col" class="py-3 px-10 capitalize" v-for="(head, key) in tableHeader" :key="key">
                        {{ head.name }}
                    </th>

                </tr>
            </thead>
            <tbody>
                <tr class="max-h-full even:bg-orange-200   bg-white border-b dark:bg-gray-800 dark:border-gray-700"
                    v-for="(body, key) in equipments">
                    <td scope="row" class="text-center p-4">
                        {{ body.name }}
                    </td>
                    <td class="text-center">
                        {{ body.municipality }}
                    </td>
                    <td class="text-center">
                        {{ body.quantity }}
                    </td>
                    <td class="text-center">
                        {{ body.acquired }}
                    </td>
                    
                    <td class="text-center ">
                        {{ moment(body.created_at).format('LT') }}
                    </td>
                    <td class="text-center " v-if="body.status == 'pending'">
                        <div class="flex flex-row justify-center">

                            <Quantity-modal :muni="body" @submit="accept">
                                <template #trigger>
                                    <button
                                        class=" text-sm  hover:bg-green-600 mx-2 text-center bg-green-500 px-2 rounded text-white tracking-wide">
                                        Accept
                                    </button>
                                </template>
                            </Quantity-modal>
                            <PersonalModal :equipment_borrow="body.id" name="Decline" @submit="deny(id, reason)" />
                        </div>



                        <!-- <button @click="deny(body.eb_id)"
                                    class="text-sm  hover:bg-red-600 mx-2 text-center bg-red-500 px-2 rounded text-white tracking-wide">
                                    Decline
                                </button> -->
                    </td>
                    <td class="text-center" v-else>
                        <div class="flex flex-row justify-center space-x-3">
                            <person-info-modal :body="body" />
                            <UnifinishModal v-if="body.status === 'accepted'" :body="body" />
                        </div>

                    </td>


                </tr>

            </tbody>
        </table>
    </Content-box>
</template>

<script>
import MunicipalityLayout from '@/Layouts/MunicipalityLayout.vue';
import Table from '@/Components/Table.vue';
import ContentBox from '@/Components/ContentBox.vue'
import newIncident from '@/Components/newIncident.vue'
import AddIncident from '@/Components/AddIncident.vue';
import QuantityModal from '@/Components/QuantityModal.vue';
import { Inertia } from '@inertiajs/inertia';
import UnifinishModal from '@/Components/UnfinishModal.vue'
import moment from 'moment';
import PersonInfoModal from '@/Components/PersonInfoModal.vue'
import PersonalModal from '@/Components/PersonalModal.vue';
import { emitter } from '@/Composables/useEventBus'
export default {
    layout: MunicipalityLayout,
    components: {
        ContentBox,
        Table,
        newIncident,
        AddIncident,
        UnifinishModal,
        PersonInfoModal,
        PersonalModal,
        QuantityModal,

    },
    props: {
        equipments: Object,
        incident: String,
        equipments_drowpdown: Object,
        provinces: Object,
        summary: String,
        detail_id: String
    },
    setup() {
        const back = () => {
            window.history.back();
        }
        const getQuantity = (quantity, request) => {
            axios.post('/api/confirm-quantity', {
                quantity: quantity.value,
                transaction: request
            }).then((res) => { })
            Inertia.reload()
            // console.log(quantity, request);
        }
        const pop = (reason) => {
            alert(reason)
        }
        const tableHeader = [
            { name: 'equipment' },
            { name: 'municipality' },
            { name: 'requested quantity' },
            { name: 'borrowed quantity' },
            { name: 'time' },
            { name: 'action' },

        ]
        const accept = (quantity, id) => {
            console.log(id);

            axios.post('/api/accepted/' + id.id, {
                quantity: quantity.value
            }).then((res) => {
                Inertia.reload()
                emitter.emit('accepted')
            })
            // Inertia.get('/api/accepted/' + id.eb_id, { method: 'post' }, {
            //     onFinish: (e) => {
            //         notification()
            //         Inertia.reload({ only: ['notifications'] })
            //     }
            // })
            // form.quantity = transaction.quantity,
            //     form.equipment = transaction.equipment,
            //     form.borrower = transaction.borrower,
            //     form.borrower_id = transaction.borrower_id,
            //     form.detail_id = transaction.detail_id,
            //     form.personel = person,
            //     form.incident = transaction.reason
            // form.post('/api/accepted', {
            //     onFinish: () => {

            //         notification()
            //         Inertia.reload({ only: ['notifications'] })
            //     }
            // })
            // emitter.emit('badge')

        }

        const deny = async (id, reason) => {
            console.log('inside');
            emitter.emit('deny')
            // console.log(id, reason);
            // Inertia.post('/api/deny/' + id, { reason: reason }, {
            //     onFinish: (e) => {
            //         notification()
            //         Inertia.reload({ only: ['notifications'] })
            //     }
            // })
            // form.quantity = transaction.quantity,
            //     form.equipment = transaction.equipment,
            //     form.borrower = transaction.borrower,
            //     form.borrower_id = transaction.borrower_id,
            //     form.detail_id = transaction.detail_id,
            //     form.personel = person,
            //     form.incident = transaction.reason
            // form.post('/api/deny', {
            //     onFinish: () => {
            //         Inertia.reload({ only: ['notifications'] })
            //     }
            // })
        }

        return {
            tableHeader,
            getQuantity,
            pop,
            back,
            moment,
            accept,
            deny
        }
    }
}
</script>

<style lang="scss" scoped>

</style>