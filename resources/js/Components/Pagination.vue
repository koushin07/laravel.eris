    <template>


        <div class="flex justify-center" v-if="links.length>3">
           
            <div class="md:flex hidden">
                <template v-for="(link, key) in links">
                    <Link class="text-sm font-medium leading-none cursor-pointer text-gray-600 " :href="link.url"
                        v-html="link.label" v-if="link.url"
                        :class="link.active ? 'text-orange-700 dark:text-orange-400 border-t border-orange-400 pt-3 mr-4 px-2' : 'dark:text-gray-200  hover:text-orange-700 dark:hover:text-indigo-400 border-t border-transparent hover:border-orange-400 pt-3 mr-4 px-2'"
                        preserve-scroll>

                    </Link>

                    <span v-else-if="key===0" 
                        class="text-sm font-medium leading-none text-gray-400 cursor-not-allowed dark:text-gray-200   border-t border-transparent  pt-3 mr-4 px-2"
                        v-html="link.label">
                    </span>
                    <span v-else-if="link.url===null"
                        class="text-sm font-medium leading-none text-gray-400 cursor-not-allowed dark:text-gray-200   border-t border-transparent  pt-3 mr-4 px-2"
                        v-html="link.label">
                    </span>

                </template>


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