<template>
    <div class="toolbar">
        <app-window :title="title"></app-window>

        <div class="button-left" :class="[{'d-md-none': !back}]">
            <button v-if="back"
                    class="btn btn-secondary"
                    type="button"
                    :aria-label="$t('action.back')"
                    @click.prevent="$emit('back')">
                <font-awesome-icon :icon="backIcon" fixed-width/>
            </button>
            <app-sidebar-toggle v-else></app-sidebar-toggle>
        </div>

        <div class="title">
            <slot name="title">
                <ellipsis>{{ title }}</ellipsis>
            </slot>
        </div>

        <div class="button-right">
            <slot name="submenu">&nbsp;</slot>
        </div>

        <slot></slot>
    </div>
</template>

<script>
    import AppWindow from './AppWindow';
    import AppSidebarToggle from './AppSidebarToggle'
    import FontAwesomeIcon from '@fortawesome/vue-fontawesome'
    import faChevronLeft from '@fortawesome/fontawesome-free-solid/faChevronLeft'

    export default {
        props: ['title', 'back'],
        components: {
            AppSidebarToggle,
            AppWindow,
            FontAwesomeIcon
        },
        computed: {
            backIcon() {
                return faChevronLeft;
            }
        }
    }
</script>

<style scoped>
    .button-left,
    .button-right {
        text-align: center;
        width: 45px;
        flex: 45px;
        flex-grow: 0;
    }
</style>