<template>
    <Content-box>
        <table class="table-auto  w-full text-sm border-x text-gray-500 dark:text-gray-400">
        <thead class="text-xs text-gray-700 text-center uppercase bg-header dark:bg-gray-700 dark:text-gray-400">
            <tr>
                <th scope="col" class="py-3 px-6" v-for="(head, key) in tableHead" :key="key">
                    {{ head.name }}
                   


                </th>

            </tr>
        </thead>
        <tbody>
            <tr class="max-h-full even:bg-gray-200  bg-white border-b dark:bg-gray-800 dark:border-gray-700"
                v-for="(body, key) in attrs" :key="key">
                <td scope="row" class="text-center p-4" >
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
                <td class="text-center">
                    {{ body.created_at }}

                </td>
                <td class="text-center" v-if="editable">
                    <button href="javascript:void(0)" type="button"
                        class="font-medium text-orange-600 dark:text-orange-500 hover:underline">
                        <EditModal :form="body" />

                    </button>


                </td>
            </tr>

        </tbody>
    </table>

    </Content-box>
</template>

<script>
import MunicipalityLayout from '@/Layouts/MunicipalityLayout.vue'
import ContentBox from '@/Components/ContentBox.vue'
export default {
    layout: MunicipalityLayout,
    components:{
        ContentBox
    },
    props:{
        attrs: Object
    },
    setup () {
        const tableHead = [
            { name: "Equipment" },
            { name: "Category" },
            { name: "Model" },
            { name: "Serial" },
            { name: "Unit" },
            { name: "Code" },
            { name: "Asset ID" },
            { name: "Date" },
            { name: "Action" }
        ]
        

        return {
            tableHead,
        }
    }
}
</script>

<style lang="scss" scoped>

</style>