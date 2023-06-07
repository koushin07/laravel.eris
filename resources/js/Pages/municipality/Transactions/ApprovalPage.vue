<template>

    <Head title="Tansaction" />
    <Content-box>
        <div class="flex flex-col col-span-2  overflow-hidden h-full ">
            <span class="text-lg font-semibold font-sans text-center" v-if="notifications.length === 0">No Equipment
                Request Recieve</span>
            <span class="text-lg font-semibold font-sans text-center" v-else>Requests</span>
            <div class=" flex flex-col justify-between overflow-y-auto border-x border-b border-orange-200     space-y-2 scrollbar">

                <table class="table-auto  w-full text-sm border-x text-gray-500 dark:text-gray-400">
                    <thead
                        class="text-xs text-gray-700 text-center uppercase bg-orange-300 dark:bg-gray-700 dark:text-gray-400">
                        <tr>
                            <th scope="col" class="py-3 px-6" v-for="(head, key) in tableHeader" :key="key">
                                {{ head.name }}



                            </th>

                        </tr>
                    </thead>
                    <tbody>
                        <tr class="max-h-full even:bg-orange-200  bg-white border-b dark:bg-gray-800 dark:border-gray-700"
                            v-for="(body, key) in notifications">
                            <td scope="row" class="text-center p-2">
                                {{ body.incident }}
                            </td>
                            <td scope="row" class="text-center p-2">
                                {{ body.equipment }}
                            </td>
                            <td class="text-center p-2">
                                {{ body.municipality }}
                            </td>
                            <td class="text-center p-2">
                                {{ body.quantity }}
                            </td>
                            <td class="text-center p-2">
                                {{ fullname(body.borrower_firstname, body.borrower_lastname, body.borrower_middlename, body.borrower_suffix) }}
                            </td>
                            <td class="text-center p-2">
                                {{ body.contact }}
                            </td>
                            <td class="text-center p-2">
                                {{ body.address }}
                            </td>

                            <td class="text-center ">
                                <div class="flex flex-row justify-center">

                                    <Quantity-modal :muni="body" @submit="accept">
                                        <template #trigger>
                                            <button
                                                class=" text-sm  hover:bg-green-600 mx-2 text-center bg-green-500 px-2 rounded text-white tracking-wide">
                                                Accept
                                            </button>
                                        </template>
                                    </Quantity-modal>
                                    <PersonalModal :equipment_borrow="body.eb_id" name="Decline"
                                        @submit="deny(id, reason)" />
                                </div>



                                <!-- <button @click="deny(body.eb_id)"
                                    class="text-sm  hover:bg-red-600 mx-2 text-center bg-red-500 px-2 rounded text-white tracking-wide">
                                    Decline
                                </button> -->
                            </td>
                        </tr>

                    </tbody>
                </table>


            </div>


        </div>



    </Content-box>
</template>

<script>
import { Head, useForm } from '@inertiajs/inertia-vue3';
import MunicipalityLayout from '@/Layouts/MunicipalityLayout.vue'
import { Inertia } from '@inertiajs/inertia'
import axios from 'axios';
import ContentBox from '@/Components/ContentBox.vue';
import PersonalModal from '@/Components/PersonalModal.vue';
import useNotification from '@/Composables/useNotification';
import { emitter } from '@/Composables/useEventBus'
import QuantityModal from '@/Components/QuantityModal.vue'

export default {
    layout: MunicipalityLayout,
    components: {
        ContentBox,
        Head,
        PersonalModal,
        QuantityModal
    },
    props: {
        notifications: Array,
    },
    setup() {
        const form = useForm({
            quantity: 0,
            equipment: '',
            borrower: '',
            borrower_id: '',
            detail_id: '',
            personel: '',
            incident: ''
        });

        emitter.on('refresh-approvals', () => {
            Inertia.reload({ only: ['notifications'] })
        })
        const { notification, count } = useNotification()

        const tableHeader = [
            { name: 'incident' },
            { name: 'equipment' },
            { name: 'municipality' },
            { name: 'quantity' },
            { name: 'Personel' },
            { name: 'contact' },
            { name: 'address' },
            { name: 'action' }
        ]
        const fullname = (fname, lname, mname, suf) => {
            const f = fname ? fname :''
            const l = lname ? lname :''
            const m = mname ? mname.charAt(0) :''
            const s = suf ? suf :''

            return `${l} ${m} ${f} ${s}`;
        }
        const accept = (quantity, id) => {
            console.log(id);

            axios.post('/api/accepted/' + id.eb_id, {
                quantity: quantity.value
            }).then((res) => {
                notification()
                Inertia.reload({ only: ['notifications'] })
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
            emitter.emit('badge')

        }

        const deny = async (id, reason) => {
            console.log('inside');
            console.log(id, reason);
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
            fullname,
            notification,
            count,
            accept,
            deny,
            tableHeader


        }
    }
}
</script>

<style lang="scss" scoped>

</style>