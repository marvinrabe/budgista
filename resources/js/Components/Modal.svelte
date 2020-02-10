<script>
  import { createEventDispatcher, onMount, onDestroy } from 'svelte'
  import { fade, fly } from 'svelte/transition'
  import focusTrap from 'focus-trap'

  let modal
  let trap
  const dispatch = createEventDispatcher()

  function close () {
    dispatch('close')
  }

  function handleKeydown ({ keyCode }) {
    // Escape
    if (keyCode === 27) {
      close()
    }
  }

  onMount(async () => {
    trap = focusTrap(modal)
    trap.activate()
    console.log(123)
  })

  onDestroy(async () => {
    trap.deactivate()
  })
</script>

<svelte:window on:keydown={handleKeydown}/>

<div
  class="fixed w-full h-full top-0 left-0 flex justify-center items-end md:items-center"
  role="dialog"
  aria-modal="true"
  bind:this={modal}
>
  <div
    transition:fly="{{ y: 256 }}"
    class="bg-white w-full md:max-w-md mx-auto rounded-t md:rounded shadow-lg z-50 overflow-y-auto p-6">
    <slot></slot>
  </div>

  <div
    class="absolute w-full h-full bg-gray-900 opacity-50"
    transition:fade>
    <div
      class="active:outline-none absolute top-0 right-0 cursor-pointer flex flex-col items-center mt-4 mr-4 text-white text-sm z-50"
      on:click={close}
      role="button"
      aria-keyshortcuts="esc"
      tabindex="0"
    >
      <ion-icon name="close" aria-hidden="true" size="large"></ion-icon>
      <span class="text-sm">Close</span>
    </div>
  </div>
</div>
