<template>
    <div class="input-group">
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

        <app-money-input v-focus
                         v-model="amount"
                         v-validate="'required'"
                         @input="input"
                         ref="amount">
        </app-money-input>
    </div>
</template>

<script>
    import AppMoneyInput from '../form/AppMoneyInput'
    import bDropdown from 'bootstrap-vue/es/components/dropdown/dropdown'
    import bDropdownItem from 'bootstrap-vue/es/components/dropdown/dropdown-item'

    const EXPENSE = -1
    const INCOME = 1

    export default {
        props: ['value'],
        components: {
            AppMoneyInput,
            bDropdown,
            bDropdownItem
        },
        data() {
            return {
                type: this.value <= 0 ? EXPENSE : INCOME,
                amount: Math.abs(this.value)
            }
        },
        watch: {
            value() {
                this.amount = Math.abs(this.value)
            }
        },
        methods: {
            input() {
                this.$emit('input', this.type * this.amount)
            },
            setToExpense() {
                this.type = EXPENSE
                this.input()
            },
            setToIncome() {
                this.type = INCOME
                this.input()
            }
        }
    }
</script>
