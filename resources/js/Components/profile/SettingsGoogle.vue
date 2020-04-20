<template>
  <div class="flex -mx-1 flex-wrap items-end justify-between">
    <div class="px-1">
      <h3
        class="text-lg mb-4"
        v-t="'title.googleAccount'"
      />
      <div class="flex items-center">
        <DotIcon
          class="mr-2 text-xs"
          :class="{'text-green-6': connected, 'text-gray-5': !connected}"
        />
        <span class="text-green-9" v-if="connected">{{ $t('message.googleConnected')}}</span>
        <span class="text-gray-6" v-else>{{ $t('message.googleNotConnected')}}</span>
      </div>
    </div>
    <div class="mt-4 w-full lg:w-auto flex justify-end">
      <AppButton
        variant="danger"
        :label="$t('action.googleRemove')"
        v-if="connected"
        :loading="removing"
        @click="removeGoogle"
      />
      <GoogleConnect
        :label="$t('action.googleLink')"
        v-else
      />
    </div>
  </div>
</template>

<script>
  import AppButton from '@/Components/form/AppButton'
  import GoogleConnect from '@/Components/GoogleConnect'
  import FormGroup from '@/Components/form/FormGroup'
  import { iconComponent } from '@/Utils/Icons'
  import { faCircle } from '@fortawesome/free-solid-svg-icons'

  export default {
    components: {
      DotIcon: iconComponent({ icon: faCircle }),
      GoogleConnect,
      AppButton,
      FormGroup
    },
    data () {
      return {
        removing: false
      }
    },
    computed: {
      connected () {
        return !!this.$page.user.google_id
      }
    },
    methods: {
      removeGoogle () {
        this.removing = true

        this.$inertia
          .delete('/profile/google')
          .finally(() => {
            this.removing = false
          })
      }
    }
  }
</script>
