<template>
  <div>
    <FormGroup name="amount">
      <AmountInput
        slot-scope="{bindings}"
        v-bind="bindings"
        v-model="form.amount"
      />
    </FormGroup>

    <FormGroup name="payee">
      <PayeeInput
        slot-scope="{bindings}"
        v-bind="bindings"
        v-model="form.payee"
      />
    </FormGroup>

    <div class="flex flex-wrap -mx-1">
      <div class="w-full md:w-1/2 px-1">
        <FormGroup name="category">
          <CategorySelect
            slot-scope="{bindings}"
            v-bind="bindings"
            v-model="form.category_id"
            :income="form.amount > 0"
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
                  @click="form.recurring = !form.recurring"
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
  </div>
</template>

<script>
  import FormGroup from '@/Components/form/FormGroup.vue'
  import { faSync } from '@fortawesome/free-solid-svg-icons'
  import dayjs from 'dayjs'
  import { iconComponent } from '@/Utils/Icons'
  import CategorySelect from '../categories/CategorySelect'
  import AppButton from '../form/AppButton'
  import AppForm from '../form/AppForm'
  import DateInput from '../form/DateInput'
  import AmountInput from './AmountInput'
  import PayeeInput from './PayeeInput'
  import RecurringInput from './RecurringInput'

  export default {
    components: {
      RecurringIcon: iconComponent({ icon: faSync }),
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
      value: {
        type: Object,
        default: null
      }
    },
    data () {
      return {
        form: {
          recurring: false,
          amount: 0,
          recurrence: null,
          payee: '',
          category_id: null,
          account_id: null,
          ...this.value,
          date: dayjs(this.value.date || undefined).format('YYYY-MM-DD'),
        }
      }
    },
    watch: {
      form: {
        handler () {
          this.$emit('input', this.form)
        },
        deep: true
      }
    }
  }
</script>
