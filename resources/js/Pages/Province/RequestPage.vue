<template>
    <Content-box>
        <form class="grid  grid-flow-row gap-8 h-full " @submit.prevent="handleSubmit">
            <div class="flex flex-col space-y-16">
                <label class="text-black text-start font-semibold font-sans text-lg">
                    Municipalities
                </label>
                <Municipality-list :contents="municipalities" @submit="getMuni" />
            </div>
            <div class="flex flex-col space-y-10">
                <label for="reason" class="text-black text-start font-semibold font-sans text-lg">
                    Reason
                </label>
                <input v-model="form.reason" type="text"
                    class="border-b-2 border-0  px-2 py-1  focus:ring-0  focus:border-b-blue-600">

            </div>
            <div class="flex justify-end h-fit">
                <button type="submit" class="px-6 py-2 rounded-lg bg-orange-400 text-black text-lg">
                    Send
                </button>
            </div>

        </form>
    </Content-box>
</template>

<script>
import ContentBox from '@/Components/ContentBox.vue';
import MunicipalityList from '@/Components/Lists/MunicipalityList.vue';
import layout from '@/Layouts/Province/ProvinceLayout.vue'
import { useForm } from '@inertiajs/inertia-vue3';
export default {
    props: {
        municipalities: Array
    },
    layout: layout,
    setup() {
        const form = useForm({
            assign: null,
            reason: ''
        })
        const getMuni = (muni) => {
         console.log(muni.id)
            form.assign = muni.id
        }
        const handleSubmit = async () => {
            console.log(form.assign)
             form.post('/province/incident', {
                onSuccess: form.reset,
                onError: (e)=> alert(Object.values(e))
           })   

        }
        return { 
            form,
            getMuni,
            handleSubmit,
         };
    },
    components: { ContentBox, MunicipalityList }
}
</script>

<style lang="scss" scoped>

</style>