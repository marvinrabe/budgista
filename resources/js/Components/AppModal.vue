<template>
  <portal to="modal">
    <transition name="modal">
      <div
        class="modal d-block"
        tabindex="-1"
        role="dialog"
      >
        <div
          class="modal-dialog"
          role="document"
        >
          <div class="modal-content">
            <div class="modal-header">
              <h5
                class="modal-title"
                v-text="title"
              />
              <button
                type="button"
                class="close"
                aria-label="Close"
                @click="dismiss"
              >
                <font-awesome-icon :icon="closeIcon" />
              </button>
            </div>
            <div class="modal-body">
              <slot />
            </div>
          </div>
        </div>
      </div>
    </transition>
  </portal>
</template>

<script>
  import { faTimes } from '@fortawesome/free-solid-svg-icons'
  import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome'

  export default {
    components: {
      FontAwesomeIcon
    },
    props: ['title'],
    inject: ['$validator'],
    computed: {
      closeIcon () {
        return faTimes
      }
    },
    created () {
      const escapeHandler = e => {
        if (e.key === 'Escape') {
          this.dismiss()
        }
      }
      document.addEventListener('keydown', escapeHandler)
      this.$once('hook:destroyed', () => {
        document.removeEventListener('keydown', escapeHandler)
      })
    },
    methods: {
      dismiss () {
        this.$emit('close')
      }
    }
  }
</script>
