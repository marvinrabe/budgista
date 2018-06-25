<template>
    <div class="numeric">
        <money-format
                class="numeric-value"
                :class="colorClasses"
                :value="value">
        </money-format>
        <p class="numeric-label">{{ $t(label) }}</p>
    </div>
</template>

<style lang="scss" scoped>
    @import "../../sass/_variables.scss";

    .numeric {
        text-align: right;
        padding: 0 .5em;
        display: flex;
        flex: 1;
        flex-direction: column;
        justify-content: center;

        &-label,
        &-value {
            flex: 1;
            flex-grow: 0;
            font-size: 1em;
            line-height: 1.25em;
            white-space: nowrap;
        }

        &-value {
            font-weight: 500;
        }

        &-label {
            font-size: .8em;
            color: $gray-600;
        }
    }
</style>

<script>
    export default {
        props: ['value', 'label', 'color'],
        computed: {
            colorClasses() {
                if (this.color) {
                    return {
                        'text-success': this.value >= 0,
                        'text-danger': this.value < 0
                    }
                }
                return {}
            }
        }
    }
</script>