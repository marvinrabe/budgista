<template>
  <div class="menu">
    <template v-for="(item, index) in menu">

      <account-menu
        :key="index"
        @navigate="$emit('navigate')"
        v-if="item.accounts"
      />
      <router-link
        :class="item.class"
        :exact="!!item.exact"
        :key="index"
        :to="item.route"
        @click.native="$emit('navigate')"
        active-class="active"
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
      </router-link>
      <a
        :class="item.class"
        :key="index"
        @click.prevent="item.click"
        class="menu__item"
        href="#"
        v-else-if="item.click"
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
      <a
        :class="item.class"
        :href="item.href"
        :key="index"
        class="menu__item"
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
  import AccountMenu from '../views/accounts/IndexSidebar'

  export default {
    components: {
      AccountMenu,
      FontAwesomeIcon
    },
    computed: {
      menu () {
        return [
          {
            route: { name: 'budget' },
            exact: false,
            icon: faEnvelope,
            label: 'title.budget'
          },
          {
            route: { name: 'statistics' },
            icon: faChartBar,
            label: 'title.statistics'
          },
          {
            accounts: true
          },
          {
            route: { name: 'profile' },
            label: 'title.profile',
            icon: faUserCircle,
            class: 'd-md-none'
          },
          {
            route: { name: 'settings' },
            label: 'title.settings',
            icon: faCog,
            class: 'd-md-none'
          },
          {
            href: 'mailto:support@budgista.com',
            label: 'title.help',
            icon: faLifeRing,
            class: 'd-md-none'
          },
          {
            click: this.logout,
            label: 'action.logout',
            class: 'd-md-none'
          }
        ]
      }
    },
    methods: {
      logout () {
        this.$auth.logout({
          makeRequest: true,
          success: function () {
            this.$store.commit('RESET')
          },
          redirect: { name: 'login' }
        })
      }
    }
  }
</script>
