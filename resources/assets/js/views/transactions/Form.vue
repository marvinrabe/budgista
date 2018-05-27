<template>
    <div class="main">

        <app-toolbar :title="title" :back="true" @back="cancel"/>

        <div class="card">
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

                    <div class="form-row">
                        <div class="col-sm-6">
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
                                            <button class="btn"
                                                    type="button"
                                                    :class="{
                                                'btn-outline-light': !recurring,
                                                'btn-primary': recurring
                                            }"
                                                    :title="$t('form.recurring')"
                                                    @click="recurring = !recurring">
                                                <font-awesome-icon :icon="recurringIcon"></font-awesome-icon>
                                            </button>
                                        </div>
                                    </div>
                                </template>
                            </form-group>

                            <div class="input-group mb-3" v-if="recurring">
                                <div class="input-group-prepend">
                            <span class="input-group-text"
                                  v-t="'form.recurringInterval'">
                            </span>
                                </div>
                                <input class="form-control"
                                       type="number"
                                       min="1"
                                       max="50"
                                       step="1"
                                       v-model="interval">
                                <div class="input-group-append">
                                    <select class="form-control"
                                            v-model="freq">
                                        <option value="3">{{ $t('frequencyUnit.days') }}</option>
                                        <option value="2">{{ $t('frequencyUnit.weeks') }}</option>
                                        <option value="1">{{ $t('frequencyUnit.months') }}</option>
                                        <option value="0">{{ $t('frequencyUnit.years') }}</option>
                                    </select>
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
    import faSync from '@fortawesome/fontawesome-free-solid/faSync'
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
            recurringIcon() {
                return faSync
            },
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