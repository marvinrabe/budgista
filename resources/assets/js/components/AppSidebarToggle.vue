<template>
    <button class="menu-toggle d-md-none float-sm-none" type="button" aria-controls="menu"
            :aria-label="$t('action.navigation')"
            @click.prevent="showMenu">
        <font-awesome-icon icon="bars" fixed-width transform="shrink-3" />
    </button>
</template>

<style scoped>
    .menu-toggle {
        flex: 0;
        border: 0;
        background: transparent;
        font-size: 2rem;
        margin: 0 0 0 8px;
        color: white;
        padding: 0;
        opacity: 1;
    }

    .menu-toggle:hover {
        opacity: .8;
        cursor: pointer;
    }
</style>

<script>
    export default {
        methods: {
            showMenu() {
                let menu = document.querySelector(".menu");
                menu.classList.add("menu--animatable");
                menu.classList.add("menu--visible");
            }
        }
    }
</script>