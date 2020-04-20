<template functional>
  <div class="flex flex-col opacity-75 items-center text-center p-6">
    <img
      alt=""
      class="mb-5"
      src="../../Assets/undraw_credit_card.svg"
      style="max-width: 250px;"
    >
    <h3 class="text-xl" v-t="'title.noTransactions'"/>
    <div class="mt-2">
      <p class="m-0">
        <span v-t="'message.addTransaction'"/>
      </p>
    </div>
  </div>
</template>
