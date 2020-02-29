<template>
  <div class="card flex flex-column justify-center">
    <div class="my-5 text-center">
      <h3 class="text-xl">
        {{ $t('title.noCategories') }}
      </h3>
      <div class="flex flex-col items-center mt-2">
        <p class="mb-4">
          {{ $t('message.addCategory') }}
        </p>
        <AppButton to="/categories" variant="primary">
          <CogIcon/>
          {{ $t('action.manageCategories') }}
        </AppButton>
      </div>
    </div>
  </div>
</template>

<script>
  import AppButton from '@/Components/form/AppButton'
  import { iconComponent } from '@/Utils/Icons'
  import { faCog } from '@fortawesome/free-solid-svg-icons'

  export default {
    components: {
      AppButton,
      CogIcon: iconComponent({ icon: faCog })
    }
  }
</script>
