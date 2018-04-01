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
                    <ellipsis>{{ transaction.payee }}</ellipsis>
                </span>
            </span>
            <span class="transaction-column-2">
                <span class="transaction-category">
                    <category-name :id="transaction.category_id"></category-name>
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
            <a href="#"
               v-if="!transaction.isFuture()"
               :class="[{ 'text-success': transaction.cleared }, {'text-darker-light': !transaction.cleared}]"
               @click.prevent="toggleCleared">
                <font-awesome-icon :icon="clearIcon"/>
            </a>
        </div>
    </div>
</template>

<script>
    import Transaction from '../../models/Transaction';
    import FontAwesomeIcon from '@fortawesome/vue-fontawesome'
    import faCheckCircle from '@fortawesome/fontawesome-free-solid/faCheckCircle'
    import CategoryName from './CategoryName';
    import RecurringIcon from './RecurringIcon';

    export default {
        props: {
            transaction: {
                type: Transaction
            }
        },
        components: {
            CategoryName,
            FontAwesomeIcon,
            RecurringIcon
        },
        computed: {
            clearIcon() {
                return faCheckCircle;
            }
        },
        methods: {
            toggleCleared() {
                this.$store.dispatch('clearTransaction', this.transaction);
            }
        }
    }
</script>