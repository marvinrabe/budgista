<template>
  <Layout :title="$t('action.edit.account')">
    <AppForm @submit="save">
      <FormGroup name="name">
        <input
          class="form-input"
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
          class="form-checkbox"
          id="tracking"
          type="checkbox"
          v-model="form.tracking"
        >
        <label
          class="checkbox-label"
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

    <hr class="border-t-2 border-gray-1 my-16 mb-4"/>

    <form @submit.prevent="deleteAccount" class="flex -mx-1 flex-wrap items-end justify-between">
      <div class="flex-1 px-1">
        <h3 class="text-lg mb-2">
          {{ $t('action.delete.account') }}
        </h3>
        <p>{{ $t('hint.deleteAccount') }}</p>
      </div>
      <div class="lg:ml-4 mt-4 w-full lg:w-auto flex justify-end">
        <AppButton
          type="submit"
          :label="$t('action.delete.account')"
          :loading="saving"
          variant="danger"
        />
      </div>
    </form>

  </Layout>
</template>

<script>
  import Layout from '@/Layouts/Default'
  import AppButton from '@/Components/form/AppButton'
  import AppForm from '@/Components/form/AppForm'
  import AccountIconPicker from '@/Components/accounts/AccountIconPicker'
  import FormGroup from '@/Components/form/FormGroup'
  import { iconComponent } from '@/Utils/Icons'
  import { faTrashAlt } from '@fortawesome/free-regular-svg-icons'

  export default {
    components: {
      Layout,
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
      deleteAccount () {
        if (window.confirm(this.$t('message.deleteAccount', { name: this.account.name }))) {
          this.$inertia.delete(this.account.links.destroy)
        }
      }
    }
  }
</script>
