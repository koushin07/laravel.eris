<template>
    <div @click="openModal">
        <button class="text-blue-400">
            details
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
                            class="w-full max-w-md transform overflow-hidden rounded-2xl bg-white p-6 text-left align-middle shadow-xl transition-all">

                            <DialogTitle as="h3" class="flex flex-row justify-end mx-4">

                                <button class=" flex justify-end text-e hover:scale-110 hover:text-orange-500"
                                    @click="closeModal">
                                    <i class="fa-solid fa-x text-lg"></i>

                                </button>

                            </DialogTitle>
                            <StatusCard/>


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
import StatusCard from './Transactions/StatusCard.vue';
const props = defineProps({
    muni: Object
})

const emit = defineEmits(['submit'])
const isOpen = ref(false)
const quantity = ref(null)
function closeModal() {

    isOpen.value = false
}
function openModal() {
    isOpen.value = true
}
function submit() {
    // console.log(props.muni.quantity, quantity.value);
    if (props.muni.quantity >= quantity.value) {
        emit('submit', quantity, props.muni)
        closeModal()
    }
    else {
        alert('only ' + props.muni.quantity + ' is available')
    }

}

</script>
    