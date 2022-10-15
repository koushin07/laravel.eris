<template>
    <div class="box-border h-fit bg-white  px-4 shadow-xl content-center rounded-2xl overflow-y-auto">
        <ul v-if="pending!==null" class=" flex flex-col py-2">
            <li v-for="send in pending.data"
                class=" relative flex justify-between px-4 py-2 pl-0 mb-2 border-0 rounded-xl text-inherit">
                <div class="flex flex-col">
                    <h6 class="mb-1 text-sm font-semibold leading-normal dark:text-white text-slate-700">
                        {{send.equipment}}</h6>

                    <span class="text-xs text-zinc-900 leading-tight ">Borrower: {{ send.borrower }}</span>
                    <span class="text-xs text-zinc-900 leading-tight ">Quantity: {{ send.quantity }}</span>
                </div>
                <div class="flex flex-col space-y-2  items-center text-md leading-normal dark:text-white/80">
                    <button @click="$emit('accept', send.id)"
                        class="text-xs text-white bg-green-500 px-2 py-1 rounded-xl hover:scale-110 hover:shadow-lg">
                        Accept
                    </button>
                    <button @click="$emit('deny', send.id)"
                        class="text-xs text-white bg-red-500 px-2 py-1 rounded-xl hover:scale-110 hover:shadow-lg">
                        Deny
                    </button>
                </div>
            </li>
        </ul>
        <ul class="flex flex-col py-2" v-else>
            <li class="relative flex justify-between px-4 py-2 pl-0 mb-2 border-0 rounded-xl text-inherit">
                <div class="flex flex-col">
                    <h6 class="mb-1 text-sm font-bold leading-normal dark:text-white text-slate-700">
                        No Pending Request
                    </h6>


                </div>
            </li>
        </ul>


    </div>
</template>

<script>
import axios from 'axios';

export default {
    props: {
        pending: Object
    },
    
    setup() {
        

        return {
           
        }
    }
}
</script>

<style lang="scss" scoped>

</style>