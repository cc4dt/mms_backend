<template>
  <app-layout title="Equipment">
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        Master Data
      </h2>
    </template>

    <div class="py-12 mx-auto sm:p-4 md:p-8 lg:p-12">
      <div class="max-w-7xl mx-auto">
        <datatable class="px-2 sm:px-6" :meta="datatableMeta" :data="paginationData"></datatable>
      </div>
    </div>
  </app-layout>
</template>

<script>
import { defineComponent } from "vue";
import AppLayout from "@/Layouts/AppLayout.vue";
import { Link } from "@inertiajs/inertia-vue3";
import Datatable from "@/Components/Datatable/Index";

export default defineComponent({
  mixins: [Datatable],
  components: {
    AppLayout,
    Link,
    Datatable,
  },
  props: {
    equipment: Array,
    // type: Object,
    paginationData: Object,
    datatableMeta: {
      options: Object,
      buttons: Object,
      filters: Object,
      columns: Object,
    },
  },
  data() {
    return {}
  },
  methods: {},
});
</script>
