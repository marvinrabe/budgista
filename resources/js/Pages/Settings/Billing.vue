<template>
  <Layout :title="$t('title.billing')">
    <div class="card">
      <div class="card-header">
        <h2 class="text-xl">
          {{ $t('title.billing') }}
        </h2>
      </div>
      <div class="card-body">
        <p v-if="subscriptionEnded" class="text-red-9">
          Your subscription has run out at:
          <DateFormat :value="$page.user.subscription_ends_at"/>
        </p>
        <p v-else-if="$page.user.subscription_state === 'trial'">
          You are currently on trial. Your trial ends at:
          <DateFormat :value="$page.user.subscription_ends_at"/>
        </p>
        <p v-else-if="$page.user.subscription_state === 'active'">
          You are currently subscribed. Next payement is due at:
          <DateFormat :value="$page.user.subscription_ends_at"/>
          <template v-if="!canCheckout">
            <div class="mt-2">
              <a class="font-medium tracking-wide" :href="$page.user.paddle_update_url">Update Billing Details</a>
              &middot;
              <a class="font-medium tracking-wide" :href="$page.user.paddle_cancel_url">Cancel Subscription</a>
            </div>
          </template>
        </p>
        <p v-else-if="$page.user.subscription_state === 'cancelled'">
          Your subscription has been canceled and will end at:
          <DateFormat :value="$page.user.subscription_ends_at"/>
          <span class="block text-gray-6 mt-2">
              You can resubscribe when your subscription phase has ran out.
            </span>
        </p>

        <div class="mt-4" v-if="canCheckout">
          <AppButton
            @click="subscribe"
            variant="primary"
            label="Subscribe now"
          />

          <p class="text-gray-6 mt-8">
            It might take a few seconds for your subscription to be processed.
            If you experience issues after purchase please contact us at
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
