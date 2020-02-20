<template>
  <div v-if="notVerified"
       class="bg-yellow-0 border-yellow-3 border rounded p-3 mb-4">
    <div class="md:flex items-center text-black-75">
      <i18n path="message.verifyEmail" tag="div">
        <template v-slot:email>
          <strong>{{ $page.user.email }}</strong>
        </template>
      </i18n>

      <div class="mt-2 md:mt-0 ml-auto text-right">
        <div class="flex">
          <ResendVerification />
          <AppButton
            class="hover:underline"
            :label="$t('action.changeEmail')"
            to="/profile"
            subtle
            small
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
