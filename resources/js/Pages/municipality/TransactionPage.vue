<template>

    <Head title="Tansaction" />
    <Content-box>
        <!-- grid grid-cols-5 gap-2 -->

        <!-- Requests -->
        <div class="flex flex-col col-span-2  overflow-hidden h-full ">
            <span class="text-lg font-semibold font-sans text-center" v-if="notifications.length === 0">No Equipment
                Request Recieve</span>
            <span class="text-lg font-semibold font-sans text-center" v-else>Requests</span>
            <div class=" flex flex-col justify-between overflow-y-auto border-2 rounded-lg    space-y-2 scrollbar">
                <div v-for="(notification, key ) in notifications" :key="key"
                    class="rounded-lg p-4  relative text-center flex justify-between pr-2 border-b pb-2 border-red-200 last:border-transparent">



                    <div class="grid grid-cols-1">

                        <span class="font-bold text-sm text-gray-700 text-start">{{
                                notification.data.borrower[0].municipality
                        }}</span>
                        <button class="font-bold text-sm text-gray-600 text-start hover:text-slate-900">{{
                                notification.data.equipment.name
                        }}:
                            <span class="text-xs">{{ notification.data.quantity }}</span>
                        </button>
                    </div>

                    <div class="flex flex-col justify-between space-y-2">
                        <button
                            @click="accept(notification.data.equipment.id, notification.data.borrower_id, notification.id, notification.data.borrower[0].municipality, notification.data.quantity)"
                            class=" text-sm  hover:bg-green-600  text-center bg-green-500 px-2 rounded-lg text-white tracking-wide">Accept</button>
                        <button
                            @click="deny(notification.data.equipment.id, notification.data.borrower_id, notification.id, notification.data.borrower[0].municipality, notification.data.quantity)"
                            class="text-sm  hover:bg-red-600  text-center bg-red-500 px-2 rounded-lg text-white tracking-wide">Deny

                        </button>
                    </div>

                </div>



            </div>


        </div>



    </Content-box>
    <Content-box>
        <h1 class="text-semibold text-center tex-lg pb-10">Unfinish Transaction</h1>
        <div class="grid grid-cols-5 gap-5 place-content-center">
            <div class=" flex flex-col z-0  justify-between col-span-2">
                <div class="flex flex-col  overflow-hidden h-[450px] ">

                    <div class="flex flex-col justify-between overflow-y-auto border-2 rounded-lg  space-y-2 scrollbar">

                        <button v-for="(unfin, key) in unfinish" :key="key" 
                        @click="openForm(unfin.name, unfin.id)"
                            class="flex justify-between  border-b  p-4 hover:bg-slate-200 border-grey-200 last:border-transparent">

                            <div class="grid grid-cols-1 text-start">
                                <span class="font-bold text-base text-gray-700 uppercase">{{ unfin.municipality
                                }}</span>
                                <span class="text-xs text-gray-700 uppercase">{{ unfin.name }}</span>
                            </div>



                        </button>


                    </div>
                </div>
            </div>
            <div class=" flex flex-col z-0 h-full  justify-between col-span-3">
                <div class="flex flex-col  overflow-hidden h-full ">

                    <form v-if="toggleForm" @submit.prevent="handleSubmit"
                        class=" flex flex-col animate-fade-in-down justify-between overflow-y-auto border-2 rounded-lg  space-y-2 scrollbar p-5 ">
                        <div class="flex flex-row justify-between">
                            <h1 class="font-bold text-2xl font-sans antialiased capitalize">
                                {{ equipmentAttr.equipment_name }}</h1>

                        </div>

                        <div class="grid grid-cols-2 gap-10  h-full w-full">


                            <div class="grid grid-rows-3 gap-10">
                                <div class="flex flex-col">
                                    <label class="text-sm font-bold">Serial Number</label>
                                    <input type="number" v-model="equipmentAttr.serial_number"
                                        class="border-b-2 border-0  px-2 py-1  focus:ring-0  focus:border-b-blue-600">
                                </div>
                                <div class="flex flex-col">
                                    <label class="text-sm font-bold">Code</label>
                                    <input type="text" v-model="equipmentAttr.code"
                                        class="border-b-2 border-0  px-2 py-1  focus:ring-0  focus:border-b-blue-600">
                                </div>
                                <div class="flex flex-col">
                                    <label class="text-sm font-bold">Asset ID</label>
                                    <input type="number" v-model="equipmentAttr.asset_id"
                                        class="border-b-2 border-0  px-2 py-1  focus:ring-0  focus:border-b-blue-600">
                                </div>
                            </div>

                            <div class="grid grid-rows-3 gap-10">
                                <div class="flex flex-col">
                                    <label class="text-sm font-bold">Unit</label>
                                    <input type="number" v-model="equipmentAttr.unit"
                                        class="border-b-2 border-0  px-2 py-1  focus:ring-0  focus:border-b-blue-600">
                                </div>
                                <div class="flex flex-col">
                                    <label class="text-sm font-bold">Model Number</label>
                                    <input type="number" v-model="equipmentAttr.model_number"
                                        class="border-b-2 border-0  px-2 py-1  focus:ring-0  focus:border-b-blue-600">
                                </div>
                                <div class="flex flex-col">
                                    <label class="text-sm font-bold">Quantity</label>
                                    <input type="number" v-model="equipmentAttr.quantity"
                                        class="border-b-2 border-0  px-2 py-1  focus:ring-0  focus:border-b-blue-600">
                                </div>
                            </div>
                            <div class="flex justify-end col-span-2 ">
                                <button type="submit"
                                    class="bg-orange-500 px-11 py-2 rounded-xl  hover:bg-orange-700 ">save</button>

                            </div>


                        </div>
                    </form>
                </div>
            </div>
        </div>
    </Content-box>


    <Content-box>
        <h1 class="text-semibold text-center tex-lg pb-10"> Equipment Borrow type</h1>
        <Borrow-history :borrowings="borrowings" />
    </Content-box>
    <Content-box>
        <!-- <h1 class="font-semibold text-xl text-center">Incident Report</h1>
        <div class="box-content rounded-lg p-10 border-2 border-gray-500 h-fit  ">
            <div class="grid grid-rows-2 gap-10">
                <div class="flex flex-row justify-around">
                    <div class="flex flex-col">
                        <label class="text-sm font-bold">Quantity</label>
                        <input type="number"
                            class="border-b-2 border-0  px-2 py-1  focus:ring-0  focus:border-b-blue-600">
                    </div>
                    <div class="flex flex-col">
                        <label class="text-sm font-bold">Quantity</label>
                        <input type="number" 
                            class="border-b-2 border-0  px-2 py-1  focus:ring-0  focus:border-b-blue-600">
                    </div>
                </div>
            </div>

        </div> -->
        <Incident-report :reports="reports"/>
    </Content-box>
</template>

<script>
import ContentBox from '@/Components/ContentBox.vue';
import MunicipalityLayout from '@/Layouts/MunicipalityLayout.vue'
import axios from 'axios';
import { ref } from 'vue';
import { Inertia } from '@inertiajs/inertia'
import { Head, useForm } from '@inertiajs/inertia-vue3';
import BorrowHistory from '@/Components/Transactions/BorrowHistory.vue';
import IncidentReport from '@/Components/Transactions/IncidentReport.vue';


export default {
    layout: MunicipalityLayout,
    components: { ContentBox, Head, BorrowHistory, IncidentReport },
    props: {
        notifications: Array,
        unfinish: Array,
        borrowings: Array,
        reports: Object,
    },
    setup() {

        const equipmentAttr = useForm({
            id: null,
            equipment_name: '',
            serial_number: null,
            unit: null,
            code: '',
            model_number: null,
            asset_id: null,
            quantity: null
        })


        const handleSubmit = async () => {
            equipmentAttr.post(route('api.attrs'), {
                onError: (e) => {
                    alert(Object.values(e))
                },
                preserveScroll: true,
                onFinish: () => {
                    toggleForm.value = !toggleForm.value
                }
            })

        }
        const selectedEquipment = ref('')
        const toggleForm = ref(false)
        const toggleBorrowing = ref(false)

        const openForm = (equipment, id) => {

            equipmentAttr.equipment_name = equipment
            equipmentAttr.id = id
            selectedEquipment.value = equipment
            toggleForm.value = !toggleForm.value
        }



        const accept = async (equip, id, notify_id, muni, quantity) => {
            await axios.post(`/api/accepted`, {
                quantity: quantity,
                equipment: equip,
                borrower_id: id,
                notif_id: notify_id,
                municipality: muni
            }).then((res) => {

                Inertia.reload()
            })
        }

        const deny = async (equip, id, notify_id, muni, quantity) => {
            console.log(quantity)
            await axios.post(`/api/deny`, {
                quantity: quantity,
                equipment: equip,
                borrower_id: id,
                notif_id: notify_id,
                municipality: muni
            }).then((res) => {

                Inertia.reload({ only: ['notifications'] })
            })
        }

        return {
            accept,
            deny,
            equipmentAttr,
            toggleForm,
            openForm,
            selectedEquipment,
            handleSubmit,
            toggleBorrowing,
        };
    },
  
}
</script>

<style lang="scss" scoped>

</style>