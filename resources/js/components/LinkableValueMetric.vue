<template>
    <BaseValueMetric
        @selected="handleRangeSelected"
        :title="card.name"
        :previous="previous"
        :value="value"
        :ranges="card.ranges"
        :format="format"
        :prefix="prefix"
        :suffix="suffix"
        :suffix-inflection="suffixInflection"
        :selected-range-key="selectedRangeKey"
        :loading="loading"
        :url="this.url"
    />
</template>

<script>
import { Minimum } from 'laravel-nova'
import BaseValueMetric from './Base/ValueMetric'
import ValueMetric from "./Base/ValueMetric";

export default {

    extends: ValueMetric,

    components: {
        BaseValueMetric
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
        format: '(0[.]00a)',
        value: 0,
        previous: 0,
        prefix: '',
        suffix: '',
        suffixInflection: true,
        selectedRangeKey: null,
    }),

    watch: {
        resourceId() {
            this.fetch()
        },
    },

    created() {
        if (this.hasRanges) {
            this.selectedRangeKey = this.card.ranges[0].value
        }
    },

    mounted() {
        this.fetch(this.selectedRangeKey)
    },

    methods: {
        handleRangeSelected(key) {
            this.selectedRangeKey = key
            this.fetch()
        },

        fetch() {
            this.loading = true

            Minimum(Nova.request().get(this.metricEndpoint, this.rangePayload)).then(
                ({
                    data: {
                        value: { value, previous, prefix, suffix, suffixInflection, format, url },
                    },
                }) => {
                    this.value = value
                    this.format = format || this.format
                    this.prefix = prefix || this.prefix
                    this.suffix = suffix || this.suffix
                    this.suffixInflection = suffixInflection
                    this.previous = previous
                    this.loading = false
                    this.url = url;
                }
            )
        },
    },

    computed: {
        hasRanges() {
            return this.card.ranges.length > 0
        },

        rangePayload() {
            return this.hasRanges ? { params: { range: this.selectedRangeKey } } : {}
        },

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
