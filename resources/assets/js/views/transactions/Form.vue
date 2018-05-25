<template>
    <div class="main">

        <app-toolbar :title="title" :back="true" @back="cancel"/>

        <div class="card border-0">
            <div class="card-body">
                <app-form @submit="saveTransaction" ref="form">
                    <form-group name="amount">
                        <div class="input-group"
                             slot-scope="{bindings}">
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
                                    :value.sync="amount"
                                    v-bind="bindings"
                                    v-focus
                                    v-validate="'required'"
                                    ref="amount">
                            </money-input>
                        </div>
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

                    <form-group name="category">
                        <select class="form-control"
                                slot-scope="{bindings}"
                                v-bind="bindings"
                                v-model="category">
                            <option value="">{{ $t('form.uncategorized') }}</option>
                            <option v-for="category in sortedCategories" :key="category.id" :value="category.id">
                                {{ category.name }}
                            </option>
                        </select>
                    </form-group>

                    <form-group name="date">
                        <template slot-scope="{bindings}">
                            <input class="form-control"
                                   type="date"
                                   v-if="hasHTML5DateInput"
                                   v-bind="bindings"
                                   v-model="date"
                                   v-validate="'required'">
                            <date-input v-else v-bind="bindings" v-model="date"></date-input>
                        </template>
                    </form-group>

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
                                        <span class="input-group-text"
                                              v-if="freq == 3">{{ $t('frequencyUnit.days') }}</span>
                                        <span class="input-group-text"
                                              v-if="freq == 2">{{ $t('frequencyUnit.weeks') }}</span>
                                        <span class="input-group-text"
                                              v-if="freq == 1">{{ $t('frequencyUnit.months') }}</span>
                                        <span class="input-group-text"
                                              v-if="freq == 0">{{ $t('frequencyUnit.years') }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <template slot="actions">
                        <button class="btn btn-outline-danger mr-auto"
                                type="button"
                                :title="$t('action.delete.transaction')"
                                v-if="!isNew"
                                @click="deleteTransaction">
                            <font-awesome-icon :icon="['far', 'trash-alt']"/>
                        </button>

                        <button class="btn btn-text-dark"
                                type="button"
                                @click="cancel">
                            {{ $t('action.cancel') }}
                        </button>

                        <button class="btn btn-light d-sm-inline-block d-none"
                                type="button"
                                v-if="isNew"
                                @click="saveAndNew">
                            {{ $t('action.saveAndNew') }}
                        </button>

                        <button class="btn btn-primary"
                                type="submit">
                            {{ $t('action.save') }}
                        </button>
                    </template>
                </app-form>
            </div>
        </div>
    </div>
</template>

<script>
    import Modernizr from 'modernizr'
    import {mapGetters} from 'vuex'
    import bDropdown from 'bootstrap-vue/es/components/dropdown/dropdown'
    import bDropdownItem from 'bootstrap-vue/es/components/dropdown/dropdown-item'
    import RRule from 'rrule'

    const EXPENSE = -1
    const INCOME = 1

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
            category: ''
        }),
        computed: {
            rrule() {
                if (!this.recurring) {
                    return ''
                }
                return new RRule({
                    freq: this.freq,
                    interval: this.interval
                }).toString()
            },
            title() {
                return ''
            },
            isNew() {
                return false
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
                    'amount': this.type * this.amount,
                    'date': this.date,
                    'payee': this.payee,
                    'category_id': this.category,
                    'rrule': this.rrule,
                    'account_id': this.account_id
                }
            },

            setToExpense() {
                this.type = EXPENSE
            },

            setToIncome() {
                this.type = INCOME
            },

            reset() {
                // Reset Data
                this.type = EXPENSE
                this.amount = 0
                this.date = new Date().toISOString().slice(0, 10)
                this.payee = ''
                this.category = ''
                this.recurring = false
                this.freq = RRule.MONTHLY
                this.interval = 1
            },

            cancel() {
                // To be implemented by child forms.
            },

            saveTransaction() {
                // To be implemented by child forms.
            },

            saveAndNew() {
                // To be implemented by child forms.
            },

            deleteTransaction() {
                // To be implemented by child forms.
            }

        }
    }
</script>