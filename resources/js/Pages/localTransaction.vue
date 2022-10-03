<template>

    <Head title="Transaction" />

    <div class="container  p-4">
        <div class="flex flex-1 w-full flex-col sm:flex-row gap-4">

            <div class="z-0 h-full p-5  rounded-lg bg-white w-full sm:w-8/12">
                <div v-if="$page.props.flash.message" class="alert">
                    {{ $page.props.flash.message }}
                </div>
                <form class="px-8" @submit.prevent="form.post(route('transactions.store'))">
                    <div class="grid grid-rows-1 md:grid-rows-3 gap-4 ">
                        <div class="mb-3 w-80 z-40">
                            <label class="block text-gray-700 text-sm font-bold mb-2" for="password">
                                municipality
                            </label>
                            <MunicipalityList @submit="getMunicipality" :contents="municipalities" />
                        </div>
                        <div class="mb-3 w-80 z-20" v-if="Xtransaction">
                            <label class="block text-gray-700 text-sm font-bold mb-2" for="password">
                                Province
                            </label>
                            <ProvinceList @submit="getProvince" :contents="provinces"/>
                          
                        </div>
                        <div class="mb-3 w-80 z-0" >
                            <label class="block text-gray-700 text-sm font-bold mb-2" for="password">
                                Equipment
                            </label>
                            <EquipmentList @submit="getEquipment" :contents="allEquipment.data " />
                        </div>
                        <div class="mb-3 w-40">
                            <label class="block text-gray-700 text-sm font-bold mb-2" for="password">
                                Quantity
                            </label>
                            <input v-model="form.quantity"
                                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                id="username" type="number" placeholder="Quantity">
                        </div>
                    </div>

                    <div class="flex items-center justify-between pt-2 pb-0">
                        <button
                            class=" bg-zinc-600 hover:bg-zinc-700 text-white font-bold py-2 px-4 rounded-lg focus:outline-none focus:shadow-outline"
                            type="submit">
                            Request
                        </button>
                        <label for="default-toggle" class="inline-flex relative items-center cursor-pointer">
                              <input type="checkbox" @click="Xtransaction=!Xtransaction" id="default-toggle" class="sr-only peer">
                            <div
                                class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 dark:peer-focus:ring-blue-800 rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-blue-600">
                            </div>
                            <span class="ml-3 text-sm font-medium text-gray-900 dark:text-gray-300">Cross Transaction</span>
                        </label>


                    </div>
                </form>



            </div>

            <div class="flex flex-col rounded-lg bg-white sm:w-4/12 p-4 ">
                <div class="grid grid-cols-1 gap-2 m-2">
                    <!-- <input class="border-2 border-bg-slate-200 bg-white rounded-md" placeholder="Search here ..." /> -->

                    <h4 class="text-center font-bold text-lg">Your Request</h4>

                    <div class=" h-fit overflow-x-auto scrollbar">
                        <Receipt :receipt="receipt" />
                    </div>

                </div>
            </div>
        </div>
        <div class="flex h-80 p-4 border my-2 shadow-lg content-center w-full bg-white rounded-2xl">
            <div class="flex flex-col space-y-2 w-full">
                <div class="flex flex-row justify-between">
                    <span class="pl-2 font-bold">{{ name }}</span>
                    <input class="border-2 border-bg-slate-200 bg-white rounded-md px-2"
                        placeholder="Search here ..." />
                </div>

                <div class=" h-fit overflow-auto scrollbar">

                    <EquipmentModelLists v-if="allEquipment" :equipments="list.data" @picked="pick" />

                </div>
            </div>


        </div>
    </div>

</template>

<script >

import MunicipalityList from '@/Components/Lists/MunicipalityList.vue';
import EquipmentList from '@/Components/Lists/EquipmentList.vue';
import { useForm, Head } from '@inertiajs/inertia-vue3';
import { ref, watch } from 'vue';
import axios from 'axios';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import EquipmentModelLists from '../Components/Transactions/EquipmentModelLists.vue';
import Receipt from '../Components/Receipt.vue';
import ProvinceList from '@/Components/Lists/ProvinceList.vue';
import { Inertia } from '@inertiajs/inertia';
export default {
    layout: AuthenticatedLayout,

    components: {
    MunicipalityList,
    EquipmentList,
    Head,
    EquipmentModelLists,
    Receipt,
    ProvinceList,

},
    props: {
        municipalities: [Array, Object],
        provinces: Array,
    },

    setup(props) {
        const Xtransaction = ref(false)
        let name = ref('Equipment Name')
        let list = ref({})
        let allEquipment = ref({})
    
        const receipt = ref({
            equipment: '',
            municipality: '',
            serial: '',
            model: ''
        })
        let form = useForm(
            {
                municipality_id: '',
                equipment_id: '',
                quantity: null,
            }
        )
        const getEquipment = (equipment) => {
            receipt.value.equipment = equipment.equipment_name
            receipt.value.model = equipment.model_number
            receipt.value.serial = equipment.serial_number
            form.equipment_id = equipment.id
            name = equipment.equipment_name
            //send axios get all equipment with the same name
            axios.post(`http://127.0.0.1:8000/equipmentList/${equipment.equipment_name}`).then((res) => {

                list.value = res

            }).catch(err => console.log(err))
        }
        const getMunicipality = (muni) => {
            receipt.value.municipality = muni.municipality_name
            form.municipality_id = muni.id
            axios.post(`http://127.0.0.1:8000/getEquipment/${muni.id}`)
                .then((res) => {
                    allEquipment.value = res

                }).catch(err => console.log(err))
        }

        const getProvince = (prov) =>{
            Inertia.get('/transactions/create', {'province': prov.id},{
                preserveScroll: true,
                preserveScroll:true
            });
            // console.log(prov)
            // axios.get(`http://127.0.0.1:8000/provinces-Municipality/${prov.id}`)
            // .then(res =>props.municipalities =res).catch(err => console.log(err))
        }

        const pick =(equipment) => {
            receipt.value.model = equipment.model_number
            receipt.value.serial = equipment.serial_number
            form.equipment_id = equipment.id
        }

        const submit = () => {
            form.post(route('transactions.store'), {
                onFinish: () => form.reset('equipment_id', 'municipality_id', 'quantity'),
                preserveScroll: true,

            });
        }

        watch(Xtransaction, (isToggle)=>{
            const holder = props.municipalities
           
            if(isToggle){
                console.log('true')
               console.log(holder)
            }
            if(!isToggle){
                console.log('false')
            }
        })
        return {
            Xtransaction,
            name,
            list,
            receipt,
            allEquipment,
            form,
            getEquipment,
            getMunicipality,
            pick,
            getProvince,
            submit,

        }
    }

}



</script>


<style lang="scss" scoped>

</style>