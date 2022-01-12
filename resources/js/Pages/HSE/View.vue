<template>
  <app-layout title="HSE">
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">HSE</h2>
    </template>

    <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="p-6 sm:px-6 bg-white border-b border-gray-200">
            <table class="min-w-full divide-y divide-gray-200 bg-white divide-y divide-gray-200">
                <tr class="bg-gray-50">
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Station</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Created by</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                </tr>
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{hse.station.name}}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{hse.created_by.name}}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{hse.timestamp}}</td>
                </tr>
                <template v-for="process in hse.processes" :key="process.id">
                    <tr class="bg-gray-50">
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">HSE</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Serial</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Note</th>
                    </tr>
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{process?.hse?.name}}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{process?.equipment?.serial}}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{process?.description}}</td>
                    </tr>
                    <tr class="bg-gray-50">
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Procedure</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Value</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Sparepart</th>
                    </tr>
                    <tr v-for="detail in process?.details ?? []" :key="detail.id">
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{detail?.procedure?.name}}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{detail?.option?.name}} {{detail?.value ? " - " : ""}} {{detail?.value}}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{detail?.spare_part?.name}}</td>
                    </tr>
                </template>
            </table>
        </div>
      </div>
    </div>
  </app-layout>
</template>

<script>
import { defineComponent } from "vue";
import AppLayout from "@/Layouts/AppLayout.vue";
import { Link } from "@inertiajs/inertia-vue3";

import {
  InteractsWithQueryBuilder,
  Tailwind2,
} from "@protonemedia/inertiajs-tables-laravel-query-builder";

export default defineComponent({
//   mixins: [InteractsWithQueryBuilder],

  components: {
    AppLayout,
    Link,
    Table: Tailwind2.Table,
  },
  props: {
    hse: Object,
  },
});
</script>
