<template>
  <div>

    <FormGroup name="amount" :has-label="false">
      <div class="flex flex-col" slot-scope="{bindings}">
        <div class="flex z-10" style="margin-bottom: -1px;">
          <button
            type="button"
            class="rounded-t py-2 px-4 text-gray-6 text-sm"
            :class="{'bg-white border border-b-0 border-gray-4 text-gray-8 order-first': type === -1}"
            @click="setToExpense">
            <ExpenseIcon
              class="text-gray-5 mr-1 "
              :class="{'text-red-6': type === -1}"
            />
            <span class="font-medium">
              {{ $t('form.expense')}}
            </span>
          </button>
          <button
            type="button"
            class="rounded-t py-2 px-4 text-gray-6 text-sm"
            :class="{'bg-white border border-b-0 border-gray-4 text-gray-8 order-first': type === 1}"
            @click="setToIncome">
            <IncomeIcon
              class="text-gray-5 mr-1"
              :class="{'text-green-6': type === 1}"
            />
            <span class="font-medium">
              {{ $t('form.income')}}
            </span>
          </button>
        </div>
        <AmountInput
          class="text-4xl rounded-tl-none"
          :type="type"
          v-bind="bindings"
          v-model="form.amount"
        />
      </div>
    </FormGroup>

    <div class="flex flex-wrap -mx-1">
      <div class="w-full md:w-1/2 px-1">
        <FormGroup name="payee">
          <PayeeInput
            slot-scope="{bindings}"
            :placeholder="isTransfer ? $t('form.transferPayee') : undefined"
            v-bind="bindings"
            v-model="form.payee"
          />
        </FormGroup>
      </div>

      <div class="w-full md:w-1/2 px-1">
        <FormGroup name="category_id">
          <CategorySelect
            slot-scope="{bindings}"
            v-bind="bindings"
            v-model="form.category_id"
            :income="type === 1"
          />
        </FormGroup>
      </div>
    </div>

    <div class="flex flex-wrap -mx-1 justify-end">
      <div class="w-full md:w-1/2 px-1">
        <FormGroup name="account_id">
          <AccountSelect
            slot-scope="{bindings}"
            v-bind="bindings"
            v-model="form.account_id"
          />
        </FormGroup>
      </div>

      <div class="w-full md:w-1/2 px-1">
        <FormGroup name="date">
          <template slot-scope="{bindings}">
            <div class="flex items-stretch">
              <DateInput
                v-bind="bindings"
                v-model="form.date"
                class="rounded-r-none"
              />
              <div class="border border-l-0 border-gray-4 rounded-r flex items-center">
                <AppButton
                  :title="$t('form.recurring')"
                  @click="toggleRecurring"
                  :class="{'text-blue-7 hover:text-blue-9': form.recurring}"
                  icon
                >
                  <RecurringIcon/>
                </AppButton>
              </div>
            </div>
          </template>
        </FormGroup>

        <RecurringInput
          v-if="form.recurring"
          v-model="form.recurrence"
        />
      </div>
    </div>


    <FormGroup name="notes">
      <AppTextarea
        slot-scope="{bindings}"
        v-bind="bindings"
        v-model="form.notes"/>
    </FormGroup>

  </div>
</template>

<script>
  import FormGroup from '@/Components/form/FormGroup.vue'
  import { faHistory, faSignInAlt, faSignOutAlt } from '@fortawesome/free-solid-svg-icons'
  import { iconComponent } from '@/Utils/Icons'
  import CategorySelect from '../categories/CategorySelect'
  import AppButton from '../form/AppButton'
  import AppForm from '../form/AppForm'
  import DateInput from '../form/DateInput'
  import AmountInput from './AmountInput'
  import PayeeInput from './PayeeInput'
  import RecurringInput from './RecurringInput'
  import AccountSelect from '@/Components/accounts/AccountSelect'
  import _ from 'lodash'
  import AppTextarea from '@/Components/AppTextarea'

  const EXPENSE = -1
  const INCOME = 1

  export default {
    components: {
      AppTextarea,
      AccountSelect,
      RecurringIcon: iconComponent({ icon: faHistory }),
      IncomeIcon: iconComponent({ icon: faSignInAlt }),
      ExpenseIcon: iconComponent({ icon: faSignOutAlt }),
      AppForm,
      AppButton,
      FormGroup,
      AmountInput,
      CategorySelect,
      PayeeInput,
      DateInput,
      RecurringInput
    },
    props: {
      value: Object
    },
    data () {
      return {
        type: _.get(this.value, 'amount', 0) <= 0 ? EXPENSE : INCOME,
        form: this.value
      }
    },
    computed: {
      isTransfer () {
        return this.form.category_id ? this.form.category_id.startsWith('account:') : false
      }
    },
    watch: {
      form: {
        handler () {
          this.$emit('input', this.form)
        },
        deep: true
      }
    },
    methods: {
      setToExpense () {
        this.type = EXPENSE
      },
      setToIncome () {
        this.type = INCOME
      },
      toggleRecurring() {
        this.form.recurring = !this.form.recurring
        if(!this.form.recurring) {
          this.form.recurrence = null
        }
      }
    }
  }
</script>
