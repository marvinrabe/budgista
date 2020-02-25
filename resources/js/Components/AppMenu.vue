<template functional>
  <div class="menu">
    <div class="flex items-center" v-if="props.title">
      <h2 class="px-4 py-2 text-gray-6 font-medium">
        {{ props.title }}
      </h2>
      <slot name="header"/>
    </div>
    <div class="menu__body card">
      <slot></slot>
    </div>
  </div>
</template>
