<template>
  <Layout :step="3" :title="$t('title.setupAccounts')" @next="save">
    <p class="mb-4">{{ $t('message.setupAccounts') }}</p>
    <ul class="rounded-sm border border-gray-3 shadow-sm">
      <li class="border-b border-gray-3 flex p-4 items-center" v-for="(account, index) in accounts">
        <strong>{{ account.name }}</strong>
        <AppMoney :value="account.amount || 0" color class="ml-auto"/>
        <AppButton icon class="ml-2" @click="removeAccount(index)">
          <TrashIcon/>
        </AppButton>
      </li>
      <li class="p-4 bg-gray-0 rounded-sm">
        <form @submit.prevent="addAccount" class="flex flex-col md:flex-row md:items-end justify-center md:space-x-2">
          <FormGroup name="name" class="md:mb-0">
            <input
              class="form-input"
              :placeholder="$t('placeholder.accountName')"
              slot-scope="{bindings}"
              v-model="form.name"
              v-bind="bindings">
          </FormGroup>
          <FormGroup name="balance.default" class="md:mb-0">
            <AppMoneyInput
              slot-scope="{bindings}"
              v-model="form.amount"
              v-bind="bindings"/>
          </FormGroup>
          <AppButton type="submit" variant="light">
            <PlusIcon/>
            {{ $t('action.add')}}
          </AppButton>
        </form>
      </li>
    </ul>
  </Layout>
</template>

<script>
  import Layout from '@/Layouts/Setup'
  import AppMoney from '@/Components/AppMoney'
  import { iconComponent } from '@/Utils/Icons'
  import { faPlus, faTrashAlt } from '@fortawesome/free-solid-svg-icons'
  import AppButton from '@/Components/form/AppButton'
  import AppMoneyInput from '@/Components/form/AppMoneyInput'
  import FormGroup from '@/Components/form/FormGroup'

  export default {
    components: {
      FormGroup,
      AppMoneyInput,
      AppButton,
      AppMoney,
      Layout,
      TrashIcon: iconComponent({ icon: faTrashAlt }),
      PlusIcon: iconComponent({ icon: faPlus }),
    },
    data () {
      return {
        accounts: [],
        form: {
          name: null,
          amount: null
        }
      }
    },
    methods: {
      save () {
        if (!this.accounts.length && !window.confirm(this.$t('message.setupNoAccounts'))) {
          return
        }

        this.$inertia.post('/setup/accounts', {
          accounts: this.accounts
        })
      },
      addAccount () {
        if (!this.form.name) {
          alert(this.$t('message.emptyAccountName'))
          return
        }

        this.accounts.push(JSON.parse(JSON.stringify(this.form)))

        this.$nextTick(() => {
          this.form.name = null
          this.form.amount = 0
        })
      },
      removeAccount (index) {
        this.accounts.splice(index)
      }
    }
  }
</script>
