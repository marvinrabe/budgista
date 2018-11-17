<template>
    <div id="app">
        <router-view></router-view>
        <portal-target name="modal"></portal-target>
        <vue-snotify></vue-snotify>
    </div>
</template>

<style src="./sass/app.scss" lang="scss"></style>

<script>
    import 'typeface-roboto'

    export default {}
</script>
