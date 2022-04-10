<template>
  <app-layout title="Equipment">
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        Master Data
      </h2>
    </template>

    <div class="py-12 mx-auto sm:p-4 md:p-8 lg:p-12">
      <div class="max-w-7xl mx-auto">
        <!-- <div
          class="
            grid grid-cols-1
            sm:grid-cols-2
            md:grid-cols-3
            lg:grid-cols-4
            gap-2
          "
        >
          <div
            v-for="(item, index) in equipment"
            class="
              shadow-lg
              rounded-2xl
              p-2
              bg-white
              dark:bg-gray-800
              items-center
            "
            :key="index"
          >
            <h4 class="text-center">{{ item.station.name }}</h4>
            <h5 class="text-center">{{ item.equipment.name }}</h5>
            <qrcode class="self-center mx-auto" :value="item.serial"></qrcode>
            <p class="text-center py-2 text-clip overflow-hidden ...">
              {{ item.serial }}
            </p>
          </div>
        </div> -->
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
