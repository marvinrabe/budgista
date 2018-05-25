<template>
    <div class="balance">
        <app-number :value="account.clearedBalance" label="form.balance.current"></app-number>
        <app-number :value="account.unclearedBalance" label="form.balance.upcoming"></app-number>
        <app-number :value="account.workingBalance" label="form.balance.future" :color="true"></app-number>
    </div>
</template>

<style scoped>
    .balance {
        display: flex;
    }
</style>

<script>
    import AppNumber from '../../components/AppNumber'

    export default {
        props: ['account'],
        components: {
            AppNumber
        }
    }
</script>