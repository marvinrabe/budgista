<template>
  <AppButton
    :disabled="sent"
    :label="text"
    :loading="loading"
    @click="send"
    subtle
    small
  />
</template>

<script>
  import axios from 'axios'
  import AppButton from '../form/AppButton'

  export default {
    components: {
      AppButton
    },
    data () {
      return {
        loading: false,
        sent: false
      }
    },
    computed: {
      text () {
        if (this.sent) {
          return this.$t('message.verificationSent')
        }
        return this.$t('action.sendVerification')
      }
    },
    methods: {
      send () {
        this.loading = true

        axios
          .post('/auth/verify')
          .then(() => {
            this.sent = true
          })
          .finally(() => {
            this.loading = false
          })
      }
    }
  }
</script>
