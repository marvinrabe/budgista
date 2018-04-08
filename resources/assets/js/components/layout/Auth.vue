<template>
    <div id="auth" class="py-4">
        <app-logo :height="48" class="mb-2"></app-logo>

        <div class="container">
            <div class="row justify-content-md-center">
                <div class="col-sm-12 col-md-6 col-lg-5 center">
                    <router-view :key="$router.fullPath"></router-view>
                </div>
            </div>
        </div>
    </div>
</template>

<style scoped>
    #auth {
        height: 100%;
        display: flex;
        flex-direction: column;

        overflow-y: scroll; /* has to be scroll, not auto */
        -webkit-overflow-scrolling: touch;
    }
</style>

<script>
    import AppLogo from '../AppLogo.vue'

    export default {
        components: {
            AppLogo
        }
    }
</script>