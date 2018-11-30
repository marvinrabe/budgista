<template>
    <div class="form-group">
        <label :for="name" v-if="hasLabel" v-t="labelTranslation"></label>
        <slot :bindings="bindings" :id="name"></slot>
        <FormGroupError :name="name"/>
    </div>
</template>

<script>
    import FormGroupError from './FormGroupError'

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
        components: {
            FormGroupError
        },
        inject: ['$validator'],
        computed: {
            labelTranslation() {
                return 'form.' + (this.label || this.name)
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
