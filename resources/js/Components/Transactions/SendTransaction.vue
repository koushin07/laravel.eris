<template>
    <div class="box-border h-fit bg-white  px-4 shadow-xl content-center rounded-2xl overflow-y-auto">
        <ul class="flex flex-col">
            <li v-for="send in sent.data" 
            class="relative flex justify-between px-4 py-2 pl-0 mb-2 border-0 rounded-xl text-inherit">
                <div class="flex flex-col">
                    <h6 class="mb-1 text-sm font-semibold leading-normal dark:text-white text-slate-700">
                       {{ send.equipment_name }}</h6>

                    <span class="text-xs text-zinc-900 leading-tight ">Quantity: {{ send.quantity }}</span>
                </div>
                <div class="flex text-inline items-center text-sm leading-normal dark:text-white/80">
                    {{ send.municipality_name }}

                </div>
            </li>
           

        </ul>
    </div>
</template>

<script setup>
defineProps({
    sent: Object
})
</script>

<style lang="scss" scoped>

</style>