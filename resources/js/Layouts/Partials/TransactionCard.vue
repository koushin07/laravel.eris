<template>
    <div class="transaction-card hidden sm:flex static  flex-col flex-grow h-screen overflow-x-auto  scrollbar">
        <div class="flex-col m-2">
            <div class="flex justify-between items-center p-5 gap-5">
                <div>
                    <i class="fa-solid fa-house-user"></i>
                    <!-- <div v-if="! $page.props.auth.notification"></div> -->
                </div>
                <!-- :class="[$page.props.auth.notification ? 'animate-ping ' : '']" -->
                <div class="space-x-3.5">
                    <i class="fa-solid fa-bell ">
                        <span
                            class="animate-ping  inline-flex h-full w-full rounded-full bg-sky-400 opacity-75"></span></i>
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
                        <span class="text-red-500 font-semibold">Pending</span>
                        <span class="text-red-500 cursor-pointer">See All</span>
                    </div>

                    <PendingTransaction @accept="accept" @deny="deny" :pending="pending" />
                </div>
                <div class="flex flex-col space-x-1">
                    <div class="flex justify-between px-4">
                        <span class="text-emerald-500">Send</span>
                        <inertia-link class="text-emerald-500 cursor-pointer" :href="route('transactions.index')">See
                            All</inertia-link>
                    </div>
                    <RecievedTransaction :transactions="send" />
                </div>



            </div>



        </div>
    </div>
</template>


<script>
import axios from 'axios';
import { onMounted, ref } from 'vue';
import RecievedTransaction from '@/Components/Transactions/RecievedTransaction.vue';
import SendTransaction from '../../Components/Transactions/SendTransaction.vue';
import { usePage } from '@inertiajs/inertia-vue3';
import PendingTransaction from '@/Components/Transactions/PendingTransaction.vue';

export default {
    components: {
        RecievedTransaction,
        SendTransaction,
        PendingTransaction
    },
    created() {

    },
    setup() {
        window.Echo.private(`confirmed.${usePage().props.value.auth.user.id}`)
        .listen('.equipment.confirmed', () =>{
            alert('your request is accepted and on its way')
            console.log('accepted')
        })
        window.Echo.private(`denied.${usePage().props.value.auth.user.id}`)
        .listen('.equipment.denied', () =>{
            alert('your request is Denied')
            console.log('deny')
        })
         window.Echo.private(`requestSend.${usePage().props.value.auth.user.id}`)
            .listen('.Mtransaction.created', (e) => {
                console.log('inside')
                alert('new Request Recieve')
                axios.get(
                    '/api/send'
                ).then((res) => {
                    transactions.value = res
                    console.log('done')
                    alert('you recieve transaction')
                }).catch((err) => {
                    console.log(err)
                })
            })
        const accept = async (id) => {
            await axios.post(`/api/accept/${id}`)
                .then(
                    axios.get(
                        '/api/send'
                    ).then((res) => {
                        send.value = res
                        console.log(res)

                    }).catch((err) => {
                        console.log(` this is recieved query${err}`)
                    }),
                    axios.get(
                        '/api/pending'
                    ).then((res) => {
                        pending.value = res
                    }).catch(err => console.log(err))
                )

        }
        const deny = async (id) => {
            await axios.post(`/api/deny/${id}`).then((res) => console.log(res))
        }
        let send = ref([])
        let pending = ref({})
        const user = usePage().props.value.auth
        onMounted(() => {

            console.log(usePage().props.value.auth)
            axios.get(
                '/api/send'
            ).then((res) => {
                send.value = res


            }).catch((err) => {
                console.log(` this is recieved query${err}`)
            })

            axios.get(
                '/api/pending'
            ).then((res) => {
                pending.value = res
            }).catch(err => console.log(err))
        })

        return {
            send,
            pending,
            accept,
            deny,


        }

    }
}
</script>
<style lang="scss" scoped>

</style>