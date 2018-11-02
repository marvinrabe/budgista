<template>
    <div class="menu"
         @click="hideMenu"
         v-sticky="{ zIndex:  sticky ? 900 : 1035, stickyTop: sticky ? 72 : 0, disabled: !sticky}"
         v-resize="resizePage">
        <div class="app-menu py-3 py-md-0" @click.stop>
            <app-menu @navigate="hideMenu"></app-menu>
        </div>
    </div>
</template>

<script>
    import VueSticky from 'vue-sticky'
    import VueResize from 'vue-resize-directive'
    import AppMenu from './AppMenu'

    export default {
        components: {
            AppMenu
        },
        directives: {
            sticky: VueSticky,
            resize: VueResize
        },
        data() {
            return {
                sticky: window.innerWidth >= 768
            }
        },
        mounted() {
            let menu = this.$el

            menu.addEventListener('transitionend', function () {
                menu.classList.remove('menu--animatable')
            }, false)
        },
        methods: {
            resizePage() {
                this.sticky = window.innerWidth >= 768
            },
            hideMenu() {
                let menu = this.$el
                if (menu.classList.contains('menu--visible')) {
                    menu.classList.add('menu--animatable')
                    menu.classList.remove('menu--visible')
                }
            }
        }
    }
</script>
