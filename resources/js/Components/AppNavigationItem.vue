<template>
  <li>
    <inertia-link
      :href="href"
      class="font-medium px-4 py-3 hover:no-underline text-gray-7 hover:text-gray-8 rounded flex items-center">
      <FontAwesomeIcon
        :icon="icon"
        class="mr-2 text-gray-6"
        :class="{'text-blue-5': active}"
        fixed-width
        v-if="icon"
      />
      <span class="flex flex-col min-w-0">
        <span
          class="ellipsis leading-tight"
          :class="{'text-blue-7': active}">
          <span>{{ label }}</span>
        </span>
        <AppMoney
          v-if="amount !== null"
          :value="amount"
          class="text-xs"
          color
        />
      </span>
    </inertia-link>
  </li>
</template>

<script>
  import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome'
  import AppMoney from '@/Components/AppMoney'

  export default {
    components: {
      AppMoney,
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
      },
      amount: {
        type: Number,
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
