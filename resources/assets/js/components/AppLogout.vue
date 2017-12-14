<template>
    <form ref="logout-form" action="/logout" method="POST" class="d-inline-block">
        <input type="hidden" name="_token" :value="token">
        <a class="text-muted small" href="#"
           @click.prevent="logout">
            {{ $t('action.logout') }}
        </a>
    </form>
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
                this.$el.submit();
            }
        }
    }
</script>