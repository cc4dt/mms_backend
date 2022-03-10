<template>
  <ButtonWithDropdown placement="bottom-end" :active="hasEnabledFilter">
    <template #button>
      <svg
        xmlns="http://www.w3.org/2000/svg"
        class="h-5 w-5"
        :class="{
          'text-gray-400': !hasEnabledFilter,
          'text-green-400': hasEnabledFilter,
        }"
        viewBox="0 0 20 20"
        fill="currentColor"
      >
        <path
          fill-rule="evenodd"
          d="M3 3a1 1 0 011-1h12a1 1 0 011 1v3a1 1 0 01-.293.707L12 11.414V15a1 1 0 01-.293.707l-2 2A1 1 0 018 17v-5.586L3.293 6.707A1 1 0 013 6V3z"
          clip-rule="evenodd"
        />
      </svg>
    </template>

    <div role="menu" aria-orientation="vertical" aria-labelledby="sort-menu">
      <div v-for="filter in filters" :key="filter.key">
        <h3 class="text-xs uppercase tracking-wide bg-gray-100 dark:bg-gray-900 p-3">
          {{ filter.title }}
        </h3>
        <div class="p-2">
          <div v-if="filter.type == 'date_between'" class="space-y-1">
            <input
              class="
                block
                focus:ring-indigo-500 focus:border-indigo-500
                w-full
                shadow-sm
                dark:shadow-gray-100
                dark:bg-gray-700
                sm:text-sm
                border-gray-300
                rounded-md
              "
              type="date"
              :value="
                query.filter[filter.key] ? query.filter[filter.key][0] : null
              "
              @change="onChangeBetween(filter.key, $event.target.value, 0)"
            />
            <input
              v-if="query.filter[filter.key] && query.filter[filter.key][0]"
              class="
                block
                focus:ring-indigo-500 focus:border-indigo-500
                w-full
                shadow-sm
                dark:shadow-gray-100
                dark:bg-gray-700
                sm:text-sm
                border-gray-300
                rounded-md
              "
              type="date"
              :value="query.filter[filter.key][1]"
              @change="onChangeBetween(filter.key, $event.target.value, 1)"
            />
          </div>
          <select
            v-else
            v-model="query.filter[filter.key]"
            class="
              block
              focus:ring-indigo-500 focus:border-indigo-500
              w-full
              shadow-sm
              dark:shadow-gray-100
              dark:bg-gray-700
              sm:text-sm
              border-gray-300
              rounded-md
            "
          >
            <option :value="null">-</option>
            <option
              v-for="(option, key) in filter.data"
              :value="key"
              :key="key"
            >
              {{ option }}
            </option>
          </select>
        </div>
      </div>
    </div>
  </ButtonWithDropdown>
</template>

<script>
import ButtonWithDropdown from "./ButtonWithDropdown.vue";
import find from "lodash-es/find";

export default {
  components: {
    ButtonWithDropdown,
  },
  props: {
    filters: {
      type: Object,
      required: true,
    },
    query: {
      type: Object,
      required: true,
    },

    onChange: {
      type: Function,
      required: true,
    },
  },

  computed: {
    hasEnabledFilter() {
      var filterkeys = this.filters.map((i) => i.key)
      return find(
        this.query.filter,
        (filter, key) => {
          console.log(filter, filter && filterkeys.includes(key))
          return filter && (typeof filter !== 'object' || Object.keys(filter).length) && filterkeys.includes(key)
        }
      )
        ? true
        : false;
    },
  },
  methods: {
    onChangeBetween(key, value, side = 0) {
      if (!this.query.filter[key]) this.query.filter[key] = {};
      this.query.filter[key][side] = value;
      if(side==0 && !value) this.query.filter[key] = {}
    },
  },
};
</script>
