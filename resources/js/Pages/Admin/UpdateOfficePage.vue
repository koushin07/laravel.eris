<!--
  This example requires some changes to your config:
  
  ```
  // tailwind.config.js
  module.exports = {
    // ...
    plugins: [
      // ...
      require('@tailwindcss/forms'),
    ],
  }
  ```
-->
<template>




    <div class="mt-10 sm:mt-0">
        <div class="md:grid place-content-center">

            <div class="mt-5 md:col-span-2 md:mt-0 w-full">
                <form @submit.prevent="handleSubmit">
                    <div class="overflow-hidden shadow sm:rounded-md w-[700px]">
                        <div class="bg-white px-4 py-5 sm:p-6">
                            <div class="grid grid-cols-2 gap-6 w-full">

                                <div class="col-span-6">
                                    <label for="first-name"
                                        class="block text-sm font-medium text-gray-700">Municipality</label>
                                    <input v-model="form.municipality" type="text" name="first-name" id="first-name" autocomplete="given-name"
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" />
                                </div>
                                <div class="col-span-6">
                                    <label for="first-name"
                                        class="block text-sm font-medium text-gray-700">Province</label>
                                   <v-select :options="convertedProvince" v-model="form.province"/>
                                </div>

                                
                                

                               
                            </div>
                        </div>
                        <div class="bg-gray-50 px-4 py-3 text-right sm:px-6">
                            <button type="submit"
                                class="inline-flex justify-center rounded-md border border-transparent bg-indigo-600 py-2 px-4 text-sm font-medium text-white shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">Save</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>



</template>
  

<script>
import ProvinceList from '@/Components/Lists/ProvinceList.vue';
import { useForm } from '@inertiajs/inertia-vue3';
import { ref } from 'vue';
import AdminLayout from '@/Layouts/AdminLayout.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import TextInput from '@/Components/TextInput.vue';

export default {
    layout: AdminLayout,
    components: {
        InputError,
        TextInput,
        InputLabel,
    },
    props: {
        provinces: Object,
        office: Object
    },
    setup({ office, provinces }) {
        const selected = ref()
        const form = useForm({
            municipality: '',
            province: ''

        })
        const handleSubmit = () => {
            form.put(route('rdrrmc.office.update', office.id))
        }
        
        const convertedProvince = provinces ? Object.values(provinces).map((c) => c.province) : []
        return {
            form,
            handleSubmit,
            convertedProvince,
        };
    },
    components: { ProvinceList }
}
</script>

<style lang="scss" scoped>

</style>