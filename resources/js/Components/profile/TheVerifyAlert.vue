<template>
  <div class="alert" v-if="!$page.user.email_verified_at">
    <div class="d-md-flex align-items-center">
      <i18n path="message.verifyEmail" tag="div">
        <strong place="email">{{ me.email }}</strong>
      </i18n>
      <div class="mt-2 mt-md-0 ml-auto text-right">
        <div class="btn-group">
          <ResendVerification/>
          <AppButton
            :label="$t('action.changeEmail')"
            :to="{name: 'profile'}"
            small
            subtle
          />
        </div>
      </div>
    </div>
  </div>
</template>

<script>
  import AppButton from '../form/AppButton'
  import ResendVerification from './ResendVerification'

  export default {
    components: {
      AppButton,
      ResendVerification
    }
  }
</script>

<style scoped>
  .alert {
    @apply bg-yellow-100 border-yellow-200 text-black border-solid border-0 border-l-4 p-4 mb-4 shadow;
  }
</style>
