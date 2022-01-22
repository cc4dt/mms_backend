<template>
    <app-layout title="Download">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                MMS APP
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-12 text-center">
                    <a :href="route('app.download.android')">
                        <jet-button type="button">
                            Android APK
                        </jet-button>
                    </a>
                    <p class="p-3">version {{version}}</p>
                </div>
            </div>
        </div>
    </app-layout>
</template>

<script>
    import { defineComponent } from 'vue'
    import AppLayout from '@/Layouts/AppLayout.vue'
    import JetButton from '@/Jetstream/Button.vue'
    import { Head, Link } from '@inertiajs/inertia-vue3'

    export default defineComponent({
        components: {
            AppLayout,
            JetButton,
            Link,
            Head,
        },
        props: [
            'downloadLink',
            'version',
        ],
    })
</script>
