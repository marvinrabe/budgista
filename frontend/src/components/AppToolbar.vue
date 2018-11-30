<template>
    <div class="toolbar">
        <app-window :title="title"></app-window>

        <div class="title">
            <slot name="title">
                <AppEllipsis>{{ title }}</AppEllipsis>
            </slot>
        </div>

        <slot></slot>

        <div class="button-right">
            <slot name="submenu">&nbsp;</slot>
        </div>
    </div>
</template>

<script>
    import AppEllipsis from './AppEllipsis'
    import AppWindow from './AppWindow'

    export default {
        props: ['title'],
        components: {
            AppEllipsis,
            AppWindow
        }
    }
</script>
