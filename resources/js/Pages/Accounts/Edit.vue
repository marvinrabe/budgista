<template>
  <Layout>
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

      <FormGroup name="icon">
        <account-icon-picker v-model="form.icon"/>
      </FormGroup>

      <div class="form-check">
        <input
          :value="true"
          class="form-check-input"
          id="tracking"
          type="checkbox"
          v-model="form.isTracking"
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
  </Layout>
</template>

<script>
  import Layout from '@/Layouts/Default'
  import AppButton from '@/Components/form/AppButton'
  import AppForm from '@/Components/form/AppForm'
  import AccountIconPicker from '@/Components/accounts/AccountIconPicker'
  import FormGroup from '@/Components/form/FormGroup'

  export default {
    components: {
      Layout,
      AccountIconPicker,
      AppButton,
      AppForm,
      FormGroup
    },
    props: {
      account: Object
    },
    data () {
      return {
        form: {
          name: this.account.name,
          icon: this.account.icon,
          isTracking: this.account.isTracking
        },
        saving: false
      }
    },
    methods: {
      save () {
        this.saving = true

        this.$inertia
          .put(`/accounts/${this.account.id}`, this.form)
          .finally(() => {
            this.saving = false
          })
      }
    }
  }
</script>
