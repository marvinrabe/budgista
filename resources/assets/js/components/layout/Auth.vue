<template>
    <div id="auth">
        <div class="container py-4">
            <div class="d-flex flex-column">
                <router-link :to="{name:'login'}" class="text-center">
                    <app-logo :height="48" class="mb-4" style="flex-shrink: 0"></app-logo>
                </router-link>
                <div class="row justify-content-md-center">
                    <div class="col-sm-12 col-md-6 col-lg-5 center">
                        <router-view :key="$router.fullPath"></router-view>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<style scoped>
    #auth {
        height: 100%;

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