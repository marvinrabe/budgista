<template>
    <div class="balance">
        <div class="balance-minor">
            <div class="balance-current">
                <money-format
                        class="balance-value"
                        :class="[{ 'text-success': account.clearedBalance >= 0}, { 'text-danger': account.clearedBalance < 0}]"
                        :value="account.clearedBalance">
                </money-format>
                <p class="balance-label">{{ $t('form.balance.current') }}</p>
            </div>
            <div class="balance-upcoming">
                <money-format
                        class="balance-value"
                        :class="[{ 'text-success': account.unclearedBalance >= 0}, { 'text-danger': account.unclearedBalance < 0}]"
                        :value="account.unclearedBalance">
                </money-format>
                <p class="balance-label">{{ $t('form.balance.upcoming') }}</p>
            </div>
        </div>
        <div class="balance-future">
            <money-format
                    class="balance-value"
                    :class="[{ 'text-success': account.workingBalance >= 0}, { 'text-danger': account.workingBalance < 0}]"
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