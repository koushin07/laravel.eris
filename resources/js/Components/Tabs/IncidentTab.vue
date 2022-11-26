<template>
    <div class="flex flex-col space-y-10 justify-around p-2">

<new-incident @request="getIncident" name="New">
    <template #body>

    </template>
</new-incident>

<div class="flex flex-row px-6 space-x-3">
    <div class="  flex flex-col  w-3/5">
        <span class="text-lg font-semibold">incident</span>

        <div class=" flex flex-col overflow-y-auto  rounded-lg    space-y-2 scrollbar">
            <div v-if="incidents.length !== 0"
                class="rounded-lg p-4  relative text-center flex justify-between pr-2 border-2  pb-2">



                <div class="grid grid-cols-1">
                    <div class="flex flex-row">
                        <input class="font-bold text-sm text-gray-700 text-start focus:outline-0"
                            v-model="incidents" />

                    </div>


                </div>

                <button @click="getStatuses(incidents)"
                    class="text-sm text-center text-orange-500 px-2 rounded-lg tracking-wide">
                    <!-- <TransactionModal :equipments="equipments" :provinces="provinces"
                            :incident="incident.incident" :histories="histories" /> -->
                    details
                </button>


            </div>

            <div v-for="(key) in Object.keys(histories)"
                class="rounded-lg p-4  relative text-center flex justify-between pr-2 border-2  pb-2">



                <div class="grid grid-cols-1">
                    <div class="flex flex-row">
                        <span class="font-bold text-sm text-gray-700 text-start focus:outline-0"> {{ key }}
                        </span>

                    </div>


                </div>

                <button @click="getStatuses(key, histories[key])"
                    class="text-sm text-center text-orange-500 px-2 rounded-lg tracking-wide">
                    <!-- <TransactionModal :equipments="equipments" :provinces="provinces"
                            :incident="incident.incident" :histories="histories" /> -->
                    details
                </button>


            </div>
        </div>
    </div>
    <StatusCard v-if="selected" @submit="handleSubmit" :selected="selected" :statuses="pendings"
        :equipments="equipments" :provinces="provinces" />
    <!-- <div class="flex flex-col  overflow-hidden  w-2/5">
        <span class="text-lg font-semibold font-sans">Status</span>
        <div
            class="flex flex-col justify-between overflow-y-auto border-2 rounded-lg p-4 space-y-2 scrollbar">
            <div class="flex flex-row justify-end">

                <button class="text-lg font-semibold bg-orange-300 w-fit px-4 rounded"
                    v-if="selected.length > 0">
                    <TransactionModal @submit="handleSubmit" :equipments="equipments" :provinces="provinces"
                        :incident="selected" />
                </button>
            </div>
            <div v-for="(pending, key) in pendings" :key="key"
                class="flex justify-between pr-2 border-b pb-2 border-red-200 last:border-transparent">

                <div class="grid grid-cols-1">
                    <span class="font-bold text-sm text-gray-700">{{ pending.owner }}</span>
                    <span class="text-xs text-gray-700">{{ pending.equipment }}:{{
                            pending.quantity
                    }}</span>
                </div>

                <span v-if="pending.status == 'pending'"
                    class="text-slate-400 text-sm font-thin italic">Pending...</span>
                <span v-else-if="pending.status == 'accepted'"
                    class="text-green-400 text-base font-semibold ">Accepted</span>
                <span v-else-if="pending.status == 'denied'"
                    class="text-red-400 text-base font-semibold ">Denied</span>
            </div>

        </div>
    </div> -->
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