<template>
  <div class="card flex flex-column justify-center">
    <div class="my-5 text-center">
      <h2 class="text-xl text-gray-8">
        {{ $t('title.noAccounts') }}
      </h2>
      <div class="flex flex-col items-center mt-2">
        <p class="mb-4">
          {{ $t('message.addAccount') }}
        </p>
        <AppButton to="/accounts/create" variant="primary">
          <PlusIcon/>
          {{ $t('action.create.account') }}
        </AppButton>
      </div>
    </div>
  </div>
</template>

<script>
  import AppButton from '@/Components/form/AppButton'
  import { iconComponent } from '@/Utils/Icons'
  import { faPlus } from '@fortawesome/free-solid-svg-icons'

  export default {
    components: {
      AppButton,
      PlusIcon: iconComponent({ icon: faPlus })
    }
  }
</script>
