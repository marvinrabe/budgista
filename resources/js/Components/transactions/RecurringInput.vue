<template>
  <FormGroup name="date" label="recurringInterval">
    <div class="flex items-stretch mb-3">
      <input
        class="form-control border-gray-4 flex-1 w-auto min-w-0 rounded-r-none border-r-0 text-right font-numeric"
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
  </FormGroup>
</template>

<script>
  import FormGroup from '@/Components/form/FormGroup'

  export default {
    components: {
      FormGroup
    },
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
