<template>
  <a
    :class="classes"
    @click.prevent="toggle"
    href="#"
  >
    <CheckIcon/>
  </a>
</template>

<script>
  import { faCheckCircle } from '@fortawesome/free-solid-svg-icons'
  import { iconComponent } from '@/Utils/Icons'

  export default {
    components: {
      CheckIcon: iconComponent({ icon: faCheckCircle })
    },
    props: {
      transaction: Object
    },
    computed: {
      classes () {
        return this.transaction.cleared ? 'text-green-7' : 'text-gray-5 hover:text-gray-6'
      }
    },
    methods: {
      toggle () {
        if (this.transaction.cleared) {
          this.unclear()
        } else {
          this.clear()
        }
      },
      clear () {
        this.$inertia.post('/clearedTransactions', {
          id: this.transaction.id
        })
      },
      unclear () {
        this.$inertia.delete(`/clearedTransactions/${this.transaction.id}`, { preserveScroll: true })
      }
    }
  }
</script>
