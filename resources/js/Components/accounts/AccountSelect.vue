<template>
  <select
    :value="value"
    @input="e => $emit('input', e.target.value)"
    class="form-control"
  >
    <option :value="null" disabled hidden>
      {{ $t('form.pleaseSelect')}}
    </option>
    <option
      :key="account.id"
      :value="account.id"
      v-if="exclude !== account.id"
      v-for="account in $page.user.accounts"
    >
      {{ account.name }}
    </option>
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
