<template>
    <div class="input-group mb-3">
        <div class="input-group-prepend">
            <span class="input-group-text"
                  v-t="'form.recurringInterval'">
            </span>
        </div>
        <input class="form-control"
               type="number"
               min="1"
               max="50"
               step="1"
               v-model="interval"
               @input="input">
        <div class="input-group-append">
            <select class="form-control"
                    v-model="frequency"
                    @input="input">
                <option value="3">{{ $t('frequencyUnit.days') }}</option>
                <option value="2">{{ $t('frequencyUnit.weeks') }}</option>
                <option value="1">{{ $t('frequencyUnit.months') }}</option>
                <option value="0">{{ $t('frequencyUnit.years') }}</option>
            </select>
        </div>
    </div>
</template>

<script>
    import RRule from 'rrule'
    import {rrulestr} from 'rrule'

    export default {
        props: ['value'],
        data() {
            let rule = null;

            try {
                rule = rrulestr(this.value + ';COUNT=1')
            } catch(e) {
                // do nothing
            }

            return {
                frequency: rule ? rule.options.freq : RRule.MONTHLY,
                interval: rule ? rule.options.interval : 1
            }
        },
        computed: {
            rrule() {
                return new RRule({
                    freq: this.frequency,
                    interval: this.interval
                }).toString()
            }
        },
        mounted() {
            this.input();
        },
        methods: {
            input() {
                this.$emit('input', this.rrule)
            }
        }
    }
</script>