<template>
    <span class="ellipsis" :style="{ height: height + 'px' }">
        <span ref="ellipsis" class="ellipsis-item">
            <slot></slot>
        </span>
    </span>
</template>

<script>
    export default {
        data() {
            return {
                height: 0
            }
        },
        mounted() {
            this.height = this.$refs.ellipsis.clientHeight;
        }
    }
</script>

<style scoped>
    .ellipsis {
        display: block;
        position: relative;
    }

    .ellipsis-item {
        display: block;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
        min-width: 0;
        position: absolute;
        left: 0;
        right: 0;
    }
</style>