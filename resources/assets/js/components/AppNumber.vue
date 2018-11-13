<template>
    <div class="numeric">
        <app-skeleton :busy="loading" variant="dark">
            <money-format
                    class="numeric-value"
                    :class="colorClasses"
                    :value="value">
            </money-format>
        </app-skeleton>
        <p class="numeric-label">{{ $t(label) }}</p>
    </div>
</template>

<style lang="scss" scoped>
    @import "../../sass/_variables.scss";

    .numeric {
        padding: 0 1em;
        display: flex;
        flex: 1;
        flex-direction: column;
        align-items: flex-end;
        border-right: 1px solid $gray-300;

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

        &:last-child {
            border-right: 0;
        }

        &:first-child {
            border-left: 0;
        }
    }
</style>

<script>
    import AppSkeleton from './AppSkeleton'
    export default {
        props: ['value', 'label', 'color', 'loading'],
        components: {
            AppSkeleton
        },
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
