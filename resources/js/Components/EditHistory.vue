<template>
    <form @submit.prevent="handleSubmit">

        <div class="">
            <div class="px-4 py-5 bg-white sm:p-6">
                <div class="grid grid-cols-6 gap-6">
                    <div class="col-span-6 sm:col-span-6">
                        <span class="text-xl font-bold">
                            {{ updateForm.name }}
                        </span>

                    </div>

                    <div class="col-span-6 flex flex-col ">
                        <span class="text-sm text-slate-500 ">Returned Status</span>
                        <div class="flex flex-row space-x-6 border-2 p-4 rounded-lg">
                            <div class="col-span-6 sm:col-span-6 lg:col-span-2">
                                <label for="model_number"
                                    class="block text-sm font-medium text-gray-700">Serviceable</label>
                                <input type="number" name="model_number" id="model_number"
                                    v-model="updateForm.serviceable" required=""
                                    class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                            </div>
                            <div class="col-span-6 sm:col-span-6 lg:col-span-2">
                                <label for="model_number"
                                    class="block text-sm font-medium text-gray-700">Unusable</label>
                                <input type="number" name="model_number" id="model_number" v-model="updateForm.unusable"
                                    required=""
                                    class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                            </div>
                            <div class="col-span-6 sm:col-span-6 lg:col-span-2">
                                <label for="model_number" class="block text-sm font-medium text-gray-700">Poor</label>
                                <input type="number" name="model_number" id="model_number" v-model="updateForm.poor"
                                    required=""
                                    class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                            </div>
                        </div>
                    </div>
                    <div class="col-span-6 flex flex-col ">
                        <span class="text-sm text-slate-500 ">Equipment Attribute</span>

                        <div class="flex flex-col space-y-4 border-2 rounded-lg p-4">
                            <div class="flex flex-row justify-around space-x-6 ">
                                <div class="col-span-6 sm:col-span-6 lg:col-span-2 flex flex-col">
                                    <label for="model_number" class="block text-sm font-medium text-gray-700">Model
                                        Number</label>
                                    <input type="number" name="model_number" id="model_number"
                                        v-model="updateForm.attrs.model_number" required=""
                                        class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                </div>
                                <div class="col-span-6 sm:col-span-3">
                                    <label for="asset_id" class="block text-sm font-medium text-gray-700">asset
                                        ID
                                    </label>
                                    <input type="number" name="asset_id" id="asset_id"
                                        class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"
                                        v-model="updateForm.attrs.asset_id" required="">

                                </div>
                                <div class="col-span-6 sm:col-span-3 lg:col-span-2 flex flex-col">
                                    <label for="serial_number" class="block text-sm font-medium text-gray-700">Serial
                                        Number</label>
                                    <input type="number" name="serial_number" id="serial_number"
                                        v-model="updateForm.attrs.serial_number" required=""
                                        class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                </div>
                            </div>
                            <div class="flex flex-row justify-between space-x-6 ">
                                <div class="flex flex-col col-span-6">
                                <div class="col-span-6 sm:col-span-3 lg:col-span-2">
                                    <label for="unit" class="block text-sm font-medium text-gray-700">Unit
                                    </label>
                                    <input type="number" name="unit" id="unit" v-model="updateForm.attrs.unit"
                                        required=""
                                        class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                </div>
                            </div>
                            <div class="col-span-6 sm:col-span-3">
                                <label for="code" class="block text-sm font-medium text-gray-700">Code
                                </label>
                                <input type="text" name="code" id="code"
                                    class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"
                                    v-model="updateForm.attrs.code" required="">

                            </div>
                            </div>
                            

                            <div class="col-span-6 sm:col-span-3">
                                <label for="category" class="block text-sm font-medium text-gray-700">Category</label>

                                <select
                                    class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                    v-model="updateForm.attrs.category" required>
                                    <option value="none" selected disabled hidden>
                                        {{ updateForm.attrs.category }}
                                    </option>
                                    <option>category1</option>
                                    <option>category2</option>
                                    <option>category3</option>

                                </select>
                            </div>
                            <div class="col-span-6">
                                <label for="asset_desc" class="block text-sm font-medium text-gray-700">Asset
                                    Description</label>
                                <input type="text" name="asset_desc" id="asset_desc"
                                    v-model="updateForm.attrs.asset_desc" required=""
                                    class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                            </div>

                            <div class="col-span-6">
                                <label for="remarks" class="block text-sm font-medium text-gray-700">Remarks</label>
                                <input type="text" name="remarks" id="remarks" v-model="updateForm.attrs.remarks"
                                    required=""
                                    class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                            </div>

                        </div>

                    </div>
                </div>
            </div>
        </div>
        <div class=" mr-7 flex justify-end">

            <button type="submit"
                class="inline-flex  justify-center rounded-md border border-transparent bg-orange-200 px-4 py-2 text-sm font-medium text-blue-900 hover:bg-blue-200 focus:outline-none focus-visible:ring-2 focus-visible:ring-blue-500 focus-visible:ring-offset-2">
                Update
            </button>
        </div>
    </form>
</template>

<script setup>
import { useForm } from '@inertiajs/inertia-vue3';


const props = defineProps({
    form: Object
})

const updateForm = useForm({
    borrow_id: props.form.borrow_id,
    detail_id: props.form.detail_id,
    name: props.form.equipment,
    attrs: {
        equipment_id: props.form.equipment_id,
        code: props.form.code,
        asset_desc: props.form.asset_desc,
        category: props.form.category,
        unit: props.form.unit,
        model_number: props.form.model_number,
        serial_number: props.form.serial_number,
        asset_id: props.form.asset_id,
        remarks: props.form.remarks,
    },
    status: {
        serviceable: props.form.serviceable,
        unusable: props.form.unusable,
        poor: props.form.poor
    },

})

function handleSubmit() {
    if (updateForm.status.serviceable + updateForm.status.unusable + updateForm.poor <= props.form.quantity) {
        updateForm.put(route('municipality.detail.update', props.form.detail_id), {
            onError: (e) => {
                alert(Object.values(e))
            },
            onSuccess: (e) => {
                alert("done")
            }
        })
    }

}
</script>

<style lang="scss" scoped>

</style>