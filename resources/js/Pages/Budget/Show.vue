<template>
  <Layout>
    <div class="card p-4">
      <div class="relative flex items-start">
        <div>
          <inertia-link
            :href="category.links.edit"
            :title="$t('action.edit.category')"
            class="text-gray-8 hover:text-gray-8">
            <h2 class="text-xl leading-tight ellipsis flex">
              <span>{{ category.name }}</span>
            </h2>
          </inertia-link>
          <p class="mb-3 text-sm" v-if="category.description">{{ category.description }}</p>
        </div>

        <div class="ml-auto text-lg leading-tight p-2 flex items-center -mr-2 -mt-2">
          <AppMoney class="font-light" color :value="categoryBudget.available"/>
          <InfoIcon
            class="ml-2 text-sm text-gray-6 hover:text-gray-8 cursor-pointer"
            @click="() => {showInfo = !showInfo}"
          />
        </div>

        <div
          class="flex-col px-6 py-4 bg-white z-10 absolute right-0 top-0 rounded shadow-lg"
          :class="{'hidden': !showInfo, 'flex': showInfo}"
          @click.stop="() => {showInfo = false}"
        >
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
        </div>
      </div>

      <div class="flex flex-col">
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
    </div>

    <h3 class="text-lg mb-2 px-4">{{ $t('title.transactions')}}</h3>

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
  import { faInfoCircle, faLightbulb } from '@fortawesome/free-solid-svg-icons'
  import AppButton from '@/Components/form/AppButton'

  export default {
    props: {
      category: Object,
      categoryBudget: Object,
      transactions: Object
    },
    components: {
      AppButton,
      AppMoney,
      AppMoneyInput,
      AppPagination,
      FormGroup,
      InfoIcon: iconComponent({ icon: faInfoCircle }),
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
