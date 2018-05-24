<template>
    <div class="main">

        <app-toolbar :title="title" :back="true" @back="cancel"/>

        <div class="content">
            <form id="transaction" class="container pt-2"
                  @submit.prevent="submitForm"
                  autocomplete="off"
                  data-vv-scope="transaction"
                  novalidate>

                <div class="form-group">
                    <label for="amount">{{ $t('form.amount')}}</label>
                    <div class="input-group" :class="[{'is-invalid': errors.has('transaction.amount')}]">
                        <div class="input-group-prepend">
                            <b-dropdown
                                    :variant="(type === 1) ? 'outline-success':'outline-danger'"
                                    :text="(type === 1) ? $t('form.income') : $t('form.expense')">
                                <b-dropdown-item @click="setToExpense">
                                    {{ $t('form.expense') }}
                                </b-dropdown-item>
                                <b-dropdown-item @click="setToIncome">
                                    {{ $t('form.income') }}
                                </b-dropdown-item>
                            </b-dropdown>
                        </div>

                        <money-input
                                id="amount"
                                :value.sync="amount"
                                v-validate="'required'"
                                data-vv-name="amount"
                                :data-vv-as="$t('form.amount')"
                                v-focus
                                ref="amount">
                        </money-input>
                    </div>
                    <span class="invalid-feedback">{{ errors.first('transaction.amount') }}</span>
                </div>

                <div class="form-group">
                    <label for="payee">{{ $t('form.payee')}}</label>
                    <input id="payee" type="text" class="form-control" list="payees"
                           v-model="payee"
                           v-validate="'required'"
                           data-vv-name="payee"
                           :data-vv-as="$t('form.payee')">
                    <datalist id="payees">
                        <option v-for="payee in getPayees" :key="payee" :value="payee"/>
                    </datalist>

                    <span class="invalid-feedback">{{ errors.first('transaction.payee') }}</span>
                </div>

                <div class="form-group">
                    <label for="category">{{ $t('form.category')}}</label>
                    <select id="category" class="form-control" v-model="category">
                        <option value="">{{ $t('form.uncategorized') }}</option>
                        <option v-for="category in sortedCategories" :key="category.id" :value="category.id">
                            {{ category.name }}
                        </option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="date">{{ $t('form.date')}}</label>
                    <div v-if="hasHTML5DateInput">
                        <input type="date"
                               id="date"
                               class="form-control"
                               v-model="date"
                               v-validate="'required'"
                               data-vv-name="date"
                               :data-vv-as="$t('form.date')">
                        <span class="invalid-feedback">{{ errors.first('transaction.date') }}</span>
                    </div>

                    <date-input v-else id="date" v-model="date"></date-input>
                </div>

                <div class="mb-3">
                    <div class="form-check">
                        <label class="form-check-label">
                            <input type="checkbox" class="form-check-input" v-model="recurring">
                            {{ $t('form.recurring') }}
                        </label>
                    </div>

                    <div class="form-row mt-3" v-if="recurring">
                        <div class="col">
                            <label for="freq">{{ $t('form.recurringFrequency') }}</label>
                            <select id="freq" class="form-control" v-model="freq">
                                <option value="3">{{ $t('frequency.daily') }}</option>
                                <option value="2">{{ $t('frequency.weekly') }}</option>
                                <option value="1">{{ $t('frequency.monthly') }}</option>
                                <option value="0">{{ $t('frequency.yearly') }}</option>
                            </select>
                        </div>

                        <div class="col">
                            <label for="interval">{{ $t('form.recurringInterval') }}</label>
                            <div class="input-group mb-2 mb-sm-0">
                                <input type="number" min="1" max="50" step="1" id="interval"
                                       class="form-control" v-model="interval"/>
                                <div class="input-group-append">
                                    <span class="input-group-text" v-if="freq == 3">{{ $t('frequencyUnit.days') }}</span>
                                    <span class="input-group-text" v-if="freq == 2">{{ $t('frequencyUnit.weeks') }}</span>
                                    <span class="input-group-text" v-if="freq == 1">{{ $t('frequencyUnit.months') }}</span>
                                    <span class="input-group-text" v-if="freq == 0">{{ $t('frequencyUnit.years') }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>

            <div class="container text-right">
                <div class="float-left" v-if="!isNew">
                    <button class="btn btn-outline-danger"
                            :title="$t('action.delete.transaction')"
                            v-on:click="deleteTransaction">
                        <font-awesome-icon :icon="['far', 'trash-alt']"/>
                    </button>
                </div>

                <button class="btn btn-text-dark" v-on:click="cancel">
                    {{ $t('action.cancel') }}
                </button>

                <button v-if="isNew" v-on:click="saveAndNew" class="btn btn-light d-sm-inline-block d-none">
                    {{ $t('action.saveAndNew') }}
                </button>

                <button form="transaction" class="btn btn-primary">
                    {{ $t('action.save') }}
                </button>
            </div>
        </div>
    </div>
</template>

<script>
    import Modernizr from 'modernizr';
    import {mapGetters} from 'vuex'
    import bDropdown from 'bootstrap-vue/es/components/dropdown/dropdown'
    import bDropdownItem from 'bootstrap-vue/es/components/dropdown/dropdown-item'
    import RRule from 'rrule'

    const EXPENSE = -1;
    const INCOME = 1;

    export default {
        components: {
            bDropdown,
            bDropdownItem
        },
        data: () => ({
            type: EXPENSE,
            amount: 0,
            date: new Date().toISOString().slice(0, 10),
            recurring: false,
            freq: RRule.MONTHLY,
            interval: 1,
            payee: '',
            category: '',
            validated: false
        }),
        computed: {
            rrule() {
                if (!this.recurring) {
                    return '';
                }
                return new RRule({
                    freq: this.freq,
                    interval: this.interval
                }).toString();
            },
            title() {
                return '';
            },
            isNew() {
                return false
            },
            hasHTML5DateInput() {
                return Modernizr.inputtypes.date;
            },
            ...mapGetters([
                'sortedCategories',
                'getPayees'
            ])
        },
        methods: {

            getResult() {
                return {
                    'amount': this.type * this.amount,
                    'date': this.date,
                    'payee': this.payee,
                    'category_id': this.category,
                    'rrule': this.rrule,
                    'account_id': this.account_id
                };
            },

            setToExpense() {
                this.type = EXPENSE;
            },

            setToIncome() {
                this.type = INCOME;
            },
            reset() {
                // Reset Validation
                this.validated = false;
                this.errors.clear('transaction');

                // Reset Data
                this.type = EXPENSE;
                this.amount = 0;
                this.date = new Date().toISOString().slice(0, 10);
                this.payee = '';
                this.category = '';
                this.recurring = false;
                this.freq = RRule.MONTHLY;
                this.interval = 1;
            },

            submitForm() {
                this.$validator.validateAll('transaction').then(isValid => {
                    this.validated = true;

                    if (isValid) {
                        this.saveTransaction();
                    }
                });
            },

            cancel() {
                // To be implemented by child forms.
            },

            saveTransaction() {
                // To be implemented by child forms.
            },

            deleteTransaction() {
                // To be implemented by child forms.
            }

        }
    }
</script>