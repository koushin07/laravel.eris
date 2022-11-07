<template>
    <div class="flex flex-col h-full">
        <form class="flex flex-col justify-center " @submit.prevent="HandleSubmit">
            <div class="grid grid-cols-3 gap-10 z-50">
                <div class=" col-span-2  flex flex-col z-0 justify-between ">
                    <label for="Equipment" class="text-sm font-bold">Equipment</label>
                    <Equipment-list @submit="getEquipment" :contents="equipments" />
                </div>
                <div class=" flex flex-col z-0  justify-between">
                    <label for="Quantity" class="text-sm font-bold">Quantity</label>
                    <input name="Quantity" type="number" v-model="quantity"
                        class="border-2 bg-transparent rounded-lg focus:outline-none focus:ring-0  py-2 px-1" />
                </div>
            </div>

        </form>
        <div class="grid grid-cols-3 gap-10 pt-6">
            <div class=" col-span-2  flex flex-col z-0 justify-between ">
                <div class="flex flex-col  overflow-hidden h-[280px] ">
                    <span class="text-lg font-semibold font-sans text-center">Municipalities</span>
                    <div
                        class="flex flex-col justify-between overflow-y-auto border-2 rounded-lg p-4 space-y-2 scrollbar">
                        <div class="flex flex-row justify-end space-x-3" v-if="municipalities">
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



                        </div>


                        <div aria-label="Loading..." class="grid place-content-center py-10 h-full" role="status"
                            v-if="loading">
                            <svg class="h-12 w-12 animate-spin stroke-gray-500" viewBox="0 0 256 256">
                                <line x1="128" y1="32" x2="128" y2="64" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="24"></line>
                                <line x1="195.9" y1="60.1" x2="173.3" y2="82.7" stroke-linecap="round"
                                    stroke-linejoin="round" stroke-width="24"></line>
                                <line x1="224" y1="128" x2="192" y2="128" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="24"></line>
                                <line x1="195.9" y1="195.9" x2="173.3" y2="173.3" stroke-linecap="round"
                                    stroke-linejoin="round" stroke-width="24"></line>
                                <line x1="128" y1="224" x2="128" y2="192" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="24"></line>
                                <line x1="60.1" y1="195.9" x2="82.7" y2="173.3" stroke-linecap="round"
                                    stroke-linejoin="round" stroke-width="24"></line>
                                <line x1="32" y1="128" x2="64" y2="128" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="24"></line>
                                <line x1="60.1" y1="60.1" x2="82.7" y2="82.7" stroke-linecap="round"
                                    stroke-linejoin="round" stroke-width="24"></line>
                            </svg>
                        </div>


                        <div class="flex justify-between pr-2 border-b pb-2 border-red-200 last:border-transparent"
                            v-for="(municipality, key) in municipalities" :key="key" v-if="!loading">

                            <div class="grid grid-cols-1">
                                <span class="font-bold text-base text-gray-700">{{
                                        municipality.municipality
                                }}</span>
                                <span class="text-xs text-gray-700">Quantity: {{ municipality.quantity }}</span>
                            </div>

                            <button class="text-red-600 text-base hover:text-red-700 hover:scale-110 font-semibold"
                                @click="handleRequest(municipality)">Request</button>

                        </div>
                        <div class="grid place-content-center py-10" v-if="!municipalities && !notFound">
                            <span class="text-lg font-bold text-gray-600 text-center"> Nothing Found</span>
                            <span class="text-xs font-semibold text-gray-600"> Try Changing Quantity</span>

                        </div>

                    </div>
                </div>
            </div>
            <div class=" flex flex-col z-0  justify-between">
                <div class="flex flex-col  overflow-hidden h-[280px] ">
                    <span class="text-lg font-semibold font-sans text-center">Status</span>
                    <div
                        class="flex flex-col justify-between overflow-y-auto border-2 rounded-lg p-4 space-y-2 scrollbar">
                        <div v-for="(pending, key) in pendings" :key="key"
                            class="flex justify-between pr-2 border-b pb-2 border-red-200 last:border-transparent">

                            <div class="grid grid-cols-1">
                                <span class="font-bold text-sm text-gray-700">{{ pending.municipality }}</span>
                                <span class="text-xs text-gray-700"></span>
                            </div>

                            <span v-if="pending.status == 'pending'"
                                class="text-slate-400 text-sm font-thin italic">Pending...</span>
                            <span v-else-if="pending.status == 'accept'"
                                class="text-green-400 text-base font-semibold ">Accepted</span>
                            <span v-else class="text-red-400 text-base font-semibold ">Denied</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="flex justify-end flex-row space-x-2">
            <label>Cross Transanction</label>
            <input type="radio" class="mt-1" @click="radio = !radio" :checked="radio" />

        </div>

    </div>
</template>

<script>
import { ref, watch, onMounted } from 'vue';
import EquipmentList from './Lists/EquipmentList.vue';
import axios from 'axios';
import { usePage } from '@inertiajs/inertia-vue3';
import useFetchMunicipality from '@/Composables/useFetchMunicipality'
import useLocalStorage from '@/Composables/useLocalStorage'
import useChannel from '@/Composables/useChannel'

export default {
    props: {
        equipments: Object
    },
    components: {
        EquipmentList
    },
    setup() {
        const { municipalities, getLocalMunicipality, getRegionalMunicipality } = useFetchMunicipality()
        const { confirmed, denied } = useChannel();
        const { setItem } = useLocalStorage()
        const radio = ref(false)
        const loading = ref(false)
        const selectAll = ref([])
        const selectClick = ref(false)
        const notFound = ref(true)
        const equipments = ref({})
        const quantity = ref();
        const pendings = ref([]);

        const getEquipment = async (equipment) => {
            if (quantity.value) {
                loading.value = true
                if (!radio.value) {
                    await getLocalMunicipality(equipment.equipment_name, quantity.value)
                    loading.value = false
                    equipments.value = equipment
                    notFound.value = false
                } else {
                    await getRegionalMunicipality(equipment.equipment_name, quantity.value)
                    loading.value = false
                    equipments.value = equipment
                    notFound.value = false
                }

            } else {
                alert('please fill up quantity field')
            }

        }

        const handleSelectAll = async () => {

            for (let i in municipalities.value) {
                selectAll.value[i] = municipalities.value[i].municipality_id
                setItem(municipalities.value[i], equipments.value.equipment_name)
                for (let p in pendings.value) {

                    if (pendings.value[p].municipality === muni.municipality && pendings.value[p].equipment === muni.equipment) {
                        pendings.value.splice(p, 1)

                    }
                }
                pendings.value.push(municipalities.value[i])

            }
            await axios.post(`/api/requestAll`, {

                equipment: equipments.value.equipment_name,
                municipalities: selectAll.value,
                quantity: quantity.value,

            }).then((res) => {


                municipalities.value = res.data

            }).catch((err) => { console.log(err) })
        }

        const handleRequest = async (muni) => {
            municipalities.value = Object.values(municipalities.value).filter((m) => {
                return m.municipality_id !== muni.municipality_id
            })
            setItem(muni, equipments.value.equipment_name)
            for (let p in pendings.value) {

                if (pendings.value[p].municipality === muni.municipality && pendings.value[p].equipment === muni.equipment) {
                    pendings.value.splice(p, 1)

                }
            }

            pendings.value.push(muni)

            await axios
                .post(
                    `/api/${equipments.value.equipment_name}/request/${muni.municipality_id}/${quantity.value}
                `)
                .then((res) => {
                    console.log(res)

                })

        }
      
        watch(pendings.value, (value) => {
            window.localStorage.setItem('municipality', JSON.stringify(value))
        })


        onMounted(() => {
            confirmed(pendings)
            denied(pendings);
            let exist = JSON.parse(localStorage.getItem('municipality'))

            if (exist !== null) {

                for (let e in exist) {

                    if (new Date(new Date().getTime()) < new Date(exist[e].expiration)) {
                        pendings.value.push(exist[e])
                    }

                }

            }

        })
        return {
            radio,
            loading,
            selectClick,
            notFound,
            quantity,
            getEquipment,
            municipalities,
            handleSelectAll,
            handleRequest,
            pendings,


        };
    }
}
</script>

<style lang="scss" scoped>

</style>