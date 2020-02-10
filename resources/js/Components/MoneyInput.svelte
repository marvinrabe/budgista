<script>
  import MoneyKeypad from './MoneyKeypad.svelte'
  import Modal from './Modal.svelte'
  import { formatter } from '@/global'

  export let value = null

  let input
  let keypadVisible = false

  const placeholder = formatter.format(0)

  function showKeyPad () {
    keypadVisible = true
  }

  function hideKeypad () {
    keypadVisible = false
    input.value = value ? formatter.format(value) : ''
  }

  function onFocus () {
    input.value = value ? formatter.formatSimple(value) : ''
    input.select()
  }

  function onInput (event) {
    value = formatter.unformat(event.target.value)
  }

  function onBlur (event) {
    value = formatter.unformat(event.target.value)
    input.value = value ? formatter.format(value) : ''
  }
</script>

<input
  bind:this={input}
  type="text"
  class="input text-right"
  {placeholder}
  on:touchend|preventDefault={showKeyPad}
  on:focus={onFocus}
  on:input={onInput}
  on:blur={onBlur}
/>

{#if keypadVisible}
  <Modal on:close={hideKeypad}>
    <MoneyKeypad on:submit={hideKeypad} bind:value={value}/>
  </Modal>
{/if}
