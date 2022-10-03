<template>
    <div class="overflow-auto relative items-center">
        <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400 overflow-auto">
            <thead class="static text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                <tr>
                    <th scope="col" class="py-3 px-2 text-center">
                        serial number
                    </th>
                    <th scope="col" class="py-3 px-2 text-center">
                        model number
                    </th>
                    <th scope="col" class="py-3 px-2 text-center">
                        Code
                    </th>
                    <th scope="col" class="py-3 px-2 text-center">
                        unit
                    </th>
                    <th scope="col" class="py-3 px-2 text-center">
                        asset ID
                    </th>

                </tr>
            </thead>
            <tbody class="">

                <EquipmentModelList v-for="equipment in equipments" :key="equipment.id" :equipment="equipment"
                    @picked="pick" />
            </tbody>
        </table>
    </div>
</template>

<script>
import EquipmentModelList from './EquipmentModelList.vue';

export default {
    components: {
        EquipmentModelList
    },
    props: {
        equipments: Array
    },
    methods: {
        pick(equipment) {
            this.$emit('picked', equipment)
        }
    },
    setup() {




        return {}
    }
}
</script>

<style lang="scss" scoped>

</style>