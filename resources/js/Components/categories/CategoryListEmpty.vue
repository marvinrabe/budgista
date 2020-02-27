<template>
  <div class="card flex flex-column justify-center">
    <div class="my-5 text-center">
      <h2 class="text-xl text-gray-8">
        {{ $t('title.noCategories') }}
      </h2>
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
