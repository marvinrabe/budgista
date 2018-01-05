<template>
    <div class="balance">
        <div class="balance-minor">
            <div class="balance-current">
                <p class="balance-label">{{ $t('form.balance.current') }}</p>
                <money-format
                        class="balance-value"
                        :value="account.clearedBalance">
                </money-format>
            </div>
            <div class="balance-upcoming">
                <p class="balance-label">{{ $t('form.balance.upcoming') }}</p>
                <money-format
                        class="balance-value"
                        :value="account.unclearedBalance">
                </money-format>
            </div>
        </div>
        <div class="balance-future">
            <money-format
                    class="balance-value"
                    :value="account.workingBalance">
            </money-format>
            <p class="balance-label">{{ $t('form.balance.future') }}</p>
        </div>
    </div>
</template>

<script>
    export default {
        props: ['account']
    }
</script>