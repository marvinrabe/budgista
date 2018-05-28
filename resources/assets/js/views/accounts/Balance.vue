<template>
    <div class="balance">
        <app-number :value="account.clearedBalance" label="form.balance.cleared" :color="true"></app-number>
        <app-number :value="account.workingBalance" label="form.balance.working" :color="true"></app-number>
    </div>
</template>

<style scoped>
    .balance {
        padding: 0 1em;
        margin: 0 -.5em;
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