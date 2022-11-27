<template>

    <!-- <ContentBox>
        <Local-transactions :equipments="equipments" :provinces="provinces" />
    </ContentBox> -->

    <Content-box>
        <div class="flex flex-col space-y-8">
            <div class="flex">
                <new-incident :equipments="equipments" name="New" :provinces="provinces" />
            </div>

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
                    <tr class="max-h-full even:bg-gray-100  bg-white border-b dark:bg-gray-800 dark:border-gray-700"
                        v-for="(body, key) in histories" :key="key">

                        <td scope="row" class="p-4 text-center">
                            {{ body.incident }}
                        </td>
                        <td scope="row" class="text-center">
                            {{ body.acquired }}
                        </td>
                        <td class="text-center">
                            {{ body.quantity }}
                        </td>
                        <td class="text-center">
                            {{ body.owner_address }}
                        </td>
                        <td class="text-center">
                            <DetailModal/>
                        </td>


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
import DetailModal from '@/Components/DetailModal.vue';

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
        StatusCard,
        DetailModal
    },
    layout: MunicipalityLayout,
    setup({ histories }) {


        const isEditable = ref(false)
        const incidents = ref('')
        const { pendings, confirmed, denied } = useChannel()
        const incident = ref('')

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
            if (histories) {
                //  for(const history in histories){
                //     console.log(history);
                //  }
                Object.keys(histories).forEach((history, key) => {
                    incidents.value.push({
                        incident: history
                    })
                })
                console.log(incidents.value);
            }
        }
        const getStatuses = (incident, status) => {
            console.log(incident);
            incident.value = incident
            pendings.value = status
            
        }


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
            incident,
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