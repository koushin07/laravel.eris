<template>

    <!-- <ContentBox>
        <Local-transactions :equipments="equipments" :provinces="provinces" />
    </ContentBox> -->
    <Content-box>

        <div class="flex flex-col space-y-10 justify-around p-2">

            <new-incident @request="getIncident" name="New">
                <template #body>

                </template>
            </new-incident>

            <div class="flex flex-row px-6 space-x-3">
                <div class="  flex flex-col  w-3/5">
                    <span class="text-lg font-semibold">incident</span>

                    <div class=" flex flex-col overflow-y-auto  rounded-lg    space-y-2 scrollbar">
                        <div v-if="incidents.length !== 0"
                            class="rounded-lg p-4  relative text-center flex justify-between pr-2 border-2  pb-2">



                            <div class="grid grid-cols-1">
                                <div class="flex flex-row">
                                    <input class="font-bold text-sm text-gray-700 text-start focus:outline-0"
                                        v-model="incidents" />

                                </div>


                            </div>

                            <button @click="getStatuses(incidents)"
                                class="text-sm text-center text-orange-500 px-2 rounded-lg tracking-wide">
                                <!-- <TransactionModal :equipments="equipments" :provinces="provinces"
                                        :incident="incident.incident" :histories="histories" /> -->
                                details
                            </button>


                        </div>

                        <div v-for="(key) in Object.keys(histories)"
                            class="rounded-lg p-4  relative text-center flex justify-between pr-2 border-2  pb-2">



                            <div class="grid grid-cols-1">
                                <div class="flex flex-row">
                                    <span class="font-bold text-sm text-gray-700 text-start focus:outline-0"> {{ key }}
                                    </span>

                                </div>


                            </div>

                            <button @click="getStatuses(key, histories[key])"
                                class="text-sm text-center text-orange-500 px-2 rounded-lg tracking-wide">
                                <!-- <TransactionModal :equipments="equipments" :provinces="provinces"
                                        :incident="incident.incident" :histories="histories" /> -->
                                details
                            </button>


                        </div>
                    </div>
                </div>
                <StatusCard v-if="selected" @submit="handleSubmit" :selected="selected" :statuses="pendings"
                    :equipments="equipments" :provinces="provinces" />
                <!-- <div class="flex flex-col  overflow-hidden  w-2/5">
                    <span class="text-lg font-semibold font-sans">Status</span>
                    <div
                        class="flex flex-col justify-between overflow-y-auto border-2 rounded-lg p-4 space-y-2 scrollbar">
                        <div class="flex flex-row justify-end">

                            <button class="text-lg font-semibold bg-orange-300 w-fit px-4 rounded"
                                v-if="selected.length > 0">
                                <TransactionModal @submit="handleSubmit" :equipments="equipments" :provinces="provinces"
                                    :incident="selected" />
                            </button>
                        </div>
                        <div v-for="(pending, key) in pendings" :key="key"
                            class="flex justify-between pr-2 border-b pb-2 border-red-200 last:border-transparent">

                            <div class="grid grid-cols-1">
                                <span class="font-bold text-sm text-gray-700">{{ pending.owner }}</span>
                                <span class="text-xs text-gray-700">{{ pending.equipment }}:{{
                                        pending.quantity
                                }}</span>
                            </div>

                            <span v-if="pending.status == 'pending'"
                                class="text-slate-400 text-sm font-thin italic">Pending...</span>
                            <span v-else-if="pending.status == 'accepted'"
                                class="text-green-400 text-base font-semibold ">Accepted</span>
                            <span v-else-if="pending.status == 'denied'"
                                class="text-red-400 text-base font-semibold ">Denied</span>
                        </div>

                    </div>
                </div> -->
            </div>

        </div>
    </Content-box>
    <Content-box>
        <div class="flex flex-col space-y-8">
            <new-incident :equipments="equipments" @request="getIncident" name="New" :provinces="provinces" />
               
            <table class="table-auto  w-full text-sm border-x text-gray-500 dark:text-gray-400">
                <thead
                    class="text-xs text-gray-700 text-center uppercase bg-header dark:bg-gray-700 dark:text-gray-400">
                    <tr>
                        <th scope="col" class="py-3 px-6" v-for="(head, key) in tableHeader" :key="key">
                            {{ head.name }}



                        </th>

                    </tr>
                </thead>
                <tbody>
                    <tr class="max-h-full even:bg-gray-200  bg-white border-b dark:bg-gray-800 dark:border-gray-700"
                       >
                        <!-- <td scope="row" class="py-4 px-6 font-medium  text-gray-900 whitespace-nowrap dark:text-white">
                            {{ body.name }}
                        </td>
                        <td class="text-center">
                            {{ body.category }}
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
                        <td class="text-center" v-if="editable">
                            <button href="javascript:void(0)" type="button"
                                class="font-medium text-blue-600 dark:text-blue-500 hover:underline">
                                <EditModal :form="body" />

                            </button>


                        </td> -->
                    </tr>

                </tbody>
            </table>

        </div>



    </Content-box>

</template>

<script>
import { ref, watch, onMounted } from 'vue';
import ContentBox from '../../Components/ContentBox.vue'
import MunicipalityLayout from '@/Layouts/MunicipalityLayout.vue';
import EquipmentList from '../../Components/Lists/EquipmentList.vue';
import { Inertia } from '@inertiajs/inertia'
import axios from 'axios';
import { useForm, usePage } from '@inertiajs/inertia-vue3';
import LocalTransactions from '@/Components/LocalTransactions.vue';
import newIncident from '@/Components/newIncident.vue'
import TransactionModal from '@/Components/TransactionModal.vue';
import useChannel from '@/Composables/useChannel';
import StatusCard from '@/Components/Transactions/StatusCard.vue';
export default {
    props: {
        histories: Object,
        equipments: Object,
        provinces: Object,

    },
    components: {
        ContentBox,
        EquipmentList,
        LocalTransactions,
        newIncident,
        TransactionModal,
        StatusCard
    },
    layout: MunicipalityLayout,
    setup({ histories }) {


        const isEditable = ref(false)
        const incidents = ref('')
        const { pendings, confirmed, denied } = useChannel()
        const selected = ref('')

        const tableHeader = [
            { name: "INCIDENT" },
            { name: "ACQUIRED" },
            { name: "REQUEST" },
            { name: "REPORT" },
            { name: "DETAIL" },


        ]
        const tabs = [
            { name: 'Incidents', nagivated: false },
            { name: 'Cart', nagivated: false },
            { name: 'Approved', nagivated: false },

        ]
        const getIncident = (incident) => {
            incidents.value = incident
        }
        const getHistories = () => {
            // if (histories) {
            //     //  for(const history in histories){
            //     //     console.log(history);
            //     //  }
            //     Object.keys(histories).forEach((history, key) => {
            //         incidents.value.push({
            //             incident: history
            //         })
            //     })
            //     console.log(incidents.value);
            // }
        }
        const getStatuses = (incident, status) => {
            console.log(incident);
            selected.value = incident
            pendings.value = status
            // console.log('this is incident ',incident);
            // if (selected) {
            //     pendings.value = []
            // }
            // selected.value = incident
            // console.log(selected.value);
            // for (const [key, value] of Object.entries(histories)) {
            //     console.log(key, incident);
            //     value.map((s)=>{
            //         console.log('this is s  ',s);
            //     })

            //     if (incident === key) {

            //         value.map((v) => {
            //             console.log(v);
            //             pendings.value.push(v)
            //         })
            //     } {

            //     }
            // }
        }


        const handleSubmit = async (form) => {
            form.incidents = selected
            console.log(form.incidents);
            form.post('/api/request', {
                // preserveState: true,
                preserveScroll: true,
                onFinish: () => {
                    incidents.value = ''
                    selected.value = ''
                    // Inertia.reload()
                    // getHistories()
                },

            })
        }


        onMounted(() => {
            confirmed()
            denied()
            getHistories()
        })
        const newIncident = () => {
            incidents.value.push({
                incident: ''
            })

        }


        return {
            tabs,
            tableHeader,
            selected,
            isEditable,
            handleSubmit,
            incidents,
            newIncident,
            getIncident,
            getStatuses,
            pendings,
        }
    },

}
</script>

<style lang="scss" scoped>

</style>