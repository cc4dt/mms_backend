<template>
  <app-layout title="Users">
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">Users</h2>
    </template>

    <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
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
    </div>
  </app-layout>
</template>

<script>
import { defineComponent } from "vue";
import AppLayout from "@/Layouts/AppLayout.vue";

import InteractsWithQueryBuilder from "@/Components/Datatable/InteractsWithQueryBuilder.vue";

import Table from "@/Components/Datatable/Tailwind/Table.vue";

export default defineComponent({
  mixins: [InteractsWithQueryBuilder],

  components: {
    AppLayout,
    Table,
  },
  props: {
    data: Object,
  },
  data() {},
});
</script>