<template>
    <head title="Update"/>
    <ContentBox>


        
        <form class="h-full " @submit.prevent="handleSubmit">
            <div class="flex flex-row justify-between">
                <h1 class="font-bold text-2xl font-sans antialiased">Update Inventory</h1>
                <button type="submit" class="bg-orange-500 px-3 py-2 rounded-xl hover:bg-orange-700">Submit</button>
            </div>

            <div class="grid grid-cols-2 gap-10  h-full w-full">
                <div class="grid grid-cols-3 gap-2">
                    <div class="flex flex-col col-span-2">
                        <label class="text-sm font-bold">Equipment Name</label>
                        <input type="text" v-model="form.equipment_name" required
                            class="border-2 rounded-md px-2 py-1  focus:outline-none focus:border-transparent focus:ring-2 focus:ring-blue-300">
                    </div>
                    <div class="flex flex-col">
                        <label class="text-sm font-bold">Category</label>
                        <select class="form-select border-2 rounded-md px-2 py-1  focus:outline-none focus:border-transparent focus:ring-2 focus:ring-blue-300"
                            v-model="form.category" required>
                           
                            <option>category1</option>
                            <option>category2</option>
                            <option>category3</option>

                        </select>
                     
                    </div>
                </div>
                <div class="grid grid-cols-3 gap-2">
                    <div class="flex flex-col">
                        <label class="text-sm font-bold">Serviceable</label>
                        <input type="number" v-model="form.serviceable" required
                            class="border-2 rounded-md px-2 py-1  focus:outline-none focus:border-transparent focus:ring-2 focus:ring-blue-300">
                    </div>
                    <div class="flex flex-col">
                        <label class="text-sm font-bold">Unusable</label>
                        <input type="number" v-model="form.unusable" required
                            class="border-2 rounded-md px-2 py-1  focus:outline-none focus:border-transparent focus:ring-2 focus:ring-blue-300">
                    </div>
                    <div class="flex flex-col">
                        <label class="text-sm font-bold">Poor</label>
                        <input type="number" v-model="form.poor" required
                            class="border-2 rounded-md px-2 py-1  focus:outline-none focus:border-transparent focus:ring-2 focus:ring-blue-300">
                    </div>
                </div>
                <div class="grid grid-cols-3 gap-2">
                    <div class="flex flex-col">
                        <label class="text-sm font-bold">Serial Number</label>
                        <input type="number" v-model="form.serial_number" required
                            class="border-2 rounded-md px-2 py-1  focus:outline-none focus:border-transparent focus:ring-2 focus:ring-blue-300">
                    </div>
                    <div class="flex flex-col">
                        <label class="text-sm font-bold">Code</label>
                        <input type="text" v-model="form.code" required
                            class="border-2 rounded-md px-2 py-1  focus:outline-none focus:border-transparent focus:ring-2 focus:ring-blue-300">
                    </div>
                    <div class="flex flex-col">
                        <label class="text-sm font-bold">Asset ID</label>
                        <input type="number" v-model="form.asset_id" required
                            class="border-2 rounded-md px-2 py-1  focus:outline-none focus:border-transparent focus:ring-2 focus:ring-blue-300">
                    </div>
                </div>

                <div class="grid grid-cols-3 gap-2">
                    <div class="flex flex-col">
                        <label class="text-sm font-bold">Unit</label>
                        <input type="number" v-model="form.unit" required
                            class="border-2 rounded-md px-2 py-1  focus:outline-none focus:border-transparent focus:ring-2 focus:ring-blue-300">
                    </div>
                    <div class="flex flex-col">
                        <label class="text-sm font-bold">Model Number</label>
                        <input type="number" v-model="form.model_number" required
                            class="border-2 rounded-md px-2 py-1  focus:outline-none focus:border-transparent focus:ring-2 focus:ring-blue-300">
                    </div>
                    <!-- <div class="flex flex-col">
                        <label class="text-sm font-bold">Quantity</label>
                        <input type="number" v-model="form.quantity" required
                            class="border-2 rounded-md px-2 py-1  focus:outline-none focus:border-transparent focus:ring-2 focus:ring-blue-300">
                    </div> -->
                </div>

                <div class="flex flex-col">
                    <label class="text-sm font-bold">Remarks</label>
                    <textarea type="text" v-model="form.remarks" required
                        class="border-2 rounded-md px-2 py-1  focus:outline-none focus:border-transparent focus:ring-2 focus:ring-blue-300">
                    </textarea>
                </div>
                <div class="flex flex-col">
                    <label class="text-sm font-bold">Asset Desciption</label>
                    <textarea type="text" v-model="form.asset_desc" required
                        class="border-2 rounded-md px-2 py-1  focus:outline-none focus:border-transparent focus:ring-2 focus:ring-blue-300">
                    </textarea>
                </div>

            </div>
        </form>
    </ContentBox>

</template>

<script>
import axios from 'axios';
import { ref, computed } from 'vue';
import { Head } from '@inertiajs/inertia-vue3';
import { useForm } from '@inertiajs/inertia-vue3';
import ContentBox from '../../Components/ContentBox.vue';
import municipalityLayout from '@/Layouts/MunicipalityLayout.vue'
import InputError from '@/Components/InputError.vue';


export default {
    layout: municipalityLayout,
    components: { ContentBox, InputError, Head },
    setup() {

        const form = useForm({

            equipment_name: '',
            code: '',
            asset_desc: '',
            category: '',
            unit: null,
            model_number: null,
            serial_number: null,
            asset_id: null,
            remarks: '',
            serviceable: null,
            unusable: null,
            poor: null
        })

        const handleSubmit = () => {
            form.post(route('municipality.inventory.store'), {
                onError: (e) => {
                    alert(Object.values(e))
                    form.clearErrors()

                },
                
               
            })

            //  form.get('/municipality/inventory/store',{
            //     onFinish: ()=> {
            //         /* reset only has error */
            //         form.reset()
            //     }
            //  })
            // const cookie = VueCookies.get('access_token')
            // console.log(JSON.stringify(form.value))
            // await axios.post('/owned/create',
            //     JSON.stringify(form.value), {
            //     headers: {
            //         'Content-Type': 'application/json',
            //         'Authorization': `Bearer ${cookie}`
            //     }
            // }
            // ).then((res) => {


            // }).catch((err) => {
            //     if (err.request.status == 401) {
            //         const refresh = VueCookies.get('refresh_token')
            //         axios.get('/auth/refresh_token', {
            //             headers: {
            //                 'Authorization': `Bearer ${refresh}`
            //             }
            //         }).then((res) => {
            //             VueCookies.remove('access_token')
            //             VueCookies.set('access_token', res.data.ACCESS_TOKEN)
            //             this.handleSubmit
            //         })
            //     }
            // })

        }

        return {
            form,

            handleSubmit
        }
    },

}
</script>

<style lang="scss" scoped>

</style>