<template>


    <div class="">
        <div class="px-4 py-5 bg-white sm:p-6">
            <div class="grid grid-cols-6 gap-6">
                <div class="col-span-6 sm:col-span-3">
                    <label for="equipment_name" class="block text-sm font-medium text-gray-700">Equipment
                        Name</label>
                    <input type="text" name="equipment_name" id="equipment_name"
                        class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"
                        :v-model="form.equipment_name" required="" disabled>

                </div>

                <div class="col-span-6 sm:col-span-3">
                    <label for="status" class="block text-sm font-medium text-gray-700">Status</label>
                    <select name="status" id="status" disabled
                        class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"
                        required="">
                        <option value="status" selected disabled hidden>
                            {{ form.status }}
                        </option>
                        <option value="Serviceable">Serviceable</option>
                        <option value="Poor">Poor</option>
                        <option value="Unusable">Unusable</option>


                    </select>
                </div>



                <div class="col-span-6 sm:col-span-6 lg:col-span-2">
                    <label for="model_number" class="block text-sm font-medium text-gray-700">Model
                        Number</label>
                    <input disabled type="number" name="model_number" id="model_number" :v-model="form.model_number"
                        required=""
                        class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                </div>



                <div class="col-span-6 sm:col-span-3 lg:col-span-2">
                    <label for="serial_number" class="block text-sm font-medium text-gray-700">Serial
                        Number</label>
                    <input disabled type="number" name="serial_number" id="serial_number" :v-model="form.serial_number"
                        required=""
                        class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                </div>


                <div class="col-span-6 sm:col-span-3 lg:col-span-2">
                    <label for="unit" class="block text-sm font-medium text-gray-700">Unit
                    </label>
                    <input disabled type="number" name="unit" id="unit" :v-model="form.unit" required=""
                        class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                </div>

                <div class="col-span-6 sm:col-span-3">
                    <label for="code" class="block text-sm font-medium text-gray-700">Code
                    </label>
                    <input disabled type="text" name="code" id="code"
                        class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"
                        :v-model="form.code" required="">

                </div>
                <div class="col-span-6 sm:col-span-3">
                    <label for="asset_id" class="block text-sm font-medium text-gray-700">asset ID
                    </label>
                    <input disabled type="number" name="asset_id" id="asset_id"
                        class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"
                        :v-model="form.asset_id" required="">

                </div>



            </div>


            <div class="col-span-6 sm:col-span-3">
                <label for="category" class="block text-sm font-medium text-gray-700">Category</label>
                <select disabled id="category" name="category" required=""
                    class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                    <option value="none" selected disabled hidden>
                        {{ form.category }}
                    </option>
                    <option value="Category1">Category 1</option>
                    <option value="Category2">Category 2</option>
                    <option value="Category3">Category 3</option>
                </select>
            </div>




            <div class="col-span-6">
                <label for="asset_desc" class="block text-sm font-medium text-gray-700">Asset
                    Description</label>
                <input disabled type="text" name="asset_desc" id="asset_desc" :v-model="form.asset_desc" required=""
                    class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
            </div>

            <div class="col-span-6">
                <label for="remarks" class="block text-sm font-medium text-gray-700">Remarks</label>
                <input disabled type="text" name="remarks" id="remarks" :v-model="form.remarks" required=""
                    class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
            </div>




        </div>
        <button type="submit">as</button>




    </div>

</template>

<script setup>
defineProps({
    form: Object,

})
</script>

<style lang="scss" scoped>

</style>