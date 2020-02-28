<template>
  <div class="flex -m-2 items-stretch">
    <div class="p-2 lg:w-1/3 xl:w-1/4" :class="{'hidden md:block w-5/12': hasContent, 'w-full md:w-5/12 ': !hasContent}">
      <div class="sticky" style="top: 5rem;">
        <slot name="menu"/>
      </div>
    </div>
    <div class="p-2 lg:w-2/3 xl:w-3/4" :class="{'w-full md:w-7/12': hasContent, 'hidden md:block w-7/12 ': !hasContent}">
      <slot name="content">
        <slot name="placeholder"/>
      </slot>
    </div>
  </div>
</template>

<script>
  export default {
    props: {
      title: String
    },
    computed: {
      hasContent () {
        return !!this.$slots.content
      }
    }
  }
</script>
