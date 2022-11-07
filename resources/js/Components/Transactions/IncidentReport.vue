<template>
    <h1 class="text-2xl pb-6 text-center">Incident Report</h1>
    <div class="grid grid-cols-5 gap-5 place-content-center">
        <div class=" flex flex-col z-0  justify-between col-span-2">
            <div class="flex flex-col  overflow-hidden h-[480px] ">

                <div class="flex flex-col justify-between overflow-y-auto border-2 rounded-lg  space-y-2 scrollbar">

                    <button v-for="(report, key) in reports" :key="key"
                        @click="openReport(report.id, report.equipment_name)"
                        class="flex justify-between  border-b  p-4 hover:bg-slate-200 border-grey-200 last:border-transparent">

                        <div class="grid grid-cols-1 text-start">
                            <span class="font-bold text-base text-gray-700 uppercase">
                                {{ report.name }}
                            </span>
                            <span class="text-xs text-gray-700 uppercase">{{ report.equipment_name }}</span>
                        </div>
                    </button>


                </div>
            </div>
        </div>
        <div class=" flex flex-col z-0 h-full  justify-between col-span-3">
            <div class="flex flex-col  overflow-hidden h-full ">

                <form @submit.prevent="submitReport" v-if="incident.details_id"
                    class=" flex flex-col animate-fade-in-down justify-between overflow-y-auto border-2 rounded-lg  space-y-2 scrollbar p-5 ">
                    <div class="flex flex-row justify-between">
                        <h1 class="font-bold text-2xl font-sans antialiased capitalize">
                            {{ selected }}
                        </h1>

                    </div>

                    <div class="grid  gap-10  h-full w-full pt-5">



                        <div class="grid place-content-center">
                            <div class="max-w-xl">
                                <label @dragover.prevent="hover = true" @drop.prevent @dragleave.prevent="hover = false"
                                    :class="hover ? 'border-gray-400' : ''"
                                    class="flex flex-col  justify-evenly w-full h-32 px-4 transition bg-white border-2 border-gray-300 border-dashed rounded-md appearance-none cursor-pointer hover:border-gray-400 focus:outline-none">
                                    <span class="flex items-center space-x-2" @drop="drop">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-gray-600"
                                            fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" />
                                        </svg>
                                        <span class="font-medium text-gray-600">
                                            Drop Incident Report to Attach, or
                                            <span class="text-blue-600 underline">browse</span>
                                        </span>
                                    </span>


                                    <input type="file" name="docs" @input="incident.docs = $event.target.files[0]"
                                        class="hidden">
                                </label>
                                <div class=" mt-5 flex flex-row justify-between rounded-lg bg-green-400 p-3 animate-fade-in-down"
                                    v-if="incident.docs">
                                    <span class="font-semibold text-sm">{{ incident.docs.name }}</span>
                                    <i class="fa-solid fa-x text-sm text-center h-3 hover:scale-110"
                                        @click="resetDocs"></i>
                                </div>
                                <div class="flex justify-end col-span-2 pt-5  animate-fade-in-down"
                                    v-if="incident.docs">
                                    <button type="submit"
                                        class="bg-orange-500 px-5 text-sm py-2 rounded-xl  hover:bg-orange-700 ">save</button>

                                </div>
                            </div>
                        </div>

                    </div>
                </form>
            </div>
        </div>
    </div>
</template>

<script>
import { useForm } from '@inertiajs/inertia-vue3';

import { ref, watch } from 'vue';

export default {
    props: {
        reports: Array
    },
    setup() {

        const hover = ref(false)
        const selected = ref('')
        const incident = useForm({
            details_id: null,
            docs: '',

        })
        const resetDocs = () => {
            incident.reset()
        }
        const openReport = (id, equipment) => {
            selected.value = equipment
            incident.details_id = id

        }
        const drop = (e) => {
            incident.docs = e.dataTransfer.files[0]
            console.log(e.dataTransfer.files)
            console.log(incident.docs)
        }
        const submitReport = async () => {

            incident.post(route('municipality.incident.store'), {
                forceFormData: true,
                onError: ()=>{
                    console.log(error)
                },
                onSuccess: ()=>{
                    incident.reset()
                }
                
                
            })
        }


        watch(incident, value => console.log(value))


        return {
            drop,
            hover,
            selected,
            incident,
            submitReport,
            openReport,
            resetDocs
        }
    }
}
</script>

<style lang="scss" scoped>

</style>