<template>
    <div class="toolbar">
        <app-sidebar-toggle></app-sidebar-toggle>

        <app-window :title="title"></app-window>
        <div class="title">
            <slot name="title">
                <ellipsis>{{ title }}</ellipsis>
            </slot>
        </div>

        <div class="sub-menu-placeholder">
            <slot name="submenu">&nbsp;</slot>
        </div>

        <slot></slot>
    </div>
</template>

<script>
    import AppWindow from './AppWindow';
    import AppSidebarToggle from './AppSidebarToggle'

    export default {
        props: ['title'],
        components: {AppSidebarToggle, AppWindow}
    }
</script>

<style scoped>
    .sub-menu-placeholder {
        width: 45px;
        flex: 45px;
        flex-grow: 0;
    }
</style>