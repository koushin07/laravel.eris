<template class="smooth">

    <Head :title="equipments.name" />
    <!-- <ContentBox class="bg-white">
        <div class="flex flex-row space-x-2 w-full ">
            <div
                class="p-4 box-content flex flex-col shadow bg-custom w-3/2 h-full rounded-2xl m-5 transition ease-in-out delay-50 bg-blue-500 hover:-translate-y-1 hover:scale-110  duration-200 cursor-pointer">
                <div class="text-center -translate-y-8  ">
                    <span
                        class=" text-3xl font-bold tracking-widest  w-fit text-center font-tohama  text-orange-400 bg-text">
                        {{ equipments.name }}
                    </span>
                </div>
                <div class="flex flex-col sm:flex-row ">
                    <span class="text-xl font-bold  sm:border-r-2 t border-black py-2 pr-2">TRANSACTION

                    </span>
                    <div class="flex flex-col pl-2 justify-between">
                        {{ tracks.mean ? 'tracks' : '' }}
                        <span class="text-lg font-semibold">Borrowed: {{ tracks.mean ? tracks.mean[0]?.total_of_borrow :
                                0
                        }}</span>
                        <span class="text-lg font-semibold">Returned: {{ tracks.mean ? tracks.mean[1]?.total_of_return :
                                0
                        }}</span>
                    </div>

                </div>


              


            </div>





        </div>

    </ContentBox> -->
    <div class="flex flex-col justify-end h-fit p-5">
        <span class="text-xl font-bold  ">
            {{ equipments.name }}
        </span>

    </div>
    <Content-box class="h-fit">
        <div class="box-content flex flex-col w-full space-y-3">
            <span class="text-xl text-start font-semibold border-b-2 border-gray-100 p-3">
                Attributes
            </span>
            <div class="flex flex-row place-content-end space-x-10 border-b-gray-100 p-3 border-b-2">

                <v-select :options="['Serviceable', 'Poor', 'Unusable']" placeholder="Status" class=" w-1/3"
                    v-model="equipmentStatus" />


                <!-- <input type="date" class="rounded" v-model="date"> -->
                <!-- <Datepicker v-model="date" :enable-time-picker="false" no-hours-overlay :is-24="false" /> -->
            </div>
            <div class="relative ">
                <table class="table-auto  w-full text-sm border-x border-orange-200 text-gray-500 dark:text-gray-400">
                    <thead
                        class="text-xs text-gray-700 text-center uppercase bg-orange-300 dark:bg-gray-700 dark:text-gray-400">
                        <tr>
                            <th scope="col" class="py-3 px-6" v-for="(head, key) in tableHeader " :key="key">
                                {{ head.name }}



                            </th>

                        </tr>
                    </thead>
                    <tbody v-for="(body, key) in owned.data">
                        <tr
                            class="max-h-full even:bg-gray-200  bg-white border-b  drop-shadow dark:bg-gray-800 dark:border-gray-700">
                            <td scope="row" class="text-center p-4">
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
                            <!-- <td class="text-center">
                    {{ moment(body.recieved_at).format('MMMM DD Y') }}
                </td> -->
                            <td class="text-center">
                                <button @click="collapsible = collapsible === body ? '' : body" type="button"
                                    class="font-medium dark:text-orange-500 hover:underline">
                                    <!-- <EditModal :form="body" /> -->
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                        stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
                                    </svg>

                                </button>


                            </td>
                        </tr>
                        <tr v-if="Object.keys(collapsible).length !== 0 && collapsible.serial_number === body.serial_number"
                            class="m-4 border max-h-full shadow bg-gray-50 dark:bg-gray-800 dark:border-gray-700">
                            <td scope="row" class="text-center p-4 ">
                                <div class="flex flex-col">
                                    <span class="text-slate-500 ">
                                        Serviceable
                                    </span>
                                    <span class=" ">
                                        {{ body.serviceable }}
                                    </span>
                                </div>
                            </td>
                            <td class="text-center">
                               
                            </td>
                            <td scope="row" class="text-center p-4 ">
                                <div class="flex flex-col">
                                    <span class="text-slate-500 ">
                                        Poor
                                    </span>
                                    <span class=" ">
                                        {{ body.poor }}
                                    </span>
                                </div>
                            </td>
                            <td class="text-center">
                               
                            </td>
                            <td scope="row" class="text-center p-4 ">
                                <div class="flex flex-col">
                                    <span class="text-slate-500 ">
                                        Unusable
                                    </span>
                                    <span class=" ">
                                        {{ body.unserviceable }}
                                    </span>
                                </div>
                            </td>

                            
                           
                            <td class="text-center">
                                

                            </td>
                            <!-- <td class="text-center">
                    {{ moment(body.recieved_at).format('MMMM DD Y') }}
                </td> -->
                            <td class="text-center" v-if="$page.props.auth.user.assign_office.municipality">

                                <div href="javascript:void(0)" type="button"
                                    class="font-medium text-orange-600 dark:text-orange-500 hover:underline flex flex-row justify-center space-x-4">
                                    <EditModal :form="body" />
                                    <StatusModal :detail_id="body.detail_id" />
                                </div>


                            </td>
                        </tr>
                    </tbody>
                </table>
                <div class="bg-white ">
                    <Pagination :links="owned.links" />


                </div>
            </div>


        </div>
    </Content-box>
    <Content-box>
        <span class="text-xl font-semibold p-4">
            Transaction History
        </span>
        <table class="table-auto  w-full text-sm border-x text-gray-500 dark:text-gray-400 ">
            <thead
                class="text-xs text-gray-700 text-center uppercase bg-orange-300 dark:bg-gray-700 dark:text-gray-400">
                <tr>
                    <th scope="col" rowspan='2' class="text-base p-2 border-r-2">
                        municipality
                    </th>
                    <th scope="col" rowspan='1' colspan="2" class="text-base p-2 ">
                        TOTAL
                    </th>

                    <th scope="col" rowspan='1' colspan="3" class="text-base p-2 border-x-2 border-b-2 ">
                        Status
                    </th>
                    <th scope="col" rowspan='1' colspan="2" class="text-base p-2 border-b-2">
                        Date
                    </th>
                    <th scope="col" rowspan='2' colspan="" class="text- p-2 border-l-2">
                        Action
                    </th>

                </tr>
                <tr class="">


                    <th scope="col" rowspan='1' colspan="1" class="text-sm p-2 border-t-2">borrowed</th>
                    <th scope="col" rowspan='1' colspan="1" class="text-sm p-2 border-r-2 border-t-2">return</th>

                    <th scope="col" rowspan='1' colspan="1" class="text-sm p-2">Serviceable</th>
                    <th scope="col" rowspan='1' colspan="1" class="text-sm p-2">Unusable</th>
                    <th scope="col" rowspan='1' colspan="1" class="text-sm p-2 border-r-2">Poor</th>
                    <th scope="col" rowspan='1' colspan="1" class="text-sm p-2 border-r-2">borrowed</th>
                    <th scope="col" rowspan='1' colspan="1" class="text-sm p-2">return</th>


                </tr>
            </thead>
            <tbody>
                <tr class="max-h-full even:bg-gray-200  bg-white border-b dark:bg-gray-800 dark:border-gray-700"
                    v-for="(body, key) in borrow.data">
                    <td scope="row" class="text-center p-4">
                        <span class="text-lg font-semibold">
                            {{ body.municipality }}

                        </span>
                        <span class="block text-sm">{{ body.borrower }}</span>
                    </td>

                    <td class="text-center">
                        {{ body.total_borrow }}
                    </td>
                    <td class="text-center">
                        {{ body.total_return }}
                    </td>
                    <td class="text-center">
                        {{ body.serviceable }}
                    </td>
                    <td class="text-center">
                        {{ body.unserviceable }}
                    </td>
                    <td class="text-center">
                        {{ body.poor }}

                    </td>
                    <td class="text-center">
                        {{ moment(body.date_borrow).format('MMMM DD Y, H:m:a') }}
                    </td>
                    <td class="text-center">
                        <!-- {{ body.date_returned }} -->
                        {{ moment(body.date_returned).isValid() ? moment(body.date_returned).format('MMMM DD Y, H:m:a') : 'Not Yet Returned' }}

                    </td>
                    <!-- <td class="text-center">
                    {{ moment(body.recieved_at).format('MMMM DD Y') }}
                </td> -->
                    <td class="text-center">
                        <inertia-link :href="('/borrow-attrs/' + body.eqip_id)" type="button"
                            class="font-medium text-orange-600 dark:text-orange-500 hover:underline">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                stroke="currentColor" class="w-5 h-5 text-orange-300">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M3.75 3.75v4.5m0-4.5h4.5m-4.5 0L9 9M3.75 20.25v-4.5m0 4.5h4.5m-4.5 0L9 15M20.25 3.75h-4.5m4.5 0v4.5m0-4.5L15 9m5.25 11.25h-4.5m4.5 0v-4.5m0 4.5L15 15" />
                            </svg>


                        </inertia-link>


                    </td>
                </tr>

            </tbody>
        </table>
        <div class="bg-white ">
            <Pagination :links="borrow.links" />


        </div>
    </Content-box>
</template>

<script>
import ProvinceLayout from '@/Layouts/Province/ProvinceLayout.vue';
import MunicipalityLayout from '@/Layouts/MunicipalityLayout.vue';
import { Inertia } from '@inertiajs/inertia';
import ContentBox from '@/Components/ContentBox.vue';
import EditModal from '@/Components/Forms/EditModal.vue'
import Pagination from '@/Components/Pagination.vue';
import moment from 'moment';
import { usePage, Head } from '@inertiajs/inertia-vue3';
import { watch, ref } from 'vue'
import StatusModal from '@/Components/StatusModal.vue'
import AdminLayout from '@/Layouts/AdminLayout.vue'

export default {
    layout: (h, page) => {
        if (!page.props.auth.user.assign_office.municipality && !page.props.auth.user.assign_office.province) {
            return h(AdminLayout, () => page)
        } if (!page.props.auth.user.assign_office.municipality){
            return h(ProvinceLayout, () => page)
        }
        else {
            return h(MunicipalityLayout, () => page)
        }
    },
    components: {
        ContentBox,
        EditModal,
        Pagination,
        Head,
        StatusModal
    },
    props: {
        equipments: Object,
        owned: Object,
        borrow: Object,
        tracks: Object,
    },
    setup() {
        const tableHeader = [
            { name: 'category' },
            { name: 'Model number' },
            { name: 'Serial number' },
            { name: 'Unit' },
            { name: 'Code' },
            { name: 'Asset ID' },
            { name: 'Action' }
        ]
        const search = ref()
        const equipmentStatus = ref()
        const category = ref()
        const date = ref()
        const collapsible = ref({})
        watch(search, value => {

            Inertia.get(usePage().url.value, { search: value }, {
                preserveState: true
            })

        })
        watch(equipmentStatus, value => {
            Inertia.get(usePage().url.value, { status: value }, {
                preserveState: true
            })
        })
        watch(category, value => {
            Inertia.get(usePage().url.value, { category: value }, {
                preserveState: true
            })
        })
        watch(date, value => {
            Inertia.get(usePage().url.value, { date: value }, {
                preserveState: true
            })
        })
        return {
            tableHeader,
            moment,
            search,
            equipmentStatus,
            category,
            date,
            collapsible,
        }
    }
}
</script>

<style scoped>
.shadow {
    box-shadow: rgba(0, 0, 0, 0.24) 0px 3px 8px;

}

.bg-custom {
    background-color: #E8F3D6;
}

.inner-shadow {
    box-shadow: rgba(0, 0, 0, 0.16) 0px 1px 4px;
}

.smooth {
    scroll-behavior: smooth;
}
</style>