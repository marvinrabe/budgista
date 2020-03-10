<template>
  <AppSelect
    :value="value"
    @input="value => $emit('input', value)"
  >
    <option :value="null" v-if="income">
      {{ $t('form.income') }}
    </option>
    <option :value="null" v-else>
      {{ $t('form.uncategorized') }}
    </option>
    <optgroup :label="$t(income ? 'form.transferFrom': 'form.transferTo')">
      <option
        :key="account.id"
        :value="'account:' + account.id"
        v-if="exclude !== account.id"
        v-for="account in $page.user.accounts"
      >
        {{ account.name }}
      </option>
    </optgroup>
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
      },
      accounts: {
        type: Boolean,
        default: false
      }
    }
  }
</script>
