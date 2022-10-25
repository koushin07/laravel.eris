<template>
    <div class="box-border h-full bg-white p-2 rounded-xl mt-1 w-full">
        <div class="grid grid-flow-row gap-4">
           <PendingTransaction/>

           
        </div>
    </div>
</template>

<script>
import PendingTransaction from './PendingTransaction.vue';
export default {
    setup() {
        return {};
    },
    components: { PendingTransaction }
}
</script>

<style lang="scss" scoped>

</style>