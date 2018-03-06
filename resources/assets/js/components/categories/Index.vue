<template>
    <div class="main">

        <app-toolbar :title="$t('title.categories')">
            <button type="button"
                    class="btn btn-secondary"
                    @click.prevent="$refs.createCategory.showModal()"
                    :title="$t('action.create.category')"
                    slot="submenu">
                <font-awesome-icon icon="plus"/>
            </button>
        </app-toolbar>


        <div class="content container-fluid">
            <div class="row justify-content-center">
                <div class="col mt-3 col-lg-8">
                    <draggable v-model="categories" :options="{handle:'.name'}" class="list-group">
                        <div class="list-group-item" v-for="category in categories">
                            <div class="d-flex">
                                <div class="name">
                                    <span class="handle"></span>
                                    {{ category.name}}
                                </div>
                                <a href="#"
                                   class="text-muted ml-auto"
                                   @click.prevent="$refs.updateCategory.showModal(category)"
                                   :title="$t('action.edit.category')">
                                    <font-awesome-icon icon="pencil-alt"/>
                                </a>
                            </div>
                        </div>
                    </draggable>
                </div>
            </div>
        </div>

        <create-category ref="createCategory"></create-category>
        <update-category ref="updateCategory"
                         @delete:category="category => $refs.deleteCategory.showModal(category)"></update-category>
        <delete-category ref="deleteCategory"></delete-category>
    </div>
</template>

<style lang="scss" scoped>
    .name {
        position: relative;
    }

    .name, span.handle {
        cursor: move;
        cursor: -webkit-grab;
        cursor: -moz-grab;
    }

    span.handle {
        position: absolute;
        content: '....';
        width: 12px;
        height: 20px;
        display: inline-block;
        overflow: hidden;
        line-height: 5px;
        padding: 3px 4px;
        vertical-align: middle;
        margin-top: -.7em;
        margin-right: .3em;
        font-size: 12px;
        font-family: sans-serif;
        letter-spacing: 2px;
        color: #cccccc;
        left: -19px;
        top: 8px;
    }

    span.handle::after {
        content: '.. .. .. ..';
    }
</style>

<script>
    import CreateCategory from './CreateCategory';
    import UpdateCategory from './UpdateCategory';
    import DeleteCategory from './DeleteCategory';
    import draggable from 'vuedraggable'

    export default {
        components: {draggable, CreateCategory, UpdateCategory, DeleteCategory},
        computed: {
            categories: {
                get() {
                    return this.$store.getters.sortedCategories;
                },
                set(value) {
                    this.$store.dispatch('sortCategories', value)
                }
            }
        }
    }
</script>