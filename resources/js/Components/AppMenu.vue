<template>
  <div class="menu">
    <template v-for="(item, index) in menu">
      <AccountMenu
        :key="index"
        @navigate="$emit('navigate')"
        v-if="item.accounts"
      />
      <AppMenuItem
        v-else
        :key="index"
        :class="item.class"
        :icon="item.icon"
        :href="item.route"
        :label="$t(item.label)"
        @click="() => navigate(item)"
      />
    </template>
  </div>
</template>

<script>
  import { faChartBar, faCog, faEnvelope, faLifeRing, faUserCircle } from '@fortawesome/free-solid-svg-icons'
  import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome'
  import AccountMenu from '@/Pages/Accounts/Index'
  import AppMenuItem from '@/Components/AppMenuItem'

  export default {
    components: {
      AppMenuItem,
      AccountMenu,
      FontAwesomeIcon
    },
    computed: {
      menu () {
        return [
          {
            route: '/budget',
            exact: false,
            icon: faEnvelope,
            label: 'title.budget'
          },
          {
            route: '/statistics',
            icon: faChartBar,
            label: 'title.statistics'
          },
          {
            accounts: true
          },
          {
            route: '/profile',
            label: 'title.profile',
            icon: faUserCircle,
            class: 'lg:hidden'
          },
          {
            route: '/settings',
            label: 'title.settings',
            icon: faCog,
            class: 'lg:hidden'
          },
          {
            click: this.help,
            label: 'title.help',
            icon: faLifeRing,
            class: 'lg:hidden'
          },
          {
            click: this.logout,
            label: 'action.logout',
            class: 'lg:hidden'
          }
        ]
      }
    },
    methods: {
      navigate (item) {
        if (item.click) {
          item.click()
        }
        this.$emit('navigate')
      },
      logout () {
        this.$inertia.post('/logout')
      },
      help () {
        window.location = 'mailto:support@budgista.com'
      }
    }
  }
</script>
