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
  import axios from 'axios'
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
        axios.put('/transactions/' + this.transaction.id + '/clear')
      }
    }
  }
</script>
