<template>
  <div class="budget-groups">
    <div :key="n"
         class="card mb-3"
         v-for="n in 3"
         v-once>
      <div class="budget-group">
        <div class="budget-group-handle" style="width: 26px;">&nbsp;</div>
        <div class="data">
          <div class="budget-column-name">
            <app-skeleton :loading="true"/>
          </div>
          <div class="budget-column-budget">
            <app-skeleton :loading="true"/>
          </div>
          <div class="budget-column-activity">
            <app-skeleton :loading="true"/>
          </div>
          <div class="budget-column-available">
            <app-skeleton :loading="true"/>
          </div>
        </div>
        <div class="actions">&nbsp;</div>
      </div>

      <div
        :key="i"
        class="budget-categories"
        v-for="i in 5"
        v-once
      >
        <div class="budget-row">
          <div class="handle budget-row-handle">&nbsp;</div>
          <div class="data">
            <div class="budget-column-name">
              <AppSkeleton :loading="true"/>
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
          <div class="actions">&nbsp;</div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
  import AppSkeleton from '../AppSkeleton'

  export default {
    components: {
      AppSkeleton
    }
  }
</script>
