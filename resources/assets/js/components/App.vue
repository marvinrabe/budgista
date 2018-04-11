<template>
    <div id="app">
        <router-view></router-view>
        <vue-snotify></vue-snotify>
    </div>
</template>

<script>
    import {setLanguage} from '../i18n'

    export default {
        mounted() {
            setLanguage(document.querySelector('html').getAttribute('lang'));
        }
    }
</script>