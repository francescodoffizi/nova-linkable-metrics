<template>
    <BaseCountMetric
        :title="card.name"
        :chart-data="chartData"
        :loading="loading"
        :urls="this.card.urls"
    />
</template>

<script>
import {Minimum} from 'laravel-nova'
import BaseCountMetric from './Base/CountMetric'
import CountMetric from "./Base/CountMetric";

export default {

    extends: CountMetric,

    components: {
        BaseCountMetric
    },

    props: {
        card: {
            type: Object,
            required: true,
        },

        resourceName: {
            type: String,
            default: '',
        },

        resourceId: {
            type: [Number, String],
            default: '',
        },

        lens: {
            type: String,
            default: '',
        },
    },

    data: () => ({
        loading: true,
        chartData: [],
    }),

    watch: {
        resourceId() {
            this.fetch()
        },
    },

    created() {
        this.fetch()
    },

    methods: {
        fetch() {
            this.loading = true

            Minimum(Nova.request(this.metricEndpoint)).then(({data: {value: {value}}}) => {
                this.chartData = value
                this.loading = false
            })
        },
    },
    computed: {
        metricEndpoint() {
            const lens = this.lens !== '' ? `/lens/${this.lens}` : ''
            if (this.resourceName && this.resourceId) {
                return `/nova-api/${this.resourceName}${lens}/${this.resourceId}/metrics/${this.card.uriKey}`
            } else if (this.resourceName) {
                return `/nova-api/${this.resourceName}${lens}/metrics/${this.card.uriKey}`
            } else {
                return `/nova-api/metrics/${this.card.uriKey}`
            }
        },
    },
}
</script>
