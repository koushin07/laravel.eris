<script setup>
import GuestLayout from '@/Layouts/GuestLayout.vue';

import { Head, Link, useForm } from '@inertiajs/inertia-vue3';
import { ref } from 'vue';
import ResgisterAsMunicipality from './ResgisterAsMunicipality.vue';
import RegisterAsProvince from './RegisterAsProvince.vue';


defineProps({
    municipalities: Array,
    provinces: Array,
})

let registerAs = ref(true)

    
</script>

<template>
    <GuestLayout>

        <Head title="Register" />
        <ul class="nav nav-tabs flex flex-col md:flex-row flex-wrap list-none border-b-0 pl-0 mb-4" id="tabs-tabFill"
            role="tablist">
            <li class="nav-item flex-auto text-center" role="presentation" @click="registerAs = ! registerAs">

                <a :class="{'border-b-orange-500': registerAs}"
                    class="cursor-pointer nav-link w-full block font-medium text-xs leading-tight  uppercase border-x-0 border-t-0 border-b-2 border-transparent px-6 py-3 my-2 hover:bg-gray-100 focus:border-transparent   "
                    id="tabs-home-tabFill" data-bs-toggle="pill" data-bs-target="#tabs-homeFill" role="tab"
                    aria-controls="tabs-homeFill" aria-selected="true">Municipality</a>
            </li>
            <li class="nav-item flex-auto text-center" role="presentation"
             @click="registerAs = ! registerAs">
                <a :class="{'border-b-orange-500': !registerAs}"
                class="cursor-pointer nav-link w-full block font-medium text-xs leading-tight uppercase border-x-0 border-t-0  border-b-2 border-transparent px-6 py-3 my-2  hover:bg-gray-100 focus:border-transparent  "
                    id="tabs-profile-tabFill" data-bs-toggle="pill" data-bs-target="#tabs-profileFill" role="tab"
                    aria-controls="tabs-profileFill" aria-selected="false"> Province</a>
            </li>

        </ul>


        <div v-if="registerAs">
            <ResgisterAsMunicipality  :provinces="provinces" />
        </div>
        <div v-else>
            <RegisterAsProvince  :provinces="provinces"/>
        </div>




    </GuestLayout>
</template>
