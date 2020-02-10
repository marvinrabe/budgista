<script>
  import _ from 'lodash'
  import { createEventDispatcher } from 'svelte'
  import { formatter } from '@/global'

  const dispatch = createEventDispatcher()

  export let value = null

  let display

  let digits = value ? String(value).split('') : []
  $: input = digits.length ? parseInt(digits.join('')) : 0

  const select = num => () => {
    digits = [...digits, num]
    display.focus()
  }

  function backspace () {
    digits.pop()
    digits = digits
    display.focus()
  }

  function submit () {
    value = input ? input : null
    dispatch('submit')
  }

  function handleKeydown (event) {
    if (_.range(0, 10).includes(parseInt(event.key))) {
      select(event.key)()
      event.preventDefault()
    } else if (event.keyCode === 8) {
      backspace()
      event.preventDefault()
    } else if (event.keyCode === 13) {
      submit()
      event.preventDefault()
    }
  }

  function handlePaste (event) {
    const text = event.clipboardData.getData('Text')
    digits = String(formatter.unformat(text)).split('')
  }
</script>

<style>
  .keypad {
    @apply flex flex-wrap -mx-2;
  }

  .keypad__display::selection {
    @apply bg-transparent;
  }

  .keypad__wrapper {
    @apply w-1/3 px-2 border-r-2;
  }

  .keypad__wrapper:nth-child(3n) {
    @apply border-0;
  }

  .keypad__button {
    @apply text-xl w-full p-2;
    transition: background 0.8s;
  }

  .keypad__button:active {
    @apply bg-gray-200 outline-none;
    transition: background 0s;
  }
</style>

<svelte:window/>

<div class="relative">
  <label class="opacity-75 absolute p-2" for="money_input">Amount</label>
  <input
    id="money_input"
    type="text"
    bind:this={display}
    readonly
    aria-readonly="false"
    class="keypad__display w-full text-4xl text-right focus:outline-none focus:shadow-outline bg-gray-200 mb-4 p-4 rounded-sm"
    on:keydown={handleKeydown}
    on:paste|preventDefault={handlePaste}
    value={formatter.format(input)}
  />
</div>

<div class="keypad" aria-hidden="true">
    {#each _.range(1, 10) as number}
      <div class="keypad__wrapper">
        <button
          class="keypad__button border-b-2"
          on:click={select(number)}
        >{number}</button>
      </div>
    {/each}
  <div class="keypad__wrapper">
    <button
      class="keypad__button"
      title="Backspace"
      on:click={backspace}>
      <ion-icon name="backspace"></ion-icon>
    </button>
  </div>
  <div class="keypad__wrapper">
    <button
      class="keypad__button"
      on:click={select(0)}>
      0
    </button>
  </div>
  <div class="keypad__wrapper">
    <button
      class="keypad__button"
      title="Done"
      on:click={submit}>
      <ion-icon name="checkmark-circle"></ion-icon>
    </button>
  </div>
</div>
