<template>
  <div
    class="sidebar"
    rel="sidebar"
    @click="hide">
    <div class="sidebar__content" @click.stop>
      <AppNavigation/>
    </div>
  </div>
</template>

<script>
  import AppNavigation from '@/Components/AppNavigation'

  export default {
    components: {
      AppNavigation
    },
    mounted () {
      let sidebar = this.$el
      sidebar.addEventListener('transitionend', function () {
        sidebar.classList.remove('sidebar--animatable')
      }, false)
    },
    beforeDestroy () {
      document.body.style.removeProperty('overflow')
    },
    methods: {
      hide () {
        document.body.style.removeProperty('overflow')
        let classes = this.$el.classList
        if (classes.contains('sidebar--visible')) {
          classes.add('sidebar--animatable')
          classes.remove('sidebar--visible')
        }
      }
    }
  }
</script>
