<script setup>
import ApplicationLogo from '@/Components/ApplicationLogo.vue';
import { Link } from '@inertiajs/inertia-vue3';
</script>

<template>
    <div class="min-h-screen flex flex-col bg-slate-50 sm:justify-center items-center pt-6 sm:pt-0">
        <div>
            <Link href="/">
                <img src="../../css/eris.png " class=" w-full">
            </Link>
        </div>

        <div class="w-full bg-white sm:max-w-md mt-6 px-6 py-4 bg-whiteoverflow-hidden sm:rounded-lg cstm-shadow">
            <slot />
        </div>
    </div>
</template>

<style scoped>
.cstm-shadow{
    box-shadow: rgba(0, 0, 0, 0.35) 0px 5px 15px;
}
</style>
