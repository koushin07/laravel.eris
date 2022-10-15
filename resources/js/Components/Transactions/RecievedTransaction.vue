<template>
    <div class="box-border h-fit  px-4 py-2 shadow-xl content-center bg-white rounded-2xl">
        <ul class="flex flex-col">
            <li v-for="send in transactions.data"
            class="relative flex justify-between px-4 py-2 pl-0 mb-2 border-0 rounded-xl text-inherit">
                <div class="flex flex-col">
                    <h6 class="mb-1 text-sm font-semibold leading-normal dark:text-white text-slate-700">
                       {{send.equipment}}</h6>

                    <span class="text-xs text-zinc-900 leading-tight ">Quantity: {{ send.quantity }}</span>
                </div>
                <div class="flex  items-center text-md leading-normal dark:text-white/80">
                   {{ send.borrower }}

                </div>
            </li>
           

        </ul>
    </div>
</template>

<script setup>

defineProps({
    transactions:  Object

})


</script>

<style lang="scss" scoped>

</style>