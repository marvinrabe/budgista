<template>
    <div class="toolbar toolbar-primary">
        <app-sidebar-toggle></app-sidebar-toggle>

        <app-window :title="title"></app-window>
        <div class="title">
            <slot name="title">
                <ellipsis>{{ title }}</ellipsis>
            </slot>
        </div>

        <div class="sub-menu-placeholder d-md-none">&nbsp;</div>

        <slot></slot>
    </div>
</template>

<script>
    export default {
        'props': ['title']
    }
</script>

<style scoped>
    .sub-menu-placeholder {
        width: 38px;
        flex: 38px;
        flex-grow: 0;
    }
</style>