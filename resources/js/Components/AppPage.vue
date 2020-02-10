<script>
  import AppOffline from './AppOffline'

  export default {
    data () {
      return {
        offline: false
      }
    },
    methods: {
      error (error) {
        console.log(error);
        if (error.message === 'Network Error') {
          this.offline = true
        }
      },
      retry () {
        this.offline = false
        this.$emit('retry')
      }
    },
    render (createElement) {
      let content = this.$slots.default

      if (this.offline) {
        content = [createElement(AppOffline, {
          on: {
            retry: this.retry
          }
        })]
      }

      return createElement('div', { class: 'main' }, content)
    }
  }
</script>
