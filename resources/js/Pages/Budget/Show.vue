<template>
  <Layout>

    <div class="card">
      <div class="card-header flex justify-between items-center">
        <h2 class="text-xl">
          {{ category.name }}
        </h2>

        <AppMoney
          :value="categoryBudget.available"
          class="ml-auto badge text-xl"
          :class="{'badge--red': categoryBudget.available < 0, 'badge--green': categoryBudget.available > 0, 'badge--gray': categoryBudget.available === 0, }"
        />
      </div>

      <div class="card-body border-b border-gray-3 flex flex-wrap items-baseline -mx-2">
        <FormGroup
          name="amount"
          label="budget"
          class="w-full lg:w-1/2 px-2">
          <template v-slot:additional v-if="categoryBudget.recommendedBudget > 0">
            <div class="ml-auto text-gray-6 text-sm px-1 font-medium">
              {{ $t('word.recommended')}}:
              <AppMoney
                :value="categoryBudget.recommendedBudget"
                class="cursor-pointer hover:text-gray-8"
                @click.native="() => updateBudget(categoryBudget.recommendedBudget)"
              />
            </div>
          </template>
          <AppMoneyInput
            :value="categoryBudget.budget"
            @change="val => updateBudget(val)"
            allow-negative
          />
        </FormGroup>
        <div class="flex flex-1 flex-col px-2">
          <div class="px-4 py-1 flex items-center justify-between">
            <span class="text-xs tracking-wide font-bold uppercase ">
              {{ $t('form.previousMonth')}}
            </span>

            <AppMoney :value="categoryBudget.previousMonth"/>
          </div>
          <div class="px-4 py-1 flex items-center justify-between">
            <span class="text-xs tracking-wide font-bold uppercase ">
              {{ $t('form.budget')}}
            </span>

            <AppMoney :value="categoryBudget.budget"/>
          </div>
          <div class="border-b-2 border-gray-3 px-4 py-1 flex items-center justify-between">
            <span class="text-xs tracking-wide font-bold uppercase ">
              {{ $t('form.activity')}}
            </span>

            <AppMoney :value="categoryBudget.activity"/>
          </div>
          <div class="px-4 py-1 flex items-center justify-between">
            <span class="text-xs tracking-wide font-bold uppercase ">
              {{ $t('form.available')}}
            </span>

            <AppMoney :value="categoryBudget.available"/>
          </div>
        </div>
      </div>
    </div>

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

  export default {
    props: {
      category: Object,
      categoryBudget: Object,
      transactions: Object
    },
    components: {
      AppMoney,
      AppMoneyInput,
      AppPagination,
      FormGroup,
      Layout,
      TransactionList
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
