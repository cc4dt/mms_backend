<template>
  <td v-show="cell.show">
    <span class="flex flex-row items-center">
      <div v-if="field != null">
        <div v-if="cell.type == 'bool'">
          <span v-if="field" class="fa fa-check fill-sky-700"></span>
          <span v-else class="fa fa-close fill-red-700"></span>
        </div>
        <div v-else-if="cell.type == 'badge'">
          {{field}}
        </div>
        <div v-else-if="cell.type == 'link'">
          <a :href="field" target="_blank">{{field}}</a>
        </div>
        <div v-else-if="cell.type == 'email'">
          <a :href="'mailto:' + field">{{field}}</a>
        </div>
        <div v-else-if="cell.type == 'phone'">
          <a :href="'tel:' + field">{{field}}</a>
        </div>
        <div v-else-if="cell.type == 'date'">
          {{field ? new Date(field).toLocaleDateString("en-US"): ''}}
        </div>
        <div v-else-if="cell.type == 'datetime'">
          {{field ? new Date(field).toLocaleString("en-US"): ''}}
        </div>
        <div v-else>
          {{field}}
        </div>
      </div>
    </span>
  </td>
</template>

<script>

export default {
  props: {
    data: {
      type: String,
      required: true,
    },
    cell: {
      type: Object,
      required: true,
    },
  },
  computed: {
    field() {
      return this.data ?? this.cell.default ?? null;
    }
  }
};
</script>