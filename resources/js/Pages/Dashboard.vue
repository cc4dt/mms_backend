<template>
    <app-layout title="Dashboard">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Dashboard
            </h2>
        </template>

        <div class="p-4 sm:p-8 md:p-12 space-y-4 space-x-4 w-100">
            <div class="flex flex-wrap">
                <Ticket class="m-2" icon="fa fa-clock" title="BD after 4 PM" :count="over4pm.count + 'T'"
                    :total="total.tickets" :percent="over4pm.percent" />
                <Ticket class="m-2" v-for="t in ticketStatusCounts" :key="t" :title="t.key" :count="t.data + 'B'"
                    :total="total.tickets" :percent="t.percent" />
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-2"></div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-2">
                <div class="
            bg-white
            dark:bg-gray-800 dark:text-white
            shadow-xl
            sm:rounded-lg
            px-2
            py-4
          ">
                    <h5 class="
              mb-2
              text-xl
              font-bold
              tracking-tight
              text-gray-900
              dark:text-white
            ">
                        SLA
                    </h5>
                    <DoughnutChart :chartData="slaData" />
                </div>

                <div class="
            bg-white
            dark:bg-gray-800 dark:text-white
            shadow-xl
            sm:rounded-lg
            px-2
            py-4
          ">
                    <h5 class="
              mb-2
              text-xl
              font-bold
              tracking-tight
              text-gray-900
              dark:text-white
            ">
                        Breakdown status
                    </h5>
                    <DoughnutChart :chartData="ticketStatusData" />
                </div>

                <div class="
            bg-white
            dark:bg-gray-800 dark:text-white
            shadow-xl
            sm:rounded-lg
            px-2
            py-4
          ">
                    <h5 class="
              mb-2
              text-xl
              font-bold
              tracking-tight
              text-gray-900
              dark:text-white
            ">
                        Open Breakdowns after 4 PM
                    </h5>
                    <BarChart :style="`height: ` + (creatorAfter4pmData.labels.length + 1) * 24 + `px`"
                        :chartData="creatorAfter4pmData" :options="stationOptions" />
                </div>
                <div class="
            bg-white
            dark:bg-gray-800 dark:text-white
            shadow-xl
            sm:rounded-lg
            px-2
            py-4
          ">
                    <h5 class="
              mb-2
              text-xl
              font-bold
              tracking-tight
              text-gray-900
              dark:text-white
            ">
                        Close Breakdowns after 4 PM
                    </h5>
                    <BarChart :style="`height: ` + (colserAfter4pmData.labels.length + 1) * 24 + `px`"
                        :chartData="colserAfter4pmData" :options="stationOptions" />
                </div>

                <div class="
            bg-white
            dark:bg-gray-800 dark:text-white
            shadow-xl
            sm:rounded-lg
            px-2
            py-4
          ">
                    <h5 class="
              mb-2
              text-xl
              font-bold
              tracking-tight
              text-gray-900
              dark:text-white
            ">
                        Open Breakdowns
                    </h5>
                    <BarChart :style="`height: ` + (creatorData.labels.length + 1) * 24 + `px`" :chartData="creatorData"
                        :options="stationOptions" />
                </div>

                <div class="
            bg-white
            dark:bg-gray-800 dark:text-white
            shadow-xl
            sm:rounded-lg
            px-2
            py-4
          ">
                    <h5 class="
              mb-2
              text-xl
              font-bold
              tracking-tight
              text-gray-900
              dark:text-white
            ">
                        Close Breakdowns
                    </h5>
                    <BarChart :style="`height: ` + (colserData.labels.length + 1) * 24 + `px`" :chartData="colserData"
                        :options="stationOptions" />
                </div>

                <div class="
            bg-white
            dark:bg-gray-800 dark:text-white
            shadow-xl
            sm:rounded-lg
            px-2
            py-4
          ">
                    <h5 class="
              mb-2
              text-xl
              font-bold
              tracking-tight
              text-gray-900
              dark:text-white
            ">
                        Station Breakdowns
                    </h5>
                    <BarChart :style="`height: ` + (stationData.labels.length + 1) * 24 + `px`" :chartData="stationData"
                        :options="stationOptions" />
                </div>

                <div class="
            bg-white
            dark:bg-gray-800 dark:text-white
            shadow-xl
            sm:rounded-lg
            px-2
            py-4
          ">
                    <h5 class="
              mb-2
              text-xl
              font-bold
              tracking-tight
              text-gray-900
              dark:text-white
            ">
                        Breakdown Problems
                    </h5>
                    <BarChart :style="`height: ` + (breakdownData.labels.length + 1) * 24 + `px`" v-if="breakdownCounts"
                        class="h-x2" :chartData="breakdownData" :options="stationOptions" />
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
        creatorAfter4pmCounts: Array,
        colserAfter4pmCounts: Array,
        slaCounts: Array,
    },
    data() {
        console.log(this.slaCounts);
        return {
            slaData: {
                labels: this.slaCounts.map((item) => item.key),
                datasets: [
                    {
                        data: this.slaCounts.map((item) => item.data),
                        backgroundColor: this.slaCounts.map((item) =>
                            this.stringToColor(item.key)
                        ),
                    },
                ],
            },
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
            stationData: {
                labels: this.stationBreakdownCounts
                    .filter((i) => i.data)
                    .map((item) => item.key),
                datasets: [
                    {
                        data: this.stationBreakdownCounts
                            .filter((i) => i.data)
                            .map((item) => item.data),
                        backgroundColor: this.stationBreakdownCounts
                            .filter((i) => i.data)
                            .map((item) => this.stringToColor(item.key)),
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
            creatorData: {
                labels: this.creatorCounts
                    .filter((i) => i.data)
                    .map((item) => item.key),
                datasets: [
                    {
                        data: this.creatorCounts
                            .filter((i) => i.data)
                            .map((item) => item.data),
                        backgroundColor: this.creatorCounts
                            .filter((i) => i.data)
                            .map((item) => this.stringToColor(item.key)),
                    },
                ],
            },
            creatorAfter4pmData: {
                labels: this.creatorAfter4pmCounts
                    .filter((i) => i.data)
                    .map((item) => item.key),
                datasets: [
                    {
                        data: this.creatorAfter4pmCounts
                            .filter((i) => i.data)
                            .map((item) => item.data),
                        backgroundColor: this.creatorAfter4pmCounts
                            .filter((i) => i.data)
                            .map((item) => this.stringToColor(item.key)),
                    },
                ],
            },
            colserAfter4pmData: {
                labels: this.colserAfter4pmCounts
                    .filter((i) => i.data)
                    .map((item) => item.key),
                datasets: [
                    {
                        data: this.colserAfter4pmCounts
                            .filter((i) => i.data)
                            .map((item) => item.data),
                        backgroundColor: this.colserAfter4pmCounts
                            .filter((i) => i.data)
                            .map((item) => this.stringToColor(item.key)),
                    },
                ],
            },
            colserData: {
                labels: this.colserCounts.filter((i) => i.data).map((item) => item.key),
                datasets: [
                    {
                        data: this.colserCounts
                            .filter((i) => i.data)
                            .map((item) => item.data),
                        backgroundColor: this.colserCounts
                            .filter((i) => i.data)
                            .map((item) => this.stringToColor(item.key)),
                    },
                ],
            },
        };
    },
    methods: {
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
        // const stationData = computed(() => ());

        const testData = computed(() => ({
            labels: labels.value,
            datasets: [
                {
                    data: data.value,
                    backgroundColor: labels.value.map(stringToColor),
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
