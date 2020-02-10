<template>
  <AppForm
    @submit="saveTransaction"
    ref="form"
  >
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

    <div class="form-row">
      <div class="col-sm-6">
        <FormGroup name="category">
          <CategorySelect
            slot-scope="{bindings}"
            v-bind="bindings"
            v-model="form.category_id"
          />
        </FormGroup>
      </div>
      <div class="col-sm-6">
        <FormGroup name="date">
          <template slot-scope="{bindings}">
            <div class="input-group">
              <DateInput
                v-bind="bindings"
                v-model="form.date"
              />
              <div class="input-group-append">
                <button
                  :class="{'text-primary': form.recurring}"
                  :title="$t('form.recurring')"
                  @click="form.recurring = !form.recurring"
                  class="btn btn-light date__recurring"
                  type="button"
                >
                  <RecurringIcon/>
                </button>
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

    <template slot="actions">
      <AppButton
        :label="$t('action.cancel')"
        @click="$emit('cancel')"
        subtle
      />

      <AppButton
        :label="$t('action.save')"
        :loading="saving"
        variant="primary"
      />
    </template>
  </AppForm>
</template>

<script>
  import FormGroup from '@/components/form/FormGroup.vue'
  import { faSync } from '@fortawesome/free-solid-svg-icons'
  import dayjs from 'dayjs'
  import { iconComponent } from '../../helpers'
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
      },
      saving: {
        type: Boolean,
        default: false
      }
    },
    data () {
      return {
        form: {
          recurring: false,
          amount: 0,
          date: dayjs().format('YYYY-MM-DD'),
          recurrence: null,
          payee: '',
          category_id: null,
          account_id: null
        }
      }
    },
    watch: {
      value: {
        handler () {
          if (!this.value) {
            return
          }
          Object.assign(this.form, this.value)
        },
        immediate: true
      }
    },
    methods: {
      saveTransaction () {
        this.$emit('input', this.form)
      }
    }
  }
</script>

<style scoped>
  .date__recurring {
    border-color: #dce0e4;
  }
</style>
