<template>
    <div>
        <button :class="classes" class="w-full text-start" v-if="as == 'button'">
            <slot></slot>
        </button>

        <a class="flex space-s-3" :href="href" :class="classes" v-else-if="as == 'url'">
            <slot />
        </a>

        <Link class="flex space-s-3" :href="href" :class="classes" v-else>
            <slot />
        </Link>
    </div>
</template>

<script>
    import { defineComponent } from 'vue';
    import { Link } from '@inertiajs/inertia-vue3';

    export default defineComponent({
        components: {
            Link,
        },
        props: ['active', 'href', 'as'],

        computed: {
            classes() {
                return this.active
                    ? 'block ps-3 pe-4 py-2 border-s-4 border-indigo-400 text-base font-medium text-indigo-700 bg-indigo-50 focus:outline-none focus:text-indigo-800 focus:bg-indigo-100 focus:border-indigo-700 transition'
                    : 'block ps-3 pe-4 py-2 border-s-4 border-transparent text-base font-medium text-gray-600 hover:text-gray-800 hover:bg-gray-50 hover:border-gray-300 focus:outline-none focus:text-gray-800 focus:bg-gray-50 focus:border-gray-300 transition'
            }
        }
    })
</script>
