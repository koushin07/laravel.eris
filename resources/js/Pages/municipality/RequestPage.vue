<template>

    <ContentBox>
        <div class="grid grid-cols-3 gap-5 h-full">
            <form class="flex flex-col col-span-2 justify-between" @submit.prevent="HandleSubmit">
                <div class="grid gap-10">
                    <div class="relative flex flex-col z-0  ">
                        <label for="Equipment" class="text-sm font-bold">Equipment</label>
                        <div class="relative ">
                            <input type="search" id="search-dropdown"
                                class="block  w-full z-20 text-sm border-2 bg-transparent rounded-lg focus:outline-none focus:ring-0  py-2 px-1
                                "
                               required>
                            <button type="submit"
                                class="absolute top-0 right-0 p-2 text-sm font-medium text-white bg-blue-700 
                                rounded-r-lg border-2 border-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none
                                 focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800"><svg
                                    aria-hidden="true" class="w-5 h-5" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                </svg></button>
                        </div>
                    </div>
                    <div class="relative flex flex-col z-0 w-64 ">
                        <label for="Quantity" class="text-sm font-bold">Quantity</label>
                        <input name="Quantity" type="number" v-model="request.quanity"
                            class="border-2 bg-transparent rounded-lg focus:outline-none focus:ring-0  py-2 px-1" />
                    </div>
                </div>
                <div class="flex justify-between pb-10">
                    <button type="button" class="w-60 border-2 rounded-md bg-orange-400 py-2"  @click="broadcast">Request</button>
                    <div class="">

                        <input type="radio" name="crosstransaction" id="" class="w-5 h-5 align-middle">
                        <label class="align-middle">crosstransaction</label>

                    </div>

                </div>
            </form>
            <div class="flex flex-col ">
                <span class="text-lg font-semibold font-sans text-center">Municipalities</span>
                <div class="box-content border-2 h-full rounded-lg"></div>
            </div>
        </div>
    </ContentBox>
    <ContentBox></ContentBox>
</template>

<script>
import { ref } from 'vue';
import ContentBox from '../../Components/ContentBox.vue'
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';

export default {
    layout: AuthenticatedLayout,
    setup() {

        const request = ref({
            equipment: '',  
            quanity: Number,
        })
        const HandleSubmit = async () => {

        }

       

        return {
            request,
           
        };
    },
    components: { ContentBox }
}
</script>

<style lang="scss" scoped>

</style>