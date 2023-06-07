<template>
    <div @click="openModal">
        <button class=" border-2 rounded px-2 w-fit py-1 text-white font-semibold flex border-orange-500 bg-orange-500">

            <span>Add</span><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                stroke="currentColor" class="w-6 h-6">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v12m6-6H6" />
            </svg>

        </button>


    </div>
    <TransitionRoot appear :show="isOpen" as="template">
        <Dialog as="div" @close="closeModal" class="relative z-10">
            <TransitionChild as="template" enter="duration-300 ease-out" enter-from="opacity-0" enter-to="opacity-100"
                leave="duration-200 ease-in" leave-from="opacity-100" leave-to="opacity-0">
                <div class="fixed inset-0 bg-black bg-opacity-25" />
            </TransitionChild>

            <div class="fixed inset-0 overflow-y-auto">
                <div class="flex min-h-full items-center justify-center p-4 text-center">
                    <TransitionChild as="template" enter="duration-300 ease-out" enter-from="opacity-0 scale-95"
                        enter-to="opacity-100 scale-100" leave="duration-200 ease-in" leave-from="opacity-100 scale-100"
                        leave-to="opacity-0 scale-95">
                        <DialogPanel
                            class="w-full max-w-md transform overflow-hidden rounded bg-white p-6 text-left align-middle shadow-xl transition-all">
                            <DialogTitle as="h3" class="flex flex-row justify-between mx-4">

                                <span class="text-lg font-medium leading-6 text-gray-900"> Equipmet Details</span>
                                <button class="grid place-content-center hover:scale-110 hover:text-orange-500"
                                    @click="closeModal">
                                    <i class="fa-solid fa-x text-lg"></i>

                                </button>

                            </DialogTitle>
                            <div class="mt-2">


                                <form @submit.prevent="handleSubmit">

                                    <div class="">
                                        <div class="px-4 py-5 bg-white sm:p-6">
                                            <div class="grid grid-cols-6 gap-6">
                                                <div class="col-span-6 sm:col-span-3">
                                                </div>
                                                <div class="col-span-6 sm:col-span-3">
                                                    <label for="name"
                                                        class="block text-sm font-medium text-gray-700">Date
                                                        Receive</label>
                                                    <Datepicker v-model="form.date" show-now-button />
                                                 

                                                </div>
                                                <div class="col-span-6 sm:col-span-6">
                                                    <label for="name"
                                                        class="block text-sm font-medium text-gray-700">Equipment
                                                        Name</label>
                                                    <input type="text" name="name" id="name"
                                                        class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"
                                                        v-model="form.equipment_name" required="">

                                                </div>

                                                <div class="col-span-6 flex flex-col ">
                                                    <span class="text-sm text-slate-500 ">Status</span>
                                                    <div class="flex flex-row space-x-6 border-t-2">
                                                        <div class="col-span-6 sm:col-span-6 lg:col-span-2">
                                                            <label for="model_number"
                                                                class="block text-sm font-medium text-gray-700">Serviceable</label>
                                                            <input type="number" name="model_number" id="model_number"
                                                                v-model="form.serviceable" required=""
                                                                class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                                        </div>
                                                        <div class="col-span-6 sm:col-span-6 lg:col-span-2">
                                                            <label for="model_number"
                                                                class="block text-sm font-medium text-gray-700">
                                                            Unserviceable</label>
                                                            <input type="number" name="model_number" id="model_number"
                                                                v-model="form.unserviceable" required=""
                                                                class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                                        </div>
                                                        <div class="col-span-6 sm:col-span-6 lg:col-span-2">
                                                            <label for="model_number"
                                                                class="block text-sm font-medium text-gray-700">Poor</label>
                                                            <input type="number" name="model_number" id="model_number"
                                                                v-model="form.poor" required=""
                                                                class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                                        </div>
                                                    </div>
                                                </div>



                                                <div class="col-span-6 sm:col-span-6 lg:col-span-2">
                                                    <label for="model_number"
                                                        class="block text-sm font-medium text-gray-700">Model
                                                        Number</label>
                                                    <input type="text" name="model_number" id="model_number"
                                                        v-model="form.model_number" required=""
                                                        class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                                </div>



                                                <div class="col-span-6 sm:col-span-3 lg:col-span-2">
                                                    <label for="serial_number"
                                                        class="block text-sm font-medium text-gray-700">Serial
                                                        Number</label>
                                                    <input type="text" name="serial_number" id="serial_number"
                                                        v-model="form.serial_number" required=""
                                                        class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                                </div>


                                                <div class="col-span-6 sm:col-span-3 lg:col-span-2">
                                                    <label for="unit"
                                                        class="block text-sm font-medium text-gray-700">Unit
                                                    </label>
                                                    <input type="number" name="unit" id="unit" v-model="form.unit"
                                                        required=""
                                                        class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                                </div>

                                                <div class="col-span-6 sm:col-span-3">
                                                    <label for="code"
                                                        class="block text-sm font-medium text-gray-700">Code
                                                    </label>
                                                    <input type="text" name="code" id="code"
                                                        class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"
                                                        v-model="form.code" required="">

                                                </div>
                                                <div class="col-span-6 sm:col-span-3">
                                                    <label for="asset_id"
                                                        class="block text-sm font-medium text-gray-700">asset ID
                                                    </label>
                                                    <input type="number" name="asset_id" id="asset_id"
                                                        class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"
                                                        v-model="form.asset_id" required="">

                                                </div>



                                            </div>


                                            <div class="col-span-6 sm:col-span-3">
                                                <label for="category"
                                                    class="block text-sm font-medium text-gray-700">Category</label>

                                                <select
                                                    class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                                    v-model="form.category" required>
                                                    <option value="none" selected disabled hidden>
                                                        {{ form.category }}
                                                    </option>
                                                    <option>Water Rescue</option>
                                                    <option>Fire and Rescue</option>
                                                    <option>Protective Gears</option>

                                                </select>
                                            </div>




                                            <div class="col-span-6">
                                                <label for="asset_desc"
                                                    class="block text-sm font-medium text-gray-700">Asset
                                                    Description</label>
                                                <input type="text" name="asset_desc" id="asset_desc"
                                                    v-model="form.asset_desc" required=""
                                                    class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                            </div>

                                            <div class="col-span-6">
                                                <label for="remarks"
                                                    class="block text-sm font-medium text-gray-700">Remarks</label>
                                                <input type="text" name="remarks" id="remarks" v-model="form.remarks"
                                                    required=""
                                                    class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                            </div>





                                        </div>




                                    </div>
                                    <div class=" mr-7 flex justify-end">

                                        <button type="submit"
                                            class="inline-flex  justify-center rounded-md border border-transparent bg-orange-200 px-4 py-2 text-sm font-medium text-blue-900 hover:bg-blue-200 focus:outline-none focus-visible:ring-2 focus-visible:ring-blue-500 focus-visible:ring-offset-2">
                                            Add
                                        </button>
                                    </div>
                                </form>

                            </div>


                        </DialogPanel>
                    </TransitionChild>
                </div>
            </div>
        </Dialog>
    </TransitionRoot>
</template>
    
<script setup>
import { ref } from 'vue'
import { useForm } from '@inertiajs/inertia-vue3';
import {
    TransitionRoot,
    TransitionChild,
    Dialog,
    DialogPanel,
    DialogTitle,
} from '@headlessui/vue'

const form = useForm({
    date: '',
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
    unserviceable: null,
    poor: null
})

const handleSubmit = () => {
    form.post(route('municipality.inventory.store'), {
        onFinish: () => {
            form.reset()
            closeModal()

        },
        onSuccess: () => {
            form.reset()
        },
        onError: (e) => {
            alert(Object.values(e))
            form.clearErrors()
            closeModal()
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
const isOpen = ref(false)

function closeModal() {
    isOpen.value = false
}
function openModal() {
    isOpen.value = true
}

</script>
    