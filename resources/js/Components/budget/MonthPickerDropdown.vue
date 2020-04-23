<template>
  <AppDropDown body-class="left-0 top-0 mt-12">
    <template v-slot:activator>
      <slot/>
    </template>
    <div class="flex flex-col">
      <div class="flex justify-center items-center">
        <AppButton icon @click="lastYear">
          <PrevIcon/>
        </AppButton>
        <div class="font-bold">
          {{ year }}
        </div>
        <AppButton icon @click="nextYear">
          <NextIcon/>
        </AppButton>
      </div>
      <div class="flex flex-wrap w-56">
        <AppButton
          class="w-1/3" subtle variant="light"
          v-for="(month, index) in $t('month')" :key="index"
          @click="() => selectMonth(index)"
        >
          {{ month }}
        </AppButton>
      </div>
    </div>
  </AppDropDown>
</template>
<script>
  import AppDropDown from '@/Components/AppDropDown'
  import AppButton from '@/Components/form/AppButton'
  import { iconComponent } from '@/Utils/Icons'
  import { faChevronLeft, faChevronRight } from '@fortawesome/free-solid-svg-icons'
  import Month from '@/Utils/Month'

  export default {
    components: {
      AppButton,
      AppDropDown,
      NextIcon: iconComponent({ icon: faChevronRight }),
      PrevIcon: iconComponent({ icon: faChevronLeft })
    },
    props: {
      value: Month
    },
    data () {
      return {
        year: this.value.year
      }
    },
    methods: {
      selectMonth (month) {
        return this.$emit('input', new Month(this.year, month))
      },
      nextYear () {
        this.year += 1
      },
      lastYear () {
        this.year -= 1
      }
    }
  }
</script>
