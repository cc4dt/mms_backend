<template>
  <app-layout title="PM">
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">PM</h2>
    </template>

    <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <Link
          :href="route('pm.create')"
          class="
            mb-4
            inline-flex
            items-center
            px-4
            py-2
            bg-gray-800
            border border-transparent
            rounded-md
            font-semibold
            text-xs text-white
            uppercase
            tracking-widest
            hover:bg-gray-700
            active:bg-gray-900
            focus:outline-none
            focus:border-gray-900
            focus:ring
            focus:ring-gray-300
            disabled:opacity-25
            transition
          "
        >
          Create New
        </Link>
        <div class="p-6 sm:px-6 bg-white border-b border-gray-200">
          <Table
            :filters="queryBuilderProps.filters"
            :search="queryBuilderProps.search"
            :columns="queryBuilderProps.columns"
            :on-update="setQueryBuilder"
            :meta="data"
          >
            <template #head>
              <tr>
                <th
                  v-for="column in queryBuilderProps.columns"
                  v-show="column.enabled"
                  v-bind:key="column.key"
                  @click.prevent="sortBy(column.key)"
                >
                  {{ column.label }}
                </th>
              </tr>
            </template>

            <template #body>
              <tr v-for="row in data.data" :key="row.id">
                <td
                  v-for="column in queryBuilderProps.columns"
                  v-show="showColumn(column.key)"
                  v-bind:key="column.key"
                >
                  {{ row[column.key] }}
                </td>
              </tr>
            </template>
          </Table>
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
  mixins: [InteractsWithQueryBuilder],

  components: {
    AppLayout,
    Link,
    Table: Tailwind2.Table,
  },
  props: {
    data: Object,
  },
});
</script>
