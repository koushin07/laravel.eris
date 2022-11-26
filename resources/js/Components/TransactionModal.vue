<template>
    <div @click="openModal">
      <button class="bg-"></button>
     Request
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
                class="w-[1000px]  transform overflow-hidden rounded-2xl bg-white p-6 text-left align-middle shadow-xl transition-all">
                <DialogTitle as="h3" class="text-lg font-medium leading-6 text-gray-900 flex justify-end">
                  <button class="grid place-content-center hover:scale-110 hover:text-orange-500" @click="closeModal">
                    <i class="fa-solid fa-x text-lg "></i>
  
                  </button>
                </DialogTitle>
                <div class="mt-4">
                      <LocalTransactions
                      @submitted="getSubmit" :equipments="props.equipments" :provinces="props.provinces" :incident="props.incident" />
                      
                </div>
  
                <div class="mt-4">
  
  
                  <div class="mt-4 grid place-content-center">
                  <!-- <button type="button"
                    class="inline-flex justify-center rounded-md border border-transparent bg-orange-300 px-4 py-2 text-sm font-medium  hover:bg-orange-400 focus:outline-none focus-visible:ring-2 focus-visible:ring-blue-500 focus-visible:ring-offset-2"
                    @click="closeModal">
                    Crea
                  </button> -->
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
  import LocalTransactions from './LocalTransactions.vue';
  import {
    TransitionRoot,
    TransitionChild,
    Dialog,
    DialogPanel,
    DialogTitle,
  } from '@headlessui/vue'
  
  const props = defineProps({
  
    equipments: Object,
    provinces: Object,
    incident: String,
  })
  const incident = ref('')
  const isOpen = ref(false)
  const emit = defineEmits(['submit'])
  function closeModal() {
    // emit('selected', incident.value)
    isOpen.value = false
  }
  function getSubmit(form){
    emit('submit', form)
    // console.log('submit', form);
  }
  function openModal() {
    isOpen.value = true
  }
  </script>
      