<template>
    <div @click="openModal">

        details

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


                                <form action="" method="POST">

                                    <div class="">
                                        <div class="px-4 py-5 bg-white sm:p-6">
                                            <div class="grid grid-cols-6 gap-6">
                                                <div class="col-span-6 sm:col-span-3">
                                                    <label for="equipment_name"
                                                        class="block text-sm font-medium text-gray-700">Equipment
                                                        Name</label>
                                                    <input type="text" name="equipment_name" id="equipment_name"
                                                        class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"
                                                        :value="form.equipment_name" required="">

                                                </div>

                                                <div class="col-span-6 sm:col-span-3">
                                                    <label for="status"
                                                        class="block text-sm font-medium text-gray-700">Status</label>
                                                    <select name="status" id="status"
                                                        class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"
                                                        required="">
                                                        <option value="status" selected disabled hidden>
                                                            {{ form.status }}
                                                        </option>
                                                        <option value="Serviceable">Serviceable</option>
                                                        <option value="Poor">Poor</option>
                                                        <option value="Unusable">Unusable</option>


                                                    </select>
                                                </div>



                                                <div class="col-span-6 sm:col-span-6 lg:col-span-2">
                                                    <label for="model_number"
                                                        class="block text-sm font-medium text-gray-700">Model
                                                        Number</label>
                                                    <input type="number" name="model_number" id="model_number"
                                                        :value="form.model_number" required=""
                                                        class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                                </div>



                                                <div class="col-span-6 sm:col-span-3 lg:col-span-2">
                                                    <label for="serial_number"
                                                        class="block text-sm font-medium text-gray-700">Serial
                                                        Number</label>
                                                    <input type="number" name="serial_number" id="serial_number"
                                                        :value="form.serial_number" required=""
                                                        class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                                </div>


                                                <div class="col-span-6 sm:col-span-3 lg:col-span-2">
                                                    <label for="unit"
                                                        class="block text-sm font-medium text-gray-700">Unit
                                                    </label>
                                                    <input type="number" name="unit" id="unit" :value="form.unit"
                                                        required=""
                                                        class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                                </div>

                                                <div class="col-span-6 sm:col-span-3">
                                                    <label for="code"
                                                        class="block text-sm font-medium text-gray-700">Code
                                                    </label>
                                                    <input type="text" name="code" id="code"
                                                        class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"
                                                        :value="form.code" required="">

                                                </div>
                                                <div class="col-span-6 sm:col-span-3">
                                                    <label for="asset_id"
                                                        class="block text-sm font-medium text-gray-700">asset ID
                                                    </label>
                                                    <input type="number" name="asset_id" id="asset_id"
                                                        class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"
                                                        :value="form.asset_id" required="">

                                                </div>



                                            </div>


                                            <div class="col-span-6 sm:col-span-3">
                                                <label for="category"
                                                    class="block text-sm font-medium text-gray-700">Category</label>
                                                <select id="category" name="category" required=""
                                                    class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                                    <option value="none" selected disabled hidden>
                                                        {{ form.category }}
                                                    </option>
                                                    <option value="Category1">Category 1</option>
                                                    <option value="Category2">Category 2</option>
                                                    <option value="Category3">Category 3</option>
                                                </select>
                                            </div>




                                            <div class="col-span-6">
                                                <label for="asset_desc"
                                                    class="block text-sm font-medium text-gray-700">Asset
                                                    Description</label>
                                                <input type="text" name="asset_desc" id="asset_desc"
                                                    :value="form.asset_desc" required=""
                                                    class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                            </div>

                                            <div class="col-span-6">
                                                <label for="remarks"
                                                    class="block text-sm font-medium text-gray-700">Remarks</label>
                                                <input type="text" name="remarks" id="remarks" :value="form.remarks"
                                                    required=""
                                                    class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                            </div>





                                        </div>




                                    </div>
                                </form>

                            </div>

                            <div class="mt-4">

                                <button type="submit" @click="closeModal"
                                    class="inline-flex justify-center rounded-md border border-transparent bg-blue-100 px-4 py-2 text-sm font-medium text-blue-900 hover:bg-blue-200 focus:outline-none focus-visible:ring-2 focus-visible:ring-blue-500 focus-visible:ring-offset-2">
                                    Okay
                                </button>
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
import {
    TransitionRoot,
    TransitionChild,
    Dialog,
    DialogPanel,
    DialogTitle,
} from '@headlessui/vue'

defineProps({
    form: Object
})
const isOpen = ref(false)

function closeModal() {
    isOpen.value = false
}
function openModal() {
    isOpen.value = true
}
</script>
    