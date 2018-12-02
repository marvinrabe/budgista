<template>
    <button class="btn btn-text-dark"
            type="button"
            aria-controls="menu"
            :aria-label="$t('action.navigation')"
            @click.prevent="showMenu">
        <font-awesome-icon :icon="icon" fixed-width/>
    </button>
</template>

<script>
    import {faBars} from '@fortawesome/free-solid-svg-icons'

    export default {
        computed: {
            icon() {
                return faBars
            }
        },
        methods: {
            showMenu() {
                document.body.style.setProperty('overflow', 'hidden')
                let menu = document.querySelector('[rel=\'sidebar\']')
                menu.classList.add('sidebar--animatable')
                menu.classList.add('sidebar--visible')
            }
        }
    }
</script>
