<template>
    <div @click="openModal">
        <button>
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                stroke="currentColor" class="w-6 h-6">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
            </svg>
        </button>
    </div>
    <TransitionRoot appear :show="isOpen" as="template">
        <Dialog as="div" @close="closeModal" class="relative z-50">
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
                            class="w-[600px]  transform overflow-hidden rounded-2xl bg-white p-6 text-left align-middle shadow-xl transition-all">
                            <DialogTitle as="h3" class="text-lg font-medium leading-6 text-gray-900 flex justify-end">
                                <button class="grid place-content-center hover:scale-110 hover:text-orange-500"
                                    @click="closeModal">
                                    <i class="fa-solid fa-x text-lg "></i>

                                </button>
                            </DialogTitle>
                            <div class="flex flex-col space-y-10">
                                <span class="text-xl font-semibold">
                                    Update Status
                                </span>

                                <form @submit.prevent="handleSubmit">
                                    <div class="flex flex-row space-x-6">
                                        <div class="mb-6">

                                            <label for="custom-input-number"
                                                class="w-full text-gray-700 text-sm font-semibold">Serviceable
                                            </label>
                                            <div
                                                class="flex flex-row h-10 w-full rounded-lg relative bg-transparent mt-1">
                                                <button type="button"
                                                    class=" bg-gray-300 text-gray-600 hover:text-gray-700 hover:bg-gray-400 h-full w-20 rounded-l cursor-pointer outline-none">
                                                    <span class="m-auto text-2xl font-thin"
                                                        @click="addNew.serviceable--">−</span>
                                                </button>
                                                <input type="number"
                                                    class="outline-none focus:outline-none text-center w-full bg-gray-300 font-semibold text-md hover:text-black focus:text-black  md:text-basecursor-default flex items-center text-gray-700  outline-none"
                                                    name="custom-input-number" v-model="addNew.serviceable" />
                                                <button type="button"
                                                    class="bg-gray-300 text-gray-600 hover:text-gray-700 hover:bg-gray-400 h-full w-20 rounded-r cursor-pointer">
                                                    <span class="m-auto text-2xl font-thin"
                                                        @click="addNew.serviceable++">+</span>
                                                </button>
                                            </div>

                                        </div>
                                        <div class="mb-6">

                                            <label for="custom-input-number"
                                                class="w-full text-gray-700 text-sm font-semibold">Poor
                                            </label>
                                            <div
                                                class="flex flex-row h-10 w-full rounded-lg relative bg-transparent mt-1">
                                                <button type="button"
                                                    class=" bg-gray-300 text-gray-600 hover:text-gray-700 hover:bg-gray-400 h-full w-20 rounded-l cursor-pointer outline-none">
                                                    <span class="m-auto text-2xl font-thin"
                                                        @click="addNew.poor--">−</span>
                                                </button>
                                                <input type="number"
                                                    class="outline-none focus:outline-none text-center w-full bg-gray-300 font-semibold text-md hover:text-black focus:text-black  md:text-basecursor-default flex items-center text-gray-700  outline-none"
                                                    name="custom-input-number" v-model="addNew.poor" />
                                                <button type="button"
                                                    class="bg-gray-300 text-gray-600 hover:text-gray-700 hover:bg-gray-400 h-full w-20 rounded-r cursor-pointer">
                                                    <span class="m-auto text-2xl font-thin"
                                                        @click="addNew.poor++">+</span>
                                                </button>
                                            </div>

                                        </div>
                                    </div>
                                    <div class="grid grid-flow-col place-content-center ">
                                        <div class="mb-6">

                                            <label for="custom-input-number"
                                                class="w-full text-gray-700 text-sm font-semibold">Unusable
                                            </label>
                                            <div
                                                class="flex flex-row h-10 w-full rounded-lg relative bg-transparent mt-1">
                                                <button type="button"
                                                    class=" bg-gray-300 text-gray-600 hover:text-gray-700 hover:bg-gray-400 h-full w-20 rounded-l cursor-pointer outline-none">
                                                    <span class="m-auto text-2xl font-thin"
                                                        @click="addNew.unserviceable--">−</span>
                                                </button>
                                                <input type="number"
                                                    class="outline-none focus:outline-none text-center w-full bg-gray-300 font-semibold text-md hover:text-black focus:text-black  md:text-basecursor-default flex items-center text-gray-700  outline-none"
                                                    name="custom-input-number" v-model="addNew.unserviceable" />
                                                <button type="button"
                                                    class="bg-gray-300 text-gray-600 hover:text-gray-700 hover:bg-gray-400 h-full w-20 rounded-r cursor-pointer">
                                                    <span class="m-auto text-2xl font-thin"
                                                        @click="addNew.unserviceable++">+</span>
                                                </button>
                                            </div>

                                        </div>
                                    </div>
                                    <button type="submit"
                                        class="text-white bg-orange-400 hover:bg-orange-500 focus:ring-4 focus:outline-none focus:ring-orange-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-orange-600 dark:hover:bg-orange-500 dark:focus:ring-orange-800">Add</button>
                                </form>

                            </div>

                            <div class="mt-4">

                                <slot name="footer" />
                                <!-- <button type="button"
                    class="inline-flex justify-center rounded-md border border-transparent bg-blue-100 px-4 py-2 text-sm font-medium text-blue-900 hover:bg-blue-200 focus:outline-none focus-visible:ring-2 focus-visible:ring-blue-500 focus-visible:ring-offset-2"
                    @click="closeModal">
                    Save
                  </button> -->

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
import axios from 'axios';
import { useToast } from "vue-toastification";
const props = defineProps({
    detail_id: String
})
const toast = useToast();
const addNew = ref({
    serviceable: 0,
    poor: 0,
    unserviceable: 0,
})
 function handleSubmit(){
axios.get('/api/add-quantity/'+ props.detail_id, {params: {
    serviceable: addNew.value.serviceable,
    poor: addNew.value.poor,
    unserviceable: addNew.value.unserviceable
}}).then((res) =>{
        toast.success('Quantity Added')
})
 }
const isOpen = ref(false)


function closeModal() {
    isOpen.value = false
}
function openModal() {
    isOpen.value = true
}
</script>
<style scoped>
input[type='number']::-webkit-inner-spin-button,
input[type='number']::-webkit-outer-spin-button {
    -webkit-appearance: none;
    margin: 0;
}

.custom-number-input input:focus {
    outline: none !important;
}

.custom-number-input button:focus {
    outline: none !important;
}
</style>
    