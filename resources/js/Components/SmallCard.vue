<template>
    <div class="box-border h-20 p-4 border shadow-lg content-center bg-white rounded-2xl">
        <div class="flex flex-row justify-between" >
            <div >
                <p class="mb-0 font-sans font-semi-bold leading-normal text-sm">{{ props.title }}
                </p>
                <h5 class="mb-0 font-bold">
                    {{ props.quantity }}
                    <!--            <span class="leading-normal text-sm font-weight-bolder text-lime-500">+55%</span>-->
                </h5>
            </div>
            <div class="hidden sm:flex px-3 text-right mt-1 mr-2 h-10 rounded-3xl  w-10 bg-gradient-to-b from-cyan-500 to-blue-500">

            </div>
        </div>
        </div>
</template>

<script setup>
const props =defineProps({
    quantity: [String, Number],
    title: String,
})

</script>

<style scoped>

</style>
