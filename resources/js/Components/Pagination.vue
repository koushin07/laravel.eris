    <template>

    <div class="flex items-center justify-center pb-4 lg:px-0 sm:px-6 px-2 ml-2" v-if="links.length>3">
        <div class="lg:w-3/5 w-full  flex items-center justify-between border-t border-gray-200 dark:border-gray-700">
           
            <div class="sm:flex hidden">
                <template v-for="(link, key) in links">
                    <Link class="text-sm font-medium leading-none cursor-pointer text-gray-600 " :href="link.url"
                        v-html="link.label" v-if="link.url"
                        :class="link.active ? 'text-indigo-700 dark:text-indigo-400 border-t border-indigo-400 pt-3 mr-4 px-2' : 'dark:text-gray-200  hover:text-indigo-700 dark:hover:text-indigo-400 border-t border-transparent hover:border-indigo-400 pt-3 mr-4 px-2'"
                        preserve-scroll>

                    </Link>

                    <span v-else-if="key===0"
                        class="text-sm font-medium leading-none cursor-pointer text-gray-600 dark:text-gray-200   border-t border-transparent  pt-3 mr-4 px-2"
                        v-html="link.label">
                    </span>

                </template>


            </div>
           

        </div>
        
    </div>
   
</template>

<script setup>
import { Link } from '@inertiajs/inertia-vue3';
const props = defineProps({ 
    links: Array,
})


</script>

<style lang="scss" scoped>

</style>