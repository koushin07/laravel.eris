<template>
    <div @click="openModal">

        Create Form

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
                            <DialogTitle as="h3" class="text-lg font-medium leading-6 text-gray-900">
                                Equipmet Details
                            </DialogTitle>
                            <div class="mt-2">


                                <form @submit.prevent="submit">

                                    <div class="px-4 py-5 bg-white sm:p-6">
                                        <div class="grid grid-cols-6 gap-6">
                                            <div class="col-span-12 sm:col-span-6 w-full">
                                                <label for="equipment_name"
                                                    class="block text-sm font-medium text-gray-700">Equipment
                                                    Name</label>
                                                <input type="text" name="equipment_name" id="equipment_name"
                                                    vModel="form.equipment_name"
                                                    class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"
                                                    required="">
                                                <InputError class="mt-2" :message="form.errors.equipment_name" />

                                            </div>

                                            <!-- <div class="col-span-6 sm:col-span-3">
                                                <label for="status"
                                                    class="block text-sm font-medium text-gray-700">Status</label>
                                                <select name="status" id="status" v-model="form.status"
                                                    class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"
                                                    required="">
                                                    <option value="status" selected hidden>

                                                    </option>
                                                    <option value="Serviceable">Serviceable</option>
                                                    <option value="Poor">Poor</option>
                                                    <option value="Unusable">Unusable</option>


                                                </select>
                                                <InputError class="mt-2" :message="form.errors.status" />
                                            </div> -->


                                            <div class="col-span-6 sm:col-span-6 lg:col-span-2">
                                                <label for="serviceable"
                                                    class="block text-sm font-medium text-gray-700">Seriveable</label>
                                                <input type="number" name="serviceable" id="serviceable" required=""
                                                    vModel="form.serviceable"
                                                    class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                                <InputError class="mt-2" :message="form.errors.serviceable" />
                                            </div>
                                            <div class="col-span-6 sm:col-span-6 lg:col-span-2">
                                                <label for="unusable"
                                                    class="block text-sm font-medium text-gray-700">Unusable</label>
                                                <input type="number" name="unusable" id="unusable" required=""
                                                    vModel="form.unusable"
                                                    class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                                <InputError class="mt-2" :message="form.errors.unusable" />
                                            </div>



                                            <div class="col-span-6 sm:col-span-3 lg:col-span-2">
                                                <label for="poor"
                                                    class="block text-sm font-medium text-gray-700">Poor</label>
                                                <input type="number" name="poor" id="poor"
                                                    vModel="form.poor"
                                                    class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                                <InputError class="mt-2" :message="form.errors.poor" />
                                            </div>

                                            <div class="col-span-6 sm:col-span-6 lg:col-span-2">
                                                <label for="model_number"
                                                    class="block text-sm font-medium text-gray-700">Model
                                                    Number</label>
                                                <input type="number" name="model_number" id="model_number" required=""
                                                    vModel="form.model_number"
                                                    class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                                <InputError class="mt-2" :message="form.errors.model_number" />
                                            </div>
                                            <div class="col-span-6 sm:col-span-6 lg:col-span-2">
                                                <label for="asset_id"
                                                    class="block text-sm font-medium text-gray-700">asset ID</label>
                                                <input type="number" name="asset_id" id="asset_id" required=""
                                                    vModel="form.asset_id"
                                                    class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                                <InputError class="mt-2" :message="form.errors.asset_id" />
                                            </div>



                                            <div class="col-span-6 sm:col-span-3 lg:col-span-2">
                                                <label for="serial_number"
                                                    class="block text-sm font-medium text-gray-700">Serial
                                                    Number</label>
                                                <input type="number" name="serial_number" id="serial_number"
                                                    vModel="form.serial_number"
                                                    class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                                <InputError class="mt-2" :message="form.errors.serial_number" />
                                            </div>


                                            <div class="col-span-6 sm:col-span-3 lg:col-span-2">
                                                <label for="unit" class="block text-sm font-medium text-gray-700">Unit
                                                </label>
                                                <input type="number" name="unit" id="unit" vModel="form.unit"
                                                    class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                                <InputError class="mt-2" :message="form.errors.unit" />
                                            </div>

                                            <div class="col-span-6 sm:col-span-3">
                                                <label for="code" class="block text-sm font-medium text-gray-700">Code
                                                </label>
                                                <input type="text" name="code" id="code" vModel="form.code"
                                                    class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                                <InputError class="mt-2" :message="form.errors.code" />

                                            </div>
                                            



                                        </div>


                                        <div class="col-span-6 sm:col-span-3">
                                            <label for="category"
                                                class="block text-sm font-medium text-gray-700">Category</label>
                                            <select id="category" name="category" required="" v-model="form.category"
                                                class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                                <option value="none" selected hidden>

                                                </option>
                                                <option value="Category1">Category 1</option>
                                                <option value="Category2">Category 2</option>
                                                <option value="Category3">Category 3</option>
                                            </select>
                                            <InputError class="mt-2" :message="form.errors.category" />
                                        </div>




                                        <div class="col-span-6">
                                            <label for="asset_desc"
                                                class="block text-sm font-medium text-gray-700">Asset
                                                Description</label>
                                            <input type="text" name="asset_desc" id="asset_desc" required=""
                                                vModel="form.asset_desc"
                                                class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                            <InputError class="mt-2" :message="form.errors.asset_desc" />
                                        </div>

                                        <div class="col-span-6">
                                            <label for="remarks"
                                                class="block text-sm font-medium text-gray-700">Remarks</label>
                                            <input type="text" name="remarks" id="remarks" required=""
                                                vModel="form.remarks"
                                                class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                            <InputError class="mt-2" :message="form.errors.remarks" />
                                        </div>
                                    </div>

                                    <button type="submit"
                                        class="inline-flex justify-center rounded-md border border-transparent bg-blue-100 px-4 py-2 text-sm font-medium text-blue-900 hover:bg-blue-200 focus:outline-none focus-visible:ring-2 focus-visible:ring-blue-500 focus-visible:ring-offset-2">
                                        Save
                                    </button>

                                </form>

                            </div>

                            <div class="mt-4">


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
import InputError from '@/Components/InputError.vue';

let form = useForm({
    equipment_name: '',
    status: '',
    model_number: '',
    serial_number: '',
    unit: '',
    code: '',
    asset_id: '',
    category: '',
    asset_desc: '',
    remarks: '',
    serviceable: '',
    unusable: '',
    poor: '',
});

const submit = () => {

    console.log(form)
    form.post(route('equipment.store'), {
        onSuccess: () => {
            alert('yey')
            isOpen.value = false
            form.reset()

        },

    })
};
const isOpen = ref(false)

function closeModal() {
    isOpen.value = false
}
function openModal() {
    isOpen.value = true
}
</script>
    