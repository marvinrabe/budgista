<template>
  <div class="card">
    <div class="d-flex text-muted flex-column justify-content-center">
      <div class="my-5 text-center">
        <img
          alt=""
          class="img-fluid mb-3"
          src="../../assets/undraw_credit_card.svg"
          style="max-width: 250px;"
        >
        <h5 v-t="'title.emptyAccount'"/>
        <div class="mt-2">
          <p class="m-0">
            <span v-t="'message.addTransaction'"/>
          </p>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
  export default {}
</script>
