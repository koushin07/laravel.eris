<template>
    <tr @click="$emit('picked', equipment)"
        class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 cursor-pointer hover:bg-slate-200">
        <th scope="row" class="py-4 px-2 font-medium text-gray-900 whitespace-nowrap dark:text-white text-center">
            {{ equipment.serial_number }}
        </th>
        <td class="py-4 px-2 text-center">
            {{ equipment.model_number }}
        </td>
        <td class="py-4 px-2 text-center">
            {{ equipment.code }}
        </td>
        <td class="py-4 px-2 text-center">
            {{ equipment.unit }}
        </td>
        <td class="py-4 px-2 text-center">
            {{ equipment.asset_id }}
        </td>

    </tr>
</template>

<script setup>
defineProps({
    equipment: Object
})


</script>

<style lang="scss" scoped>

</style>