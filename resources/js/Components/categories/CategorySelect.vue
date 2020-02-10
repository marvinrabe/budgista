<template>
  <AppSkeleton :loading="true" height="2.35em" margin="0" v-if="$apollo.loading" width="100%"/>
  <select
    :value="value"
    @input="e => $emit('input', e.target.value)"
    class="form-control"
    v-else
  >
    <option :value="null">
      {{ $t('form.uncategorized') }}
    </option>
    <optgroup
      :key="group.id"
      :label="group.name"
      v-for="group in sortedGroups"
    >
      <option
        :key="category.id"
        :value="category.id"
        v-for="category in group.categories"
      >
        {{ category.name }}
      </option>
    </optgroup>
  </select>
</template>

<script>
  import AppSkeleton from '../AppSkeleton'

  export default {
    components: { AppSkeleton },
    props: {
      value: {
        type: String,
        default: null
      },
      exclude: { // TODO exclude category
        type: String,
        default: null
      }
    },
    apollo: {
      groups: {
        query: require('../../gql/query/groups.gql')
      }
    },
    computed: {
      sortedGroups () {
        const groups = this.groups
        groups.sort((a, b) => a.sort - b.sort)
        return groups
      }
    }
  }
</script>
