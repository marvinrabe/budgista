<template>
  <select
    :value="value"
    @input="e => $emit('input', e.target.value)"
    class="form-control"
  >
    <option :value="null" disabled selected hidden>
      {{ $t('form.pleaseSelect') }}
    </option>
    <option
      :key="group.id"
      :value="group.id"
      v-for="group in $page.user.groups"
    >
      {{ group.name }}
    </option>
  </select>
</template>

<script>
  export default {
    props: {
      value: {
        type: String,
        default: null
      }
    }
  }
</script>
