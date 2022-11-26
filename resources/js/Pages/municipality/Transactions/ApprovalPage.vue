<template>

    <Head title="Tansaction" />
    <Content-box>
        <div class="flex flex-col col-span-2  overflow-hidden h-full ">
            <span class="text-lg font-semibold font-sans text-center" v-if="notifications.length === 0">No Equipment
                Request Recieve</span>
            <span class="text-lg font-semibold font-sans text-center" v-else>Requests</span>
            <div class=" flex flex-col justify-between overflow-y-auto border-2 rounded-lg    space-y-2 scrollbar">
                <div v-for="(notification, key ) in notifications" :key="key"
                    class="rounded-lg p-4  relative text-center flex justify-between pr-2 border-b pb-2 border-red-200 last:border-transparent">



                    <div class="grid grid-cols-1">

                        <span class="font-bold text-sm text-gray-700 text-start">{{
                        
                        }}</span>
                        <span class="font-bold text-sm text-gray-600 text-start hover:text-slate-900">{{
                                notification.equipment
                        }}:
                            <span class="text-xs">{{ notification.quantity }}</span>
                        </span>
                    </div>
                    <div class="grid grid-cols-1">

                        <span class="font-bold text-sm text-gray-700 text-start">{{
                                notification.borrower_personel
                        }}</span>
                        <span class="font-bold text-sm text-gray-600 text-start hover:text-slate-900">{{
                                notification.reason
                        }}
                            <!-- <span class="text-xs">{{ notification.data.quantity }}</span> -->
                        </span>
                    </div>

                    <div class="flex flex-col justify-between space-y-2">
                        <button
                            class=" text-sm  hover:bg-green-600  text-center bg-green-500 px-2 rounded-lg text-white tracking-wide">
                            <Personal-modal name="Accept" :transaction="notification" @submit="accept" />
                        </button>
                        <button
                            class="text-sm  hover:bg-red-600  text-center bg-red-500 px-2 rounded-lg text-white tracking-wide">
                            <Personal-modal name="Deny" :transaction="notification" @submit="deny" />
                        </button>
                    </div>

                </div>



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

export default {
    layout: MunicipalityLayout,
    components: {
        ContentBox,
        Head,
        PersonalModal
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

        emitter.on('refresh-approvals', ()=>{
            Inertia.reload({ only: ['notifications'] })
        })
        const { notification, count } = useNotification()
        const accept = (transaction, person) => {
            console.log(transaction);


            form.quantity = transaction.quantity,
                form.equipment = transaction.equipment,
                form.borrower = transaction.borrower,
                form.borrower_id = transaction.borrower_id,
                form.detail_id = transaction.detail_id,
                form.personel = person,
                form.incident = transaction.reason
            form.post('/api/accepted', {
                onFinish: () => {
                    
                    notification()
                    Inertia.reload({ only: ['notifications'] })
                }
            })
            emitter.emit('badge')

        }

        const deny = async (transaction, person) => {

            form.quantity = transaction.quantity,
                form.equipment = transaction.equipment,
                form.borrower = transaction.borrower,
                form.borrower_id = transaction.borrower_id,
                form.detail_id = transaction.detail_id,
                form.personel = person,
                form.incident = transaction.reason
            form.post('/api/deny', {
                onFinish: () => {
                    Inertia.reload({ only: ['notifications'] })
                }
            })
        }

        return {
            notification,
            count,
            accept,
            deny

        }
    }
}
</script>

<style lang="scss" scoped>

</style>