<template>
    <div class="container  p-4">
        <div class="flex flex-1 w-full flex-col sm:flex-row gap-4">
            <div class="flex flex-col rounded-lg bg-white sm:w-4/12 p-4 ">
                <div class="grid grid-cols-1 gap-2 m-2">
                    <!-- <input class="border-2 border-bg-slate-200 bg-white rounded-md" placeholder="Search here ..." /> -->

                    <h4 class="text-center font-bold text-lg">Provinces</h4>

                    <div class=" h-fit ">
                        <div class="flex justify-between items-center p-2 gap-5" v-for="province in provinces"
                            :key="province.id">
                            <span class="mb-1 text-md font-bold leading-normal dark:text-white text-slate-700">
                                {{ province.province }}
                            </span>
                            <button @click="getProvince(province)" type="button"
                                class="transition duration-300  ease-in-out hover:scale-125">
                                <i class="fa-solid fa-angle-right"></i>

                            </button>
                        </div>
                    </div>

                </div>
            </div>
            <div class="z-0 h-full p-5  rounded-lg bg-white w-full sm:w-8/12">


                <div class=" ">
                    <h4 class="text-center font-bold text-lg">
                        Municipalitis of {{ name }}</h4>
                    <div class="h-fit overflow-x-auto scrollbar">

                        <div class="flex justify-between items-center p-2 gap-5" v-if="municipalities.length !==0"
                            v-for="municipality in municipalities" :key="municipality.id">
                            <span class="mb-1 text-md font-bold leading-normal dark:text-white text-slate-700">
                                {{ municipality.municipality }}
                            </span>
                            <inertia-link :href="route('equipment.show', municipality.id)"
                              class="transition duration-300  ease-in-out hover:scale-125">
                                <i class="fa-solid fa-folder-open"></i>

                            </inertia-link>
                        </div>

                        <h6 class="text-center font-semibold text-lg pt-10 " v-else>Select Province</h6>


                    </div>

                </div>
            </div>
        </div>

    </div>
</template>

<script>
import AuthenticatedLayout from '@/Layouts/MunicipalityLayout.vue';

import {  ref } from 'vue';
import Table from '@/Components/Table.vue';
import axios from 'axios';
export default {
    layout: AuthenticatedLayout,

    props: {
        provinces: Object
    },
    setup() {
        const name = ref("");
        const municipalities = ref([]);
        const tableHeader = [
            { name: 'Equipment Name' },

            { name: 'Status' },
            { name: 'Quantity' },
            { name: 'Actions' }
        ]

        const getProvince = (province) => {
            axios.get(`http://127.0.0.1:8000/province/${province.province}`).then((res) => {
                municipalities.value = res.data;
            
            });
            name.value = province.province_name;
        };


        return {
            tableHeader,
            name,
            municipalities,
            getProvince,
            
        };
    },
    components: { Table }
}
</script>

<style lang="scss" scoped>

</style>