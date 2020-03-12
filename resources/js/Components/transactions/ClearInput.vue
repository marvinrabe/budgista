<template>
  <button
    type="button"
    :title="$t(this.transaction.paid ? 'hint.paid' : 'hint.unpaid')"
    :class="classes"
    @click.prevent="toggle">
    <CheckIcon/>
  </button>
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
        return this.transaction.paid ? 'text-green-7 hover:text-green-9' : 'text-gray-5 hover:text-gray-6'
      }
    },
    methods: {
      toggle () {
        if (this.transaction.paid) {
          this.unclear()
        } else {
          this.clear()
        }
      },
      clear () {
        this.$inertia.post('/paidTransactions', {
          id: this.transaction.id
        })
      },
      unclear () {
        this.$inertia.delete(`/paidTransactions/${this.transaction.id}`, { preserveScroll: true })
      }
    }
  }
</script>
