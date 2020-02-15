<template>
  <select
    :value="value"
    @input="e => $emit('input', e.target.value)"
    class="form-control"
  >
    <option :value="null">
      {{ $t('form.uncategorized') }}
    </option>
    <optgroup
      :key="group.id"
      :label="group.name"
      v-for="group in $page.user.groups"
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
  export default {
    props: {
      value: {
        type: String,
        default: null
      },
      exclude: { // TODO exclude category
        type: String,
        default: null
      }
    }
  }
</script>
