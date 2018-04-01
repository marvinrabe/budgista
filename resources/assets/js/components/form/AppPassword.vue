<template>
    <div class="VuePassword">
        <div class="VuePassword__Input">
            <slot :bindings="bindings" :handlers="handlers"></slot>

            <a href="#" class="VuePassword__Toggle text-darker-light" role="button" @click.prevent="togglePassword">
                <font-awesome-icon :icon="toggleIcon" />
            </a>
        </div>

        <svg viewBox="0 0 40 2" class="VuePassword__Meter" preserveAspectRatio="none" v-if="!disableStrength">
            <path d="M0 1 L10 1" :class="getStrengthClass(0)"></path>
            <path d="M10.25 1 L20 1" :class="getStrengthClass(1)"></path>
            <path d="M20.25 1 L30 1" :class="getStrengthClass(2)"></path>
            <path d="M30.25 1 L40 1" :class="getStrengthClass(3)"></path>
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
        color: gray;
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

    .VuePassword__Meter path:hover {
        color: inherit;
    }
</style>

<script>
    import FontAwesomeIcon from '@fortawesome/vue-fontawesome'
    import faEye from '@fortawesome/fontawesome-free-solid/faEye'
    import faEyeSlash from '@fortawesome/fontawesome-free-solid/faEyeSlash'
    import passwordStrength from 'zxcvbn'

    export default {
        inheritAttrs: false,
        props: {
            strengthClasses: {
                type: Array,
                default() {
                    return [
                        'text-darker-light',
                        'text-danger',
                        'text-warning',
                        'text-success',
                        'text-success'
                    ]
                }
            },
            disableStrength: {
                type: Boolean,
                default: false
            }
        },
        components: {
            FontAwesomeIcon
        },
        data() {
            return {
                type: 'password',
                strength: {}
            }
        },
        computed: {
            toggleIcon() {
                if(this.type === 'password') {
                    return faEye;
                }
                return faEyeSlash;
            },
            strengthClass() {
                if (this.strengthClasses[this.strength.score]) {
                    return this.strengthClasses[this.strength.score]
                }
                return this.strengthClasses[0];
            },
            bindings() {
                return {
                    type: this.type
                }
            },
            handlers() {
                return {
                    input: this.emitInput
                }
            }
        },
        methods: {
            emitInput(event) {
                this.strength = passwordStrength(event.target.value);
            },
            togglePassword() {
                this.type = this.type === 'password' ? 'text' : 'password';
            },
            getStrengthClass(strength) {
                if (this.strength.score > strength) {
                    return this.strengthClass
                }
                return this.strengthClasses[0];
            }
        }
    }
</script>