<template>
    <div class="flex flex-col  overflow-hidden  ">
        <span class="text-lg text-center font-semibold font-sans">Status</span>
        <div class="flex border-2 flex-col justify-between overflow-y-auto  rounded-lg p-4 space-y-2 scrollbar">
           
            <div v-for="(pending, key) in statuses" :key="key"
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
                <span v-else-if="pending.status == 'denied'" class="text-red-400 text-base font-semibold ">Denied</span>
            </div>

        </div>
    </div>
</template>

<script setup>
import TransactionModal from '@/Components/TransactionModal.vue';

const props =defineProps({
    selected: String,
    statuses: Array,
     equipments: Object,
        provinces: Object,

})
const emit = defineEmits(['submit'])
function getSubmit(form){
    emit('submit', form)
}
</script>

<style lang="scss" scoped>

</style>