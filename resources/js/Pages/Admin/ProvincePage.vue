<template>
    <div class="flex flex-row justify-between flex-row-reverse pb-5">
        <form class="flex items-center">
            <label for="simple-search" class="sr-only">Search</label>
            <div class="relative w-full">
                <div class="flex absolute inset-y-0 left-0 items-center pl-3 pointer-events-none">
                    <svg aria-hidden="true" class="w-5 h-5 text-gray-500 dark:text-gray-400" fill="currentColor"
                        viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd"
                            d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z"
                            clip-rule="evenodd"></path>
                    </svg>
                </div>
                <input type="text" id="simple-search"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full pl-10 p-2.5  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                    placeholder="Search" v-model="search" required>
            </div>

        </form>
        <span class="text-xl font-bold p-2">Provinces</span>

    </div>
    <table class="table-auto  w-full text-sm  text-gray-500 dark:text-gray-400 border-2 border-orange-300">
        <thead class="text-xs text-gray-700 text-center uppercase bg-orange-300 dark:bg-gray-700 dark:text-gray-400">
            <tr>
                <th scope="col" class="py-3 px-6" v-for="(head, key) in tableHeader" :key="key">
                    {{ head.name }}
                </th>

            </tr>
        </thead>
        <tbody>
            <tr class="max-h-full even:bg-orange-200 bg-white border-b dark:bg-gray-800 dark:border-gray-700"
                v-for="(province, key) in provinces.data">
                <td scope="row"
                    class="text-center py-4 px-6 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                    {{ province.province }}
                </td>
                <td scope="row"
                    class="text-center py-4 px-6 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                    {{ province.email }}
                </td>
                <td scope="row"
                    class="text-center py-4 px-6 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                    {{ fullname(province.firstname, province.lastname, province.middlename, province.suffix) }}
                </td>
                <td scope="row"
                    class="text-center py-4 px-6 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                    <div class="flex flex-row justify-center" v-if="province.must_reset_password">
                        <button @click="verify(province.id)"
                            class="text-sm  hover:bg-green-600 mx-2 text-center bg-green-500 px-2 rounded text-white tracking-wide">Verify</button>
                        <button @click="verify(province.id)"
                            class="text-sm  hover:bg-red-600 mx-2 text-center bg-red-500 px-2 rounded text-white tracking-wide">Deny</button>
                    </div>



                    <div class="flex flex-row space-x-1 justify-center" v-else>
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="w-5 h-5 text-green-500">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M9 12.75L11.25 15 15 9.75M21 12c0 1.268-.63 2.39-1.593 3.068a3.745 3.745 0 01-1.043 3.296 3.745 3.745 0 01-3.296 1.043A3.745 3.745 0 0112 21c-1.268 0-2.39-.63-3.068-1.593a3.746 3.746 0 01-3.296-1.043 3.745 3.745 0 01-1.043-3.296A3.745 3.745 0 013 12c0-1.268.63-2.39 1.593-3.068a3.745 3.745 0 011.043-3.296 3.746 3.746 0 013.296-1.043A3.746 3.746 0 0112 3c1.268 0 2.39.63 3.068 1.593a3.746 3.746 0 013.296 1.043 3.746 3.746 0 011.043 3.296A3.745 3.745 0 0121 12z" />
                        </svg>
                        <span class="font-semibold text-green-500">
                            Verified

                        </span>

                    </div>
                </td>


            </tr>

        </tbody>
    </table>
    <Pagination :links="provinces.links" />
</template>

<script>
import Pagination from '@/Components/Pagination.vue';
import AdminLayout from '@/Layouts/AdminLayout.vue';
import { usePage, Head } from '@inertiajs/inertia-vue3';
import { Inertia } from '@inertiajs/inertia';
import { ref, watch, } from 'vue';

export default {
    layout: AdminLayout,
    components: { Pagination, Head },

    props: {
        provinces: Object,
        filters: [Array, Object]
    },
    setup(filters) {
        const tableHeader = [
            { name: "Office" },
            { name: "email" },
            { name: "Personel" },
            { name: " Action" },
        ];
        const search = ref(filters.search)
        watch(search, value => {

            Inertia.get(usePage().url.value, { search: value }, {
                preserveState: true
            })

        })
        const fullname = (fname, lname, mname, suf) => {
            const f = fname ? fname : ''
            const l = lname ? lname : ''
            const m = mname ? mname.charAt(0) : ''
            const s = suf ? suf : ''
            return `${l} ${m} ${f} ${s}`;
        }

        const verify = (id) => {
            Inertia.post('/api/verify/' + id);
        }
        return {
            verify,
            fullname,
            tableHeader,
            search,
        };
    },
}
</script>

<style lang="scss" scoped>

</style>