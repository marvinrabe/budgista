<template>
    <div class="menu-toggle-container d-md-none ml-3">
        <button class="menu-toggle btn" type="button" aria-controls="menu"
                :aria-label="$t('action.navigation')"
                @click.prevent="showMenu">
            <span class="fa fa-navicon"></span>
        </button>
    </div>
</template>

<style>
    .menu-toggle-container {
        position: absolute;
        top: 0.8em;
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