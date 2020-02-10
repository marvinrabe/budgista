<template>
  <div class="input-group mb-3">
    <div class="input-group-prepend">
      <span
        class="input-group-text"
        v-t="'form.recurringInterval'"
      />
    </div>
    <input
      class="form-control"
      max="50"
      min="1"
      step="1"
      type="number"
      v-model="interval"
    >
    <div class="input-group-append">
      <select
        class="form-control"
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
