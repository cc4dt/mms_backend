<template>
  <app-layout title="Station">
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">Station</h2>
    </template>

    <div class="py-12 mx-auto sm:p-4 md:p-8 lg:p-12">
      <div class="max-w-7xl mx-auto">
        <div class="py-6 bg-white dark:bg-gray-800 dark:text-slate-400 border-b border-gray-200">
          <datatable class="px-2 sm:px-6" :meta="datatableMeta" :data="paginationData"></datatable>
        </div>
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
    type: Object,
    paginationData: Object,
    datatableMeta: {
      options: Object,
      buttons: Object,
      filters: Object,
      columns: Object,
    },
  },
  data() {
    // console.log(this.datatableMeta)
    return {
    }
  },
});
</script>
