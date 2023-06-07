<template>
    <div @click="openModal">
        <button class="text-blue-400" >
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
  <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" />
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
                            class="w-fit  transform overflow-hidden rounded bg-white p-2 text-left align-middle shadow-xl transition-all">
<span class="text-3xl font-semibold grid place-content-center mt-10 tracking-wider">{{ body.name }}</span>
                           <Edit-history :body="body" />

                          


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
import EditHistory from './EditHistory.vue';

const props = defineProps({
  body: Object

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
    