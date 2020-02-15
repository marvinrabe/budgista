<template>
  <div class="menu">
    <template v-for="(item, index) in menu">
      <account-menu
        :key="index"
        @navigate="$emit('navigate')"
        v-if="item.accounts"
      />
      <inertia-link
        :class="item.class"
        :key="index"
        :href="item.route"
        @click="$emit('navigate')"
        class="menu__item"
        v-else-if="item.route"
      >
        <font-awesome-icon
          :icon="item.icon"
          class="mr-1"
          fixed-width
          v-if="item.icon"
        />
        <span
          class="d-block mr-1"
          style="width: 1.25em"
          v-else
        />
        <span>{{ $t(item.label) }}</span>
      </inertia-link>
      <a
        :class="item.class"
        :key="index"
        @click.prevent="item.click"
        class="menu__item"
        href="#"
        v-else
      >
        <font-awesome-icon
          :icon="item.icon"
          class="mr-1"
          fixed-width
          v-if="item.icon"
        />
        <span
          class="d-block mr-1"
          style="width: 1.25em"
          v-else
        />
        <span>{{ $t(item.label) }}</span>
      </a>
    </template>
  </div>
</template>

<script>
  import { faChartBar, faCog, faEnvelope, faLifeRing, faUserCircle } from '@fortawesome/free-solid-svg-icons'
  import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome'
  import AccountMenu from '@/Pages/Accounts/Index'

  export default {
    components: {
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
      logout () {
        this.$inertia.post('/logout')
      },
      help () {
        window.location = 'mailto:support@budgista.com'
      }
    }
  }
</script>
