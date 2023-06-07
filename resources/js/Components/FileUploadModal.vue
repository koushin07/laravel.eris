<template>
    <div @click="openModal">
<button>
    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
        class="w-6 h-6">
        <path stroke-linecap="round" stroke-linejoin="round"
            d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5M16.5 12L12 16.5m0 0L7.5 12m4.5 4.5V3" />
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
                            <div class="grid place-content-center">
                                <div class="max-w-xl">
                                    <label @dragover.prevent="hover = true" @drop.prevent
                                        @dragleave.prevent="hover = false" :class="hover ? 'border-gray-400' : ''"
                                        class="flex flex-col  justify-evenly w-full h-32 px-4 transition bg-white border-2 border-gray-300 border-dashed rounded-md appearance-none cursor-pointer hover:border-gray-400 focus:outline-none">
                                        <span class="flex items-center space-x-2" @drop="drop">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-gray-600"
                                                fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" />
                                            </svg>
                                            <span class="font-medium text-gray-600">
                                                Drop Incident Report to Attach, or
                                                <span class="text-blue-600 underline">browse</span>
                                            </span>
                                        </span>


                                        <input type="file" name="docs" @input="incident.docs = $event.target.files[0]"
                                            class="hidden">
                                    </label>
                                    <div class=" mt-5 flex flex-row justify-between rounded-lg bg-green-400 p-3 animate-fade-in-down"
                                        v-if="incident.docs">
                                        <span class="font-semibold text-sm">{{ incident.docs.name }}</span>
                                        <i class="fa-solid fa-x text-sm text-center h-3 hover:scale-110"
                                            @click="resetDocs"></i>
                                    </div>
                                    <div class="flex justify-end col-span-2 pt-5  animate-fade-in-down"
                                        v-if="incident.docs">
                                        <button @click="submitReport"
                                            class="bg-orange-500 px-5 text-sm py-2 rounded-xl  hover:bg-orange-700 ">save</button>

                                    </div>
                                </div>
                            </div>


                            <div class="mt-4">

                                <slot name="footer" />


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
import { useToast } from "vue-toastification";

const props = defineProps({
    detail_id: String
})

const incident = useForm({
    id: props.detail_id,
    docs: '',

})
const toast = useToast();

const drop = (e) => {
    incident.docs = e.dataTransfer.files[0]
    console.log(e.dataTransfer.files)
    console.log(incident.docs)
}
const submitReport = async () => {

    incident.post(route('municipality.incident.store'), {
        forceFormData: true,
        onError: (e) => {
            console.log(e)
        },
        onSuccess: () => {
            toast.success('Report submitted')
            open.value = false
            incident.reset('id', 'docs')
            closeModal()
        }


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
    