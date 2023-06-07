<template>
    <div @click="openModal">
        <button class="border rounded-md text-sm px-4">
            Filter
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
                            class="grid place-content-center w-full max-w-md transform overflow-hidden rounded-2xl bg-slate-50 p-6 text-left align-middle shadow-xl transition-all">

                            <v-select multiple :options="convertedProvince" v-model="requests.provinces" label="name">
                            </v-select>



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

const emit = defineEmits(['submit'])

const props = defineProps({
    equipment: Object,
    provinces: Object,
    municipalities: Object,
})
const isOpen = ref(false)

const convertedProvince = Object.values(props.provinces).map((c) => c.name)
const convertedEquipment = Object.values(props.equipment).map((c) => c.name)

function closeModal() {

    isOpen.value = false
}
function openModal() {
    isOpen.value = true
}
function submit() {

}

</script>
    