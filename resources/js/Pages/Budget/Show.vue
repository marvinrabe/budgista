<template>
  <Layout>
    <div class="card">
      <div class="card-header flex justify-between items-center">
        <div class="flex flex-col">
          <h2 class="text-xl leading-tight ellipsis flex">
            <span>{{ category.name }}</span>
          </h2>
          <p class="text-sm text-gray-6" v-if="category.description">{{ category.description }}</p>
        </div>
        <AppButton
          :to="category.links.edit"
          :title="$t('action.edit.category')"
          icon>
          <CogIcon/>
        </AppButton>
      </div>

      <div class="card-body flex items-baseline -mx-2">
        <div class="flex flex-1 flex-col px-2">
          <FormGroup
            name="amount"
            label="budget"
            class="mb-0">
            <template v-slot:additional>
              <div
                class="ml-auto mt-2 px-4 flex items-baseline justify-end"
                v-if="categoryBudget.recommendedBudget > 0 && categoryBudget.amount < categoryBudget.recommendedBudget">
          <span class="label mr-2">
            <TipIcon class="text-yellow-5 mr-1"/>
            {{ $t('word.recommended')}}:
          </span>
                <AppMoney
                  :value="categoryBudget.recommendedBudget"
                  class="cursor-pointer hover:text-gray-8 hover:underline text-sm"
                  @click.native="() => updateBudget(categoryBudget.recommendedBudget)"
                />
              </div>
            </template>
            <AppMoneyInput
              :value="categoryBudget.amount"
              @change="val => updateBudget(val)"
              allow-negative
            />
          </FormGroup>

        </div>

        <div class="flex flex-1 flex-col px-2 items-end">
          <div class="label mb-2">
            {{ $t('form.available')}}
          </div>

          <AppDropDown body-class="flex-col right-0 top-0 mt-10 whitespace-no-wrap">
            <template v-slot:activator>
              <div
                class="badge border border-transparent px-4 py-2 text-right"
                :class="{'badge--red': categoryBudget.available < 0, 'badge--green': categoryBudget.available > 0, 'badge--gray': categoryBudget.available === 0, }"
              >
                <InfoIcon class="text-sm opacity-50 hover:opacity-75"/>
                <AppMoney class="ml-2" color :value="categoryBudget.available"/>
              </div>
            </template>

            <div class="py-1 flex items-baseline justify-between">
              <div class="label mr-6">
                {{ $t('form.previousMonth')}}
              </div>

              <AppMoney :value="categoryBudget.previousMonth" class="text-sm"/>
            </div>
            <div class="py-1 flex items-baseline justify-between">
              <div class="label mr-6">
                {{ $t('form.budget')}}
              </div>

              <AppMoney :value="categoryBudget.amount" class="text-sm"/>
            </div>
            <div class="py-1 flex items-baseline justify-between">
              <div class="label mr-6">
                {{ $t('form.activity')}}
              </div>

              <AppMoney :value="categoryBudget.activity" class="text-sm"/>
            </div>
            <div class="py-1 flex items-baseline justify-between">
              <div class="label mr-6">
                {{ $t('form.available')}}
              </div>

              <AppMoney :value="categoryBudget.available" class="text-sm"/>
            </div>
          </AppDropDown>
        </div>
      </div>

    </div>

    <h3 class="text-lg mb-2">{{ $t('title.transactions')}}</h3>

    <TransactionList
      :transactions="transactions.data"
      column="account"
    />

    <div class="flex items-center justify-end">
      <AppPagination :paginator="transactions"/>
    </div>
  </Layout>
</template>
<script>
  import Layout from '@/Pages/Budget/Index'
  import FormGroup from '@/Components/form/FormGroup'
  import TransactionList from '@/Components/transactions/TransactionList'
  import AppMoneyInput from '@/Components/form/AppMoneyInput'
  import AppPagination from '@/Components/AppPagination'
  import AppMoney from '@/Components/AppMoney'
  import { iconComponent } from '@/Utils/Icons'
  import { faInfoCircle, faLightbulb, faCog } from '@fortawesome/free-solid-svg-icons'
  import AppButton from '@/Components/form/AppButton'
  import AppDropDown from '@/Components/AppDropDown'

  export default {
    props: {
      category: Object,
      categoryBudget: Object,
      transactions: Object
    },
    components: {
      AppDropDown,
      AppButton,
      AppMoney,
      AppMoneyInput,
      AppPagination,
      FormGroup,
      InfoIcon: iconComponent({ icon: faInfoCircle }),
      CogIcon: iconComponent({ icon: faCog }),
      TipIcon: iconComponent({ icon: faLightbulb }),
      Layout,
      TransactionList
    },
    data () {
      return {
        showInfo: false
      }
    },
    methods: {
      updateBudget (value) {
        this.$inertia
          .post(`/budget/${this.$page.budget.month.value}/categories/${this.category.id}`, {
            amount: value
          }, { preserveScroll: true })
      }
    }
  }
</script>
