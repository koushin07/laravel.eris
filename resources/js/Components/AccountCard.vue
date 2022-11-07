<template>
    <div class="box-content border-2 h-full w-full rounded-3xl shadow-inner shadow-2xl shadow-orange-500/50">
        <div class="flex flex-col ">
            <div class="box-content flex flex-col h-full w-full py-4 text-center">
                <span class="text-sm font-bold font-sans">municipality</span>
                <span class="font-bold text-2xl">{{ $page.props.auth.user.name }}</span>
            </div>
            <div class="box-content gap-3 h-full w-full grid place-content-center">
                <span class="text-lg font-semibold font-sans antialiased">Gmail:
                    <span class="text-lg"> {{ $page.props.auth.user.email }}</span>
                </span>
                <div class="flex flex-col">
                    <label class="text-sm font-bold align-center mb-0">Password</label>
                    <input type="number"
                        class="border-b-2 border-0 w-full  px-2 py-1  focus:ring-0  focus:border-b-blue-600">

                </div>
                <div class="flex flex-col">
                    <label class="text-sm font-bold align-center mb-0">new Password</label>
                    <input type="number"
                        class="border-b-2 border-0 w-full  px-2 py-1  focus:ring-0  focus:border-b-blue-600">

                </div>
                <div class="flex flex-col">
                    <label class="text-sm font-bold align-center mb-0">Confirm Password</label>
                    <input type="number"
                        class="border-b-2 border-0 w-full  px-2 py-1  focus:ring-0  focus:border-b-blue-600">
                </div>

                <button class="rounded-xl bg-orange-400 py-2  w-full">
                    Save
                </button>


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

<style lang="scss" scoped>

</style>