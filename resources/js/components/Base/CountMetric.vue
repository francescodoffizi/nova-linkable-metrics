<template>
    <loading-card :loading="loading" class="px-6 py-4">
        <h3 class="flex mb-3 text-base text-80 font-bold">
            {{ title }}

            <span class="ml-auto font-semibold text-70 text-sm"
            >({{ formattedTotal }} {{ __('total') }})</span
            >
        </h3>
        <div class="overflow-hidden overflow-y-auto max-h-90px">
            <ul class="list-reset">
                <li v-for="(item, index) in formattedItems" class="text-xs text-80 leading-normal">
                    <span
                        class="inline-block rounded-full w-2 h-2 mr-2"
                        :style="{
                            backgroundColor: item.color,
                        }"
                    />
                    <router-link tag="a" :to="urls[index]" :title="title"
                                 class="cursor-pointer text-primary dim no-underline">
                        {{ item.label }} ({{ item.value }} - {{ item.percentage }}%)
                    </router-link>
                </li>
            </ul>
        </div>

        <div
            ref="chart"
            :class="chartClasses"
            style="width: 90px; height: 90px; right: 20px; bottom: 30px; top: calc(50% + 15px);"
        />
    </loading-card>
</template>

<script>
import Chartist from 'chartist'
import 'chartist/dist/chartist.min.css'

const colorForIndex = index =>
    [
        '#F5573B',
        '#F99037',
        '#F2CB22',
        '#8FC15D',
        '#098F56',
        '#47C1BF',
        '#1693EB',
        '#6474D7',
        '#9C6ADE',
        '#E471DE',
    ][index]

export default {
    name: 'CountMetric',

    props: {
        title: String,
        helpText: Object,
        helpWidth: Object,
        urls: Array,
    },

    data: () => ({chartist: null}),

    watch: {
        chartData: function (newData, oldData) {
            this.renderChart()
        },
    },

    mounted() {
        this.chartist = new Chartist.Pie(this.$refs.chart, this.formattedChartData, {
            donut: true,
            donutWidth: 10,
            donutSolid: true,
            startAngle: 270,
            showLabel: false,
        })

        this.chartist.on('draw', context => {
            if (context.type === 'slice') {
                context.element.attr({style: `fill: ${context.meta.color} !important`})
            }
        })
    },

    methods: {
        renderChart() {
            this.chartist.update(this.formattedChartData)
        },

        getItemColor(item, index) {
            return typeof item.color === 'string' ? item.color : colorForIndex(index)
        },
    },

    computed: {

        link() {
            return JSON.parse(this.url);
        },

        chartClasses() {
            return [
                'vertical-center',
                'rounded-b-lg',
                'ct-chart',
                'mr-4',
                this.formattedTotal <= 0 ? 'invisible' : '',
            ]
        },

        formattedChartData() {
            return {labels: this.formattedLabels, series: this.formattedData}
        },

        formattedItems() {
            return _(this.chartData)
                .map((item, index) => {
                    return {
                        label: item.label,
                        value: item.value,
                        color: this.getItemColor(item, index),
                        percentage:
                            this.formattedTotal > 0
                                ? ((item.value * 100) / this.formattedTotal).toFixed(2)
                                : '0',
                    }
                })
                .value()
        },

        formattedLabels() {
            return _(this.chartData)
                .map(item => item.label)
                .value()
        },

        formattedData() {
            return _(this.chartData)
                .map((item, index) => {
                    return {
                        value: item.value,
                        meta: {color: this.getItemColor(item, index)},
                    }
                })
                .value()
        },

        formattedTotal() {
            return _.sumBy(this.chartData, 'value')
        },
    },
}
</script>
