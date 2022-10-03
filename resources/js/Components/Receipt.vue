<template>
    <table class="table-auto">

        <tbody class="cursor-pointer">
            <tr class="flex flex-col space-y-2">
                <td class="flex flex-col">
                    <span class="mb-1 text-md font-bold leading-normal dark:text-white text-slate-700">
                        Equipment: <span class="text-xs text-zinc-900 leading-tight">
                            {{ receipt.equipment }}
                        </span>
                    </span>
                </td>
                <td class="flex flex-col">
                    <span class="mb-1 text-md font-bold leading-normal dark:text-white text-slate-700">
                        Municipality: <span class="text-xs text-zinc-900 leading-tight">
                            {{ receipt.municipality }}
                        </span>
                    </span>
                </td>
                <td class="flex flex-col">
                    <span class="mb-1 text-sm font-semibold leading-normal dark:text-white text-slate-700">
                        Serial Number: <span class="text-xs text-zinc-900 leading-tight">
                            {{ receipt.serial }}
                        </span>
                    </span>
                </td>
                <td class="flex flex-col">
                    <span class="mb-1 text-sm font-semibold leading-normal dark:text-white text-slate-700">
                        Model Number: <span class="text-xs text-zinc-900 leading-tight">
                            {{ receipt.model }}
                        </span>
                    </span>
                </td>



            </tr>

        </tbody>
    </table>
</template>

<script>
export default {
    props: {
        receipt: Object
    },
    setup() {


        return {}
    }
}
</script>

<style lang="scss" scoped>

</style>