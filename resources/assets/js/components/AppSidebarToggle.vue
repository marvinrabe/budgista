<template>
    <div class="menu-toggle-container d-md-none">
        <button class="menu-toggle btn" type="button" aria-controls="menu"
                :aria-label="$t('action.navigation')"
                @click.prevent="showMenu">
            <font-awesome-icon icon="bars" />
        </button>
    </div>
</template>

<style>
    .menu-toggle-container {
        position: absolute;
        top: 13px;
        left: 13px;
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