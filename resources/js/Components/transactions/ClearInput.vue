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
  import { iconComponent } from '../../helpers'

  export default {
    components: {
      CheckIcon: iconComponent({ icon: faCheckCircle })
    },
    props: {
      transaction: Object
    },
    computed: {
      classes () {
        return this.transaction.cleared ? 'text-success' : 'text-darker-light'
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
        this.$inertia.delete(`/clearedTransactions/${this.transaction.id}`)
      }
    }
  }
</script>
