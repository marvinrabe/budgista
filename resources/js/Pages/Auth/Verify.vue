<template>
  <div class="card">
    <div class="card-body">
      <div
        class="text-center p-5"
        style="min-height: 230px;"
        v-if="loading"
      >
        <app-spinner/>
      </div>
      <div
        class="verify"
        v-else
      >
        <font-awesome-icon
          :icon="icon"
          size="5x"
        />

        <h1 v-t="title"/>
        <p v-t="message"/>

        <AppButton
          :label="$t('action.returnToApp')"
          to="/"
        />
      </div>
    </div>
  </div>
</template>

<style lang="scss" scoped>
  @import '../../../sass/variables';

  .verify {
    text-align: center;

    svg {
      margin-bottom: .2em;
    }

    .fa {
      &-exclamation-circle {
        color: $yellow;
      }

      &-check-circle {
        color: $green;
      }
    }
  }
</style>

<script>
  import { faCheckCircle, faExclamationCircle } from '@fortawesome/free-solid-svg-icons'
  import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome'
  import axios from 'axios'
  import AppSpinner from '../../Components/AppSpinner'
  import AppButton from '../../Components/form/AppButton'

  export default {
    components: {
      AppButton,
      AppSpinner,
      FontAwesomeIcon
    },
    props: {
      token: {
        type: String,
        required: true
      }
    },
    data () {
      return {
        loading: true,
        verified: false
      }
    },
    computed: {
      icon () {
        if (this.verified) {
          return faCheckCircle
        }
        return faExclamationCircle
      },
      title () {
        if (this.verified) {
          return 'title.success'
        }
        return 'title.error'
      },
      message () {
        if (this.verified) {
          return 'message.verificationSuccessful'
        }
        return 'message.verificationFailed'
      }
    },
    created () {
      axios.put('/auth/verify/' + this.token)
        .then(() => {
          this.verified = true
        })
        .finally(() => {
          this.loading = false
        })
    }
  }
</script>
