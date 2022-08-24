<template>
  <app-layout :title="station.name">
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ station.name }}</h2>
    </template>

    <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="grid grid-cols-6 gap-6">
          <div class="col-span-6 sm:col-span-4 space-y-6">
            <div class='overflow-x-auto relative shadow-md sm:rounded-lg'>
              <table
                class="w-full text-sm text-center text-gray-500 dark:text-gray-400 border-collapse border border-slate-500">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                  <tr>
                    <th scope="col" class="py-3 px-6 border border-slate-600" rowspan="3">Station</th>
                    <th scope="col" class="py-3 px-6 border border-slate-600"
                      v-for="maintenance in needs.columns.maintenances" :key="maintenance.id"
                      :colspan="maintenance.count">{{ maintenance.name }}</th>
                    <th scope="col" class="py-3 px-6 border border-slate-600" rowspan="3">Total</th>
                  </tr>

                  <tr v-if="needs.columns.procedures">
                    <th scope="col" class="py-3 px-6 border border-slate-600" v-for="item in needs.columns.procedures"
                      :key="item.id" :colspan="item.count > 1 ? item.count : 1" :rowspan="item.count > 1 ? 1 : 2">{{
                          item.name
                      }}
                    </th>
                  </tr>
                  <tr v-if="needs.columns.spares">
                    <th scope="col" class="py-3 px-6 border border-slate-600" v-for="item in needs.columns.spares"
                      :key="item.id">{{ item.name
                      }}</th>
                  </tr>
                </thead>
                <tbody>
                  <tr v-for="row in needs.rows" :key="row.id"
                    class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                    <th scope="row" class="py-4 px-6 font-medium text-gray-900 whitespace-nowrap dark:text-white">{{
                        row.name
                    }}</th>
                    <td v-for="item in row.items" :key="item.id" class="py-4 px-6">{{ item ? item : '' }}</td>
                    <th scope="row" class="py-4 px-6 font-medium text-gray-900 whitespace-nowrap dark:text-white">{{
                        formatter.format(row.total)
                    }}</th>
                  </tr>
                </tbody>
                <tfoot class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                  <tr>
                    <th scope="col" class="py-3 px-6">Price</th>
                    <th scope="col" class="py-3 px-6" v-for="item in needs.priceRow" :key="item.id">{{
                        formatter.format(item)
                    }}</th>
                    <th scope="col" class="py-3 px-6"></th>
                  </tr>
                  <tr>
                    <th scope="col" class="py-3 px-6">SUM</th>
                    <th scope="col" class="py-3 px-6" v-for="item in needs.sumRow" :key="item.id">{{ item }}</th>
                    <th scope="col" class="py-3 px-6">{{ needs.sumRow.reduce((partialSum, a) => partialSum + a, 0) }}
                    </th>
                  </tr>
                  <tr>
                    <th scope="col" class="py-3 px-6">Total</th>
                    <th scope="col" class="py-3 px-6" v-for="item in needs.totalRow" :key="item.id">{{
                        formatter.format(item)
                    }}</th>
                    <th scope="col" class="py-3 px-6">{{ formatter.format(needs.totalRow.reduce((partialSum, a) =>
                        partialSum + a, 0))
                    }}
                    </th>
                  </tr>
                </tfoot>
              </table>
            </div>

            <card>
              <template #header>
                <div class="
              h-12
              border-b border-gray-200
              dark:border-gray-500
              px-2
              flex
              justify-between
              items-center
            ">
                  <h2>Breakdown Problems</h2>
                </div>
              </template>
              <div class="p-2">
                <BarChart :style="`height: ` + (breakdownData.labels.length + 1) * 24 + `px`" v-if="breakdownCounts"
                  class="h-x2" :chartData="breakdownData" :options="stationOptions" />
              </div>
            </card>
          </div>
          <div class="col-span-6 sm:col-span-2 space-y-6">
            <card>
              <ul class="space-y-2 p-4">
                <li>
                  <fai icon="fa-solid fa-location-dot" /> {{ station.state.name }}
                </li>
                <li>
                  <fai icon="fa-solid fa-clipboard-list" /> {{ ticketsCount }}
                </li>
                <li>
                  <fai icon="fa-solid fa-money-check-dollar" /> {{ formatter.format(needs.totalRow.reduce((partialSum,
                      a) =>
                      partialSum + a, 0))
                  }}
                </li>
              </ul>
            </card>
            <card>
              <template #header>
                <div class="
              h-12
              border-b border-gray-200
              dark:border-gray-500
              px-2
              flex
              justify-between
              items-center
            ">
                  <h2>Latest Activities</h2>
                </div>
              </template>

              <div class="p-2 space-y-2 overflow-x-hidden overflow-y-auto" style="max-height: 250px">
                <div v-for="t in tickets" :key="t.id">
                  <inertia-link :href="route('ticket.show', t.id)">
                    <div class="bg-gray-200 dark:bg-gray-900 rounded-md px-2 py-2">
                      <div class="flex justify-between">
                        <div>{{ t.station.name }}</div>
                        <div>
                          {{ t.openline?.created_by?.name }}
                        </div>
                      </div>
                      <div>{{ t.breakdown.name }}</div>
                      <div class="flex justify-between">
                        <div>
                          {{ t.timeline?.status?.name }}
                        </div>
                        <div>
                          {{ timeAgo(t.timeline?.timestamp) }}
                        </div>
                      </div>
                    </div>
                  </inertia-link>
                </div>
              </div>
            </card>
            <div class="
            bg-white
            dark:bg-gray-800 dark:text-white
            shadow-xl
            sm:rounded-lg
          ">
              <div class="
              h-12
              border-b border-gray-200
              dark:border-gray-500
              px-2
              flex
              justify-between
              items-center
            ">
                <h2>Equipment</h2>
                <div>{{ equipment.length }}</div>
              </div>
              <div class="px-2 py-4 space-y-2 overflow-x-hidden overflow-y-auto" style="max-height: 250px">
                <div v-for="t in equipment" :key="t.id">
                  <inertia-link :href="route('master.show', t.id)">
                    <div class="bg-gray-200 dark:bg-gray-900 rounded-md px-2 py-2">
                      <div class="flex justify-between">
                        <div>{{ t.equipment.name }}</div>
                        <div>
                          {{ t.serial }}
                        </div>
                      </div>
                      <!-- <div>{{ t.breakdown.name }}</div>
                      <div class="flex justify-between">
                        <div>
                          {{ t.timeline?.status?.name }}
                        </div>
                        <div>
                          {{ timeAgo(t.timeline?.timestamp) }}
                        </div>
                      </div> -->
                    </div>
                  </inertia-link>
                </div>
              </div>
            </div>

            <card>
              <template #header>
                <div class="
              h-12
              border-b border-gray-200
              dark:border-gray-500
              px-2
              flex
              justify-between
              items-center
            ">
                  <h2>Breakdown status</h2>
                </div>
              </template>
              <div class="p-2">
                <DoughnutChart :chartData="ticketStatusData" />
              </div>
            </card>
          </div>
        </div>
      </div>
    </div>
  </app-layout>
</template>

<script>
import { computed, defineComponent, ref } from "vue";
import { shuffle } from "lodash";

import AppLayout from "@/Layouts/AppLayout.vue";
import Card from "@/Components/Card.vue";
import { Link } from "@inertiajs/inertia-vue3";
import TimeAgo from "javascript-time-ago";

import {
  InteractsWithQueryBuilder,
  Tailwind2,
} from "@protonemedia/inertiajs-tables-laravel-query-builder";

import { DoughnutChart, BarChart, LineChart, PieChart } from "vue-chart-3";
import { Chart, registerables } from "chart.js";

Chart.register(...registerables);

export default defineComponent({
  //   mixins: [InteractsWithQueryBuilder],

  components: {
    AppLayout,
    Link,
    Card,
    Table: Tailwind2.Table,
    DoughnutChart,
    BarChart,
    LineChart,
    PieChart,
  },
  props: {
    station: Object,
    needs: Object,
    tickets: Array,
    equipment: Array,
    ticketStatusCounts: Array,
    ticketsCount: Number,
    breakdownCounts: Array,
  },
  data() {
    return {
      formatter: new Intl.NumberFormat('en-US', {
        style: 'currency',
        currency: 'USD',

        // These options are needed to round to whole numbers if that's what you want.
        //minimumFractionDigits: 0, // (this suffices for whole numbers, but will print 2500.10 as $2,500.1)
        //maximumFractionDigits: 0, // (causes 2500.99 to be printed as $2,501)
      }),

      ticketStatusData: {
        labels: this.ticketStatusCounts.map((item) => item.key),
        datasets: [
          {
            data: this.ticketStatusCounts.map((item) => item.data),
            backgroundColor: this.ticketStatusCounts.map((item) =>
              this.stringToColor(item.key)
            ),
          },
        ],
      },
      breakdownData: {
        labels: this.breakdownCounts
          .filter((i) => i.data)
          .map((item) => item.key),
        datasets: [
          {
            data: this.breakdownCounts
              .filter((i) => i.data)
              .map((item) => item.data),
            backgroundColor: this.breakdownCounts
              .filter((i) => i.data)
              .map((item) => this.stringToColor(item.key)),
          },
        ],
      },
    }
  },
  methods: {
    timeAgo: (date) => {
      const timeAgo = new TimeAgo("ar");
      return timeAgo.format(new Date(date));
    },
    stringToColor: function (str) {
      var hash = 0;
      for (var i = 0; i < str.length; i++) {
        hash = str.charCodeAt(i) + ((hash << 5) - hash);
      }
      var color = "#";
      for (var i = 0; i < 3; i++) {
        var value = (hash >> (i * 8)) & 0xff;
        color += ("00" + value.toString(16)).substr(-2);
      }
      return color;
    },
  },

  setup() {
    const options = ref({
      responsive: true,
      plugins: {
        legend: {
          position: "top",
          display: false,
        },
        title: {
          display: true,
          text: "Chart.js Doughnut Chart",
        },
      },
    });

    const stationOptions = ref({
      responsive: true,
      maintainAspectRatio: false,
      legend: { display: false },
      indexAxis: "y",
      elements: {
        bar: {
          borderWidth: 2,
        },
      },
      plugins: {
        legend: {
          position: "top",
          display: false,
        },
      },
    });

    function shuffleData() {
      data.value = shuffle(data.value);
    }

    return { shuffleData, options, stationOptions };
  },
});
</script>
