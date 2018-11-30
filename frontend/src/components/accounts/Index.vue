<template>
    <div v-if="account" class="main">
        <AppToolbar :title="account.name">
            <AccountBalance :account="account"/>

            <template slot="submenu">
                <AccountSettings :account="account"/>

                <router-link
                        :to="{ name: 'transaction.new', query: { account: account_id }}"
                        class="btn btn-primary btn-sm"
                        :title="$t('action.create.transaction')">
                    <font-awesome-icon icon="plus"/>
                    {{ $t('word.transaction') }}
                </router-link>
            </template>
        </AppToolbar>

        <TransactionList :account_id="account_id"></TransactionList>
    </div>
</template>

<style>
    @media (max-width: 575.98px) {
        .toolbar .balance .numeric:first-child {
            align-items: flex-start !important;
        }
    }
</style>

<style scoped>
    @media (max-width: 575.98px) {
        .toolbar .title {
            order: 1;
        }

        .toolbar .button-right {
            order: 2;
        }

        .toolbar .balance {
            order: 3;
            flex: 100%;
            padding: 0;
            margin-top: .5em;
        }

        .toolbar .balance .numeric {
            text-align: center !important;
        }
    }
</style>

<script>
    import AppToolbar from '../AppToolbar'
    import AccountBalance from './AccountBalance.vue'
    import AccountSettings from './AccountSettings'
    import TransactionList from '@/components/transactions/TransactionList'

    export default {
        props: ['account_id'],
        components: {
            AppToolbar,
            AccountBalance,
            AccountSettings,
            TransactionList
        },
        computed: {
            account() {
                return this.$store.getters.findAccountById(this.account_id)
            }
        }
    }
</script>
