<template>
  <nav
    class="
      bg-white
      px-4
      py-3
      flex
      items-center
      justify-between
      border-t border-gray-200
      sm:px-6
    "
  >
    <p v-if="meta.total < 1">{{ translations.no_results_found }}</p>
    <!-- <div class="flex-1 flex justify-between sm:hidden">
      <component
        :is="meta.current != 1 ? 'inertia-link' : 'div'"
        @click="meta.current != 1 ? onPageChange(1) : null"
        class="
          relative
          inline-flex
          items-center
          px-4
          py-2
          border border-gray-300
          text-sm
          font-medium
          rounded-md
          text-gray-700
          bg-white
          hover:text-gray-500
        "
        >{{ "<<" }}</component
      >
      <component
        :is="meta.current != 1 ? 'inertia-link' : 'div'"
        @click="meta.current != 1 ? onPageChange(meta.current - 1) : null"
        class="
          relative
          inline-flex
          items-center
          px-4
          py-2
          border border-gray-300
          text-sm
          font-medium
          rounded-md
          text-gray-700
          bg-white
          hover:text-gray-500
        "
        >{{ "<" }}</component
      >
      <component
        v-for="page in meta.pages"
        :key="page"
        :is="meta.current != page ? 'inertia-link' : 'div'"
        @click="meta.current != page ? onPageChange(page) : null"
      >
        {{ page }}
      </component>
      <component
        :is="meta.current != meta.pages ? 'inertia-link' : 'div'"
        @click="
          meta.current != meta.pages ? onPageChange(meta.current + 1) : null
        "
        class="
          ml-3
          relative
          inline-flex
          items-center
          px-4
          py-2
          border border-gray-300
          text-sm
          font-medium
          rounded-md
          text-gray-700
          bg-white
          hover:text-gray-500
        "
        >{{ ">" }}</component
      >
      <component
        :is="meta.current != meta.pages ? 'inertia-link' : 'div'"
        @click="meta.current != meta.pages ? onPageChange(meta.pages) : null"
        class="
          ml-3
          relative
          inline-flex
          items-center
          px-4
          py-2
          border border-gray-300
          text-sm
          font-medium
          rounded-md
          text-gray-700
          bg-white
          hover:text-gray-500
        "
        >{{ ">>" }}</component
      >
    </div> -->
    <div
      v-if="meta.pages > 0"
      class="sm:flex-1 sm:flex sm:items-center sm:justify-between"
    >
      <div>
        <p class="lg:block text-sm text-gray-700">
          <span class="font-medium">{{ meta.from }}</span>
          {{ translations.to }}
          <span class="font-medium">{{ meta.to }}</span>
          {{ translations.of }}
          <span class="font-medium">{{ meta.total }}</span>
          {{ translations.results }}
        </p>
      </div>
      <div>
        <nav
          class="relative z-0 inline-flex rounded-md shadow-sm -space-x-px"
          aria-label="Pagination"
        >
          <component
            :is="meta.current != 1 ? 'button' : 'div'"
            type="button"
            @click="meta.current != 1 ? onPageChange(1) : null"
            class="
              relative
              inline-flex
              items-center
              px-2
              py-2
              rounded-l-md
              border border-gray-300
              bg-white
              text-sm
              font-medium
              text-gray-500
              hover:bg-gray-50
            "
          >
            <span class="fa fa-backward"></span>
          </component>
          <!-- <component
            :is="meta.current != 1 ? 'button' : 'div'"
            type="button"
            @click="meta.current != 1 ? onPageChange(meta.current - 1) : null"
            class="
              relative
              inline-flex
              items-center
              px-2
              py-2
              border border-gray-300
              bg-white
              text-sm
              font-medium
              text-gray-500
              hover:bg-gray-50
            "
          >
            <span class="fa fa-backward"></span
          ></component> -->
          <component
            v-for="page in pages"
            :key="page"
            :is="meta.current != page ? 'button' : 'div'"
            type="button"
            class="
              relative
              inline-flex
              items-center
              px-4
              py-2
              border border-gray-300
              bg-white
              text-sm
              font-medium
              text-gray-700
              hover:bg-gray-50
            "
            :class="{
              'bg-gray-100': meta.current == page,
            }"
            @click="meta.current != page ? onPageChange(page) : null"
          >
            {{ page }}
          </component>
          <!-- <component
            :is="meta.current != meta.pages ? 'button' : 'div'"
            type="button"
            @click="
              meta.current != meta.pages ? onPageChange(meta.current + 1) : null
            "
            class="
              relative
              inline-flex
              items-center
              px-2
              py-2
              border border-gray-300
              bg-white
              text-sm
              font-medium
              text-gray-500
              hover:bg-gray-50
            "
          >
            <span class="fa fa-forward"></span>
          </component> -->
          <component
            :is="meta.current != meta.pages ? 'button' : 'div'"
            type="button"
            @click="
              meta.current != meta.pages ? onPageChange(meta.pages) : null
            "
            class="
              relative
              inline-flex
              items-center
              px-2
              py-2
              rounded-r-md
              border border-gray-300
              bg-white
              text-sm
              font-medium
              text-gray-500
              hover:bg-gray-50
            "
          >
            <span class="fa fa-forward"></span
          ></component>
        </nav>
      </div>
    </div>
  </nav>
</template>

<script>
const Pagination = {
  defaultTranslations: {
    no_results_found: "No results found",
    previous: "Previous",
    next: "Next",
    to: "to",
    of: "of",
    results: "results",
  },

  setTranslations(translations) {
    Pagination.defaultTranslations = translations;
  },
};
export default {
  props: {
    onPageChange: {
      type: Function,
      required: false,
    },
    meta: {
      type: Object,
      required: false,
    },
  },

  methods: {
    range(start, stop, step) {
      var a = [start],
        b = start;
      while (b < stop) {
        a.push((b += step || 1));
      }
      return a;
    },
  },
  computed: {
    pages() {
      var f = this.meta.current > 1 ? this.meta.current - 2: 0;
      var l = this.meta.current < this.meta.pages ? this.meta.current + 1 : this.meta.pages;
      return this.range(1, this.meta.pages).slice(f, l)
    },
    translations() {
      return Pagination.defaultTranslations;
    },

    //   hasPagination() {
    //     return Object.keys(this.pagination).length > 0;
    //   },

    //   pagination() {
    //     if ("total" in this.meta && "to" in this.meta && "from" in this.meta) {
    //       return this.meta;
    //     }

    //     if ("meta" in this.meta) {
    //       return this.meta.meta;
    //     }

    //     return {};
    //   },

    //   previousPageUrl() {
    //     if ("prev_page_url" in this.pagination) {
    //       return this.pagination.prev_page_url;
    //     }

    //     if ("links" in this.meta) {
    //       return this.meta.links.prev;
    //     }
    //   },

    //   nextPageUrl() {
    //     if ("next_page_url" in this.pagination) {
    //       return this.pagination.next_page_url;
    //     }

    //     if ("links" in this.meta) {
    //       return this.meta.links.next;
    //     }
    //   },
  },
};
</script>
