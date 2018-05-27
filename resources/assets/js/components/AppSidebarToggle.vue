<template>
    <button class="btn btn-text-dark" type="button" aria-controls="menu"
            :aria-label="$t('action.navigation')"
            @click.prevent="showMenu">
        <font-awesome-icon icon="bars" fixed-width />
    </button>
</template>

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