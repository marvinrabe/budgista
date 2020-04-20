<template>
  <div class="min-w-screen flex justify-center items-center">
    <div class="w-full xl:w-3/4 m-4 md:my-8">
      <div class="flex flex-wrap items-stretch">
        <div class="w-full md:w-auto p-4 md:p-6">
          <div class="flex md:flex-col items-center justify-between md:items-start">
            <span class="label md:mb-2">
              {{ $t('title.setup') }}
            </span>
            <div class="w-24 border border-blue-6 bg-white rounded-full md:hidden overflow-hidden">
              <div class="bg-blue-3 h-2" :style="{width: percentage + '%'}"></div>
            </div>
            <ol class="hidden text-sm md:flex flex-col">
              <li class="p-2" v-for="(stepTitle, stepNumber) in steps"
                  :class="{'opacity-50 text-gray-6': stepNumber > step, 'font-bold tracking-wide text-blue-7': stepNumber === step}">
                <DoneIcon class="mr-2 text-green-7 opacity-75" v-if="stepNumber < step"/>
                <CurrentIcon class="mr-2 opacity-75" v-else-if="stepNumber === step"/>
                <PendingIcon class="mr-2 opacity-75" v-else/>
                {{ stepTitle }}
              </li>
            </ol>
          </div>
        </div>
        <div class="flex-1 p-4 md:p-6 card">
          <div class="flex flex-col min-h-full">
            <span class="text-gray-6">{{ $t('word.step')}} {{ step }}</span>
            <h1 class="text-2xl font-medium">{{ stepTitle }}</h1>

            <div class="my-4 flex-1">
              <slot></slot>
            </div>

            <div class="flex justify-end">
              <AppButton variant="primary" :label="$t('action.continue')" @click="next"/>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
  import AppLogo from '@/Components/AppLogo.vue'
  import base from '@/Layouts/base'
  import AppButton from '@/Components/form/AppButton'
  import { iconComponent } from '@/Utils/Icons'
  import { faCircle, faDotCircle } from '@fortawesome/free-regular-svg-icons'
  import { faCheckCircle } from '@fortawesome/free-solid-svg-icons'

  export default {
    components: {
      AppButton,
      AppLogo,
      DoneIcon: iconComponent({ icon: faCheckCircle }),
      CurrentIcon: iconComponent({ icon: faDotCircle }),
      PendingIcon: iconComponent({ icon: faCircle }),
    },
    props: {
      step: Number
    },
    mixins: [base],
    computed: {
      steps () {
        return [
          this.$t('action.register'),
          this.$t('title.setupCurrency'),
          this.$t('title.setupCategories'),
          this.$t('title.setupAccounts'),
          this.$t('title.setupReady'),
        ]
      },
      stepTitle () {
        return this.steps[this.step]
      },
      percentage () {
        return this.step / this.steps.length * 100
      }
    },
    methods: {
      next () {
        this.$emit('next')
      }
    }
  }
</script>
