<template>
    <content-box>
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
            <add-incident :equipments="equipments_drowpdown" :detail="detail_id" :incident="incident"
                :incident_summary="summary" :provinces="provinces">
                <template #trigger>
                    <button class="bg-button px-2 py-1 rounded-md grid grid-flow-col panel-content-center gap-1">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                            stroke="currentColor" class="w-5 h-5 text-white">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                        </svg>

                        <span class="text-center text-white ">Add</span>

                    </button>

                </template>
            </add-incident>
        </div>

        <table  class="table-auto  w-full text-sm border-x border-b border-orange-200
              text-gray-500 dark:text-orange-400">
            <thead  class="text-xs text-gray-700 text-center uppercase bg-orange-300 dark:bg-gray-700 dark:text-gray-400">
                <tr>
                    <th scope="col" class="py-3 px-10 capitalize" v-for="(head, key) in tableHeader" :key="key">
                        {{ head.name }}
                    </th>

                </tr>
            </thead>
            <tbody>
                <tr  class="max-h-full even:bg-orange-200 text-orange-600 even:text-slate-600 bg-white border-b dark:bg-gray-800 dark:border-gray-700"
                    v-for="(body, key) in equipments.data">
                    <td scope="row" class="text-center p-4">
                        {{ body.name }}
                    </td>
                    <td class="text-center">
                        {{ body.municipality }}
                    </td>
                    <td class="text-center ">
                        <span class="text-green-500 " v-if="body.status === 'accepted'">
                            {{ body.status }}
                        </span>
                        <button @click="pop(body.reason)" class=" text-red-500 underline"
                            v-if="body.status === 'declined'">
                            Declined

                        </button>
                        <span class="text-gray-500 " v-if="body.status === 'pending'">
                            {{ body.status }}
                        </span>
                        <span class="text-green-600 " v-if="body.status === 'return'">
                            {{ body.status }}ed
                        </span>

                    </td>
                    <td class="text-center">
                        {{ body.acquired ? body.acquired : 0 }}
                    </td>
                    <td class="text-center">
                        {{ body.authorize_quantity }}
                    </td>
                    <!-- <td class="text-center">
                                {{ body.incident }}
                            </td> -->
                  
                    
                    <!-- <td class="text-center">
            {{ moment(body.created_at).format('ddd, hA') }}
        </td> -->
                    <td class="text-center">
                       
                        <div class="flex flex-row justify-center">
                            <person-info-modal :body="body" />
                            
                            
                        </div>
                        <Quantity-modal :muni="body" v-if="(body.status === 'accepted' && body.acquired === 0)"
                                @submit="getQuantity">
                                <template #trigger>
                                    <button class=" bg-orange-600 px-2 text-white font-semibold rounded">
                                       Proceed
                                    </button>
                                </template>
                            </Quantity-modal>

                    </td>


                </tr>

            </tbody>
        </table>

    </content-box>

</template>

<script>
import MunicipalityLayout from '@/Layouts/MunicipalityLayout.vue';
import Table from '@/Components/Table.vue';
import ContentBox from '@/Components/ContentBox.vue'
import newIncident from '@/Components/newIncident.vue'
import AddIncident from '@/Components/AddIncident.vue';
import QuantityModal from '@/Components/QuantityModal.vue';
import { Inertia } from '@inertiajs/inertia';
import PersonInfoModal from '@/Components/PersonInfoModal.vue';
import moment from 'moment'
import { emitter } from '@/Composables/useEventBus'

export default {
    layout: MunicipalityLayout,
    components: {
        PersonInfoModal,
        ContentBox,
        Table,
        newIncident,
        AddIncident,
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
        const fullname = (fname, lname, mname, suf) => {
            const f = fname ? fname : ''
            const l = lname ? lname : ''
            const m = mname ? mname.charAt(0) : ''
            const s = suf ? suf : ''

            return `${l} ${m} ${f} ${s}`;
        }
        const back = () => {
            window.history.back();
        }
        const getQuantity = (quantity, request) => {
            axios.post('/api/confirm-quantity', {
                quantity: quantity.value,
                transaction: request
            }).then((res) => {
                Inertia.reload()
                emitter.emit('reconfirm')
            })
            Inertia.reload()
            // console.log(quantity, request);
        }
        const pop = (reason) => {
            alert(reason)
        }
        const tableHeader = [
            { name: 'equipment' },
            { name: 'municipality' },
            { name: 'status' },
            { name: 'borrowed Qty' },
            { name: 'approved Qty'  },
            // { name: 'time' },
            { name: 'action' },

        ]

        return {
            tableHeader,
            getQuantity,
            pop,
            back,
            moment,
            fullname,
        }
    }
}
</script>

<style lang="scss" scoped>

</style>