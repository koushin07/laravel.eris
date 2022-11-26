<template>

  <Combobox v-model="selected" multiple>
    <ComboboxLabel>Equipment</ComboboxLabel>
    <div class="relative mt-1 ">
      <div
        class="relative w-full cursor-default scrollbar overflow-hidden rounded-lg bg-white text-left shadow-md focus:outline-none focus-visible:ring-2 focus-visible:ring-white focus-visible:ring-opacity-75 focus-visible:ring-offset-2 focus-visible:ring-offset-teal-300 sm:text-sm">
        <ComboboxInput
          class="w-full  py-2 pl-3 pr-10 border-2 bg-transparent rounded-lg focus:outline-none focus:ring-0 "
          :displayValue=" (equipment) => equipment.name" @change="query = $event.target.value" placeholder="Search Here...." />
        <ComboboxButton class="absolute inset-y-0 right-0 flex items-center pr-2">
          <i class="fa-solid fa-chevron-down text-gray-400" aria-hidden="true"></i>

        </ComboboxButton>
        
      </div>
      <TransitionRoot leave="transition ease-in duration-100" leaveFrom="opacity-100" leaveTo="opacity-0"
        @after-leave="query = ''">
        <ComboboxOptions
          class="absolute mt-1 max-h-60 w-full overflow-auto rounded-md bg-white py-1 text-base shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none sm:text-sm">
          <div v-if="filteredEquip.length === 0 && query !== ''"
            class="relative cursor-default select-none py-2 px-4 text-gray-700">
            Nothing found.
          </div>

          <ComboboxOption v-for="equipment in filteredEquip" as="template" :key="equipment.id" :value="equipment"
            v-slot="{ selected, active }">
            <li class="relative cursor-default select-none py-2 pl-10 pr-4" :class="{
              'bg-teal-600 text-white': active,
              'text-gray-900': !active,
            }">
              <span class="block truncate" :class="{ 'font-medium': selected, 'font-normal': !selected }">
                {{ equipment.name }}
              </span>
              <span v-if="selected" class="absolute inset-y-0 left-0 flex items-center pl-3"
                :class="{ 'text-white': active, 'text-teal-600': !active }">
                <i class="fa-solid fa-check" aria-hidden="true"></i>
                <!-- <CheckIcon class="h-5 w-5" aria-hidden="true" /> -->
              </span>
            </li>
          </ComboboxOption>
        </ComboboxOptions>
      </TransitionRoot>
    </div>
  </Combobox>

</template>

<script setup>
import { ref, computed, watch } from 'vue'
import {
  Combobox,
  ComboboxInput,
  ComboboxButton,
  ComboboxOptions,
  ComboboxOption,
  TransitionRoot,
} from '@headlessui/vue'
/*   import { CheckIcon, ChevronUpDownIcon } from '@heroicons/vue/20/solid' */

const props = defineProps({
  contents: Object,
  modelValue: [Object, Array, String]
})

const emit = defineEmits(['submit'])
let selected = ref([])
let query = ref('')

let filteredEquip = computed(() =>
  query.value === ''
    ? props.contents
    : props.contents.filter((equipment) =>
      equipment.name
        .toLowerCase()
        .replace(/\s+/g, '')
        .includes(query.value.toLowerCase().replace(/\s+/g, ''))
    ),

)

watch(selected, (value)=>{
  emit('submit', selected.value)
})
</script>
