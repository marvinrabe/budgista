<template>
  <li class="flex-1 md:flex-auto">
    <inertia-link
      :href="href"
      class="font-medium p-2 md:px-4 hover:no-underline text-gray-6 hover:text-gray-8 rounded flex flex-wrap flex-col md:flex-row justify-center items-center"
      :class="{'bg-gray-0 tracking-wide font-bold': active, 'tracking-wider': !active}">
      <FontAwesomeIcon
        :icon="icon"
        class="mr-1 text-gray-5"
        :class="{'text-blue-7': active}"
        v-if="icon"
      />
      <span
        class="text-xs md:text-base"
        :class="{'text-gray-8': active}">
        {{ label }}
      </span>
    </inertia-link>
  </li>
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
    }
  }
</script>
