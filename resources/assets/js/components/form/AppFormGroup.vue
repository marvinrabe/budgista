<template>
    <div class="form-group">
        <label :for="name">{{ $t(labelTranslation)}}</label>
        <slot :bindings="bindings"></slot>
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
            }
        },
        inject: ['$validator'],
        computed: {
            labelTranslation() {
                return 'form.' + (this.label || this.name)
            },
            hasError() {
                return this.errors.has(this.name);
            },
            bindings() {
                return {
                    id: this.name,
                    "data-vv-name": this.name,
                    "data-vv-as": this.$t('form.' + this.name),
                    class: this.hasError ? 'is-invalid' : ''
                }
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