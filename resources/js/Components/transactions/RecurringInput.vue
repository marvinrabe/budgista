<template>
  <div class="flex items-stretch mb-3">
    <div class="rounded-l bg-gray-1 border border-gray-4 flex px-1 items-center whitespace-no-wrap">
      <span
        v-t="'form.recurringInterval'"
      />
    </div>
    <input
      class="form-control border-gray-4 flex-1 w-auto min-w-0 rounded-none border-l-0 border-r-0"
      max="50"
      style="width: initial;"
      min="1"
      step="1"
      type="number"
      v-model="interval"
    >
    <select
      class="form-control w-auto rounded-l-none"
      v-model="frequency"
    >
      <option value="DAILY">
        {{ $t('frequencyUnit.days') }}
      </option>
      <option value="WEEKLY">
        {{ $t('frequencyUnit.weeks') }}
      </option>
      <option value="MONTHLY">
        {{ $t('frequencyUnit.months') }}
      </option>
      <option value="YEARLY">
        {{ $t('frequencyUnit.years') }}
      </option>
    </select>
  </div>
</template>

<script>

  export default {
    props: {
      value: {
        type: Object,
        default: null
      }
    },
    data () {
      return {
        frequency: this.value ? this.value.frequency : 'MONTHLY',
        interval: this.value ? this.value.interval : 1
      }
    },
    mounted () {
      this.input()
    },
    watch: {
      frequency () {
        this.input()
      },
      interval () {
        this.input()
      }
    },
    methods: {
      input () {
        this.$emit('input', {
          frequency: this.frequency,
          interval: parseInt(this.interval)
        })
      }
    }
  }
</script>
