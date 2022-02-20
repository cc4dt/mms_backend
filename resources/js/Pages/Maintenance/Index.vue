<template>
  <app-layout title="HSE">
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">HSE</h2>
    </template>

    <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <Link
          :href="route(createRoute)"
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
          <div class="datatable">
            <table class="min-w-full border border-gray-200" id="dt-users">
            </table>
          </div>
        </div>
      </div>
      <!-- </div> -->
    </div>
  </app-layout>
</template>

<script>
import { defineComponent } from "vue";
import AppLayout from "@/Layouts/AppLayout.vue";
import { Link } from "@inertiajs/inertia-vue3";
import Datatable from "@/Shared/Table.vue";

export default defineComponent({
  mixins: [Datatable],
  components: {
    AppLayout,
    Link,
  },
});
</script>
