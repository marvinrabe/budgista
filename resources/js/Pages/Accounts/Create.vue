<template>
  <Layout>
    <AppToolbar :title="$t('action.create.account')"/>

    <div class="card">
      <div class="card-body">
        <AppForm @submit="save">
          <FormGroup name="name">
            <input
              class="form-control"
              slot-scope="{bindings}"
              type="text"
              v-bind="bindings"
              v-model="form.name"
            >
          </FormGroup>

          <FormGroup name="initialBalance">
            <app-money-input
              slot-scope="{bindings}"
              v-bind="bindings"
              v-model="form.initial_balance"
            />
          </FormGroup>

          <FormGroup name="icon">
            <account-icon-picker v-model="form.icon"/>
          </FormGroup>

          <div class="form-check">
            <input
              :value="true"
              class="form-check-input"
              id="tracking"
              type="checkbox"
              v-model="form.tracking"
            >
            <label
              class="form-check-label"
              for="tracking"
              v-t="'form.trackingAccount'"
            />
          </div>

          <template slot="actions">
            <AppButton
              :label="$t('action.save')"
              :loading="saving"
              variant="primary"
            />
          </template>
        </AppForm>
      </div>
    </div>
  </Layout>
</template>

<script>
  import Layout from '@/Layouts/Default'
  import AppToolbar from '@/Components/AppToolbar'
  import AppButton from '@/Components/form/AppButton'
  import AppForm from '@/Components/form/AppForm'
  import FormGroup from '@/Components/form/FormGroup'
  import AppMoneyInput from '@/Components/form/AppMoneyInput'
  import AccountIconPicker from '@/Components/accounts/AccountIconPicker'

  export default {
    components: {
      Layout,
      AppToolbar,
      AppButton,
      AppForm,
      AccountIconPicker,
      AppMoneyInput,
      FormGroup
    },
    data () {
      return {
        form: {
          name: '',
          initial_balance: 0,
          icon: 'credit-card',
          tracking: false
        },
        saving: false
      }
    },
    methods: {
      save () {
        this.saving = true

        this.$inertia
          .post('/accounts', this.form)
          .finally(() => {
            this.saving = false
          })
      }
    }
  }
</script>
