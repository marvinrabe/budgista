<template functional>
  <div class="menu">
    <div class="flex items-center" v-if="props.title">
      <h3 class="px-4 py-2 text-gray-6 font-medium">
        {{ props.title }}
      </h3>
      <slot name="header"/>
    </div>
    <div class="menu__body -mx-4 mb-4 lg:border-r border-gray-3">
      <slot></slot>
    </div>
  </div>
</template>
