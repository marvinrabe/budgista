<template>
    <div class="main">

        <app-toolbar :title="$t('title.categories')">
            <button type="button"
                    class="btn btn-primary btn-sm"
                    @click.prevent="$refs.createCategory.showModal()"
                    slot="submenu"
                    :title="$t('action.create.category')">
                <font-awesome-icon icon="plus"/>
                {{ $t('word.category') }}
            </button>
        </app-toolbar>

        <draggable v-model="categories" :options="{handle:'.handle'}" class="list-group">
            <div class="list-group-item" v-for="category in categories">
                <div class="d-flex align-items-center">
                                <span class="handle">
                                    <font-awesome-icon icon="arrows-alt-v" fixed-width/>
                                </span>
                    <div class="name">
                        {{ category.name}}
                    </div>
                    <button class="btn btn-sm btn-text-dark"
                            @click.prevent="$refs.updateCategory.showModal(category)"
                            :title="$t('action.edit.category')">
                        <font-awesome-icon icon="pencil-alt"/>
                    </button>
                </div>
            </div>
        </draggable>

        <create-category ref="createCategory"></create-category>
        <update-category ref="updateCategory"
                         @delete:category="category => $refs.deleteCategory.showModal(category)"></update-category>
        <delete-category ref="deleteCategory"></delete-category>
    </div>
</template>

<style lang="scss" scoped>
    .name {
        flex: 1;
        cursor: default;
    }

    .handle {
        cursor: move;
        cursor: -webkit-grab;
        cursor: -moz-grab;
        opacity: .5;
        padding: 0 .3em;
    }
</style>

<script>
    import CreateCategory from './CreateCategory'
    import UpdateCategory from './UpdateCategory'
    import DeleteCategory from './DeleteCategory'
    import draggable from 'vuedraggable'

    export default {
        components: {draggable, CreateCategory, UpdateCategory, DeleteCategory},
        computed: {
            categories: {
                get() {
                    return this.$store.getters.sortedCategories
                },
                set(value) {
                    this.$store.dispatch('sortCategories', value)
                }
            }
        }
    }
</script>