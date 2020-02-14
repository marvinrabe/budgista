<template functional>
  <div class="toolbar">
    <div class="title ellipsis">
      <slot name="title">
        {{ props.title }}
      </slot>
    </div>

    <slot/>

    <div class="btn-group">
      <slot name="submenu">
        &nbsp;
      </slot>
    </div>
  </div>
</template>
