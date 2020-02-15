<template>
  <Layout>
    <AppToolbar :title="$t('action.edit.account')">
      <template slot="submenu">
        <AppButton
          :title="$t('action.delete.account')"
          @click="deleteAccount"
          subtle
          variant="danger"
        >
          <DeleteIcon/>
        </AppButton>
      </template>
    </AppToolbar>

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
  import AccountIconPicker from '@/Components/accounts/AccountIconPicker'
  import FormGroup from '@/Components/form/FormGroup'
  import { iconComponent } from '@/helpers'
  import { faTrashAlt } from '@fortawesome/free-regular-svg-icons'

  export default {
    components: {
      Layout,
      AppToolbar,
      AccountIconPicker,
      AppButton,
      AppForm,
      FormGroup,
      DeleteIcon: iconComponent({ icon: faTrashAlt }),
    },
    props: {
      account: Object
    },
    data () {
      return {
        form: {
          name: this.account.name,
          icon: this.account.icon,
          tracking: this.account.tracking,
        },
        saving: false
      }
    },
    methods: {
      save () {
        this.saving = true

        this.$inertia
          .put(this.account.links.update, this.form)
          .finally(() => {
            this.saving = false
          })
      },
      deleteAccount() {
        this.$inertia.delete(this.account.links.destroy)
      }
    }
  }
</script>
