<template>
  <app-layout :title="Equipment">
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">Equipment</h2>
    </template>

    <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="p-6 sm:px-6 bg-white dark:bg-gray-800 dark:text-slate-400 border-b border-gray-200">
            <table class="min-w-full divide-y divide-gray-200 bg-white divide-y divide-gray-200">
                <tr class="bg-gray-50">
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Station</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Equipment</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Serial</th>
                </tr>
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{master.station.name}}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{master.equipment.name}}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{master.serial}}</td>
                </tr>
                <template v-for="item in master.details" :key="item.id">
                    <tr class="bg-gray-50">
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Attribute</th>
                        <th colspan="2" scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Value</th>
                    </tr>
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{item?.attribute?.name}}</td>
                        <td colspan="2" class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{item?.value}}</td>
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
    master: Object,
  },
});
</script>
