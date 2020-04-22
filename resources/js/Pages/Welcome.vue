<template>
  <Layout :title="$t('welcome.title')">
    <div style="max-width: 800px" class="mx-auto">
      <h1 class="text-center text-3xl leading-tight">{{ $t('welcome.headline.title') }}</h1>
      <p class="text-center text-gray-6 mb-8">{{ $t('welcome.headline.description') }}</p>

      <div class="card">
        <div class="card-body">
          <ol>
            <li class="mb-2 flex items-center" v-for="(section, index) in $t('welcome.steps')">
              <div class="p-2 text-4xl font-numeric font-light">{{ index+1 }}</div>
              <div class="flex flex-col p-2">
                <div class="font-bold text-gray-8">{{ section.title }}</div>
                <div class="text-sm">{{ section.description }}</div>
              </div>
            </li>
          </ol>
        </div>
        <div class="card-footer flex flex-col md:flex-row flex-wrap items-center justify-center" v-if="$page.user.subscription_state === 'trial'">
          <div class="flex items-center">
            <ClockIcon class="mr-2 text-gray-6"/>
            <div>{{ $tc('welcome.subscription.message', daysInTrial) }}</div>
          </div>
          <AppButton to="/settings/subscription" variant="primary" class="mt-2 md:mt-0 md:ml-auto">
            {{ $t('welcome.subscription.action') }}
          </AppButton>
        </div>
      </div>

      <div class="flex flex-col md:flex-row">
        <div class="p-4">
          <h2 class="text-lg">{{ $t('welcome.help.title') }}</h2>

          <p class="text-gray-6 my-2">{{ $t('welcome.help.description') }}</p>

          <a href="mailto:support@budgista.com" class="text-blue-6 font-bold">support@budgista.com</a>
        </div>
        <div class="p-4 md:border-l md:border-gray-3">
          <h2 class="text-lg">{{ $t('welcome.social.title') }}</h2>

          <p class="text-gray-6 my-2">{{ $t('welcome.social.description') }}</p>

          <div class="flex">
            <a v-for="item in social" :href="item.href" :title="item.title" class="text-blue-6 mr-4" target="_blank">
              <FontAwesomeIcon :icon="item.icon"/>
            </a>
          </div>
        </div>
      </div>
    </div>
  </Layout>
</template>

<script>
  import Layout from '@/Layouts/Default'
  import dayjs from 'dayjs'
  import { faTwitter, faInstagram, faFacebookSquare, faYoutube } from '@fortawesome/free-brands-svg-icons'
  import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome'
  import AppButton from '@/Components/form/AppButton'
  import { iconComponent } from '@/Utils/Icons'
  import { faLightbulb, faClock } from '@fortawesome/free-solid-svg-icons'

  export default {
    components: {
      AppButton,
      Layout,
      FontAwesomeIcon,
      ClockIcon: iconComponent({ icon: faClock }),
    },
    data () {
      return {
        social: [
          {
            icon: faTwitter,
            title: 'Twitter',
            href: 'https://twitter.com/budgista'
          },
          {
            icon: faFacebookSquare,
            title: 'Facebook',
            href: 'https://www.facebook.com/BudgistaApp/'
          },
          {
            icon: faInstagram,
            title: 'Instagram',
            href: 'https://www.instagram.com/budgista/'
          },
          {
            icon: faYoutube,
            title: 'YouTube',
            href: 'https://www.youtube.com/channel/UCoGUQ3puDzsL0W8-GPFab-A'
          }
        ]
      }
    },
    computed: {
      daysInTrial () {
        const days = Math.ceil(dayjs(this.$page.user.subscription_ends_at).diff(dayjs(), 'day', true))
        return days > 0 ? days : 0
      }
    }
  }
</script>
