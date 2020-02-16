<template>
  <div v-if="notVerified"
       class="bg-yellow-0 border-yellow-2 border-0 border-l-4 p-3 mb-3 shadow">
    <div class="md:flex items-center">
      <i18n path="message.verifyEmail" tag="div">
        <template v-slot:email>
          <strong>{{ $page.user.email }}</strong>
        </template>
      </i18n>

      <div class="mt-2 md:mt-0 ml-auto text-right">
        <div class="btn-group">
          <ResendVerification class="hover:underline"/>
          <AppButton
            :label="$t('action.changeEmail')"
            to="/profile"
            class="hover:underline"
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
    },
    computed: {
      notVerified () {
        return !this.$page.user.email_verified_at
      }
    }
  }
</script>
