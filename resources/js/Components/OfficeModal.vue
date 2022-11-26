<template>
    <div @click="openModal">
        <button class="text-blue-400">
            Re-assign

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

                            <div class="grid grid-flow-row gap-5">
                                <v-select  :options="provinces" v-model="province" label="province"></v-select>
                                <input type="text" name="quantity" class="rounded-full text-center"
                                    placeholder="Personel" v-model="person" />
                            </div>

                            <div class="mt-4 grid place-content-center">
                                <button type="button"
                                    class="inline-flex justify-center rounded-md border border-transparent bg-orange-300 px-4 py-2 text-sm font-medium  hover:bg-orange-400 focus:outline-none focus-visible:ring-2 focus-visible:ring-blue-500 focus-visible:ring-offset-2"
                                    @click="submit">
                                    update
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
import ProvinceList from './Lists/ProvinceList.vue';
const props = defineProps({
    muni: Object,
    provinces: Object
})

const emit = defineEmits(['submit'])
const isOpen = ref(false)
const province = ref()
function closeModal() {

    isOpen.value = false
}
function openModal() {
    isOpen.value = true
}
function submit() {
    emit('submit', quantity, props.muni, person.value)
    closeModal()
}

</script>
    