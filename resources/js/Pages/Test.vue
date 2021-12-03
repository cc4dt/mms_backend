<template>
    <app-layout title="Test">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Test
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                    <inertia-table 
                    :data="users" 
                    id="id" 
                    :order="order" 
                    :filters="filters" 
                    :columns="columns" 
                    routeName="users" 
                    createLink="users.create" 
                    @item-selected="show">
                    </inertia-table>
                </div>
            </div>
        </div>
    </app-layout>
</template>

<script>
    import { defineComponent } from 'vue'
    import AppLayout from '@/Layouts/AppLayout.vue'

    export default defineComponent({
        props: {
            users: Array,
            filters: Object,
            order: Object,
        },
        data() {
            return {
            columns: ["name", "email"],
            }
        },
        methods: {
            show(user) {
            this.$inertia.replace(this.route('users.edit', user.id));
            }
        },
        components: {
            AppLayout,
        },
    })
</script>
