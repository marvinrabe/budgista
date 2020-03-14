<template>
  <div class="budget">
    <div class="budget-header">
      <div class="data">
        <div class="label budget-column-name">
          {{ $t('form.category_id') }}
        </div>
        <div class="label budget-column-budget">
          <span>{{ $t('form.budget') }}</span>
        </div>
        <div class="label budget-column-activity">
          <span>{{ $t('form.activity') }}</span>
        </div>
        <div class="label budget-column-available">
          <span>{{ $t('form.available') }}</span>
        </div>
      </div>
    </div>

    <slot />
  </div>
</template>
