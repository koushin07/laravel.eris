<template>
  <div @click="openModal">

   <slot name="trigger"></slot>
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
                <button class="grid place-content-center hover:scale-110 hover:text-orange-500" @click="closeModal">
                  <i class="fa-solid fa-x text-lg "></i>

                </button>
              </DialogTitle>
              <div class="">

               
                           </div>

              <div class="mt-4">

                <slot name="footer" />
                <!-- <button type="button"
                  class="inline-flex justify-center rounded-md border border-transparent bg-blue-100 px-4 py-2 text-sm font-medium text-blue-900 hover:bg-blue-200 focus:outline-none focus-visible:ring-2 focus-visible:ring-blue-500 focus-visible:ring-offset-2"
                  @click="closeModal">
                  Save
                </button> -->

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


// const props = defineProps({
//   name: String,
//   form: Object
// })

// const updateForm = useForm({
//   equipment_id: props.form.id,
//   name: props.form.equipment,
//   code: props.form.code,
//   asset_desc: props.form.asset_desc,
//   category: props.form.category,
//   unit: props.form.unit,
//   model_number: props.form.model_number,
//   serial_number: props.form.serial_number,
//   asset_id: props.form.asset_id,
//   remarks: props.form.remarks,
//   serviceable: props.form.serviceable,
//   unserviceable: props.form.unserviceable,
//   poor: props.form.poor
// })
const isOpen = ref(false)

function closeModal() {
  isOpen.value = false
}
function openModal() {
  isOpen.value = true
}
</script>
  