<template>
  <b-dropdown
    right
    variant="text-dark"
  >
    <template slot="button-content">
      <font-awesome-icon :icon="iconUser"/>
    </template>
    <div
      :key="item.label"
      v-for="item in menu"
    >
      <b-dropdown-divider v-if="item.divider"/>
      <b-dropdown-item
        @click="item.click"
        v-else
      >
        {{ $t(item.label) }}
        <span
          class="d-block text-muted"
          v-if="item.sublabel"
          v-text="item.sublabel"
        />
      </b-dropdown-item>
    </div>
  </b-dropdown>
</template>

<script>
  import { faUserCircle } from '@fortawesome/free-solid-svg-icons'
  import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome'
  import bDropdown from 'bootstrap-vue/es/components/dropdown/dropdown'
  import bDropdownDivider from 'bootstrap-vue/es/components/dropdown/dropdown-divider'
  import bDropdownItem from 'bootstrap-vue/es/components/dropdown/dropdown-item'

  export default {
    components: {
      bDropdown,
      bDropdownItem,
      bDropdownDivider,
      FontAwesomeIcon
    },
    apollo: {
      me: {
        query: require('../gql/query/me.gql')
      }
    },
    computed: {
      menu () {
        return [
          {
            click: this.profile,
            label: 'title.profile',
            sublabel: this.me ? this.me.email : undefined
          },
          {
            divider: true
          },
          {
            click: this.settings,
            label: 'title.settings'
          },
          {
            click: this.email,
            label: 'title.help'
          },
          {
            divider: true
          },
          {
            click: this.logout,
            label: 'action.logout'
          }
        ]
      },
      iconUser () {
        return faUserCircle
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
      },
      settings () {
        this.$router.push({ name: 'settings' })
      },
      profile () {
        this.$router.push({ name: 'profile' })
      },
      email () {
        window.location = 'mailto:support@budgista.com'
      }
    }
  }
</script>
