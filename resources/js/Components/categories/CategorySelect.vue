<template>
  <select
    :value="value"
    @input="e => $emit('input', e.target.value)"
    class="form-control"
  >
    <option :value="null" v-if="income">
      {{ $t('form.income') }} ({{ $t('form.unallocated')}})
    </option>
    <option :value="null" v-else>
      {{ $t('form.uncategorized') }}
    </option>
    <optgroup :label="$t('title.categories')">
      <option
        :key="category.id"
        :value="category.id"
        v-if="exclude !== category.id"
        v-for="category in $page.user.categories"
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
      exclude: {
        type: String,
        default: null
      },
      income: {
        type: Boolean,
        default: false
      }
    }
  }
</script>
