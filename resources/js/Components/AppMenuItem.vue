<template>
  <a
    @click.prevent="navigate"
    class="menu__item"
    :class="{active: active}"
    :href="href || '#'"
  >
    <font-awesome-icon
      :icon="icon"
      class="mr-1"
      fixed-width
      v-if="icon"
    />
    <span
      class="d-block mr-1"
      style="width: 1.25em"
      v-else
    />
    <span class="ellipsis">{{ label }}</span>
    <slot></slot>
  </a>
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
      icon: {
        type: Object,
        default: null
      }
    },
    computed: {
      active () {
        return this.$inertia.page.url.startsWith(this.href)
      }
    },
    methods: {
      navigate () {
        if (this.href) {
          this.$inertia.visit(this.href)
        }
        this.$emit('click')
      }
    }
  }
</script>
