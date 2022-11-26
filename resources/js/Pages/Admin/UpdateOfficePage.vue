<template>
    <div class="flex items-center min-h-screen p-6 bg-gray-50 dark:bg-gray-900 z-0">
        <div class="flex-1 h-full max-w-4xl mx-auto overflow-hidden bg-white rounded-lg shadow-xl dark:bg-gray-800">
            <div class="flex flex-col overflow-y-auto md:flex-row">
                <div class="h-32 md:h-auto md:w-1/2">
                    <img aria-hidden="true" class="object-cover w-full h-full dark:hidden" src="/landingpage/binan.jpg"
                        alt="Office">
                    <img aria-hidden="true" class="hidden object-cover w-full h-full dark:block"
                        src="/landingpage/binan.jpg" alt="Office">
                </div>
                <form @submit.prevent="handleSubmit" class="flex items-center justify-center p-6 sm:p-12 md:w-1/2">
                    <div class="w-full">
                        <h1 class="mb-4 text-xl font-semibold text-gray-700 dark:text-gray-200">
                            Re-Assign {{ office.name }}'s Province
                        </h1>
                        <label class="block text-sm">
                            <span class="text-gray-700 dark:text-gray-400">Province</span>
                            <ProvinceList @submit="getProvince" :contents="provinces"></ProvinceList>
                        </label>

                        <!-- You should use a button here, as the anchor is only used for the example  -->
                        <button @submit.prevent="handleSubmit" class="block w-full px-4 py-2 mt-4 text-sm font-medium leading-5 text-center text-white transition-colors duration-150 bg-purple-600 border border-transparent rounded-lg active:bg-purple-600 hover:bg-purple-700 focus:outline-none focus:shadow-outline-purple"
                            >
                            Save
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</template>

<script>
import ProvinceList from '@/Components/Lists/ProvinceList.vue';
import { useForm } from '@inertiajs/inertia-vue3';
import { ref } from 'vue';

export default {
    props: {
        provinces: Object,
        office: Object
    },
    setup({ office }) {
        const selected = ref()
        const form = useForm({
            province: ''
           
        })
        const handleSubmit = ()=>{
            form.put(route('rdrrmc.office.update', office.id))
        }
        const getProvince = (province) => {
            console.log(province);
            selected.value = province.id
            form.province = province.province
            
        }

        return {
            getProvince,
            handleSubmit,
        };
    },
    components: { ProvinceList }
}
</script>

<style lang="scss" scoped>

</style>