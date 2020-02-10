<template>
  <form @submit.prevent="$emit('submit')" novalidate>
    <slot/>

    <div class="-mx-1 flex justify-end items-baseline">
      <slot name="actions"/>
    </div>
  </form>
</template>
