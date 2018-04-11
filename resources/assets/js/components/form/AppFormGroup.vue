<template>
    <div class="form-group">
        <label :for="name" v-if="hasLabel">{{ $t(labelTranslation)}}</label>
        <slot :bindings="bindings" :id="name"></slot>
        <span class="invalid-feedback" v-if="hasError">
            {{ errors.first(name) }}
        </span>
    </div>
</template>

<script>
    export default {
        props: {
            name: {
                type: String
            },
            label: {
                type: String,
                default: null
            },
            hasLabel: {
                type: Boolean,
                default: true
            }
        },
        inject: ['$validator'],
        computed: {
            labelTranslation() {
                return 'form.' + (this.label || this.name)
            },
            hasError() {
                return this.errors.has(this.name)
            },
            bindings() {
                let bindings = {
                    id: this.name,
                    name: this.name
                }

                if (this.hasLabel) {
                    bindings['data-vv-as'] = this.$t('form.' + this.name)
                }

                return bindings
            }
        }
    }
</script>

<style>
    /* Invalid Feedback is always displayed as block, because we use vue to hide message if there is no error. */
    .invalid-feedback {
        display: block;
    }
</style>