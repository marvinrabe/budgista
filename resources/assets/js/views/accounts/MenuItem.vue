<template>
    <router-link :to="{ name: 'account', params: { account_id: account.id }}"
                 active-class="active"
                 class="nav-link-main">
        <ellipsis style="flex: 1;">{{ account.name }}</ellipsis>
        <money-format
                class="ml-auto badge"
                :class="[{ 'text-danger': account.workingBalance < 0, 'text-success': account.workingBalance >= 0 }]"
                :value="account.workingBalance">
        </money-format>
    </router-link>
</template>

<script>
    export default {
        props: ['account']
    }
</script>