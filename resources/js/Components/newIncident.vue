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
              class="w-[1000px] transform overflow-hidden rounded bg-white p-6 text-left align-middle shadow-xl transition-all">
              <DialogTitle as="h3" class="text-lg font-medium leading-6 text-gray-900 flex justify-end">
                <button class="grid place-content-center hover:scale-110 hover:text-orange-500" @click="closeModal">
                  <i class="fa-solid fa-x text-lg "></i>

                </button>
              </DialogTitle>
              <div class="flex flex-col gap-22" style="font-family:Arial, sans-serif">
                <div class="flex justify-end">
                  <Datepicker v-model="form.date" show-now-button />
             
                  
                </div>
                <div class="flex flx-col justify-between mt-11 border-b">

                  <div class="flex flex-col box-content  w-full">
                    <div class="flex flex-row justify-between">
                      <input v-model="form.incidents"
                        class="focus:outline-none text-2xl  font-bold tracking-wider placeholder-stone-300"
                        placeholder="Write your Subject Here" />
                     
                    </div>


                  </div>

                </div>
                <div class="flex flex-col box-content p-3 h-full w-full">
                  <textarea v-model="form.incident_summary" class="focus:outline-none rounded active:outline-none text-sm placeholder-stone-300"
                      placeholder="Brief Summary" />
                </div>
              <div class="flex flex-row justify-end">
                <button @click="newIncident" class="bg-orange-400 text-white rounded px-2 py-1 text-lg ">Create</button>
              </div>

                <!-- <div class="flex flex-col mt-11">
                  <div class="flex flex-row space-x-10">
                    <div class="relative z-0 mb-6 w-full group">


                      <LocalTransactions @submitted="getSubmit" :equipments="props.equipments"
                        :provinces="props.provinces" :incident="props.incident" />

                    </div>
                  </div>
                </div> -->



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
import { useForm } from '@inertiajs/inertia-vue3';
import axios from 'axios';
import { Inertia } from '@inertiajs/inertia';


const emit = defineEmits(['request'])
const props = defineProps({
  add: Boolean,
  incident: String,
  incident_summary: String,
  equipments: Object,
  provinces: Object,

})

const toast = useToast();
const incident = ref('')
const incident_summary = ref('')
const date = ref(new Date().toLocaleString())
const form = useForm({
  incidents: '', 
  incident_summary: '',
  date: new Date().toLocaleString()
})

const isOpen = ref(false)

// function getSubmit(form) {

//   form.incidents = incident.value
//   form.incident_summary = incident_summary.value
//   form.date = date.value

//   form.post('/api/request', {
//     onSuccess:()=>{
      
//       closeModal()
//     },

//     onError: (error) => {
//       Object.keys(error).map((e) => toast.info('please recheck ' + e + '!'))

//     },
    
    
//   })





//   // emit('submit', form)
//   // console.log('submit', form);
// }


function newIncident(){
  form.post('/municipality/new-incident',{
    preserveScroll: true,
    onSuccess: () => {
      Inertia.reload()
      closeModal()
    }
  })
  // await axios.post('/municipality/new-incident',{
  //   incidents: incident.value,
  //   incident_summary: incident_summary.value,
  //   date: date.value
  // }).then((res)=>console.log(res))
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
    