<template>
    <div class="sidebar"
         rel="sidebar"
         @click="hide">
        <div class="sidebar__content py-3 py-md-0" @click.stop>
            <app-menu @navigate="hide"></app-menu>
        </div>
    </div>
</template>

<script>
    import AppMenu from './AppMenu'

    export default {
        components: {
            AppMenu
        },
        mounted() {
            let sidebar = this.$el
            sidebar.addEventListener('transitionend', function () {
                sidebar.classList.remove('sidebar--animatable')
            }, false)
        },
        methods: {
            hide() {
                document.body.style.removeProperty('overflow')
                let classes = this.$el.classList
                if (classes.contains('sidebar--visible')) {
                    classes.add('sidebar--animatable')
                    classes.remove('sidebar--visible')
                }
            }
        }
    }
</script>
