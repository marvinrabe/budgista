<template>
    <div>
        <skeleton
                theme="opacity"
                duration="1"
                class="transactions-row"
                bg-color="rgba(0, 0, 0, 0.1)"
                v-once
                v-for="n in 25"
                :key="n"
        >
            <div class="transaction-item">
            <span class="transaction-column">
                <span class="transaction-date">
                    <tb-skeleton shape="radius" height="1em" width="66%" style="margin: .25em 0;"></tb-skeleton>
                </span>
                <span class="transaction-payee">
                    <tb-skeleton shape="radius" height="1em" width="66%" style="margin: .25em 0;"></tb-skeleton>
                </span>
            </span>
                <span class="transaction-column-2">
                <span class="transaction-category">
                    <tb-skeleton shape="radius" height="1em" width="66%" style="margin: .25em 0;"></tb-skeleton>
                </span>
                <span class="transaction-amount">
                    <tb-skeleton shape="radius" height="1em" width="50%" style="margin: .25em 0;"></tb-skeleton>
                </span>
            </span>
            </div>
            <div class="transaction-clear">
                <tb-skeleton shape="circle" height="1em" width="1em" style="margin: .25em .5em;"></tb-skeleton>
            </div>
        </skeleton>
    </div>
</template>

<script>
    import {Skeleton, TbSkeleton} from 'tb-skeleton'

    export default {
        components: {
            Skeleton,
            TbSkeleton
        }
    }
</script>
