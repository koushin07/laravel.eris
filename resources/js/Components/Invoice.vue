<template>
    <div class="flex flex-col space-y-11 bg-white w-full py-2">
        <div class="flex flex-row justify-between">
            <div class="box-content bg-black text-white pl-11 py-4 pr-3">Incident</div>
            
        </div>
        <div class="px-10">
            <table class="table-auto  w-full text-sm border-x text-gray-500 dark:text-gray-400">
                <thead
                    class="text-xs text-gray-700 text-center uppercase bg-header dark:bg-gray-700 dark:text-gray-400">
                    <tr>
                        <th scope="col" class="py-3 px-6" v-for="(head, key) in tableHeader" :key="key">
                            {{ head.name }}



                        </th>

                    </tr>
                </thead>
                <tbody>
                    <tr class="max-h-full even:bg-gray-200  bg-white border-b dark:bg-gray-800 dark:border-gray-700"
                        v-for="(body, key) in tableBody">
                        <td scope="row" class="py-4 px-6 font-medium  text-gray-900 whitespace-nowrap dark:text-white">
                            {{ body.name }}
                        </td>
                        <td class="text-center">
                            {{ body.category }}
                        </td>
                        <td class="text-center">
                            {{ body.model_number }}
                        </td>
                        <td class="text-center">
                            {{ body.serial_number }}
                        </td>
                        <td class="text-center">
                            {{ body.unit }}
                        </td>
                        <td class="text-center">
                            {{ body.code }}
                        </td>
                        <td class="text-center">
                            {{ body.asset_id }}

                        </td>
                       
                    </tr>

                </tbody>
            </table>
        </div>
    </div>
</template>

<script setup>
const tableHeader = [
    { name: 'equipment' },
    { name: 'serial Num' },
    { name: 'asset ID' }
]
</script>

<style lang="scss" scoped>

</style>