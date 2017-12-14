<template>
    <div class="d-md-none">
        <button class="menu-toggle btn" type="button" aria-controls="menu"
                :aria-label="$t('action.navigation')"
                @click.prevent="showMenu">
            <span class="fa fa-navicon"></span>
        </button>
    </div>
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