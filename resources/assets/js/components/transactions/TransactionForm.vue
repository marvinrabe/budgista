<template>
    <app-form @submit="saveTransaction" ref="form">
        <form-group name="amount">
            <amount-input v-model="amount"></amount-input>
        </form-group>

        <form-group name="payee">
            <template slot-scope="{bindings}">
                <input class="form-control"
                       type="text"
                       list="payees"
                       v-bind="bindings"
                       v-model="payee"
                       v-validate="'required'">
                <datalist id="payees">
                    <option v-for="payee in getPayees" :key="payee" :value="payee"/>
                </datalist>
            </template>
        </form-group>

        <div class="form-row">
            <div class="col-sm-6">
                <form-group name="category">
                    <select class="form-control"
                            slot-scope="{bindings}"
                            v-bind="bindings"
                            v-model="category_id">
                        <option :value="null">{{ $t('form.uncategorized') }}</option>
                        <option v-for="category in sortedCategories" :key="category.id" :value="category.id">
                            {{ category.name }}
                        </option>
                    </select>
                </form-group>
            </div>
            <div class="col-sm-6">
                <form-group name="date">
                    <template slot-scope="{bindings}">
                        <div class="input-group">
                            <input class="form-control"
                                   type="date"
                                   v-if="hasHTML5DateInput"
                                   v-bind="bindings"
                                   v-model="date"
                                   v-validate="'required'">
                            <date-input v-else v-bind="bindings" v-model="date"></date-input>
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

                <recurring-input v-if="recurring"
                                 v-model="rrule"></recurring-input>
            </div>
        </div>

        <template slot="actions">
            <button class="btn btn-text-dark"
                    type="button"
                    @click="$emit('cancel')">
                {{ $t('action.cancel') }}
            </button>

            <app-button :label="$t('action.save')"
                        :busy="saving"
                        @click="saveTransaction">
            </app-button>
        </template>
    </app-form>
</template>

<script>
    import Modernizr from 'modernizr'
    import {mapGetters} from 'vuex'
    import faSync from '@fortawesome/fontawesome-free-solid/faSync'
    import AmountInput from './AmountInput'
    import RecurringInput from './RecurringInput'
    import _ from 'lodash'

    export default {
        props: ['transaction'],
        components: {
            AmountInput,
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
            },
            hasHTML5DateInput() {
                return Modernizr.inputtypes.date
            },
            ...mapGetters([
                'sortedCategories',
                'getPayees'
            ])
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