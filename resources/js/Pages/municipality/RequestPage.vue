<template>

    <ContentBox>
        <Local-transactions :equipments="equipments" />
      

    </ContentBox>

</template>

<script>
import { ref, watch, onMounted } from 'vue';
import ContentBox from '../../Components/ContentBox.vue'
import MunicipalityLayout from '@/Layouts/MunicipalityLayout.vue';
import EquipmentList from '../../Components/Lists/EquipmentList.vue';
import axios from 'axios';
import { usePage } from '@inertiajs/inertia-vue3';
import LocalTransactions from '@/Components/LocalTransactions.vue';
export default {
    props: {
        equipments: Object
    },
    components: {
        ContentBox,
        EquipmentList,
        LocalTransactions
    },
    layout: MunicipalityLayout,
    setup() {

      

        const selectAll = ref([])
        const selectClick = ref(false)
        const notFound = ref(true)
        const municipalities = ref([])
        const equipments = ref({})
        const quantity = ref();
        const pendings = ref([]);

        const getEquipment = async (equipment) => {
            console.log(radio.value)
            if (quantity.value) {
                
                if(!radio.value == false){
                    await axios.post(`/api/equipment/${equipment.equipment_name}/quantity/${quantity.value}`)
                    .then((res) => {
                        console.log(res.data)
                        equipments.value = equipment
                        municipalities.value = res.data
                        notFound.value = false
                      
                    })
                  
                }else{
                    await axios.post(`/api/cross/equipment/${equipment.equipment_name}/quantity/${quantity.value}`)
                    .then((res) => {
                        console.log(res.data)
                        equipments.value = equipment
                        municipalities.value = res.data
                        notFound.value = false
                      
                    })
                }
             
            } else {
                alert('please fill up quantity field')
            }

        }
        const setItem = (muni, equipment) => {
            let date = new Date(new Date().getTime() + (60000 * 10))
            muni['expiration'] = date
            muni['equipment'] = equipment //equipments.value.equipment_name 
            muni['status'] = 'pending'


            for (let p in pendings.value) {

                if (pendings.value[p].municipality === muni.municipality && pendings.value[p].equipment === muni.equipment) {
                    pendings.value.splice(p, 1)
                    console.log(pendings.value[p])
                }
            }
            pendings.value.push(muni)
        }

        const handleSelectAll = async () => {

            for (let i in municipalities.value) {
                selectAll.value[i] = municipalities.value[i].municipality_id
                setItem(municipalities.value[i], equipments.value.equipment_name)

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



            await axios
                .post(
                    `/api/${equipments.value.equipment_name}/request/${muni.municipality_id}/${quantity.value}
                `)
                .then((res) => {
                    console.log(res)

                })

        }
        window.Echo.private(`confirmed.${usePage().props.value.auth.user.id}`)
            .listen('.equipment.confirmed', (e) => {

                alert('borrow accepted', e)

                Object.values(pendings.value).filter((p) => {
                    if (e.unfinish.owner === p.municipality_id && e.unfinish.equipment === p.equipment && p.status === 'pending') {
                        p.status = 'accept'
                    }
                })

            })
        window.Echo.private(`denied.${usePage().props.value.auth.user.id}`)
            .listen('.equipment.denied', (e) => {

                alert('borrow denied', e)

                Object.values(pendings.value).filter((p) => {
                    if (e.unfinish.owner === p.municipality_id && e.unfinish.equipment === p.equipment && p.status === 'pending') {
                        p.status = 'denied'
                    }
                })

            })
        watch(pendings.value, (value) => {

            // console.log('this is value',value)
            // setWithExpiry('municipality', value, 20)

            window.localStorage.setItem('municipality', JSON.stringify(value))
        })


        onMounted(() => {
            let exist = JSON.parse(localStorage.getItem('municipality'))

            if (exist !== null) {

                for (let e in exist) {

                    if (new Date(new Date().getTime()) < new Date(exist[e].expiration)) {
                        console.log('is')
                        pendings.value.push(exist[e])
                    }

                }

            }
        })



        return {
            selectClick,
            notFound,
            quantity,
            getEquipment,
            municipalities,
            handleSelectAll,
            handleRequest,
            pendings,
            


        };
    },

}
</script>

<style lang="scss" scoped>

</style>