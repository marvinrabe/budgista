<template>
    <div class="transactions-row"
         :class="[{ 'transactions-row-future': transaction.isFuture() }]">
        <router-link
                class="transaction-item"
                :to="{ name: 'transaction.edit', params: { transaction_id: transaction.id }}">
            <span class="transaction-column">
                <span class="transaction-date">
                    {{ $dateFormatter().format(new Date(transaction.date)) }}
                    <recurring-icon :rrule="transaction.rrule"></recurring-icon>
                </span>
                <span class="transaction-payee">
                    <AppEllipsis>{{ transaction.payee }}</AppEllipsis>
                </span>
            </span>
            <span class="transaction-column-2">
                <span class="transaction-category">
                    <AppEllipsis v-if="category">{{ category.name }}</AppEllipsis>
                </span>
                <span class="transaction-amount">
                    <money-format
                            :class="[{ 'text-danger': transaction.amount < 0 }]"
                            :value="transaction.amount">
                    </money-format>
                </span>
            </span>
        </router-link>
        <div class="transaction-clear">
            <ClearInput :transaction="transaction"/>
        </div>
    </div>
</template>

<script>
    import Transaction from '../../models/Transaction'
    import AppEllipsis from '../AppEllipsis'
    import ClearInput from './ClearInput'
    import RecurringIcon from './RecurringIcon'

    export default {
        props: {
            transaction: {
                type: Transaction,
                required: true
            }
        },
        components: {
            AppEllipsis,
            ClearInput,
            RecurringIcon
        },
        computed: {
            category() {
                return this.$store.getters.findCategoryById(this.transaction.category_id)
            }
        }
    }
</script>
