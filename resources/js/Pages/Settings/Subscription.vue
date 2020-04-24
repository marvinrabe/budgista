<template>
  <Layout :title="$t('subscription.title')">
    <div class="card">
      <div class="card-header">
        <h2 class="text-xl">
          {{ $t('subscription.title') }}
        </h2>
      </div>
      <div class="card-body">
        <p v-if="!$page.user.premium">
          {{ $t('subscription.message.trial')}}
        </p>
        <p v-else-if="$page.user.subscription_state === 'active'">
          {{ $t('subscription.message.active')}}
          <DateFormat :value="$page.user.subscription_ends_at"/>
          <template v-if="!canCheckout">
            <div class="mt-2">
              <a class="font-medium tracking-wide" :href="$page.user.paddle_update_url">{{ $t('subscription.action.update')}}</a>
              &middot;
              <a class="font-medium tracking-wide" :href="$page.user.paddle_cancel_url">{{ $t('subscription.action.cancel')}}</a>
            </div>
          </template>
        </p>
        <p v-else-if="$page.user.subscription_state === 'cancelled'">
          {{ $t('subscription.message.cancelled')}}
          <DateFormat :value="$page.user.subscription_ends_at"/>
          <span class="block text-gray-6 mt-2">
            {{ $t('subscription.message.resubscribe')}}
          </span>
        </p>

        <div class="mt-4" v-if="canCheckout">
          <AppButton
            @click="subscribe"
            variant="primary"
            :label="$t('subscription.action.subscribe')"
          />

          <p class="text-gray-6 mt-8">
            {{ $t('subscription.message.checkoutNotice')}}
            <a href="mailto:support@budgista.com" class="text-gray-7">support@budgista.com</a>.
          </p>
        </div>
      </div>
    </div>
  </Layout>
</template>

<script>
  import Layout from '@/Pages/Settings/Index'
  import DateFormat from '@/Components/DateFormat'
  import dayjs from 'dayjs'
  import AppButton from '@/Components/form/AppButton'

  export default {
    components: {
      AppButton,
      DateFormat,
      Layout
    },
    props: {
      product: String
    },
    computed: {
      subscriptionEnded () {
        return dayjs(this.$page.user.subscription_ends_at).isBefore()
      },
      canCheckout () {
        return this.$page.user.subscription_state === 'trial' || this.subscriptionEnded
      }
    },
    methods: {
      subscribe () {
        Paddle.Checkout
          .open({
            product: this.product,
            email: this.$page.user.email,
            passthrough: JSON.stringify({ 'user_id': this.$page.user.id })
          })
          .then(() => {
            window.location.reload()
          })
      }
    }
  }
</script>
