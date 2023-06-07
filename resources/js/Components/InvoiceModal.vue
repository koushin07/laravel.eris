<template>
    <div @click="openModal">
        <button class=" border-2 rounded px-2 w-fit py-1 text-sky-900 font-semibold border-sky-900">Export
            Inventory</button>
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
                            class="w-full  transform overflow-hidden rounded bg-white text-left align-middle shadow-xl transition-all">
                            <DialogTitle as="h3" class="text-lg font-medium leading-6 text-gray-900 flex justify-end">
                                <button class="grid mt-2 mr-2 place-content-center hover:scale-110 hover:text-orange-500"
                                    @click="closeModal">
                                    <i class="fa-solid fa-x text-lg "></i>

                                </button>
                            </DialogTitle>


                            <Invoice />


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
import LocalTransactions from './LocalTransactions.vue';
import Invoice from '@/Components/Invoice.vue'
import {
    TransitionRoot,
    TransitionChild,
    Dialog,
    DialogPanel,
    DialogTitle,
} from '@headlessui/vue'



const isOpen = ref(false)

function closeModal() {
    // emit('selected', incident.value)
    isOpen.value = false
}
function openModal() {
    isOpen.value = true
}
</script>
<style>
</style>
      