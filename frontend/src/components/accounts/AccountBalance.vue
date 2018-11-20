<template>
    <div class="balance">
        <AppNumber
                :color="true"
                :value="account.clearedBalance"
                label="form.balance.cleared"
        />
        <AppNumber
                :color="true"
                :value="account.workingBalance"
                label="form.balance.working"
        />
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
    import AppNumber from '../AppNumber'

    export default {
        props: ['account'],
        components: {
            AppNumber
        }
    }
</script>
