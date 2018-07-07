<template>
    <select class="form-control"
            :value="value"
            @input="e => $emit('input', e.target.value)">
        <option :value="null">{{ $t('form.uncategorized') }}</option>
        <optgroup v-for="group in sortedGroups"
                  :label="group.name"
                  :key="group.id"
                  v-once>
            <option v-for="category in categories(group.id)"
                    :key="category.id"
                    :value="category.id">
                {{ category.name }}
            </option>
        </optgroup>
        <optgroup :label="$t('title.ungrouped')" v-if="categories(null).length">
            <option v-for="category in categories(null)"
                    :key="category.id"
                    :value="category.id">
                {{ category.name }}
            </option>
        </optgroup>
    </select>
</template>

<script>
    import {mapGetters} from 'vuex'

    export default {
        props: ['value', 'exclude'],
        computed: {
            ...mapGetters([
                'sortedGroups'
            ])
        },
        methods: {
            categories(groupId) {
                return this.$store.getters.sortedCategoriesByGroup(groupId).filter((item) => item.id !== this.exclude)
            }
        }
    }
</script>