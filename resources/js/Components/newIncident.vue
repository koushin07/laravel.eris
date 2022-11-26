<template>
  <div @click="openModal">
    <button class="text-lg text-white font-semibold bg-button w-fit px-4 py-1">
      <span v-if="props.name === 'New'" class="mr-2">New</span>
      <i class="fa-solid fa-plus" v-if="props.name === 'New'"></i>
      <i class="fa-regular fa-pen-to-square" v-else></i>

    </button>

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
                <!-- <div class="flex flex-col">
                  <span class="text-center text-3xl font-bold ">Municipality </span>
                  <span class="text-3xl text-center ">
                    {{ $page.props.auth.user.name }}
                  </span>
                </div> -->
                <div class="flex flx-row justify-between mt-11 border-b">

                  <div class="flex flex-col box-content ">

                    <input class="focus:outline-none text-2xl font-bold tracking-wider" value="Incident" />
                    <input class="focus:outline-none text-sm" value="incident detail" />
                  </div>

                </div>
                <div class="flex flex-col mt-11">
                  <div class="flex flex-row space-x-10">
                    <div class="relative z-0 mb-6 w-full group">
                     
                      
                      <!-- <input type="email" name="equipment" 
                        class="block py-2.5 px-0  text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer"
                        placeholder=" " required />
                      <label for="equipment"
                        class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">
                        Equipment</label> -->
                      <!-- <div class="grid grid-rows-2 gap-2">
                        <div class="my-1">
                          <label class="text-sm w-full">Equipment</label>
                          <v-select :options="props.equipments" label="name" />
                        </div>
                        <div class="my-1">
                          <label class="text-sm">Province</label>
                          <v-select :options="props.provinces" label="name" />
                        </div>


                      </div> -->
                      <LocalTransactions @submitted="getSubmit" :equipments="props.equipments"
                        :provinces="props.provinces" :incident="props.incident" />

                    </div>
                  </div>
                </div>



              </div>

              <div class="mt-4">


                <div class="mt-4 grid place-content-center">
                  <button type="button"
                    class="inline-flex justify-center rounded-md border border-transparent bg-orange-300 px-4 py-2 text-sm font-medium  hover:bg-orange-400 focus:outline-none focus-visible:ring-2 focus-visible:ring-blue-500 focus-visible:ring-offset-2"
                    @click="submit">
                    Request
                  </button>
                </div>

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
import { emitter } from '@/Composables/useEventBus'
import useFetchMunicipality from '@/Composables/useFetchMunicipality'
import {
  TransitionRoot,
  TransitionChild,
  Dialog,
  DialogPanel,
  DialogTitle,
} from '@headlessui/vue'
import LocalTransactions from './LocalTransactions.vue';

const emit = defineEmits(['request'])
const props = defineProps({
  name: String,
  equipments: Object,
  provinces: Object
})
const {  getLocalMunicipality } = useFetchMunicipality()

const incident = ref('')

const isOpen = ref(false)

function getSubmit(form) {
  emit('submit', form)
  // console.log('submit', form);
}

function closeModal() {
  incident.value = ''

  isOpen.value = false
}
function openModal() {
  isOpen.value = true
}
function submit() {

  emit('request', incident.value)
  closeModal()
}
console.log(props.provinces);
// const convertedProvince = Object.values(props.provinces).map((c) => c.name)
// const convertedEquipment = Object.values(props.equipments).map((c) => c.name)
      
async function search() {
 
    if (requests.value.equipment.length !== 0) {
      await getLocalMunicipality(requests.value)
    }

  
}
</script>
<style scoped>

</style>
    