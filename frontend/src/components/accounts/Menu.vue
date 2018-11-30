<template>
    <div class="my-2">
        <div class="d-flex align-items-center">
            <p class="menu__header">{{ $t('title.accounts') }}</p>
            <create-account ref="createAccount"
                            class="ml-auto">
            </create-account>
        </div>

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
    </div>
</template>

<script>
    import CreateAccount from './CreateAccount'
    import MenuItem from './MenuItem'
    import {mapGetters} from 'vuex'

    export default {
        components: {
            MenuItem,
            CreateAccount
        },
        computed: {
            ...mapGetters([
                'spendingAccounts',
                'trackingAccounts'
            ])
        }
    }
</script>
