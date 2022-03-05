<template>
  <app-layout title="Test">
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">Test</h2>
    </template>

    <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
          <div class="p-6 sm:px-6 bg-white border-b border-gray-200">
              <datatable :meta="datatableMeta" :data="paginationData"></datatable>
          </div>
        </div>
      </div>
    </div>
  </app-layout>
</template>

<script>
import { defineComponent } from "vue";
import AppLayout from "@/Layouts/AppLayout.vue";

import Datatable from "@/Components/Datatable/Index";

export default defineComponent({
  components: {
    AppLayout,
    Datatable,
  },
  props: {
    paginationData: Object,
    datatableMeta: {
      options: Object,
      buttons: Object,
      filters: Object,
      columns: Object,
    },
  },
  data() {
      return {};
  }
});
</script>