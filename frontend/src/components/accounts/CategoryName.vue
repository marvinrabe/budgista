<template>
    <app-ellipsis v-if="category">
        {{ category.name }}
    </app-ellipsis>
</template>

<script>
    import AppEllipsis from '../AppEllipsis';

    export default {
        props: {
            id: {
                type: String
            }
        },
        components: {
            AppEllipsis
        },
        computed: {
            category() {
                return this.$store.getters.findCategoryById(this.id);
            }
        }
    }
</script>
