<template>
  <div class="text-gray-900 dark:text-white">
    <div class="block space-y-1 md:flex md:space-x-1 md:space-y-0">
      <div class="flex space-x-1">
        <slot
          name="tableFilter"
          :hasFilters="hasFilters"
          :filters="filters"
          :query="query"
          :changeFilterValue="changeFilterValue"
        >
          <TableFilter
            v-if="hasFilters"
            :filters="filters"
            :query="query"
            :on-change="changeFilterValue"
          />
        </slot>
        <slot name="tableSize">
          <div class="relative">
            <select
              v-model="query.size"
              class="
                block
                flex-none
                sm:text-sm
                rounded-md
                shadow-sm
                focus:ring-indigo-500 focus:border-indigo-500
                border-gray-300 
                dark:border-gray-500 dark:bg-gray-800
              "
            >
              <option value="15">15</option>
              <option value="50">50</option>
              <option value="100">100</option>
              <option value="250">250</option>
            </select>
          </div>
        </slot>
        <!-- <slot
        name="tableAddSearchRow"
        :hasSearchRows="hasSearchRows"
        :search="search"
        :newSearch="newSearch"
        :enableSearch="enableSearch"
      >
        <TableAddSearchRow
          v-if="hasSearchRows"
          :rows="search"
          :new="newSearch"
          :on-add="enableSearch"
        />
      </slot> -->

        <slot
          name="tableColumns"
          :hasColumns="hasColumns"
          :columns="columns"
          :changeColumnStatus="changeColumnStatus"
        >
          <TableColumns
            v-if="hasColumns"
            :columns="columns"
            :on-change="changeColumnStatus"
          />
        </slot>
      </div>
      <slot
        name="tableGlobalSearch"
        :search="search"
        :changeGlobalSearchValue="changeGlobalSearchValue"
      >
        <!-- flex-grow  -->
        <div class="flex-grow">
          <TableGlobalSearch
            v-if="options.globalSearch"
            :value="query.filter?.global"
            :on-change="changeGlobalSearchValue"
          />
        </div>
      </slot>
      <div class="flex space-x-1">
        <inertia-link
          v-if="options?.createRoute"
          :href="route(options.createRoute)"
          class="
            inline-flex
            items-center
            px-2
            py-2
            sm:py-auto
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
          Create
        </inertia-link>
        <!-- <a
          :href="route('maintenance.pm.export.index')"
          blank='_target'
          class="
            inline-flex
            items-center
            px-2
            py-2
            sm:py-auto
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
          Export
        </a> -->
      </div>
    </div>

    <!-- <slot
      name="tableSearchRows"
      :hasSearchRows="hasSearchRows"
      :search="search"
      :newSearch="newSearch"
      :disableSearch="disableSearch"
      :changeSearchValue="changeSearchValue"
    >
      <TableSearchRows
        ref="rows"
        v-if="hasSearchRows"
        :rows="search"
        :new="newSearch"
        :on-remove="disableSearch"
        :on-change="changeSearchValue"
      />
    </slot> -->

    <slot name="tableWrapper" :meta="meta">
      <TableWrapper :class="{ 'mt-2': !onlyData }">
        <slot name="table">
          <table class="min-w-full">
            <thead class="bg-gray-50 dark:bg-gray-600">
              <slot name="head">
                <tr>
                  <header-cell
                    v-for="column in columns"
                    :key="column.key"
                    :cell="column"
                    :onSort="onSort"
                  >
                    {{ key }}
                  </header-cell>
                  <th v-if="options.actionButtons"></th>
                </tr>
              </slot>
            </thead>

            <tbody class="">
              <slot name="body">
                <tr v-for="row in rows" :key="row.id" class="odd:bg-gray-100 dark:odd:bg-gray-900">
                  <data-cell
                    v-for="column in columns"
                    :key="column.key"
                    :data="column.key.split('.').reduce((o, i) => o[i], row)"
                    :cell="column"
                  />
                  <td v-if="options.actionButtons">
                    <action-buttons
                      :id="row['id']"
                      v-if="options.actionButtons != false"
                      :showRoute="options.showRoute"
                      :editRoute="options.editRoute"
                      :deleteRoute="options.deleteRoute"
                      :onDeleted="updateData"
                    ></action-buttons>
                  </td>
                </tr>
              </slot>
            </tbody>
          </table>
        </slot>
      </TableWrapper>
      <slot name="pagination">
        <pagination
          v-if="pagination"
          :meta="pagination"
          :onPageChange="onPageChange"
        />
      </slot>
    </slot>
  </div>
</template>

<script>
import Pagination from "./Tailwind/Pagination.vue";
import TableAddSearchRow from "./Tailwind/TableAddSearchRow.vue";
import TableColumns from "./Tailwind/TableColumns.vue";
import TableFilter from "./Tailwind/TableFilter.vue";
import TableGlobalSearch from "./Tailwind/TableGlobalSearch.vue";
import TableSearchRows from "./Tailwind/TableSearchRows.vue";
import TableWrapper from "./Tailwind/TableWrapper.vue";
import HeaderCell from "./Tailwind/HeaderCell.vue";
import DataCell from "./Tailwind/DataCell.vue";
import ActionButtons from "./Tailwind/ActionButtons.vue";
import { Inertia } from "@inertiajs/inertia";

export default {
  components: {
    Pagination,
    TableAddSearchRow,
    TableColumns,
    TableFilter,
    TableGlobalSearch,
    TableSearchRows,
    TableWrapper,
    HeaderCell,
    DataCell,
    ActionButtons,
  },
  props: {
    meta: {
      type: Object,
      default: () => {
        return {};
      },
      required: false,
    },
    data: {
      type: Object,
      required: false,
    },
    // columns: {
    //   type: Object,
    //   default: () => {
    //     return {};
    //   },
    //   required: false,
    // },

    // filters: {
    //   type: Object,
    //   default: () => {
    //     return {};
    //   },
    //   required: false,
    // },

    // search: {
    //   type: Object,
    //   default: () => {
    //     return {};
    //   },
    //   required: false,
    // },

    // onUpdate: {
    //   type: Function,
    //   required: false,
    // },
  },

  computed: {
    hasFilters() {
      return Object.keys(this.filters || {}).length > 0;
    },

    hasColumns() {
      return Object.keys(this.columns || {}).length > 0;
    },

    hasSearchRows() {
      return Object.keys(this.search || {}).length > 0;
    },

    hasBody() {
      return !!this.$slots.body;
    },

    onlyData() {
      if (this.hasFilters || this.hasColumns || this.hasSearchRows) {
        return false;
      }

      if (!this.search) {
        return true;
      }

      return this.search.global ? false : true;
    },
    paginationMeta() {
      if (this.hasBody) {
        return this.meta;
      }

      const hasPagination =
        "meta" in this.meta ||
        ("total" in this.meta && "to" in this.meta && "from" in this.meta);

      if (hasPagination) {
        return this.meta;
      }

      return { meta: { total: 0 } };
    },
  },

  data() {
    return {
      newSearch: [],
      options: {},
      columns: [],
      filters: [],
      search: [],
      query: {},
      pagination: {},
      rows: [],
    };
  },

  mounted() {
    for (const key in this.meta.columns) {
      if (Object.hasOwnProperty.call(this.meta.columns, key)) {
        const column = this.meta.columns[key];
        this.columns.push({
          key: key,
          title: column.title,
          type: column.type,
          show: column.show ?? true,
          sortable: column.sortable ?? true,
          searchable: column.searchable ?? true,
          sort: this.meta.sort?.key == key ? this.meta.sort?.dir : null,
          options: column.options,
        });
        if (column.searchable ?? true)
          this.search.push({
            key: key,
            title: column.title,
            type: column.type,
            show: column.show ?? true,
            options: column.options,
          });
      }
    }
    for (const key in this.meta.filters) {
      if (Object.hasOwnProperty.call(this.meta.filters, key)) {
        const filter = this.meta.filters[key];
        this.filters.push({
          key: key,
          title: filter.title,
          type: filter.type,
          data: filter.data ?? {},
          value: null,
          options: filter.options,
        });
      }
    }

    this.options = {
      globalSearch: this.meta.options?.global_search ?? true,
      actionButtons: this.meta.options?.action_buttons ?? true,
      createRoute: this.meta.options?.create_route ?? null,
      showRoute: this.meta.options?.show_route ?? null,
      editRoute: this.meta.options?.edit_route ?? null,
      deleteRoute: this.meta.options?.delete_route ?? null,
    };
    this.initData();
    this.query = {
      size: 15,
      page: this.data?.total ? this.data.current_page : null,
      sort: this.meta.sort?.key,
      filter: {},
    };
  },

  methods: {
    initData() {
      this.pagination = {
        current: this.data?.total ? this.data.current_page : null,
        pages: this.data?.total ? this.data.last_page : 0,
        path: this.data?.path ?? null,
        total: this.data?.total,
        from: this.data?.from,
        to: this.data?.to,
      };

      if(this.data?.last_page && this.data.last_page < this.query.page) this.query.page = 1

      this.rows = this.data?.data;
    },
    onSort(key) {
      this.columns.forEach((column) => {
        if (column.key == key) {
          if (column.sort == "asc") {
            column.sort = "desc";
            this.query.sort = "-" + key;
          } else {
            column.sort = "asc";
            this.query.sort = key;
          }
        } else {
          column.sort = null;
        }
      });
    },
    onPageChange(page) {
      this.query.page = page;
    },
    updateData() {
      this.onUpdate(this.query);
    },
    disableSearch(key) {
      this.newSearch = this.newSearch.filter((search) => search != key);

      this.queryBuilderData.search[key].enabled = false;
      this.queryBuilderData.search[key].value = null;
    },

    enableSearch(key) {
      this.queryBuilderData.search[key].enabled = true;
      this.newSearch.push(key);

      this.$nextTick(() => {
        this.$refs["rows"].focus(key);
      });
    },

    changeSearchValue(key, value) {
      this.query.filter[key] = value;
    },

    changeGlobalSearchValue(value) {
      this.changeSearchValue("global", value);
    },

    changeFilterValue(key, value) {
      this.query.filter[key] = value;
    },

    changeColumnStatus(column, status) {
      this.columns[column].show = status;
    },
    onUpdate(query) {
      var data = {};
      for (const key in query) {
        if (Object.hasOwnProperty.call(query, key) && query[key]) {
          data[key] = query[key];
        }
      }
      if (this.data?.path)
        Inertia.get(this.data.path, data, {
          only: ["paginationData"],
          replace: true,
          preserveState: true,
          preserveScroll: true,
          onSuccess: (fn) => {
            this.initData();
          },
        });
    },
  },

  watch: {
    query: {
      deep: true,
      handler() {
        this.onUpdate(this.query);
      },
    },
  },
};
</script>

<style scoped>
/*
TODO: Convert to @apply
*/

table >>> th {
  font-weight: 500;
  font-size: 0.75rem;
  line-height: 1rem;
  padding-top: 0.75rem;
  padding-bottom: 0.75rem;
  padding-left: 1.5rem;
  padding-right: 1.5rem;
  text-align: left;
  --tw-text-opacity: 1;
  text-transform: uppercase;
  letter-spacing: 0.05em;
}

table >>> td {
  font-size: 0.875rem;
  line-height: 1.25rem;
  padding-top: 1rem;
  padding-bottom: 1rem;
  padding-left: 1.5rem;
  padding-right: 1.5rem;
  --tw-text-opacity: 1;
  white-space: nowrap;
}

/* table >>> tr:hover td {
  --tw-bg-opacity: 1;
  background-color: rgba(249, 250, 251, var(--tw-bg-opacity));
} */
</style>