<template>
  <div class="data">
    <div class="budget-column-name ellipsis">
      {{ category.name }}
    </div>
    <div class="budget-column-budget">
      <AppSkeleton :loading="true"/>
    </div>
    <div class="budget-column-activity">
      <AppSkeleton :loading="true"/>
    </div>
    <div class="budget-column-available">
      <AppSkeleton :loading="true"/>
    </div>
  </div>
</template>

<script>
  import AppSkeleton from '../AppSkeleton'

  export default {
    components: {
      AppSkeleton
    },
    props: {
      category: {
        type: Object,
        required: true
      }
    }
  }
</script>
