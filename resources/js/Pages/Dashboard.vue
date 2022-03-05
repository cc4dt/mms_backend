<template>
  <app-layout title="Dashboard">
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">Dashboard</h2>
    </template>

    <div class="p-4 sm:p-12 space-y-4 space-x-4 w-100">
      <!-- grid grid-flow-col gap-4 -->
      <div class="flex flex-wrap">
        <Ticket
        class=" m-2"
          icon="fa fa-clock"
          title="BD after 4 PM"
          :count="over4pm.count + 'T'"
          :total="total.tickets"
          :percent="over4pm.percent"
        />
        <Ticket
        class=" m-2"
          v-for="t in ticketStatusCounts"
          :key="t"
          :title="t.key + ' Breakdown'"
          :count="t.data + 'B'"
          :total="total.tickets"
          :percent="t.percent"
        />
        
      </div>
      <div class="grid grid-cols-1 md:grid-cols-2 gap-2">
        <div class="bg-white shadow-xl sm:rounded-lg px-2 py-4">
          <BarChart
            style="height: 1000px"
            :chartData="stationData"
            :options="stationOptions"
          />
        </div>
        <div class="bg-white shadow-xl sm:rounded-lg px-2 py-4">
          <BarChart
            style="height: 1000px"
            v-if="breakdownCounts"
            class="h-x2"
            :chartData="breakdownData"
            :options="stationOptions"
          />
        </div>
        
        <div class="bg-white shadow-xl sm:rounded-lg px-2 py-4">
          <BarChart
            :chartData="creatorData"
            :options="stationOptions"
          />
        </div>
        
        <div class="bg-white shadow-xl sm:rounded-lg px-2 py-4">
          <BarChart
            :chartData="colserData"
            :options="stationOptions"
          />
        </div>
      </div>
    </div>
  </app-layout>
</template>

<script>
import { computed, defineComponent, ref } from "vue";
import { shuffle } from "lodash";

import AppLayout from "@/Layouts/AppLayout.vue";
import Welcome from "@/Jetstream/Welcome.vue";
import Ticket from "@/Components/Dashborad/Ticket.vue";

import { DoughnutChart, BarChart, LineChart, PieChart } from "vue-chart-3";
import { Chart, registerables } from "chart.js";

const uuidv4 = require("uuid/v4");

Chart.register(...registerables);

export default defineComponent({
  components: {
    AppLayout,
    Welcome,
    DoughnutChart,
    BarChart,
    LineChart,
    PieChart,
    Ticket,
  },

  props: {
    stationBreakdownCounts: Array,
    breakdownCounts: Array,
    TicketStatusCounts: Array,
    total: Object,
    over4pm: Object,
    ticketStatusCounts: Array,
    creatorCounts: Array,
    colserCounts: Array,
  },
  data() {
    console.log(this.colserCounts);
    return {
      stationData: {
        labels: this.stationBreakdownCounts.filter((i) => i.data).map((item) => item.key),
        datasets: [
          {
            data: this.stationBreakdownCounts.filter((i) => i.data).map((item) => item.data),
            backgroundColor: this.stationBreakdownCounts.filter((i) => i.data).map((item) =>
              this.stringToColour(item.key)
            ),
          },
        ],
      },
      breakdownData: {
        labels: this.breakdownCounts.filter((i) => i.data).map((item) => item.key),
        datasets: [
          {
            data: this.breakdownCounts.filter((i) => i.data).map((item) => item.data),
            backgroundColor: this.breakdownCounts.filter((i) => i.data).map((item) =>
              this.stringToColour(item.key)
            ),
          },
        ],
      },
      creatorData: {
        labels: this.creatorCounts.filter((i) => i.data).map((item) => item.key),
        datasets: [
          {
            data: this.creatorCounts.filter((i) => i.data).map((item) => item.data),
            backgroundColor: this.creatorCounts.filter((i) => i.data).map((item) =>
              this.stringToColour(item.key)
            ),
          },
        ],
      },
      colserData: {
        labels: this.colserCounts.filter((i) => i.data).map((item) => item.key),
        datasets: [
          {
            data: this.colserCounts.filter((i) => i.data).map((item) => item.data),
            backgroundColor: this.colserCounts.filter((i) => i.data).map((item) =>
              this.stringToColour(item.key)
            ),
          },
        ],
      },
    };
  },
  methods: {
    stringToColour: function (str) {
      var hash = 0;
      for (var i = 0; i < str.length; i++) {
        hash = str.charCodeAt(i) + ((hash << 5) - hash);
      }
      var colour = "#";
      for (var i = 0; i < 3; i++) {
        var value = (hash >> (i * 8)) & 0xff;
        colour += ("00" + value.toString(16)).substr(-2);
      }
      return colour;
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
      aspectRatio: 1,
      maintainAspectRatio: false,
      legend: { display: false },
      indexAxis: "y",
      elements: {
        bar: {
          borderWidth: 2,
        },
      },
      scaleShowValues: true,
      scales: {
        xAxes: [
          {
            ticks: {
              autoSkip: false,
            },
          },
        ],
      },
      plugins: {
        legend: {
          position: "top",
          display: false,
          // title: {
          //   display: true,
          //   text: "Chart.js Doughnut Chart",
        },
      },
    });
    // const stationData = computed(() => ());

    const testData = computed(() => ({
      labels: labels.value,
      datasets: [
        {
          data: data.value,
          backgroundColor: labels.value.map(stringToColour),
          // backgroundColor: [
          //   "#77CEFF",
          //   "#0079AF",
          //   "#123E6B",
          //   "#97B0C4",
          //   "#A5C8ED",
          // ],
        },
      ],
    }));

    function shuffleData() {
      data.value = shuffle(data.value);
    }

    return { testData, shuffleData, options, stationOptions };
  },
});
</script>
