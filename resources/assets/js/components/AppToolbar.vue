<template>
    <div class="toolbar">
        <app-window :title="title"></app-window>

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
    import FontAwesomeIcon from '@fortawesome/vue-fontawesome'
    import faChevronLeft from '@fortawesome/fontawesome-free-solid/faChevronLeft'

    export default {
        props: ['title', 'back'],
        components: {
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
