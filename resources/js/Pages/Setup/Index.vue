<template>
  <Layout :step="1" :title="$t('title.setupCurrency')" @next="save">
    <p class="mb-4">{{ $t('message.setupCurrency') }}</p>
    <FormGroup name="currency">
      <AppSelect
        slot-scope="{bindings}"
        v-bind="bindings"
        v-model="form.currency"
      >
        <option
          :key="key"
          :value="key"
          v-for="(currency, key) in currencies">
          {{ currency }}
        </option>
      </AppSelect>
    </FormGroup>
  </Layout>
</template>

<script>
  import Layout from '@/Layouts/Setup'
  import FormGroup from '@/Components/form/FormGroup'
  import AppSelect from '@/Components/AppSelect'

  export default {
    components: {
      AppSelect,
      FormGroup,
      Layout
    },
    props: {
      currencies: Object
    },
    data () {
      return {
        form: {
          currency: this.$page.user.currency
        }
      }
    },
    methods: {
      save () {
        this.$inertia.post('/setup', this.form)
      }
    }
  }
</script>
