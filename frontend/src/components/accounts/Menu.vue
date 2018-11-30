<template>
    <div class="my-2">
        <div class="d-flex align-items-center">
            <p class="menu__header">{{ $t('title.accounts') }}</p>
            <create-account ref="createAccount"
                            class="ml-auto">
            </create-account>
        </div>

        <template v-if="loading">
            <MenuSkeleton v-for="n in 3" :key="n"></MenuSkeleton>
        </template>
        <template v-else>
            <menu-item
                    v-for="account in spendingAccounts"
                    :key="account.id"
                    :account="account"
                    @click.native="$emit('navigate')">
            </menu-item>

            <template v-if="trackingAccounts.length">
                <p class="menu__header mt-2">{{ $t('title.trackingAccounts') }}</p>
                <menu-item
                        v-for="account in trackingAccounts"
                        :key="account.id"
                        :account="account"
                        @click.native="$emit('navigate')">
                </menu-item>
            </template>
        </template>
    </div>
</template>

<script>
    import CreateAccount from './CreateAccount'
    import MenuItem from './MenuItem'
    import {mapGetters} from 'vuex'
    import MenuSkeleton from '@/components/accounts/MenuSkeleton'

    export default {
        components: {
            MenuSkeleton,
            MenuItem,
            CreateAccount
        },
        data() {
            return {
                loading: true
            }
        },
        computed: {
            ...mapGetters([
                'spendingAccounts',
                'trackingAccounts'
            ])
        },
        mounted() {
            this.$store
                .dispatch('accounts/fetch')
                .then(() => {
                    this.loading = false
                })
        }
    }
</script>
