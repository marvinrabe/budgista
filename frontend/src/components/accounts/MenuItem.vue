<template>
    <router-link :to="{ name: 'account', params: { account_id: account.id }}"
                 active-class="active"
                 class="menu__item">
        <font-awesome-icon :icon="icon" fixed-width class="mr-1"/>
        <ellipsis style="flex: 1;">{{ account.name }}</ellipsis>
        <money-format
                class="ml-auto badge"
                :class="[{ 'text-danger': account.workingBalance < 0, 'text-success': account.workingBalance >= 0 }]"
                :value="account.workingBalance">
        </money-format>
    </router-link>
</template>

<script>
    import {accountIcons} from '../../config'
    import {FontAwesomeIcon} from '@fortawesome/vue-fontawesome'
    import {faCreditCard} from '@fortawesome/free-solid-svg-icons'

    export default {
        props: ['account'],
        components: {
            FontAwesomeIcon
        },
        computed: {
            icon() {
                let icon = accountIcons.find(x => x.name === this.account.icon)
                if (icon) {
                    return icon.icon
                }
                return faCreditCard
            }
        }
    }
</script>
