<template>
    <div @click="openModal">
        <button class="text-blue-400">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                stroke="currentColor" class="w-6 h-6">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M15 9h3.75M15 12h3.75M15 15h3.75M4.5 19.5h15a2.25 2.25 0 002.25-2.25V6.75A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25v10.5A2.25 2.25 0 004.5 19.5zm6-10.125a1.875 1.875 0 11-3.75 0 1.875 1.875 0 013.75 0zm1.294 6.336a6.721 6.721 0 01-3.17.789 6.721 6.721 0 01-3.168-.789 3.376 3.376 0 016.338 0z" />
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
                            class=" w-1/3  transform overflow-hidden rounded bg-white p-2 text-left align-middle shadow-xl transition-all">
                            <div class="content-box p-4">
                                <table class="table-auto rounded  w-full text-sm  text-gray-500 dark:text-gray-400">
                                    <caption>
                                        Municipality Info
                                    </caption>
                                    <tr class="max-h-full bg-white border-b dark:bg-gray-800 dark:border-gray-700">

                                        <th scope="col" class="py-3 px-10 text-orange-300 capitalize">
                                            Personnel
                                        </th>
                                        <td class="text-center">
                                            <address>
                                                {{ fullname(body.firstname, body.lastname, body.middlename, body.suffix) }}
                                            </address>

                                        </td>
                                    </tr>
                                    <tr class="max-h-full bg-white border-b dark:bg-gray-800 dark:border-gray-700">

                                        <th scope="col" class="py-3 px-10 text-orange-300 capitalize">
                                            Address
                                        </th>
                                        <td class="text-center">
                                            <address>
                                                {{ body.address }}
                                            </address>

                                        </td>
                                    </tr>
                                    <tr class="max-h-full bg-white border-b dark:bg-gray-800 dark:border-gray-700">

                                        <th scope="col" class="py-3 px-10 text-orange-300 capitalize">
                                            Contact
                                        </th>
                                        <td class="text-center">

                                            {{ body.contact }}


                                        </td>
                                    </tr>
                                </table>

                            </div>

                            <div class="mt-4 flex justify-center">

                                <button type="button"
                                    class="inline-flex justify-center rounded-md border border-transparent bg-blue-100 px-4 py-2 text-sm font-medium text-blue-900 hover:bg-blue-200 focus:outline-none focus-visible:ring-2 focus-visible:ring-blue-500 focus-visible:ring-offset-2"
                                    @click="closeModal">
                                    Got it, thanks!
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
import { reactive, ref } from 'vue'
import {
    TransitionRoot,
    TransitionChild,
    Dialog,
    DialogPanel,
    DialogTitle,
} from '@headlessui/vue'

const props = defineProps({
    body: Object

})
const fullname = (fname, lname, mname, suf) => {
            const f = fname ? fname :''
            const l = lname ? lname :''
            const m = mname ? mname.charAt(0) :''
            const s = suf ? suf :''

            return `${l} ${m} ${f} ${s}`;
        }
const isOpen = ref(false)

function closeModal() {

    isOpen.value = false
}
function openModal() {
    isOpen.value = true
}


const status = ref(true)

</script>
    