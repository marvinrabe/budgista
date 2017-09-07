<template>
    <div v-if="account !== null">

        <div class="toolbar toolbar-primary">
            <div class="form-row">
                <div class="h1 col mb-0">
                    {{ account.name }}
                </div>
                <div class="col text-center">
                    <strong :class="[{ 'text-success': account.clearedBalance >= 0}, { 'text-danger': account.clearedBalance < 0}]">
                        {{ $formatNumber(account.clearedBalance, {style: 'currency', currency: currency}) }}
                    </strong>
                    <p class="small">{{ $t('form.balance.cleared') }}</p>
                </div>
                <div class="col text-center">
                    <strong :class="[{ 'text-success': account.unclearedBalance >= 0}, { 'text-danger': account.unclearedBalance < 0}]">
                        {{ $formatNumber(account.unclearedBalance, {style: 'currency', currency: currency}) }}
                    </strong>
                    <p class="small">{{ $t('form.balance.uncleared') }}</p>
                </div>
                <div class="col text-center">
                    <strong :class="[{ 'text-success': account.workingBalance >= 0}, { 'text-danger': account.workingBalance < 0}]">
                        {{ $formatNumber(account.workingBalance, {style: 'currency', currency: currency}) }}
                    </strong>
                    <p class="small">{{ $t('form.balance.working') }}</p>
                </div>
            </div>
        </div>

        <div class="toolbar toolbar-secondary">
            <div class="row">
                <div class="col">
                    <button class="btn btn-link">
                        <span class="fa fa-plus"></span> {{ $t('action.new.transaction') }}
                    </button>
                </div>

                <div class="col text-right">
                    <button class="btn btn-link" :title="$t('action.edit.account')">
                        <span class="fa fa-cog"></span>
                    </button>
                </div>
            </div>
        </div>

        <div class="transactions content">
            <div class="transactions-header">
                <div class="transaction-clear">&nbsp;</div>
                <div class="transaction-date">{{ $t('form.date') }}</div>
                <div class="transaction-payee">{{ $t('form.payee') }}</div>
                <div class="transaction-category">{{ $t('form.category') }}</div>
                <div class="transaction-outflow">{{ $t('form.outflow') }}</div>
                <div class="transaction-inflow">{{ $t('form.inflow') }}</div>
                <div class="transaction-actions">&nbsp;</div>
            </div>
            <virtual-list :size="37" :remain="8" :tobottom="loadMore">
                <div class="transactions-row" :class="[{ 'text-muted': new Date(item.date) > new Date() }]"
                     v-for="(item, index) of transactions" :key="index">
                    <div class="transaction-clear">
                        <button class="btn btn-xs"
                                :class="[{ 'btn-success': item.cleared }, {'btn-light': !item.cleared}]"
                        v-if="new Date(item.date) <= new Date()">
                            <span class="fa fa-check"></span>
                        </button>
                    </div>
                    <div class="transaction-date">
                        {{ $formatDate(new Date(item.date), {year: 'numeric', month: '2-digit', day: '2-digit'}) }}
                    </div>
                    <div class="transaction-payee">{{ item.payee }}</div>
                    <div class="transaction-category">{{ item.category }}</div>
                    <div class="transaction-outflow">
                        <span v-if="item.amount < 0">
                            {{ $formatNumber(item.amount * -1, {style: 'currency', currency: currency}) }}
                        </span>
                    </div>
                    <div class="transaction-inflow">
                        <span v-if="item.amount >= 0">
                            {{ $formatNumber(item.amount, {style: 'currency', currency: currency}) }}
                        </span>
                    </div>
                    <div class="transaction-actions">
                        <a :title="$t('action.edit.transaction')" class="text-muted">
                            <span class="fa fa-pencil"></span>
                        </a>
                    </div>
                </div>
            </virtual-list>
        </div>
    </div>
</template>

<script>
    import virtualList from 'vue-virtual-scroll-list'

    export default {
        props: ['account_id'],
        components: {virtualList},
        computed: {
            currency: function () {
                return window.currency;
            }
        },
        data: () => ({
            account: null,
            transactions: [],
            nextPage: null
        }),
        created: function () {
            axios
                .get('/api/accounts/' + this.account_id)
                .then(response => {
                    this.account = response.data.data;
                })
                .catch(e => {
                    this.errors.push(e)
                });

            axios
                .get('/api/accounts/' + this.account_id + '/transactions')
                .then(response => {
                    this.transactions = response.data.data;
                    this.nextPage = response.data.next_page_url;
                })
                .catch(e => {
                    this.errors.push(e)
                });
            this.loadMore();
        },
        methods: {
            loadMore: function () {
                if (this.nextPage === null) return;

                axios
                    .get('/api/accounts/' + this.nextPage + '/transactions')
                    .then(response => {
                        this.transactions.concat(response.data.data);
                        this.nextPage = response.data.next_page_url;
                    })
                    .catch(e => {
                        this.errors.push(e)
                    });

            }
        }

    }
</script>