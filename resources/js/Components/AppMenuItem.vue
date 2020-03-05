<template>
  <a :href="link" target="_blank" class="menu__item hover:no-underline hover:bg-gray-0" v-if="link">
    <FontAwesomeIcon
      :icon="icon"
      class="mr-2"
      fixed-width
      v-if="icon"
    />
    <div class="text-gray-8 font-medium ellipsis">
      <span>{{ label }}</span>
    </div>
    <slot></slot>
  </a>
  <inertia-link
    class="menu__item hover:no-underline hover:bg-gray-0"
    :class="{'menu__item--active': active}"
    :href="href"
    v-else
  >
    <FontAwesomeIcon
      :icon="icon"
      class="mr-2"
      fixed-width
      v-if="icon"
    />
    <div class="text-gray-8 font-medium ellipsis">
      <span>{{ label }}</span>
    </div>
    <slot></slot>
  </inertia-link>
</template>

<script>
  import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome'

  export default {
    components: {
      FontAwesomeIcon
    },
    props: {
      label: String,
      href: {
        type: String,
        default: null
      },
      link: {
        type: String,
        default: null
      },
      icon: {
        type: Object,
        default: null
      }
    },
    computed: {
      active () {
        return this.$inertia.page.url.startsWith(this.href)
      }
    }
  }
</script>
