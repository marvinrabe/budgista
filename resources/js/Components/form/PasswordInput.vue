<template>
  <div class="VuePassword">
    <div class="VuePassword__Input">
      <input
        :type="type"
        :value="value"
        class="form-control"
        v-bind="$attrs"
        @input="emitInput"
      >

      <a
        class="VuePassword__Toggle text-gray-5 hover:text-gray-6"
        href="#"
        role="button"
        tabindex="-1"
        @click.prevent="togglePassword"
      >
        <span v-show="type === 'password'">
          <font-awesome-icon :icon="passwordIcon" />
        </span>
        <span v-show="type === 'text'">
          <font-awesome-icon :icon="textIcon" />
        </span>
      </a>
    </div>

    <svg
      v-if="!disableStrength"
      class="VuePassword__Meter"
      preserveAspectRatio="none"
      viewBox="0 0 50 2"
    >
      <path
        :class="getStrengthClass(0)"
        d="M0 1 L10 1"
      />
      <path
        :class="getStrengthClass(1)"
        d="M10.25 1 L20 1"
      />
      <path
        :class="getStrengthClass(2)"
        d="M20.25 1 L30 1"
      />
      <path
        :class="getStrengthClass(3)"
        d="M30.25 1 L40 1"
      />
      <path
        :class="getStrengthClass(4)"
        d="M40.25 1 L50 1"
      />
    </svg>
  </div>
</template>

<style>
    .VuePassword {
        position: relative;
    }

    .VuePassword__Input {
        position: relative;
    }

    .VuePassword input {
        padding-right: 3em;
        width: 100%;
    }

    .VuePassword__Toggle {
        display: inline-block;
        height: 100%;
        position: absolute;
        right: 0;
        top: 0;
        z-index: 1;
    }

    .VuePassword__Toggle svg {
        fill: currentColor;
        height: 100%;
        width: 1.5em;
        margin-right: 0.75rem;
        user-select: none;
    }

    .VuePassword__Meter {
        display: block;
        height: .5rem;
        margin-top: .2rem;
        width: 100%;
    }

    .VuePassword__Meter path {
        stroke: currentColor;
        stroke-width: 1;
        border-radius: 5px;
    }
</style>

<script>
  import { faEye, faEyeSlash } from '@fortawesome/free-solid-svg-icons'
  import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome'

  export default {
    components: {
      FontAwesomeIcon
    },
    inheritAttrs: false,
    props: {
      value: {
        type: String,
        default: ''
      },
      strengthClasses: {
        type: Array,
        default () {
          return [
            'text-gray-4',
            'text-red-7',
            'text-red-7',
            'text-yellow-7',
            'text-green-7',
            'text-green-7'
          ]
        }
      },
      disableStrength: {
        type: Boolean,
        default: false
      }
    },
    data () {
      return {
        type: 'password',
        strength: {}
      }
    },
    computed: {
      passwordIcon () {
        return faEye
      },
      textIcon () {
        return faEyeSlash
      },
      strengthClass () {
        if (this.strengthClasses[this.strength.score + 1]) {
          return this.strengthClasses[this.strength.score + 1]
        }
        return this.strengthClasses[0]
      },
      bindings () {
        return {
          type: this.type
        }
      },
      handlers () {
        return {
          input: this.emitInput
        }
      }
    },
    methods: {
      emitInput (event) {
        import(/* webpackChunkName: "zxcvbn" */ 'zxcvbn').then(x => {
          this.strength = x.default(event.target.value)
        })
        this.$emit('input', event.target.value)
      },
      togglePassword () {
        this.type = this.type === 'password' ? 'text' : 'password'
      },
      getStrengthClass (strength) {
        if (this.strength.score >= strength) {
          return this.strengthClass
        }
        return this.strengthClasses[0]
      }
    }
  }
</script>
