<template>
  <div>
    <button @click="openModal"
      class="text-sm  hover:bg-red-600 mx-2 text-center bg-red-500 px-2 rounded text-white tracking-wide">
      {{ name }}
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
              class="grid place-content-center w-fit mx-10 max-w-md transform overflow-hidden rounded bg-slate-50 p-6 text-left align-middle shadow-xl transition-all">

              <div class="grid grid-flow-row gap-5">
                <span class="text-lg font-semibold">Please Provide Reason For Declining request</span>
                <textarea v-model="reason"
                  class="border-2 rounded focus:outline-hidden focus:border-hidden active:outline-hidden" />
              </div>

              <div class="mt-4 grid place-content-center">
                <button type="button"
                  class="inline-flex justify-center rounded-md border border-transparent bg-orange-300 px-4 py-2 text-sm font-medium  hover:bg-orange-400 focus:outline-none focus-visible:ring-2 focus-visible:ring-blue-500 focus-visible:ring-offset-2"
                  @click="submit">
                  submit
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
import { Inertia } from '@inertiajs/inertia'
import { emitter } from '@/Composables/useEventBus'

const props = defineProps({
  name: String,
  equipment_borrow: String
})
function openModal() {
  isOpen.value = true
}
const emit = defineEmits(['submit'])
const isOpen = ref(false)
const reason = ref('')
function closeModal() {

  isOpen.value = false
}

function submit() {
  console.log(reason, props.equipment_borrow);
  // emit('submit', props.equipment_borrow , reason.value)

  Inertia.post('/api/deny/' + props.equipment_borrow, { reason: reason.value }, {
      onFinish: (e) => {
          notification()
          Inertia.reload({ only: ['notifications'] })
         
      }
  })
  emitter.emit('deny')
  closeModal()


}
</script>
    