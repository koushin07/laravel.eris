<template>
  <div @click="openModal">
    <slot name='trigger'></slot>


  </div>
  <TransitionRoot appear :show="isOpen" as="template">
    <Dialog as="div" @close="closeModal" class="relative z-50">
      <TransitionChild as="template" enter="duration-300 ease-out" enter-from="opacity-0" enter-to="opacity-100"
        leave="duration-200 ease-in" leave-from="opacity-100" leave-to="opacity-0">
        <div class="fixed inset-0 bg-black bg-opacity-25" />
      </TransitionChild>

      <div class="fixed h-full inset-0 overflow-y-auto">
        <div class="flex min-h-full items-center justify-center p-4 text-center">
          <TransitionChild as="template" enter="duration-300 ease-out" enter-from="opacity-0 scale-95"
            enter-to="opacity-100 scale-100" leave="duration-200 ease-in" leave-from="opacity-100 scale-100"
            leave-to="opacity-0 scale-95">
            <DialogPanel
              class="w-fit  transform overflow-hidden rounded bg-white p-6 text-left align-middle shadow-xl transition-all">
              <DialogTitle as="h3" class="text-lg font-medium leading-6 text-gray-900 flex justify-end">
                <button class="grid place-content-center hover:scale-110 hover:text-orange-500" @click="closeModal">
                  <i class="fa-solid fa-x text-lg "></i>

                </button>
              </DialogTitle>
              <div class="flex flex-col gap-22" style="font-family:Arial, sans-serif">

                <div class="flex flx-row justify-between mt-11 border-b">

                  <div class="flex flex-col box-content ">

                    <input disabled :value="props.incident"
                      class="focus:outline-none text-2xl  font-bold tracking-wider placeholder-stone-300"
                      placeholder="Write your Incident Here" />
                    <input class="focus:outline-none text-sm placeholder-stone-300" :value="props.incident_summary"
                      placeholder="Brief Summary" disabled />
                  </div>

                </div>
                <div class="flex flex-col mt-11">
                  <div class="flex flex-row space-x-10">
                    <div class="relative z-0 mb-6 w-full group">


                      <LocalTransactions @submitted="getSubmit" :equipments="props.equipments"
                        :provinces="props.provinces" :incident="props.incident" />

                    </div>
                  </div>
                </div>



              </div>

              <div class="mt-4">




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
import LocalTransactions from './LocalTransactions.vue';
import { useToast } from "vue-toastification";
import axios from 'axios';
import { Inertia } from '@inertiajs/inertia';


const emit = defineEmits(['request'])
const props = defineProps({
  detail: String,
  incident: String,
  incident_summary: String,
  equipments: Object,
  provinces: Object,

})

const toast = useToast();
const incident = ref('')
const incident_summary = ref('')
if (props.incident) {
  incident.value = props.incident
}
if (props.incident_summary) {
  incident_summary.value = props.incident_summary
}


const isOpen = ref(false)

function getSubmit(form) {
  console.log('this is form ', form);
  axios.post('/api/new-request', {
    equipment: form.equipment,
    detail: props.detail,
    quantity: form.quantity,
    municipality_id: form.municipality_id
  }).then((res) => {
    Inertia.reload();
  })

}

function closeModal() {
  isOpen.value = false
}
function openModal() {
  isOpen.value = true
}
function submit() {

  incident.value = ''
  incident_summary.value = ''
  emit('request', incident.value)
  closeModal()
}

</script>
<style scoped>

</style>
      