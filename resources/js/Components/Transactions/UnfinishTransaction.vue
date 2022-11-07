<template>
    <div class="grid grid-cols-5 gap-5 place-content-center">
        <div class=" flex flex-col z-0  justify-between col-span-2">
            <div class="flex flex-col  overflow-hidden h-[480px] ">

                <div class="flex flex-col justify-between overflow-y-auto border-2 rounded-lg  space-y-2 scrollbar">

                    <button v-for="(borrowing, key) in borrowings" :key="key"
                        @click="openBorrowing(borrowing.equipment_name, borrowing.id, borrowing.quantity)"
                        class="flex flex-col   border-b  p-4 hover:bg-slate-200 border-grey-200 last:border-transparent">

                        <div class="grid grid-cols-1 text-start">
                            <span class="font-bold text-base text-gray-700 uppercase">
                                {{ borrowing.name }}
                            </span>
                            <div class="flex flex-row space-x-2">
                                <span class="text-xs text-gray-700 uppercase text-end">{{ borrowing.quantity }} </span>
                                <span class="text-xs text-gray-700 uppercase"> {{ borrowing.equipment_name }}</span>

                            </div>
                        </div>



                    </button>


                </div>
            </div>
        </div>
        <div class=" flex flex-col z-0 h-full  justify-between col-span-3">
            <div class="flex flex-col  overflow-hidden h-full ">

                <form @submit.prevent="submitStatus" v-if="status.id"
                    class=" flex flex-col animate-fade-in-down justify-between overflow-y-auto border-2 rounded-lg  space-y-2 scrollbar p-5 ">
                    <div class="flex flex-row justify-between">
                        <h1 class="font-bold text-2xl font-sans antialiased capitalize">
                            {{ status.equipment }}
                        </h1>

                    </div>

                    <div class="grid  gap-10  h-full w-full">


                        <div class="grid grid-cols-2 gap-10">
                            <div class="flex flex-col">
                                <label class="text-sm font-bold">Serviceable</label>
                                <input type="number" v-model="status.serviceable"
                                    class="border-b-2 border-0  px-2 py-1  focus:ring-0  focus:border-b-blue-600">
                            </div>
                            <div class="flex flex-col">
                                <label class="text-sm font-bold">Poor</label>
                                <input type="number" v-model="status.poor"
                                    class="border-b-2 border-0  px-2 py-1  focus:ring-0  focus:border-b-blue-600">
                            </div>
                            <div class="flex flex-col">
                                <label class="text-sm font-bold">Unusable</label>
                                <input type="number" v-model="status.unusable"
                                    class="border-b-2 border-0  px-2 py-1  focus:ring-0  focus:border-b-blue-600">
                            </div>
                        </div>


                        <div class="flex justify-end col-span-2 ">
                            <button type="submit"
                                class="bg-orange-500 px-11 py-2 rounded-xl  hover:bg-orange-700 ">save</button>

                        </div>


                    </div>
                </form>
            </div>
        </div>
    </div>
</template>

<script>
import { useForm } from '@inertiajs/inertia-vue3';
import { ref } from 'vue';
export default {

    props: {
        borrowings: Array
    },
    setup() {

        const status = useForm({
            id: null,
            equipment: '',
            serviceable: null,
            unusable: null,
            poor: null
        })
        const quantity = ref(0)
        const openBorrowing = (equipment, id, qty) => {
            console.log(qty)
            quantity.value = qty
            status.id = id
            status.equipment = equipment


        }

        const submitStatus = async () => {
            console.log(quantity.value)
            if (quantity.value >= status.serviceable + status.poor + status.unusable) {
                status.post(route('municipality.history.store'))
            }
            else {
                alert(`only ${quantity.value} equipment you lent`)
            }
        }


        return {
            status,
            quantity,
            openBorrowing,
            submitStatus
        }
    }
}
</script>

<style lang="scss" scoped>

</style>