<template>
    <ellipsis v-if="category">
        {{ category.name }}
    </ellipsis>
</template>

<script>
    import AppElipsis from '../AppEllipsis';

    export default {
        props: {
            id: {
                type: String
            }
        },
        components: {
            AppElipsis
        },
        computed: {
            category() {
                return this.$store.getters.findCategoryById(this.id);
            }
        }
    }
</script>