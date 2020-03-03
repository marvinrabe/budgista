<template>
  <AppSelect
    :value="value"
    @input="value => $emit('input', value)"
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
  </AppSelect>
</template>

<script>
  import AppSelect from '@/Components/AppSelect'

  export default {
    components: { AppSelect },
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
