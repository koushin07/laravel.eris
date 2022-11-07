<template>
    <Content-box>
        <h1 class="text-semibold text-center tex-lg pb-10">Local Transactions</h1>
        <div class="grid grid-cols-5 gap-5 place-content-center">
            <div class=" flex flex-col z-0  justify-between col-span-2">
                <div class="flex flex-col  overflow-hidden h-[480px] ">

                    <div class="flex flex-col justify-between overflow-y-auto border-2 rounded-lg  space-y-2 scrollbar">

                        <button v-for="(local, key) in locals" :key="key" @click="openForm(local)"
                            class="flex justify-between  border-b  p-4 hover:bg-slate-200 border-grey-200 last:border-transparent">

                            <div class="grid grid-cols-1 text-start">
                                <span class="font-bold text-base text-gray-700 uppercase">{{ local.borrower
                                }}</span>
                                <span class="text-xs text-gray-700 uppercase">{{ local.equipment }}</span>
                            </div>



                        </button>


                    </div>
                </div>
            </div>
            <div class=" flex flex-col z-0 h-full  justify-between col-span-3">
                <div class="flex flex-col  overflow-hidden h-full ">

                    <form v-if="localToggle"
                        class=" flex flex-col animate-fade-in-down justify-between overflow-y-auto border-2 rounded-lg  space-y-2 scrollbar p-5 ">
                        <div class="flex flex-row justify-between">
                            <h1 class="font-bold text-2xl font-sans antialiased capitalize">
                                {{ equipment.name }}
                            </h1>

                        </div>

                        <div class="grid grid-cols-2 gap-10  h-full w-full">


                            <div class="grid grid-rows-3 gap-10">
                                <div class="flex flex-col">
                                    <label class="text-sm font-bold">Serial Number</label>
                                    <input type="number" disabled :placeholder="equipment.serial"
                                        class="border-b-2 border-0  px-2 py-1  focus:ring-0  focus:border-b-blue-600">
                                </div>
                                <div class="flex flex-col">
                                    <label class="text-sm font-bold">Code</label>
                                    <input type="text" disabled :placeholder="equipment.code"
                                        class="border-b-2 border-0  px-2 py-1  focus:ring-0  focus:border-b-blue-600">
                                </div>
                                <div class="flex flex-col">
                                    <label class="text-sm font-bold">Asset ID</label>
                                    <input type="number" disabled :placeholder="equipment.asset_id"
                                        class="border-b-2 border-0  px-2 py-1  focus:ring-0  focus:border-b-blue-600">
                                </div>
                            </div>

                            <div class="grid grid-rows-3 gap-10">
                                <div class="flex flex-col">
                                    <label class="text-sm font-bold">Unit</label>
                                    <input type="number" disabled :placeholder="equipment.unit"
                                        class="border-b-2 border-0  px-2 py-1  focus:ring-0  focus:border-b-blue-600">
                                </div>
                                <div class="flex flex-col">
                                    <label class="text-sm font-bold">Model Number</label>
                                    <input type="number" disabled :placeholder="equipment.model"
                                        class="border-b-2 border-0  px-2 py-1  focus:ring-0  focus:border-b-blue-600">
                                </div>
                                <div class="flex flex-col">
                                    <label class="text-sm font-bold">Category</label>
                                    <input type="text" disabled :placeholder="equipment.category"
                                        class="border-b-2 border-0  px-2 py-1  focus:ring-0  focus:border-b-blue-600">
                                </div>
                            </div>



                        </div>
                    </form>
                </div>
            </div>
        </div>
    </Content-box>
    <Content-box>
        <h1 class="text-semibold text-center tex-lg pb-10">Cross Transactions</h1>
        <div class="grid grid-cols-5 gap-5 place-content-center">
            <div class=" flex flex-col z-0  justify-between col-span-2">
                <div class="flex flex-col  overflow-hidden h-[480px] ">

                    <div class="flex flex-col justify-between overflow-y-auto border-2 rounded-lg  space-y-2 scrollbar">

                        <button v-for="(regional, key) in regionals" :key="key" @click="openForm(regional)"
                            class="flex justify-between  border-b  p-4 hover:bg-slate-200 border-grey-200 last:border-transparent">

                            <div class="grid grid-cols-1 text-start">
                                <span class="font-bold text-base text-gray-700 uppercase">{{ regional.borrower
                                }}</span>
                                <span class="text-xs text-gray-700 uppercase">{{ regional.equipment }}</span>
                            </div>



                        </button>


                    </div>
                </div>
            </div>
            <div class=" flex flex-col z-0 h-full  justify-between col-span-3">
                <div class="flex flex-col  overflow-hidden h-full ">

                    <form v-if="toggleRegion"
                        class=" flex flex-col animate-fade-in-down justify-between overflow-y-auto border-2 rounded-lg  space-y-2 scrollbar p-5 ">
                        <div class="flex flex-row justify-between">
                            <h1 class="font-bold text-2xl font-sans antialiased capitalize">
                                {{ regional.name }}
                            </h1>

                        </div>

                        <div class="grid grid-cols-2 gap-10  h-full w-full">


                            <div class="grid grid-rows-3 gap-10">
                                <div class="flex flex-col">
                                    <label class="text-sm font-bold">Serial Number</label>
                                    <input type="number" disabled :placeholder="regional.serial"
                                        class="border-b-2 border-0  px-2 py-1  focus:ring-0  focus:border-b-blue-600">
                                </div>
                                <div class="flex flex-col">
                                    <label class="text-sm font-bold">Code</label>
                                    <input type="text" disabled :placeholder="regional.code"
                                        class="border-b-2 border-0  px-2 py-1  focus:ring-0  focus:border-b-blue-600">
                                </div>
                                <div class="flex flex-col">
                                    <label class="text-sm font-bold">Asset ID</label>
                                    <input type="number" disabled :placeholder="regional.asset_id"
                                        class="border-b-2 border-0  px-2 py-1  focus:ring-0  focus:border-b-blue-600">
                                </div>
                            </div>

                            <div class="grid grid-rows-3 gap-10">
                                <div class="flex flex-col">
                                    <label class="text-sm font-bold">Unit</label>
                                    <input type="number" disabled :placeholder="regional.unit"
                                        class="border-b-2 border-0  px-2 py-1  focus:ring-0  focus:border-b-blue-600">
                                </div>
                                <div class="flex flex-col">
                                    <label class="text-sm font-bold">Model Number</label>
                                    <input type="number" disabled :placeholder="regional.model"
                                        class="border-b-2 border-0  px-2 py-1  focus:ring-0  focus:border-b-blue-600">
                                </div>
                                <div class="flex flex-col">
                                    <label class="text-sm font-bold">Category</label>
                                    <input type="text" disabled :placeholder="regional.category"
                                        class="border-b-2 border-0  px-2 py-1  focus:ring-0  focus:border-b-blue-600">
                                </div>
                            </div>



                        </div>
                    </form>
                </div>
            </div>
        </div>
    </Content-box>


</template>

<script>
import ContentBox from '@/Components/ContentBox.vue'
import ProvinceLayout from '@/Layouts/Province/ProvinceLayout.vue'
import { reactive, ref } from 'vue'
export default {
    props: {
        locals: Array,
        regionals: Array
    },
    layout: ProvinceLayout,
    components: {
        ContentBox

    },
    setup() {
        const localToggle = ref(false)
        const toggleRegion = ref(false)
        const equipment = reactive({
            name: '',
            code: '',
            asset_desc: '',
            category: '',
            unit: null,
            model: null,
            serial: null,
            asset_id: null,
            remarks: ''
        })
        const regional = reactive({
            name: '',
            code: '',
            asset_desc: '',
            category: '',
            unit: null,
            model: null,
            serial: null,
            asset_id: null,
            remarks: ''
        })
        const openForm = (local) => {
            localToggle.value = !localToggle.value
            equipment.name = local.equipment_name
            equipment.code = local.code
            equipment.asset_desc = local.asset_desc
            equipment.category = local.category
            equipment.unit = local.unit
            equipment.model = local.model_number
            equipment.serial = local.serial_number
            equipment.asset_id = local.asset_id
            equipment.remarks = local.remarks


        }
        const openRegion = (region) =>{
            toggleRegion.value = !toggleRegion.value
            regional.name = region.equipment_name
            regional.code = region.code
            regional.asset_desc = region.asset_desc
            regional.category = region.category
            regional.unit = region.unit
            regional.model = region.model_number
            regional.serial = region.serial_number
            regional.asset_id = region.asset_id
            regional.remarks = region.remarks


        }

        return {
            localToggle,
            equipment,
            openForm,
            regional,
            openRegion,
            toggleRegion,
        }
    }
}
</script>

<style lang="scss" scoped>

</style>