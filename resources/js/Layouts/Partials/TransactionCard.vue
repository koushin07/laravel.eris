<template>
    <div class="transaction-card hidden sm:flex static  flex-col flex-grow h-screen overflow-x-auto  scrollbar">
        <div class="flex-col m-2">
            <div class="flex justify-between items-center p-5 gap-5">
                <div>
                    <i class="fa-solid fa-house-user"></i>
                </div>
                <div class="space-x-3.5">
                    <i class="fa-solid fa-bell"></i>
                    <inertia-link :href="route('logout')" method="POST" as="button">
                        <i class="fa-solid fa-arrow-right-from-bracket"></i>
                    </inertia-link>
                   
                </div>


            </div>
            <div class="flex flex-col space-y-8 justify-items-center m-4">
                <div class="box-border  h-20  p-4  hover:scale-110 content-center rounded-3xl" 
                style="background:#DAD9D8; box-shadow: 9px 10px 5px rgb(0 0 0 / 0.25);">
                <span class="text-2xl font-extrabold text-blue-500 ">
                    {{ $page.props.auth.user.name }}
              
                </span>
                    
                    
                </div>
                <div class="flex flex-col space-x-1">
                    <div class="flex justify-between px-4">
                        <span class="text-emerald-500">Received</span>
                        <inertia-link class="text-emerald-500 cursor-pointer" :href="route('transactions.index')">See All</inertia-link>
                    </div>
                    <RecievedTransaction :transactions="transactions"/>
                </div>

                <div class="flex flex-col space-x-1">
                    <div class="flex justify-between px-4">
                        <span class="text-red-600 ">Send</span>
                        <span class="text-red-500 cursor-pointer">See All</span>
                    </div>
                
                  <SendTransaction :sent="sent"/>
                </div>

            </div>



        </div>
    </div>
</template>

<script setup>
import axios from 'axios';
import { onMounted, ref } from 'vue';
import RecievedTransaction from '@/Components/Transactions/RecievedTransaction.vue';
import SendTransaction from '../../Components/Transactions/SendTransaction.vue';

let transactions = ref({})
let sent = ref({})
onMounted(()=>{
     axios.get(
        '/recieve-transaction'
    ).then((res) => {
        transactions.value = res    
    }).catch((err) =>{
        console.log(err)
    })

     axios.get(
        '/send'
    ).then((res)=>{
        sent.value = res
    }).catch(err => console.log(err))
})
</script>

<style lang="scss" scoped>

</style>