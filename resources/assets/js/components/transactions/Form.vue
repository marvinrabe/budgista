<template>
    <div class="main">

        <app-window :title="title"></app-window>

        <div class="toolbar toolbar-primary">
            <app-sidebar-toggle></app-sidebar-toggle>

            <div class="title">
                {{ title }}
            </div>
        </div>

        <div class="content content-decorated">
            <form id="transaction" class="container pt-2"
                  v-on:submit.stop.prevent="submitForm"
                  v-bind:class="[{'was-validated': validated}]"
                  autocomplete="off"
                  data-vv-scope="transaction"
                  novalidate>

                <div class="form-group">
                    <label for="amount">{{ $t('form.amount')}}</label>
                    <div class="input-group" :class="[{'is-invalid': errors.has('transaction.amount')}]">
                        <div class="input-group-btn">
                            <a href="#" class="btn btn-success dropdown-toggle"
                               :class="[{'btn-success': type === 1},{'btn-danger': type === -1}]"
                               data-toggle="dropdown"
                               aria-haspopup="true" aria-expanded="false">
                                {{ (type === 1) ? $t('form.income') : $t('form.expense') }}
                            </a>

                            <div class="dropdown-menu" role="menu" aria-labelledby="user-menu">
                                <a class="link-action dropdown-item" v-on:click="setToExpense">
                                    {{ $t('form.expense') }}
                                </a>
                                <a class="link-action dropdown-item" v-on:click="setToIncome">
                                    {{ $t('form.income') }}
                                </a>
                            </div>

                        </div>

                        <money-input
                                id="amount"
                                :value.sync="amount"
                                v-validate.initial="'required'"
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
                           v-validate.initial="'required'"
                           data-vv-name="payee"
                           :data-vv-as="$t('form.payee')">
                    <datalist id="payees">
                        <option v-for="payee in getPayees" :key="payee" :value="payee" />
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
                    <date-input id="date" v-model="date"></date-input>
                </div>

                <div class="form-check">
                    <label class="form-check-label">
                        <input type="checkbox" class="form-check-input" v-model="recurring">
                        {{ $t('form.recurring') }}
                    </label>
                </div>

                <div class="form-row mb-3" v-if="recurring">
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
                            <div class="input-group-addon" v-if="freq == 3">
                                {{ $t('frequencyUnit.days') }}
                            </div>
                            <div class="input-group-addon" v-if="freq == 2">
                                {{ $t('frequencyUnit.weeks') }}
                            </div>
                            <div class="input-group-addon" v-if="freq == 1">
                                {{ $t('frequencyUnit.months') }}
                            </div>
                            <div class="input-group-addon" v-if="freq == 0">
                                {{ $t('frequencyUnit.years') }}
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
                        <font-awesome-icon :icon="['far', 'trash-alt']" />
                    </button>
                </div>

                <button class="btn btn-light" v-on:click="cancel">
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
    import {mapGetters} from 'vuex'
    import RRule from 'rrule'

    const EXPENSE = -1;
    const INCOME = 1;

    export default {
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
            ...mapGetters([
                'sortedCategories',
                'getPayees'
            ])
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

            cancel() {
                this.$router.go(-1);
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

            saveTransaction() {
                // To be implemented by child forms.
            },

            deleteTransaction() {
                // To be implemented by child forms.
            }

        }
    }
</script>