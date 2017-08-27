<template>
    <div class="mb-3">
        <input type="hidden" name="rrule" :value="rrule"/>

        <div class="form-check">
            <label class="form-check-label">
                <input type="checkbox" class="form-check-input" v-model="recurring">
                {{ trans('form.recurring') }}
            </label>
        </div>

        <div class="form-row" v-if="recurring">
            <div class="col">
                <label for="freq">{{ trans('form.recurringFrequency') }}</label>
                <select id="freq" class="form-control" v-model="freq">
                    <option value="3">{{ trans('frequency.daily') }}</option>
                    <option value="2">{{ trans('frequency.weekly') }}</option>
                    <option value="1">{{ trans('frequency.monthly') }}</option>
                    <option value="0">{{ trans('frequency.yearly') }}</option>
                </select>
            </div>
            <div class="col">
                <label for="interval">{{ trans('form.recurringInterval') }}</label>
                <div class="input-group mb-2 mb-sm-0">
                    <input type="number" min="1" max="50" step="1" id="interval"
                           class="form-control" v-model="interval"/>
                    <div class="input-group-addon" v-if="freq == 3">
                        {{ trans('frequencyUnit.days') }}
                    </div>
                    <div class="input-group-addon" v-if="freq == 2">
                        {{ trans('frequencyUnit.weeks') }}
                    </div>
                    <div class="input-group-addon" v-if="freq == 1">
                        {{ trans('frequencyUnit.months') }}
                    </div>
                    <div class="input-group-addon" v-if="freq == 0">
                        {{ trans('frequencyUnit.years') }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    let RRule = require('rrule').RRule;
    let rrulestr = require('rrule').rrulestr;

    export default {
        props: ['rule'],
        computed: {
            rrule: function () {
                if(!this.recurring) {
                    return '';
                }
                return new RRule({
                    freq: this.freq,
                    interval: this.interval
                });
            }
        },
        data() {
            try{
                console.log(this.rule);
                let rule = rrulestr(this.rule);
                return {
                    'recurring': true,
                    'freq': rule.options.freq,
                    'interval': rule.options.interval
                }
            } catch(exception) {
                console.log(exception);
                return {
                    'recurring': false,
                    'freq': RRule.DAILY,
                    'interval': 1
                }
            }
        }
    }
</script>
