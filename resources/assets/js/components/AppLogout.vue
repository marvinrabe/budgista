<template>
    <div>
        <a class="dropdown-item"
           href="#"
           @click.stop.prevent="logout()">
            {{ $t('action.logout') }}
        </a>
        <form ref="logout-form" action="/logout" method="POST" class="hidden">
            <input type="hidden" name="_token" :value="token">
        </form>
    </div>
</template>


<script>
    export default {
        computed: {
            token: function () {
                return document.head.querySelector('meta[name="csrf-token"]').content;
            }
        },
        methods: {
            logout: function () {
                this.$refs['logout-form'].submit();
            }
        }
    }
</script>