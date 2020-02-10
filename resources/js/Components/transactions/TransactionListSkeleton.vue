<template>
  <div class="card">
    <skeleton
      :key="n"
      bg-color="rgba(0, 0, 0, 0.1)"
      class="transactions-row"
      duration="1"
      theme="opacity"
      v-for="n in 25"
      v-once
    >
      <div class="transaction-item">
        <span class="transaction-date">
          <tb-skeleton
            height="1em"
            shape="radius"
            style="margin: .25em 0;"
            width="66%"
          />
        </span>
        <span class="transaction-payee">
          <tb-skeleton
            height="1em"
            shape="radius"
            style="margin: .25em 0;"
            width="66%"
          />
        </span>
        <span class="transaction-category">
          <tb-skeleton
            height="1em"
            shape="radius"
            style="margin: .25em 0;"
            width="66%"
          />
        </span>
        <span class="transaction-amount">
          <tb-skeleton
            height="1em"
            shape="radius"
            style="margin: .25em 0;"
            width="50%"
          />
        </span>
      </div>
      <div class="transaction-clear">
        <tb-skeleton
          height="1em"
          shape="circle"
          style="margin: .25em .5em;"
          width="1em"
        />
      </div>
    </skeleton>
  </div>
</template>

<script>
  import { Skeleton, TbSkeleton } from 'tb-skeleton'

  export default {
    components: {
      Skeleton,
      TbSkeleton
    }
  }
</script>
