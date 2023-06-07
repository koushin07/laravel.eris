<template>
    <div class="flex flex-col h-full">
        <!-- <form class="flex flex-col justify-center " @submit.prevent="HandleSubmit" autocomplete="off">
            <div class="flex flex-col-reverse md:flex-row gap-5 z-20">
                <div class=" w-full flex flex-col z-0 justify-between ">
                    <label for="Equipment" class="text-sm font-bold">Equipment</label>
                    <Equipment-list @submit="getEquipment" :contents="equipments" />

                </div>
                <div class=" flex flex-col z-0  justify-end">

                    <button @click="search"
                        class="px-10 bg-button w-fit text-center text-black hover:bg-orange-500 py-3 rounded-lg">Search</button>
                </div>
            </div>
            <div class="flex flex-row space-x-2 mt-2">
                <span class="text-sm font-bold">Provinces</span>
                <i class="fa-solid fa-filter text-sm"></i>
            </div>
            <v-select multiple :options="converted" v-model="requests.provinces" label="name"></v-select>
           

        </form> -->

        <div class="grid grid-rows-2 gap-2">


            <div class="my-1">
                <label class="text-sm w-full">Equipment</label>
                <v-select multiple :options="convertedEquipment" v-model="requests.equipments" label="name"></v-select>
            </div>
            <div class="my-1">
                <label class="text-sm">Province</label>
                <v-select multiple :options="convertedProvince" v-model="requests.provinces" label="name"></v-select>
            </div>
        </div>
        <div class="flex justify-end mt-2">
            <button @click="search"
                class="px-3 bg-button w-fit text-center text-white tracking-wider   py-2 rounded">Search</button>
        </div>
        <div class="grid grid-flow-row lg:grid-flow-col gap-10 pt-6">
            <div class=" lg:col-span-4 flex flex-col z-0 justify-between ">
                <div class="flex flex-col  overflow-hidden h-[280px] ">
                    <span class="text-lg font-semibold font-sans text-center">Municipalities</span>
                    <div class="flex flex-col justify-between overflow-y-auto rounded-lg p-4 space-y-2 scrollbar">

                        <!-- <div class="flex flex-row justify-end space-x-3" v-if="municipalities && !loading && !notFound">
                            <span class="cursor-pointer text-center" :class="selectClick ? 'underline' : ''"
                                @click="selectClick = !selectClick">
                                select
                                all </span>
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" v-if="selectClick"
                                stroke-width="1.5" stroke="currentColor" @click="handleSelectAll"
                                class="w-6 h-6 hover:scale-105 cursor-pointer"
                                :class="selectClick ? 'text-green-500 animate-wiggle' : ''">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M6 12L3.269 3.126A59.768 59.768 0 0121.485 12 59.77 59.77 0 013.27 20.876L5.999 12zm0 0h7.5" />
                            </svg>



                        </div> -->

                        <!-- <div class="loader " v-if="loading"></div> -->



                        <div
                            class="flex flex-row lg:flex-col justify-between pr-2 border-b pb-2 border-red-200 last:border-transparent">

                            <table class="table-auto  w-full text-sm  text-gray-500 dark:text-gray-400">
                                <thead
                                    class="text-xs text-gray-700 text-center uppercase bg-header dark:bg-gray-700 dark:text-gray-400">
                                    <tr>
                                        <th scope="col" class="py-3 px-6" v-for="(head, key) in tableHeader" :key="key">

                                            {{ head.name !== 'SELECT ALL' ? head.name : '' }}
                                            <button class="" v-if="head.name === 'SELECT ALL'">{{ head.name }} </button>
                                        </th>

                                    </tr>
                                </thead>
                                <tbody>

                                    <tr v-if="loading"
                                        class="max-h-full even:bg-gray-100  bg-white border-b dark:bg-gray-800 dark:border-gray-700">

                                        <td scope="row" class="p-4 text-center">

                                        </td>
                                        <td scope="row" class="text-center">

                                        </td>
                                        <td class="text-center">
                                            <Loading />
                                        </td>
                                        <td class="text-center">

                                        </td>
                                        <td class="text-center">

                                        </td>
                                        <td class="text-center">



                                        </td>


                                    </tr>

                                    <tr v-else
                                        class="max-h-full even:bg-gray-100  bg-white border-b dark:bg-gray-800 dark:border-gray-700"
                                        v-for="(body, key) in municipalities" :key="key">

                                        <td scope="row" class="p-4 text-center">
                                            {{ body.equipment }}
                                        </td>
                                        <td scope="row" class="text-center">
                                            {{ body.municipality }}
                                        </td>
                                        <td class="text-center">
                                            {{ body.quantity }}
                                        </td>
                                        <td class="text-center">
                                            {{ body.owner_address }}
                                        </td>
                                        <td class="text-center">
                                            {{ body.owner_contact }}
                                        </td>
                                        <td class="text-center">

                                            <Quantity-modal placeholder="Quantity" :muni="body" @submit="submit">
                                                <template #trigger>
                                                    <button class="border-2 px-2">
                                                        Request
                                                    </button>
                                                </template>

                                            </Quantity-modal>

                                        </td>
                                    </tr>

                                </tbody>
                            </table>
                        </div>


                        <div class="grid place-content-center py-10" v-if="notFound">
                            <span class="text-lg font-bold text-gray-600 text-center"> Nothing Found</span>
                            <span class="text-xs font-semibold text-gray-600"> Try Changing Quantity</span>

                        </div>

                    </div>
                </div>
            </div>
            <!-- <div class="flex flex-col z-0 w-full justify-between">
                <div class="flex flex-col  overflow-hidden h-[280px] ">
                    <span class="text-lg font-semibold font-sans text-center">Status</span>
                    <div
                        class="flex flex-col justify-between overflow-y-auto border-2 rounded-lg p-4 space-y-2 scrollbar">
                        <div v-for="(pending, key) in pendings" :key="key"
                            class="flex justify-between pr-2 border-b pb-2 border-red-200 last:border-transparent">

                            <div class="grid grid-cols-1">
                                <span class="font-bold text-sm text-gray-700">{{ pending.municipality }}</span>
                                <span class="text-xs text-gray-700">{{ pending.equipment }}:{{ pending.quantity_borrowing }}</span>
                            </div>

                            <span v-if="pending.status == 'pending'"
                                class="text-slate-400 text-sm font-thin italic">Pending...</span>
                            <span v-else-if="pending.status == 'accept'"
                                class="text-green-400 text-base font-semibold ">Accepted</span>
                            <span v-else-if="pending.status == 'denied'" class="text-red-400 text-base font-semibold ">Denied</span>
                        </div>
                    </div>
                </div>
            </div> -->
        </div>


    </div>
</template>

<script>
import { ref, watch, onMounted } from 'vue';
import EquipmentList from './Lists/EquipmentList.vue';
import ProvinceList from './Lists/ProvinceList.vue';
import { useForm } from '@inertiajs/inertia-vue3'
import axios from 'axios';
import useFetchMunicipality from '@/Composables/useFetchMunicipality'
import useLocalStorage from '@/Composables/useLocalStorage'
import useChannel from '@/Composables/useChannel'

import Loading from './Loading.vue'
import QuantityModal from './QuantityModal.vue';

export default {

    props: {
        equipments: Object,
        provinces: Object,
        incident: String
    },
    emits: ['submitted'],
    components: {
        EquipmentList,
        ProvinceList,
        Loading,
        QuantityModal,

    },
    setup({ incident, provinces, equipments }, { emit }) {
        const select2 = ref('')
        const { municipalities, getLocalMunicipality, loading, notFound } = useFetchMunicipality()

        const { setItem } = useLocalStorage()
        const selectAll = ref([])

        const selectClick = ref(false)
        const equipment = ref({})
        // const quantity = ref(0);
        const show = ref(false)
        const requests = ref({
            equipments: [],
            provinces: []
        })
        const tableHeader = [
            { name: 'EQUIPMENT' },
            { name: 'MUNICIPALITY' },
            { name: 'AVAILABLE' },
            { name: 'ADDRESS' },
            { name: 'CONTRACT NUMBER' },
            { name: 'ACTION' }
        ]
        const form = useForm({
            equipment: '',
            municipality_id: null,
            quantity: null,
            incidents: '',
            incident_summary: '',
            date: ''

        })



        const getEquipment = async (equipment) => {
            equipment.value = equipment
            requests.value.equipments = equipment.name
        }

        const search = async () => {
            if (requests.value.equipments.length !== 0 && requests.value.provinces.length !== 0) {
                await getLocalMunicipality(requests.value)
            }

        }

        const submit = (quantity, muni) => {
            console.log('this is muni', muni);
            console.log('this is qty', quantity);
            form.equipment = muni.equipment
            form.quantity = quantity.value
            form.municipality_id = muni.municipality_id

            // console.log('this is ', muni);
            emit('submitted', form)
            // handleRequest(muni, quantity, person)
        }

        // const handleSelectAll = async () => {

        //     for (let i in municipalities.value) {
        //         selectAll.value[i] = municipalities.value[i].municipality_id
        //         console.log('this is equipment ', equipments.value);
        //         setItem(municipalities.value[i], equipments.value.id)
        //         for (let p in pendings.value) {

        //             if (pendings.value[p].municipality === muni.municipality && pendings.value[p].equipment === muni.equipment) {
        //                 pendings.value.splice(p, 1)

        //             }
        //         }
        //         pendings.value.push(municipalities.value[i])

        //     }
        //     await axios.post(`/api/requestAll`, {

        //         equipment: equipments.value.name,
        //         municipalities: selectAll.value,
        //         quantity: quantity.value,

        //     }).then((res) => {


        //         municipalities.value = res.data

        //     }).catch((err) => { console.log(err) })
        // }

        const handleRequest = async (muni, quantity, person) => {
            console.log('this is equipment ', equipment.value);
            municipalities.value = Object.values(municipalities.value).filter((m) => {
                return m.municipality_id !== muni.municipality_id
            })

            // setItem(muni, requests.value.equipment, quantity, pendings)



            console.log(incident);
            await axios
                .post(
                    `/api/request`, {
                    equipment: requests.value.equipments,
                    municipality_id: muni.municipality_id,
                    quantity: quantity.value,
                    incidents: incident,
                    person: person
                })
                .then((res) => {
                    console.log(res)

                })

        }

        // watch(pendings.value, (value) => {
        //     console.log('this is th evalue', value);
        //     window.localStorage.setItem('municipality', JSON.stringify(value))
        // })
        console.log(provinces);
        const convertedProvince = Object.values(provinces).map((c) => c.province)
        const convertedEquipment = Object.values(equipments).map((c) => c.name)
        console.log('converted ', convertedProvince);
        onMounted(() => {

            // let exist = JSON.parse(localStorage.getItem('municipality'))
            // console.log('exist is ', exist);
            // if (exist !== null) {

            //     for (let e in exist) {
            //         if (new Date(new Date().getTime()) < new Date(exist[e].expiration) && exist[e].status == 'pending') {
            //             console.log('object');
            //             pendings.value.push(exist[e])
            //         }

            //     }

            // }

        })
        return {
            tableHeader,
            convertedProvince,
            convertedEquipment,
            select2,
            submit,
            show,
            search,
            loading,
            selectAll,
            selectClick,
            notFound,
            getEquipment,
            municipalities,
            form,
            handleRequest,
            requests,



        };
    }
}
</script>

<style scoped>
.loader {
    width: 12px;
    height: 12px;
    border-radius: 50%;
    display: block;
    margin: 15px auto;
    position: relative;
    color: #870C0D;
    box-sizing: border-box;
    animation: animloader 1s linear infinite alternate;
}
</style>