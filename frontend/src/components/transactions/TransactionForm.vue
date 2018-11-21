<template>
    <app-form @submit="saveTransaction" ref="form">

        <form-group name="amount">
            <AmountInput
                    slot-scope="{bindings}"
                    v-bind="bindings"
                    v-model="amount"
            />
        </form-group>

        <form-group name="payee">
            <PayeeInput
                    slot-scope="{bindings}"
                    v-bind="bindings"
                    v-model="payee"
            />
        </form-group>

        <div class="form-row">
            <div class="col-sm-6">
                <form-group name="category">
                    <CategorySelect
                            slot-scope="{bindings}"
                            v-bind="bindings"
                            v-model="category_id"
                    />
                </form-group>
            </div>
            <div class="col-sm-6">
                <form-group name="date">
                    <template slot-scope="{bindings}">
                        <div class="input-group">
                            <DateInput
                                    v-bind="bindings"
                                    v-model="date"
                            />
                            <div class="input-group-append">
                                <button class="btn btn-outline-light"
                                        type="button"
                                        :class="{'text-primary': recurring}"
                                        :title="$t('form.recurring')"
                                        @click="recurring = !recurring">
                                    <font-awesome-icon :icon="recurringIcon"></font-awesome-icon>
                                </button>
                            </div>
                        </div>
                    </template>
                </form-group>

                <RecurringInput
                        v-if="recurring"
                        v-model="rrule"
                />
            </div>
        </div>

        <template slot="actions">
            <button class="btn btn-text-dark"
                    type="button"
                    @click="$emit('cancel')">
                {{ $t('action.cancel') }}
            </button>

            <app-button :label="$t('action.save')"
                        :busy="saving">
            </app-button>
        </template>
    </app-form>
</template>

<script>
    import _ from 'lodash'
    import AppForm from '@/components/form/AppForm.vue'
    import FormGroup from '@/components/form/FormGroup.vue'
    import {faSync} from '@fortawesome/free-solid-svg-icons'
    import AmountInput from './AmountInput'
    import RecurringInput from './RecurringInput'
    import CategorySelect from '../categories/CategorySelect'
    import PayeeInput from './PayeeInput'
    import DateInput from '../form/DateInput'

    export default {
        props: {
            transaction: {
                type: Object,
                default: () => {}
            }
        },
        components: {
            AppForm,
            FormGroup,
            AmountInput,
            CategorySelect,
            PayeeInput,
            DateInput,
            RecurringInput
        },
        data() {
            return {
                saving: false,
                id: _.get(this.transaction, 'id', null),
                amount: _.get(this.transaction, 'amount', 0),
                date: _.get(this.transaction, 'date', new Date().toISOString().slice(0, 10)),
                recurring: _.get(this.transaction, 'recurring', false),
                rrule: _.get(this.transaction, 'rrule', ''),
                payee: _.get(this.transaction, 'payee', ''),
                category_id: _.get(this.transaction, 'category_id', null),
                account_id: _.get(this.transaction, 'account_id', null)
            }
        },
        computed: {
            recurringIcon() {
                return faSync
            }
        },
        methods: {
            getResult() {
                return {
                    id: this.id,
                    amount: this.amount,
                    date: this.date,
                    payee: this.payee,
                    category_id: this.category_id,
                    rrule: this.recurring ? this.rrule : '',
                    account_id: this.account_id
                }
            },
            saveTransaction() {
                this.$emit('save')

                let transaction = this.getResult()
                this.saving = true

                this.$store
                    .dispatch('saveTransaction', transaction)
                    .then(() => {
                        this.$emit('success')
                    })
                    .catch(this.$refs.form.error)
                    .finally(() => {
                        this.saving = false
                    })
            }

        }
    }
</script>
