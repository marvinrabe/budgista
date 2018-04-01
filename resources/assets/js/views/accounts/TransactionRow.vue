<template>
    <div class="transactions-row"
         :class="[{ 'transactions-row-future': transaction.isFuture() }]">
        <router-link
                class="transaction-item"
                :to="{ name: 'transaction.edit', params: { transaction_id: transaction.id }}">
            <span class="transaction-column">
                <span class="transaction-date">
                    {{ $dateFormatter().format(new Date(transaction.date)) }}
                    <span v-if="transaction.recurring"
                          :title="humanRRule">
                        <font-awesome-icon :icon="recurringIcon"/>
                    </span>
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
    import CategoryName from './CategoryName';
    import FontAwesomeIcon from '@fortawesome/vue-fontawesome'
    import faSync from '@fortawesome/fontawesome-free-solid/faSync'
    import faCheckCircle from '@fortawesome/fontawesome-free-solid/faCheckCircle'

    let rrulestr = require('rrule').rrulestr;

    export default {
        props: {
            transaction: {
                type: Transaction
            }
        },
        components: {
            CategoryName,
            FontAwesomeIcon
        },
        computed: {
            clearIcon() {
                return faCheckCircle;
            },
            humanRRule() {
                let rule = rrulestr(this.transaction.rrule);
                return rule.toText();
            },
            recurringIcon() {
                return faSync;
            }
        },
        methods: {
            toggleCleared() {
                this.$store.dispatch('clearTransaction', this.transaction);
            }
        }
    }
</script>