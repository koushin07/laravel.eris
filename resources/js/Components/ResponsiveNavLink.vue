<script setup>
import { computed } from 'vue';
import { Link } from '@inertiajs/inertia-vue3';

const props = defineProps({
    active: Boolean,
    href: String,
    as: String,
});

const classes = computed(() => {
    return props.active
        ? 'absolute inset-y-0 left-0 w-1 bg-purple-600 rounded-tr-lg rounded-br-lg'
        : 'absolute inset-y-0 left-0 w-1 mr-1 rounded-tr-lg rounded-br-lg';
});
</script>

<template>
    <li class="relative px-6 py-3">
        <span :class="classes"
                            aria-hidden="true"></span>
                          
        <Link :href="href"  class="inline-flex items-center w-full text-sm font-semibold text-gray-800 transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200 dark:text-gray-100">
            <slot />
        </Link>

        <!-- <Link v-else :href="href" :class="classes">
            <slot />
        </Link> -->
    </li>
</template>
