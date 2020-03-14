<template>
  <AppButton
    @click="showMenu"
    :aria-label="$t('action.navigation')"
    aria-controls="menu"
    icon
  >
    <BarsIcon/>
  </AppButton>
</template>

<script>
  import { faBars } from '@fortawesome/free-solid-svg-icons'
  import { iconComponent } from '@/Utils/Icons'
  import AppButton from './form/AppButton'

  export default {
    components: {
      AppButton,
      BarsIcon: iconComponent({ icon: faBars, fixedWidth: true })
    },
    methods: {
      showMenu () {
        document.body.style.setProperty('overflow', 'hidden')
        let menu = document.querySelector('[rel=\'sidebar\']')
        menu.classList.add('sidebar--animatable')
        menu.classList.add('sidebar--visible')
      }
    }
  }
</script>
