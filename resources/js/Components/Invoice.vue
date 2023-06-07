<template>
  
<div class="page-content container mx-auto sm:px-4">
    <div class="page-header text-blue-d2">
        <h1 class="page-title text-secondary-d1">
            Invoice
            <small class="page-info">
                <i class="fa fa-angle-double-right text-80"></i>
                ID: #111-222
            </small>
        </h1>

        <div class="page-tools">
            <div class="action-buttons">
                <a class="inline-block align-middle text-center select-none border font-normal whitespace-no-wrap rounded py-1 px-3 leading-normal no-underline bg-white bg-gray-100 text-gray-800 hover:bg-gray-200 mx-1px text-95" href="#" data-title="Print">
                    <i class="mr-1 fa fa-print text-primary-m1 text-120 w-2"></i>
                    Print
                </a>
                <a class="inline-block align-middle text-center select-none border font-normal whitespace-no-wrap rounded py-1 px-3 leading-normal no-underline bg-white bg-gray-100 text-gray-800 hover:bg-gray-200 mx-1px text-95" href="#" data-title="PDF">
                    <i class="mr-1 fa fa-file-pdf-o text-danger-m1 text-120 w-2"></i>
                    Export
                </a>
            </div>
        </div>
    </div>

    <div class="container mx-auto sm:px-4 px-0">
        <div class="flex flex-wrap  mt-4">
            <div class="w-full lg:w-full pr-4 pl-4">
                <div class="flex flex-wrap ">
                    <div class="w-full">
                        <div class="text-center text-150">
                            <i class="fa fa-book fa-2x text-success-m2 mr-1"></i>
                            <span class="text-default-d3">Bootdey.com</span>
                        </div>
                    </div>
                </div>
                <!-- .row -->

                <hr class="flex flex-wrap  brc-default-l1 mx-n1 mb-4" />

                <div class="flex flex-wrap ">
                    <div class="sm:w-1/2 pr-4 pl-4">
                        <div>
                            <span class="text-sm text-grey-m2 align-middle">To:</span>
                            <span class="text-600 text-110 text-blue align-middle">Alex Doe</span>
                        </div>
                        <div class="text-grey-m2">
                            <div class="my-1">
                                Street, City
                            </div>
                            <div class="my-1">
                                State, Country
                            </div>
                            <div class="my-1"><i class="fa fa-phone fa-flip-horizontal text-gray-600"></i> <b class="text-600">111-111-111</b></div>
                        </div>
                    </div>
                    <!-- /.col -->

                    <div class="text-95 sm:w-1/2 pr-4 pl-4 self-start sm:flex justify-end">
                        <hr class="sm:hidden" />
                        <div class="text-grey-m2">
                            <div class="mt-1 mb-2 text-secondary-m1 text-600 text-125">
                                Invoice
                            </div>

                            <div class="my-2"><i class="fa fa-circle text-blue-m2 text-xs mr-1"></i> <span class="text-600 text-90">ID:</span> #111-222</div>

                            <div class="my-2"><i class="fa fa-circle text-blue-m2 text-xs mr-1"></i> <span class="text-600 text-90">Issue Date:</span> Oct 12, 2019</div>

                            <div class="my-2"><i class="fa fa-circle text-blue-m2 text-xs mr-1"></i> <span class="text-600 text-90">Status:</span> <span class="inline-block p-1 text-center font-semibold text-sm align-baseline leading-none rounded bg-orange-400 text-black hover:bg-orange-500 rounded-full py-1 px-3 px-25">Unpaid</span></div>
                        </div>
                    </div>
                    <!-- /.col -->
                </div>

                <div class="mt-4">
                    <div class="flex flex-wrap  text-600 text-white bgc-default-tp1 py-25">
                        <div class="hidden sm:block w-1/6">#</div>
                        <div class="w-3/4 sm:w-2/5 pr-4 pl-4">Description</div>
                        <div class="hidden sm:block w-1/3 sm:w-1/5 pr-4 pl-4">Qty</div>
                        <div class="hidden sm:block sm:w-1/5 pr-4 pl-4">Unit Price</div>
                        <div class="w-1/5">Amount</div>
                    </div>

                    <div class="text-95 text-secondary-d3">
                        <div class="flex flex-wrap  mb-2 sm:mb-0 py-25">
                            <div class="hidden sm:block w-1/6">1</div>
                            <div class="w-3/4 sm:w-2/5 pr-4 pl-4">Domain registration</div>
                            <div class="hidden sm:block w-1/5">2</div>
                            <div class="hidden sm:block w-1/5 text-95">$10</div>
                            <div class="w-1/5 text-secondary-d2">$20</div>
                        </div>

                        <div class="flex flex-wrap  mb-2 sm:mb-0 py-25 bgc-default-l4">
                            <div class="hidden sm:block w-1/6">2</div>
                            <div class="w-3/4 sm:w-2/5 pr-4 pl-4">Web hosting</div>
                            <div class="hidden sm:block w-1/5">1</div>
                            <div class="hidden sm:block w-1/5 text-95">$15</div>
                            <div class="w-1/5 text-secondary-d2">$15</div>
                        </div>

                        <div class="flex flex-wrap  mb-2 sm:mb-0 py-25">
                            <div class="hidden sm:block w-1/6">3</div>
                            <div class="w-3/4 sm:w-2/5 pr-4 pl-4">Software development</div>
                            <div class="hidden sm:block w-1/5">--</div>
                            <div class="hidden sm:block w-1/5 text-95">$1,000</div>
                            <div class="w-1/5 text-secondary-d2">$1,000</div>
                        </div>

                        <div class="flex flex-wrap  mb-2 sm:mb-0 py-25 bgc-default-l4">
                            <div class="hidden sm:block w-1/6">4</div>
                            <div class="w-3/4 sm:w-2/5 pr-4 pl-4">Consulting</div>
                            <div class="hidden sm:block w-1/5">1 Year</div>
                            <div class="hidden sm:block w-1/5 text-95">$500</div>
                            <div class="w-1/5 text-secondary-d2">$500</div>
                        </div>
                    </div>

                    <div class="flex flex-wrap  border-b-2 brc-default-l2"></div>

                    <!-- or use a table instead -->
                    <!--
            <div class="block w-full overflow-auto scrolling-touch">
                <table class="w-full max-w-full mb-4 bg-transparent table-striped table-borderless border-0 border-b-2 brc-default-l1">
                    <thead class="bg-none bgc-default-tp1">
                        <tr class="text-white">
                            <th class="opacity-2">#</th>
                            <th>Description</th>
                            <th>Qty</th>
                            <th>Unit Price</th>
                            <th width="140">Amount</th>
                        </tr>
                    </thead>

                    <tbody class="text-95 text-secondary-d3">
                        <tr></tr>
                        <tr>
                            <td>1</td>
                            <td>Domain registration</td>
                            <td>2</td>
                            <td class="text-95">$10</td>
                            <td class="text-secondary-d2">$20</td>
                        </tr> 
                    </tbody>
                </table>
            </div>
            -->

                    <div class="flex flex-wrap  mt-3">
                        <div class="w-full sm:w-3/5 pr-4 pl-4 text-grey-d2 text-95 mt-2 lg:mt-0">
                            Extra note such as company or payment information...
                        </div>

                        <div class="w-full sm:w-2/5 pr-4 pl-4 text-grey text-90 order-first order-sm-last">
                            <div class="flex flex-wrap  my-2">
                                <div class="w-3/5 text-right">
                                    SubTotal
                                </div>
                                <div class="w-2/5">
                                    <span class="text-120 text-secondary-d1">$2,250</span>
                                </div>
                            </div>

                            <div class="flex flex-wrap  my-2">
                                <div class="w-3/5 text-right">
                                    Tax (10%)
                                </div>
                                <div class="w-2/5">
                                    <span class="text-110 text-secondary-d1">$225</span>
                                </div>
                            </div>

                            <div class="flex flex-wrap  my-2 items-center bgc-primary-l3 p-2">
                                <div class="w-3/5 text-right">
                                    Total Amount
                                </div>
                                <div class="w-2/5">
                                    <span class="text-150 text-success-d3 opacity-2">$2,475</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <hr />

                    <div>
                        <span class="text-secondary-d1 text-105">Thank you for your business</span>
                        <a href="#" class="inline-block align-middle text-center select-none border font-normal whitespace-no-wrap rounded py-1 px-3 leading-normal no-underline bg-teal-500 text-white hover:bg-teal-600 btn-bold px-4 float-right mt-3 lg:mt-0">Pay Now</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</template>

<script setup>
import moment from 'moment';
import axios from 'axios';
import { ref, onMounted } from 'vue';

const equipment = ref()

onMounted(() => {
    axios.get('/api/invoice-data')
        .then((res) => {
            console.log(res.data);
            equipment.value = res.data
        })
})
const tableHeader = [
    { name: 'equipment' },
    { name: 'serial Num' },
    { name: 'model Num' },
    { name: 'category' },
    { name: 'unit' },
    { name: 'asset Description' }
]


</script>

<style lang="scss" scoped>

</style>