<template>
    <div class="container px-6 mx-auto grid">
        <div class="py-12">

            <div class="bg-white overflow-hidden cstm-shadow sm:rounded-lg p-2">
                <slot />
            </div>

        </div>
      

    </div>
</template>

<script>
export default {
    setup() {


        return {}
    }
}
</script>

<style scoped>
.cstm-shadow{
    box-shadow: rgba(0, 0, 0, 0.1) 0px 10px 15px -3px, rgba(0, 0, 0, 0.05) 0px 4px 6px -2px;
}
</style>