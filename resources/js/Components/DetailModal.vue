<template>
    <div @click="fetchEquipment">
        <button class="text-blue-400" >
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
                            class="w-fit  transform overflow-hidden rounded bg-white p-2 text-left align-middle shadow-xl transition-all">

                            <div class="flex flex-row justify-between p-2">
                                <span class="text-lg font-bold">{{ props.incident }}</span>


                            </div>

                            <table class="table-auto pt-2 w-full text-sm border-x text-gray-500 dark:text-gray-400"
                                v-if="status">
                                <thead
                                    class="text-xs text-gray-700 text-center uppercase bg-header dark:bg-gray-700 dark:text-gray-400">
                                    <tr>
                                        <th scope="col" class="py-3 px-10 capitalize                " v-for="(head, key) in tableHeader"
                                            :key="key">
                                            {{ head.name }}
                                        </th>

                                    </tr>
                                </thead>
                                <tbody>
                                    <tr class="max-h-full even:bg-gray-200  bg-white border-b dark:bg-gray-800 dark:border-gray-700"
                                        v-for="(body, key) in equipments">
                                        <td scope="row" class="text-center p-4">
                                            {{ body.name }}
                                        </td>
                                        <td class="text-center">
                                            {{ body.municipality }}
                                        </td>
                                        <td class="text-center ">
                                            <span class="text-green-500 " v-if="body.status === 'accepted'">
                                                {{ body.status }}
                                            </span>
                                            <span class="text-red-500 " v-if="body.status === 'denied'">
                                                {{ body.status }}
                                            </span>
                                            <span class="text-gray-500 " v-if="body.status === 'pending'">
                                                {{ body.status }}
                                            </span>

                                        </td>
                                        <td class="text-center">
                                            {{ body.quantity }}
                                        </td>
                                        <!-- <td class="text-center">
                                            {{ body.incident }}
                                        </td> -->
                                        <td class="text-center">
                                            {{ body.contact }}
                                        </td>
                                        <td class="text-center">
                                            {{ body.address }}
                                        </td>
                                        <td class="text-center">
                                            {{ body.owner }}
                                        </td>
                                        <td class="text-center">
                                            <add-incident :detail="props.detail" :equipments="equipments" :incident="body.incident"  :incident_summary="body.incident_summary" :provinces="provinces">
                                                <template #trigger>
                                                    <button
                                                        class=" text-green-500 ">
                                                        <span class="text-center">add</span>
                                                       
                                                    </button>

                                                </template>
                                            </add-incident>
                                        </td>

                                    </tr>

                                </tbody>
                            </table>


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
import StatusCard from './Transactions/StatusCard.vue';
import axios from 'axios';
import AddIncident from './AddIncident.vue';

const props = defineProps({
    incident: String,
    detail: String,
    name: String,
    equipments: Object,
    provinces: Object,

})

const emit = defineEmits(['submit'])
const isOpen = ref(false)
const quantity = ref(null)
const equipments = ref({})
const fetchEquipment = () => {
    console.log(props.detail);
    axios.get('/api/requestEquip/' + props.detail).then((res) => {
        equipments.value = res.data
        console.log(res.data);
        openModal()
    })

}
// console.log(props.equipments);
// const incident = ref(props.equipments)
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

} const tableHeader = [
    { name: 'equipment' },
    { name: 'municipality' },
    { name: 'status' },
    { name: 'borrowed quantity' },
    { name: 'contact' },
    { name: 'address' },
    { name: 'personel' },
    { name: 'action' },

]

const status = ref(true)

</script>
    