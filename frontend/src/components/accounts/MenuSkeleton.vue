<template>
    <skeleton theme="opacity" duration="1" class="menu__item" bg-color="rgba(0, 0, 0, 0.1)" style="line-height: 1.5em">
        <tb-skeleton shape="circle" height="1em" width="1em"
                     style="margin-right: .5em; margin-left: .125em;"></tb-skeleton>
        <tb-skeleton shape="radius" height="1em" width="33%" style="margin: .25em 0;"></tb-skeleton>
        <tb-skeleton shape="radius" height="1em" width="22%" style="margin-left: auto;"></tb-skeleton>
    </skeleton>
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
