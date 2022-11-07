<template>
     <div class="flex flex-col h-full">
            <form class="flex flex-col justify-center " @submit.prevent="HandleSubmit">
                <div class="grid grid-cols-3 gap-10 z-50">
                    <div class=" col-span-2  flex flex-col z-0 justify-between ">
                        <label for="Equipment" class="text-sm font-bold">Equipment</label>
                        <Equipment-list @submit="getEquipment" :contents="equipments" />
                    </div>
                    <div class=" flex flex-col z-0  justify-between">
                        <label for="Quantity" class="text-sm font-bold">Quantity</label>
                        <input name="Quantity" type="number" v-model="quantity"
                            class="border-2 bg-transparent rounded-lg focus:outline-none focus:ring-0  py-2 px-1" />
                    </div>
                </div>
              
            </form>
            <div class="grid grid-cols-3 gap-10 pt-6">
                <div class=" col-span-2  flex flex-col z-0 justify-between ">
                    <div class="flex flex-col  overflow-hidden h-[280px] ">
                        <span class="text-lg font-semibold font-sans text-center">Municipalities</span>
                        <div
                            class="flex flex-col justify-between overflow-y-auto border-2 rounded-lg p-4 space-y-2 scrollbar">
                            <div class="flex flex-row justify-end space-x-3" v-if="Object.keys(municipalities).length">
                                <span class="text-center" :class="selectClick ? 'underline' : ''"
                                    @click="selectClick = !selectClick">
                                    select
                                    all </span>
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    v-if="selectClick" stroke-width="1.5" stroke="currentColor" @click="handleSelectAll"
                                    class="w-6 h-6 hover:scale-105 cursor-pointer"
                                    :class="selectClick ? 'text-green-500 animate-wiggle' : ''">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M6 12L3.269 3.126A59.768 59.768 0 0121.485 12 59.77 59.77 0 013.27 20.876L5.999 12zm0 0h7.5" />
                                </svg>



                            </div>


                            <div class="flex justify-between pr-2 border-b pb-2 border-red-200 last:border-transparent"
                                v-for="(municipality, key) in municipalities" :key="key">

                                <div class="grid grid-cols-1">
                                    <span class="font-bold text-base text-gray-700">{{
                                            municipality.municipality
                                    }}</span>
                                    <span class="text-xs text-gray-700">Quantity: {{ municipality.quantity }}</span>
                                </div>

                                <button class="text-red-600 text-base hover:text-red-700 hover:scale-110 font-semibold"
                                    @click="handleRequest(municipality)">Request</button>

                            </div>
                            <div class="grid place-content-center py-10"
                                v-if="!Object.keys(municipalities).length && !notFound">
                                <span class="text-lg font-bold text-gray-600 text-center"> Nothing Found</span>
                                <span class="text-xs font-semibold text-gray-600"> Try Changing Quantity</span>

                            </div>

                        </div>
                    </div>
                </div>
                <div class=" flex flex-col z-0  justify-between">
                    <div class="flex flex-col  overflow-hidden h-[280px] ">
                        <span class="text-lg font-semibold font-sans text-center">Status</span>
                        <div
                            class="flex flex-col justify-between overflow-y-auto border-2 rounded-lg p-4 space-y-2 scrollbar">
                            <div v-for="(pending, key) in pendings" :key="key"
                                class="flex justify-between pr-2 border-b pb-2 border-red-200 last:border-transparent">

                                <div class="grid grid-cols-1">
                                    <span class="font-bold text-sm text-gray-700">{{ pending.municipality }}</span>
                                    <span class="text-xs text-gray-700"></span>
                                </div>

                                <span v-if="pending.status == 'pending'"
                                    class="text-slate-400 text-sm font-thin italic">Pending...</span>
                                <span v-else-if="pending.status == 'accept'"
                                    class="text-green-400 text-base font-semibold ">Accepted</span>
                                <span v-else class="text-red-400 text-base font-semibold ">Denied</span>
                            </div>



                        </div>
                    </div>
                </div>
            </div>

        </div>
</template>

<script>
export default {
    setup () {
        

        return {}
    }
}
</script>

<style lang="scss" scoped>

</style>