<template>
  <AppButton
    :loading="loading"
    @click="send"
    class="hover:underline"
    subtle
    small
  >
    {{ $t('action.sendVerification') }}
  </AppButton>
</template>

<script>
  import AppButton from '@/Components/form/AppButton'

  export default {
    components: {
      AppButton
    },
    data () {
      return {
        loading: false
      }
    },
    methods: {
      send () {
        this.loading = true

        this.$inertia
          .post('/email/resend', this.form)
          .finally(() => {
            this.loading = false
          })
      }
    }
  }
</script>
