<template>
  <div class="budget">
    <div class="budget-header">
      <div class="handle">
        &nbsp;
      </div>
      <div class="data">
        <div class="budget-column-name">
          {{ $t('form.category') }}
        </div>
        <div class="budget-column-budget">
          <span>{{ $t('form.budget') }}</span>
        </div>
        <div class="budget-column-activity">
          <span>{{ $t('form.activity') }}</span>
        </div>
        <div class="budget-column-available">
          <span>{{ $t('form.available') }}</span>
        </div>
      </div>
      <div class="actions">
        &nbsp;
      </div>
    </div>

    <slot />
  </div>
</template>
