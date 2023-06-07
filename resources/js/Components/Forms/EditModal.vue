<template>
    <div @click="openModal">
        <button>
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                stroke="currentColor" class="w-6 h-6">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" />
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
                            class="w-full max-w-md transform overflow-hidden rounded-2xl bg-white p-6 text-left align-middle shadow-xl transition-all">
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

                                                <div class="col-span-6 flex flex-col border p-2 rounded">
                                                    <span class="text-base text-slate-500 pb-2">Quantity: {{
                                                            quantity
                                                    }} </span>
                                                    <div class="flex flex-row space-x-6 ">
                                                        <div class="col-span-6 sm:col-span-6 lg:col-span-2">
                                                            <label for="model_number"
                                                                class="block text-sm font-medium text-gray-700">Serviceable</label>
                                                            <input type="number" name="model_number" id="model_number"
                                                                v-model="updateForm.serviceable" required=""
                                                                :class="updateForm.serviceable > quantity ? 'border-red' : ''"
                                                                class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                                        </div>
                                                        <div class="col-span-6 sm:col-span-6 lg:col-span-2">
                                                            <label for="model_number"
                                                                class="block text-sm font-medium text-gray-700">Unusable</label>
                                                            <input type="number" name="model_number" id="model_number"
                                                                v-model="updateForm.unserviceable" required=""
                                                                :class="updateForm.unserviceable > quantity ? 'border-red' : ''"
                                                                class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                                        </div>
                                                        <div class="col-span-6 sm:col-span-6 lg:col-span-2">
                                                            <label for="model_number"
                                                                class="block text-sm font-medium text-gray-700">Poor</label>
                                                            <input type="number" name="model_number" id="model_number"
                                                                v-model="updateForm.poor" required=""
                                                                class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                                        </div>
                                                    </div>
                                                </div>


                                                <div class="col-span-6 sm:col-span-6 lg:col-span-2">
                                                    <label for="model_number"
                                                        class="block text-sm font-medium text-gray-700">Model
                                                        Number</label>
                                                    <input type="text" name="model_number" id="model_number"
                                                        v-model="updateForm.model_number" required=""
                                                        class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                                </div>



                                                <div class="col-span-6 sm:col-span-3 lg:col-span-2">
                                                    <label for="serial_number"
                                                        class="block text-sm font-medium text-gray-700">Serial
                                                        Number</label>
                                                    <input type="text" name="serial_number" id="serial_number"
                                                        v-model="updateForm.serial_number" required=""
                                                        class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                                </div>


                                                <div class="col-span-6 sm:col-span-3 lg:col-span-2">
                                                    <label for="unit"
                                                        class="block text-sm font-medium text-gray-700">Unit
                                                    </label>
                                                    <input type="number" name="unit" id="unit" v-model="updateForm.unit"
                                                        required=""
                                                        class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                                </div>

                                                <div class="col-span-6 sm:col-span-3">
                                                    <label for="code"
                                                        class="block text-sm font-medium text-gray-700">Code
                                                    </label>
                                                    <input type="text" name="code" id="code"
                                                        class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"
                                                        v-model="updateForm.code" required="">

                                                </div>
                                                <div class="col-span-6 sm:col-span-3">
                                                    <label for="asset_id"
                                                        class="block text-sm font-medium text-gray-700">asset ID
                                                    </label>
                                                    <input type="text" name="asset_id" id="asset_id"
                                                        class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"
                                                        v-model="updateForm.asset_id" required="">

                                                </div>



                                            </div>


                                            <div class="col-span-6 sm:col-span-3">
                                                <label for="category"
                                                    class="block text-sm font-medium text-gray-700">Category</label>

                                                <select
                                                    class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                                    v-model="updateForm.category" required>
                                                    <option value="none" selected disabled hidden>
                                                        {{ updateForm.category }}
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
                                                    v-model="updateForm.asset_desc" required=""
                                                    class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                            </div>

                                            <div class="col-span-6">
                                                <label for="remarks"
                                                    class="block text-sm font-medium text-gray-700">Remarks</label>
                                                <input type="text" name="remarks" id="remarks"
                                                    v-model="updateForm.remarks" required=""
                                                    class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                            </div>





                                        </div>




                                    </div>
                                    <div class=" mr-7 flex justify-end">

                                        <button type="submit"
                                            class="inline-flex  justify-center rounded-md border border-transparent bg-orange-200 px-4 py-2 text-sm font-medium text-blue-900 hover:bg-blue-200 focus:outline-none focus-visible:ring-2 focus-visible:ring-blue-500 focus-visible:ring-offset-2">
                                            Update
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
import { ref, computed, watch } from 'vue'
import { useForm } from '@inertiajs/inertia-vue3';
import {
    TransitionRoot,
    TransitionChild,
    Dialog,
    DialogPanel,
    DialogTitle,
} from '@headlessui/vue'

const props = defineProps({
    form: Object
})

const updateForm = useForm({
    attrs: props.form.attrs_id,
    detail_id: props.form.detail_id,
    code: props.form.code,
    asset_desc: props.form.asset_desc,
    category: props.form.category,
    unit: props.form.unit,
    model_number: props.form.model_number,
    serial_number: props.form.serial_number,
    asset_id: props.form.asset_id,
    remarks: props.form.remarks,
    serviceable: props.form.serviceable,
    unserviceable: props.form.unserviceable,
    poor: props.form.poor
})

// function quantity(serviceable, poor, unserviceable) {
//     return serviceable + poor + unserviceable
// }
const qty = ref( )
const quantity = computed(() => {
    return props.form.serviceable + props.form.unserviceable + props.form.poor
})
function handleSubmit() {
   
    if ( updateForm.serviceable + updateForm.unserviceable + updateForm.poor <= quantity.value) {
        updateForm.put(route('municipality.inventory.update', props.form.id), {
            onSuccess: (e) => {
                closeModal()
            },
            onError: (e) => {
                alert(Object.values(e))


            },
        })
    }else{
        alert('Quantity Exceed')
    }

}

const isOpen = ref(false)

function closeModal() {
    isOpen.value = false
}
function openModal() {
    isOpen.value = true
}

</script>
    