import Chart from 'chart.js/auto';

import { h } from "vue";

export function generateChart(chartId, chartType) {
    return {
        render: function () {
            return h(
                "div",
                {
                    style: this.styles,
                    class: this.cssClasses,
                },
                [
                    h("canvas", {
                        attrs: {
                            id: this.chartId,
                            width: this.width,
                            height: this.height,
                        },
                        ref: "canvas",
                    }),
                ]
            );
        },

        props: {
            chartId: {
                default: chartId,
                type: String,
            },
            width: {
                default: 400,
                type: Number,
            },
            height: {
                default: 400,
                type: Number,
            },
            cssClasses: {
                type: String,
                default: "",
            },
            styles: {
                type: Object,
            },
            plugins: {
                type: Array,
                default() {
                    return [];
                },
            },
        },

        data() {
            return {
                _chart: null,
                _plugins: this.plugins,
            };
        },

        methods: {
            addPlugin(plugin) {
                this._plugins.push(plugin);
            },
            generateLegend() {
                if (this._chart) {
                    return this._chart.generateLegend();
                }
            },
            renderChart(data, options) {
                if (this._chart) this._chart.destroy();
                if (!this.$refs.canvas)
                    throw new Error(
                        "Please remove the <template></template> tags from your chart component. See https://vue-chartjs.org/guide/#vue-single-file-components"
                    );
                this._chart = new Chart(this.$refs.canvas.getContext("2d"), {
                    type: chartType,
                    data: data,
                    options: options,
                    plugins: this._plugins,
                });
            },
        },
        beforeDestroy() {
            if (this._chart) {
                this._chart.destroy();
            }
        },
    };
}
export const Bar = generateChart("bar-chart", "bar");
export const HorizontalBar = generateChart(
    "horizontalbar-chart",
    "horizontalBar"
);
export const Doughnut = generateChart("doughnut-chart", "doughnut");
export const Line = generateChart("line-chart", "line");
export const Pie = generateChart("pie-chart", "pie");
export const PolarArea = generateChart("polar-chart", "polarArea");
export const Radar = generateChart("radar-chart", "radar");
export const Bubble = generateChart("bubble-chart", "bubble");
export const Scatter = generateChart("scatter-chart", "scatter");

export default {
  Bar,
  HorizontalBar,
  Doughnut,
  Line,
  Pie,
  PolarArea,
  Radar,
  Bubble,
  Scatter
}