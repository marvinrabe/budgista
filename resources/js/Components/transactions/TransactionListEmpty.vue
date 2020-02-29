<template functional>
  <div class="flex flex-column opacity-75 justify-center">
    <div class="my-5 text-center">
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
  </div>
</template>
