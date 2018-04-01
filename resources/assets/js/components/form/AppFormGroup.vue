<template>
    <div class="form-group">
        <label :for="name">{{ $t('form.' + name)}}</label>
        <slot :bindings="bindings"></slot>
        <span class="invalid-feedback">{{ errors.first(name) }}</span>
    </div>
</template>

<script>
    export default {
        props: ['name'],
        inject: ['$validator'],
        computed: {
            bindings() {
                return {
                    id: this.name,
                    "data-vv-name": this.name,
                    "data-vv-as": this.$t('form.' + this.name)
                }
            }
        }
    }
</script>