<template functional>
  <div class="menu">
    <div class="flex items-center" v-if="props.title">
      <h3 class="px-4 py-2 text-gray-6 font-medium">
        {{ props.title }}
      </h3>
      <slot name="header"/>
    </div>
    <div class="menu__body lg:-mx-4 mb-4 card">
      <slot></slot>
    </div>
  </div>
</template>
