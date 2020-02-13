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

  export default {
    components: {
      FontAwesomeIcon
    },
    computed: {
      menu () {
        return [
          {
            click: this.profile,
            label: 'title.profile',
            sublabel: this.$page.user.email
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
        this.$inertia.post('/logout')
      },
      settings () {
        this.$inertia.visit('/settings')
      },
      profile () {
        this.$inertia.visit('/profile')
      },
      email () {
        window.location = 'mailto:support@budgista.com'
      }
    }
  }
</script>
